import os
import json
import sys
import connection
import mysql.connector
import logging
import threading
import time
from random import random
from datetime import date



def send_master_tbl(message_id,job_id):
        # mycursor, mydb = connection.get_connection()
        print("master table record sending started")
        sendtabledetals ='az_sendnumbers_test'
        momt ='MT'
        
        master_tbl_qry = "SELECT id,mobile_number,senderid,msgcredit,unicode_type,userids,service_id,is_scheduled,request_code,send_msg,metadata FROM " + sendtabledetals + " WHERE is_picked=0 AND (is_scheduled=0 ) and message_id='"+str(message_id)+"' and msg_job_id='"+str(job_id)+"' ORDER BY id DESC LIMIT 1200"
        
        mycursor.execute(master_tbl_qry)
        myresult_send_msg = mycursor.fetchall()

        send_count_count = len(myresult_send_msg)

        if send_count_count > 0 :
            send_val =[]
            master_ids = []
            for msg_row in myresult_send_msg:
                dlr_url = str(msg_row[0])
                master_ids.append(dlr_url)
                
                mobile_number = str(msg_row[1])
                senderid = str(msg_row[2])
                send_msg=str(msg_row[9])
                service_id =str(msg_row[6])
                unicode_type = msg_row[4]
                metadata=str(msg_row[10])
                if unicode_type == 0:
                    boxc_id = 0
                else:
                    boxc_id = 2
                boxc_id=str(boxc_id)
                send_val.append("('"+momt+"','"+senderid+"','"+mobile_number+"','"+send_msg+"','"+service_id+"',2,19,'"+dlr_url+"','sqlbox',"+boxc_id+",'utf8',0,'"+metadata+"')")
            
            insert_send_sms_val=','.join([str(val) for val in send_val])
            send_sms_qry = "INSERT INTO `send_sms_test` (`momt`, `sender`, `receiver`, `msgdata`, `smsc_id`,`sms_type`, `coding`, `dlr_mask`, `dlr_url`, `charset`, `boxc_id`, `udh`,`meta_data`) values "+insert_send_sms_val
            # print(send_sms_qry)
            mycursor.execute(send_sms_qry)
            mydb.commit()

            sent_master_ids=','.join([str(ids) for ids in master_ids])
            # print(sent_master_ids)
            update_master_tbl(sent_master_ids)

            # print("execution 1....")
            # print(insert_send_sms_val)



def update_master_tbl(sent_master_ids):
    update_master_tbl_qry = "update "+sendtabledetals+" set is_picked=1 where id in ("+sent_master_ids+")"
    # print(update_master_tbl_qry)
    mycursor.execute(update_master_tbl_qry)
    mydb.commit()
    # print(mycursor.rowcount, "record(s) affected")
    # mycursor.execute(update_master_tbl_qry)
    # mydb.commit()
    # print("inside")
    # print(sent_master_ids)


def update_job_tbl(message_id,job_id):
    # mycursor, mydb = connection.get_connection
    total_master_record , total_job_record = 0 , 0

    select_master_tbl_count_qry = "select convert(count(1),UNSIGNED) from "+sendtabledetals+" WHERE message_id='"+str(message_id)+"' and msg_job_id='"+str(job_id)+"'"
    mycursor.execute(select_master_tbl_count_qry)
    myresult_master_count_tbl = mycursor.fetchall()

    select_job_tbl_count_qry = "select convert(numbers_count,UNSIGNED) from "+send_job_tbl+" WHERE id='"+str(message_id)+"' and job_id='"+str(job_id)+"'"
    mycursor.execute(select_job_tbl_count_qry)
    myresult_job_count_tbl = mycursor.fetchall()

    for job_row_count in myresult_job_count_tbl:
        total_job_record = job_row_count[0]

    for master_row_count in myresult_master_count_tbl:
        total_master_record = master_row_count[0]

    if total_master_record == total_job_record :
        select_master_tbl_qry = "select count(1) as tot from "+sendtabledetals+" WHERE is_picked = 0 AND message_id='"+str(message_id)+"' and msg_job_id='"+str(job_id)+"'"
        print("update job record started.....")
        mycursor.execute(select_master_tbl_qry)
        myresult_master_tbl = mycursor.fetchall()
        
        for master_row in myresult_master_tbl:
            pending_cnt = master_row[0]
            # total_msgcredit = master_row[1]
            # print(total_msgcredit)
            print("inside loop")
            if pending_cnt == 0 :
                print("inside 2nd if")
                update_job_tbl_qry = "update "+send_job_tbl+" set is_picked=1 where id='"+str(message_id)+"' and job_id='"+str(job_id)+"'"
                # print(update_master_tbl_qry)
                mycursor.execute(update_job_tbl_qry)
                mydb.commit()
    else:
        print("no record in master tbl")
    # print("inside")
    # print(sent_master_ids)



def thread_function():
    # mycursor, mydb = connection.get_connection()
        global mycursor,mydb
        global sent_sms,sendtabledetals,send_sms,send_job_tbl
        
        while True:
            
            mycursor,mydb= connection.get_connection()
            sent_sms='sent_sms'
            print(sent_sms)
            sendtabledetals ='az_sendnumbers_test'
            send_sms='send_sms_test'
            today = date.today()
            yr = today.strftime("%Y")
            mo = today.strftime("%m")
            send_job_tbl= "az_sendmessages"+yr+mo+"_test"
            print("Thread started................")
            CountSendSMS = "select count(1) as send_queue from "+send_sms
            mycursor.execute(CountSendSMS)
            myresult_send_sms = mycursor.fetchone()

            send_sms_count = 0
            for x in myresult_send_sms:
                send_sms_count=x

            if(send_sms_count < 15000):
                job_tbl_qry = "SELECT id,job_id FROM " + send_job_tbl + " WHERE is_picked=0 AND (is_scheduled=0 ) and route!='OTP' ORDER BY id DESC LIMIT 100"
                mycursor.execute(job_tbl_qry)
                myresult_send_job = mycursor.fetchall()
                job_count = len(myresult_send_job)
                print("job table....... started")
                print(job_count)
                if job_count > 0:               
                    for job_row in myresult_send_job:
                        message_id = job_row[0]
                        job_id  =   job_row[1]
                        send_master_tbl(message_id,job_id)
                        # update_job_tbl(message_id,job_id)
                else:
                    print("no record in job table")

            time.sleep(0.01)
            # logging.info("Thread %s: finishing", name)

# if __name__ == "__main__":
#     format = "%(asctime)s: %(message)s"
#     logging.basicConfig(format=format, level=logging.INFO,
#                         datefmt="%H:%M:%S")

    # logging.info("Main    : before creating thread")      
print('Starting background task...')  
x = threading.Thread(target=thread_function,daemon=True, name='Monitor')

y = threading.Thread(target=thread_function,daemon=True, name='Monitor2')
x.start()
y.start()
x.join()
y.join()
logging.info("Main    : all done")
# for _ in range(5):
#     # block for a while
#     value = random() * 5
#     time.sleep(0.1)
    # update the data variable
    


