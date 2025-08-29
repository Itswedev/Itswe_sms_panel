import os
import json
import sys
import connection
import mysql.connector
import logging
import threading
import time
from random import random
from datetime import datetime

sendtabledetals ='az_sendnumbers'
send_sms='send_sms'


def main():
    # try:
    global sendtabledetals
    global mycursor
    global mydb
    global send_sms
    file_name=sys.argv[1]

    file_path='/var/www/html/Itswe_sms_panel/controller/classes/sent_sms/'+file_name


    # json_file = json.loads(open(file_path).read())
    # file_name=sys.argv[1]
    # json_file_path='/var/www/html/Itswe_sms_panel/controller/'+file_name
    f = open(file_path)
    data = json.load(f)
    # msg_data=data['msg']
    query_data=data['query_data']
    msg_job_id=data['msg_job_id']
    # sendtable = 'az_sendmessages202212'
    # sendtabledetals = 'az_sendnumbers_test' 
    currentDateAndTime = datetime.now()
    currentTime = currentDateAndTime.strftime("%H:%M:%S")
    print("start time"+currentTime)

    for values in query_data:
        
        insert_val =','.join(values)
        mycursor, mydb = connection.get_connection()

        query_master_tbl_insert= "INSERT INTO "+sendtabledetals+"(`id`, `message_id`, `msgdata`, `mobile_number`, `created_at`, `senderid`, `service_id`, `request_code`, `is_picked`, `priority`, `is_scheduled`, `scheduled_time`, `msgcredit`, `userids`, `operator_status_id`, `status`, `err_code`,`status_id`,`route`,`char_count`,`msg_job_id`,`schedule_sent`,`parent_id`,`sent_at`,`cut_off`,`master_job_id`,`send_msg`,`unicode_type`,`metadata`,`operator_name`) VALUES "+insert_val+"";

        mycursor.execute(query_master_tbl_insert)
        rowcount = mycursor.rowcount
        # print(rowcount)
        mydb.commit()
        mydb.close()
        # insert_send_sms(msg_job_id)
        time.sleep(0.001)
        # print(msg_data)
        # for i in data['mobile_number']:
        #     print(i)
             
            # Closing file
    f.close()

    currentDateAndTime = datetime.now()
    currentTime = currentDateAndTime.strftime("%H:%M:%S")
    print("end time"+currentTime)





if __name__ == "__main__":
    main()