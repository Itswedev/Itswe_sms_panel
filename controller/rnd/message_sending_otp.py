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
        # mycursor2, mydb2 = connection.get_connection()
        print("master table record sending started")
        sendtabledetals ='az_sendnumbers'
        momt ='MT'
        
        master_tbl_qry = "SELECT id,mobile_number,senderid,msgcredit,unicode_type,userids,service_id,is_scheduled,request_code,send_msg,metadata,route FROM " + sendtabledetals + " WHERE is_picked=0 AND (is_scheduled=0) and message_id='"+str(message_id)+"' and msg_job_id='"+str(job_id)+"' and cut_off='No' and `status`='Submitted' and route='OTP' ORDER BY id DESC LIMIT 5000"
        
        mycursor2.execute(master_tbl_qry)
        myresult_send_msg = mycursor2.fetchall()

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
                route=str(msg_row[11])
                if unicode_type == 0:
                    coding = 0
                else:
                    coding = 2
                # boxc_id=str(boxc_id)


                send_val.append("('"+momt+"','"+senderid+"','"+mobile_number+"','"+send_msg+"','"+service_id+"',2,19,'"+dlr_url+"','sqlbox',"+str(coding)+",'utf8',0,'"+metadata+"')")
            
            # Split send_val into two arrays
            half_index = len(send_val) // 2
            send_val1 = send_val[:half_index]
            send_val2 = send_val[half_index:]

            if send_val1:
                insert_send_sms_val1 = ','.join([str(val) for val in send_val1])
                send_sms_qry = "INSERT INTO `otp_send` (`momt`, `sender`, `receiver`, `msgdata`, `smsc_id`,`sms_type`,  `dlr_mask`, `dlr_url`, `boxc_id`, `coding`, `charset`,`udh`, `meta_data`) values "+insert_send_sms_val1
                mycursor2.execute(send_sms_qry)
                mydb2.commit()


            # Send sms 2 insert
            if send_val2:
                insert_send_sms_val2 = ','.join([str(val) for val in send_val2])
                send_sms_qry2 = "INSERT INTO `otp_send_2` (`momt`, `sender`, `receiver`, `msgdata`, `smsc_id`,`sms_type`,  `dlr_mask`, `dlr_url`, `boxc_id`, `coding`, `charset`,`udh`, `meta_data`) values "+insert_send_sms_val2
                mycursor2.execute(send_sms_qry2)
                mydb2.commit()

            # print(send_sms_qry)
            # # logging.basicConfig(filename="message_sending_output.log",format='%(asctime)s %(message)s',filemode='w') 
            # # logger.info(send_sms_qry) 
            # mycursor2.execute(send_sms_qry)
            # mydb2.commit()


            sent_master_ids=','.join([str(ids) for ids in master_ids])
            # print(sent_master_ids)
            update_master_tbl(sent_master_ids)
            # sys.exit()

            # print("execution 1....")
            # print(insert_send_sms_val)



def update_master_tbl(sent_master_ids):
    update_master_tbl_qry = "update "+sendtabledetals+" set is_picked=1 where id in ("+sent_master_ids+")"
    # print(update_master_tbl_qry)
    mycursor2.execute(update_master_tbl_qry)
    mydb2.commit()
    # print(mycursor2.rowcount, "record(s) affected")
    # mycursor2.execute(update_master_tbl_qry)
    # mydb2.commit()
    # print("inside")
    # print(sent_master_ids)


def update_job_tbl(message_id,job_id):
    # mycursor2, mydb2 = connection.get_connection
    total_master_record , total_job_record = 0 , 0

    select_master_tbl_count_qry = "select convert(count(1),UNSIGNED) from "+sendtabledetals+" WHERE message_id='"+str(message_id)+"' and msg_job_id='"+str(job_id)+"'"
    mycursor2.execute(select_master_tbl_count_qry)
    myresult_master_count_tbl = mycursor2.fetchall()

    select_job_tbl_count_qry = "select convert(numbers_count,UNSIGNED) from "+send_job_tbl+" WHERE id='"+str(message_id)+"' and job_id='"+str(job_id)+"'"
    mycursor2.execute(select_job_tbl_count_qry)
    myresult_job_count_tbl = mycursor2.fetchall()

    for job_row_count in myresult_job_count_tbl:
        total_job_record = job_row_count[0]

    for master_row_count in myresult_master_count_tbl:
        total_master_record = master_row_count[0]

    if total_master_record == total_job_record :
        select_master_tbl_qry = "select count(1) as tot from "+sendtabledetals+" WHERE is_picked = 0 AND message_id='"+str(message_id)+"' and msg_job_id='"+str(job_id)+"'"
        print("update job record started.....")
        mycursor2.execute(select_master_tbl_qry)
        myresult_master_tbl = mycursor2.fetchall()
        
        for master_row in myresult_master_tbl:
            pending_cnt = master_row[0]
            # total_msgcredit = master_row[1]
            # print(total_msgcredit)
            print("inside loop")
            if pending_cnt == 0 :
                print("inside 2nd if")
                update_job_tbl_qry = "update "+send_job_tbl+" set is_picked=1 where id='"+str(message_id)+"' and job_id='"+str(job_id)+"'"
                # print(update_master_tbl_qry)
                mycursor2.execute(update_job_tbl_qry)
                mydb2.commit()
    else:
        print("no record in master tbl")
    # print("inside")
    # print(sent_master_ids)



def otp_thread_function():
    # mycursor2, mydb2 = connection.get_connection()
        global mycursor2,mydb2
        global sent_sms,sendtabledetals,send_sms,send_job_tbl
        
        while True:
            try:
                mycursor2,mydb2= connection.get_connection()
                # sent_sms='sent_sms'
                # print(sent_sms)
                sendtabledetals ='az_sendnumbers'
                send_sms='otp_send'
                today = date.today()
                yr = today.strftime("%Y")
                mo = today.strftime("%m")
                send_job_tbl= "az_sendmessages"+yr+mo
                # print("Thread started................")
                CountSendSMS = "select count(1) as send_queue from "+send_sms
                mycursor2.execute(CountSendSMS)
                myresult_send_sms = mycursor2.fetchone()

                send_sms_count = 0
                for x in myresult_send_sms:
                    send_sms_count=x

                if(send_sms_count < 50000):
                    job_tbl_qry = "SELECT id,job_id FROM " + send_job_tbl + " WHERE is_picked=0 AND (is_scheduled=0 ) and route='OTP' ORDER BY id DESC LIMIT 100"
                    
                    mycursor2.execute(job_tbl_qry)
                    myresult_send_job = mycursor2.fetchall()
                    job_count = len(myresult_send_job)
                    # print("job table....... started new2")
                    # print(job_count)
                    if job_count > 0:               
                        for job_row in myresult_send_job:
                            message_id = job_row[0]
                            job_id  =   job_row[1]
                            send_master_tbl(message_id,job_id)
                            update_job_tbl(message_id,job_id)
                    else:
                        print("no record in job table")

                mycursor2.close()
                mydb2.close()
                time.sleep(0.2)
            except Exception as e:
                today = date.today()
                print(e)

        # mycursor2.close()
        # mydb2.close()
            # time.sleep(0.01)
            # logging.info("Thread %s: finishing", name)

# if __name__ == "__main__":
#     format = "%(asctime)s: %(message)s"
#     logging.basicConfig(format=format, level=logging.INFO,
#                         datefmt="%H:%M:%S")

    # logging.info("Main    : before creating thread")      
# print('Starting background task...')  
# otpsend = threading.Thread(target=otp_thread_function,daemon=True, name='Monitor')

# # y = threading.Thread(target=thread_function,daemon=True, name='Monitor2')
# otpsend.start()
# otpsend.join()
otp_thread_function()
# y.start()
# y.join()

logging.info("Main    : all done")
# for _ in range(5):
#     # block for a while
#     value = random() * 5
#     time.sleep(0.1)
    # update the data variable
    


