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



def send_master_tbl():
        # mycursor1, mydb1 = connection.get_connection()
        print("master table record sending started")
        sendtabledetals ='az_sendnumbers'
        momt ='MT'
        
        master_tbl_qry = "SELECT id,mobile_number,senderid,msgcredit,unicode_type,userids,operator_status_id,is_scheduled,request_code,send_msg,metadata,route FROM " + sendtabledetals + " WHERE is_picked=3 AND (is_scheduled=0) and `status`='Submitted' and route!='OTP' ORDER BY id ASC LIMIT 5000"

        
        mycursor1.execute(master_tbl_qry)
        myresult_send_msg = mycursor1.fetchall()

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
            # half_index = len(send_val) // 2
            # send_val1 = send_val[:half_index]
            # send_val2 = send_val[half_index:]
            insert_send_sms_val=','.join([str(val) for val in send_val])
            # if send_val1:
                # insert_send_sms_val1 = ','.join([str(val) for val in send_val1])
            send_sms_qry = "INSERT INTO `send_sms` (`momt`, `sender`, `receiver`, `msgdata`, `smsc_id`,`sms_type`,  `dlr_mask`, `dlr_url`, `boxc_id`, `coding`, `charset`,`udh`, `meta_data`) values "+insert_send_sms_val
            # print(send_sms_qry)
            # exit()
            mycursor1.execute(send_sms_qry)
            mydb1.commit()



            # Send sms 2 insert
            # if send_val2:
            #     insert_send_sms_val2 = ','.join([str(val) for val in send_val2])
            #     send_sms_qry2 = "INSERT INTO `send_sms_2` (`momt`, `sender`, `receiver`, `msgdata`, `smsc_id`,`sms_type`,  `dlr_mask`, `dlr_url`, `boxc_id`, `coding`, `charset`,`udh`, `meta_data`) values "+insert_send_sms_val2
            #     mycursor1.execute(send_sms_qry2)
            #     mydb1.commit()




            

            
            

            sent_master_ids=','.join([str(ids) for ids in master_ids])
            # print(sent_master_ids)
            update_master_tbl(sent_master_ids)
            # sys.exit()

            # print("execution 1....")
            # print(insert_send_sms_val)



def update_master_tbl(sent_master_ids):
    update_master_tbl_qry = "update "+sendtabledetals+" set is_picked=4 where id in ("+sent_master_ids+")"
    # print(update_master_tbl_qry)
    mycursor1.execute(update_master_tbl_qry)
    mydb1.commit()



def thread_function():
    # mycursor1, mydb1 = connection.get_connection()
        global mycursor1,mydb1
        global sent_sms,sendtabledetals,send_sms,send_job_tbl
        
        while True:
            try:
                mycursor1,mydb1= connection.get_connection()
                # sent_sms='sent_sms'
                # print(sent_sms)
                sendtabledetals ='az_sendnumbers'
                send_sms='send_sms'
                today = date.today()
                yr = today.strftime("%Y")
                mo = today.strftime("%m")
                # send_job_tbl= "az_sendmessages"+yr+mo
                # print("Thread started................")
                CountSendSMS = "select count(1) as send_queue from "+send_sms
                mycursor1.execute(CountSendSMS)
                myresult_send_sms = mycursor1.fetchone()

                send_sms_count = 0
                for x in myresult_send_sms:
                    send_sms_count=x

                if(send_sms_count < 50000):
                    send_master_tbl()
                    # update_job_tbl(message_id,job_id)
                    
                


                mycursor1.close()
                mydb1.close()
                time.sleep(0.2)
            except Exception as e:
                today = date.today()
                print("Exception time"+e)

            
            # logging.info("Thread %s: finishing", name)
        # mycursor1.close()
        # mydb1.close()
# if __name__ == "__main__":
#     format = "%(asctime)s: %(message)s"
#     logging.basicConfig(format=format, level=logging.INFO,
#                         datefmt="%H:%M:%S")
thread_function()
    # logging.info("Main    : before creating thread")      
# print('Starting background task...')  
# x = threading.Thread(target=thread_function,daemon=True, name='Monitor')

# # y = threading.Thread(target=thread_function,daemon=True, name='Monitor2')
# x.start()
# x.join()
# y.start()
# y.join()

# logging.info("Main    : all done")
# for _ in range(5):
#     # block for a while
#     value = random() * 5
#     time.sleep(0.1)
    # update the data variable
    


