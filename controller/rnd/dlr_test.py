import os
import json
import sys
import connection
import mysql.connector
import logging
import threading
import time
import re

from random import random
from datetime import date


def update_otp_thread_function():
        global mycursor4,mydb4
        global sent_sms,sendtabledetals,send_sms,send_job_tbl
    
    # while True:
        try:
            mycursor4,mydb4= connection.get_connection()
            sendtabledetals = 'az_sendnumbers'
            sent_sms = 'sent_sms'
            new_status ='Other'
            get_err_code = '045'
            today = date.today()

            # delete momt=MT record from sent_sms
            QueryDelete = "delete FROM "+sent_sms+" WHERE `momt`='MT' "

            mycursor4.execute(QueryDelete)
            mydb4.commit()
    
            QuerySelect = "SELECT `smsc_id`,`time`,`dlr_url`,LOCATE('NACK',msgdata),`dlr_mask`,msgdata,foreign_id FROM "+sent_sms+" WHERE update_dlr=0 and `momt`='DLR'  limit 10000"
            
            st=time.time()
            mycursor4.execute(QuerySelect)
            
            myresult_sent_sms = mycursor4.fetchall()
            dlr_count = len(myresult_sent_sms)
            master_ids = []
            if dlr_count > 0:
                for dlr_row in myresult_sent_sms:
                    msgdata_nack=dlr_row[3]
                    delivered_time=dlr_row[1]
                    dlr_url=dlr_row[2]
                    dlr_mask=dlr_row[4]
                    msgdata = dlr_row[5]
                    err_regex = r'err%3A(\d+)'
                    stat_regex = r'stat%3A(\w+)'

# Extract values using regular expressions
                    err_match = re.search(err_regex, msgdata)
                    stat_match = re.search(stat_regex, msgdata)

# Check if matches were found
                    if err_match:
                       err_code = err_match.group(1)
                    else:
                       err_code = None

                    if stat_match:
                       stat_value = stat_match.group(1)
                    else:
                       stat_value = None

# Print extracted values
                    # print("Error:", err_code)
                    # print("Status:", stat_value)

                    
                    # err_code=dlr_row[5]
                    foreign_id=dlr_row[6]
                    print(err_code)

                    smsc_name=dlr_row[0]
                    msg_id = " | msg_id: "+foreign_id
                    # smsc_name = ""


                    if msgdata_nack > 0 :
                       new_status='Failed'
                       get_err_code = '045'
                       update_master_dlr="update az_sendnumbers set status='"+str(new_status)+"', err_code='"+str(get_err_code)+"',delivered_date="+str(delivered_time)+" , master_job_id = concat(master_job_id,'"+str(msg_id)+"') where id='"+str(dlr_url)+"'"
                    #    print(update_master_dlr)
                       mycursor4.execute(update_master_dlr)
                       mydb4.commit()
                       master_ids.append(dlr_url)
                    else :
                        if dlr_mask == 1:
                            # print("DLR MAsk - "+str(dlr_mask))
                            new_status='Delivered'
                            get_err_code = '000'
                            update_master_dlr="update az_sendnumbers set status='"+str(new_status)+"', err_code='"+str(get_err_code)+"',delivered_date="+str(delivered_time)+" , master_job_id = concat(master_job_id,'"+str(msg_id)+"') where id='"+str(dlr_url)+"'"
                            mycursor4.execute(update_master_dlr)
                            mydb4.commit()
                            master_ids.append(dlr_url)

                            # update_error_code="update "+sent_sms+" set update_dlr=1 where dlr_url='"+dlr_url+"'"
                            # mycursor4.execute(update_error_code)
                            # mydb4.commit()
                        else : 
                            get_err_code = err_code

                            map_error_code ="select count(err_status) from tbl_errorcode where err_code='"+str(get_err_code)+"'"
                            mycursor4.execute(map_error_code)
                            myresult_count_error_code = mycursor4.fetchone()

                            for y in myresult_count_error_code:
                                status_count=y

                            # map_gateway ="select gateway_id from az_sms_gateway where smsc_id='"+smsc_name+"' limit 1"
                            # # print(map_gateway)
                            # mycursor4.execute(map_gateway)
                            # myresult_gateway = mycursor4.fetchone()

                            # for x in myresult_gateway:
                            #     gateway_id=x

                            if status_count > 0 :
                                status_query ="select err_status from tbl_errorcode where err_code='"+str(get_err_code)+"'  limit 1"
                                # print(status_query)
                                # print(dlr_url)
                                new_status='Other'
                                mycursor4.execute(status_query)
                                myresult_get_status = mycursor4.fetchone()
                                if myresult_get_status is not None:
                                    status_count = len(myresult_get_status)
                                    if status_count > 0 :
                                        new_status='Other'
                                        for new_stat in myresult_get_status:
                                            new_status=new_stat

                                        update_master_dlr="update az_sendnumbers set status='"+str(new_status)+"', err_code='"+str(get_err_code)+"',delivered_date="+str(delivered_time)+", master_job_id = concat(master_job_id,'"+str(msg_id)+"') where id='"+str(dlr_url)+"'"
                                            # print(update_master_dlr)
                                            # mycursor4.reset()
                                        mycursor4.execute(update_master_dlr)
                                        mydb4.commit()
                                        master_ids.append(dlr_url)

                                            # update_error_code="update "+sent_sms+" set update_dlr=1 where dlr_url='"+dlr_url+"'"
                                            # mycursor4.execute(update_error_code)
                                            # mydb4.commit()
                                    else :
                                        update_master_dlr="update az_sendnumbers set status='"+str(new_status)+"', err_code='"+str(get_err_code)+"',delivered_date="+str(delivered_time)+", master_job_id = concat(master_job_id,'"+str(msg_id)+"') where id='"+str(dlr_url)+"'"
                                        mycursor4.execute(update_master_dlr)
                                        mydb4.commit()
                                        master_ids.append(dlr_url)
                                else :
                                        new_status='Other'
                                        update_master_dlr="update az_sendnumbers set status='"+str(new_status)+"', err_code='"+str(get_err_code)+"',delivered_date="+str(delivered_time)+", master_job_id = concat(master_job_id,'"+str(msg_id)+"') where id='"+str(dlr_url)+"'"
                                        mycursor4.execute(update_master_dlr)
                                        mydb4.commit()
                                        master_ids.append(dlr_url)
                            else :
                                new_status='Other'
                                update_master_dlr="update az_sendnumbers set status='"+str(new_status)+"', err_code='"+str(get_err_code)+"',delivered_date="+str(delivered_time)+", master_job_id = concat(master_job_id,'"+str(msg_id)+"') where id='"+str(dlr_url)+"'"
                                mycursor4.execute(update_master_dlr)
                                mydb4.commit()
                                master_ids.append(dlr_url)

                                # update_error_code="update "+sent_sms+" set update_dlr=1 where dlr_url='"+dlr_url+"'"
                                # mycursor4.execute(update_error_code)
                                # mydb4.commit()
                
                # print("All DLR updated............")
                dlr_ids=','.join([str(ids) for ids in master_ids])
                delete_sent_sms_dlr = "delete from "+sent_sms+" where dlr_url in ("+dlr_ids+")"
                mycursor4.execute(delete_sent_sms_dlr)
                mydb4.commit()
                et=time.time()
                elapsed_time = et - st
                print('Execution time:', elapsed_time, 'seconds')
                exit()
                # mydb4.close()
                # time.sleep(0.2)

        except Exception as e:
                print("Exception"+str(e))
        finally:
            mydb4.close()
                # mycursor4.close()
            # mydb4.close()


# while True:
update_otp_thread_function()
    # time.sleep(0.2)
# x1 = threading.Thread(target=update_otp_thread_function,daemon=True, name='update_dlr')

# y = threading.Thread(target=thread_function,daemon=True, name='Monitor2')
# x1.start()
# x1.join()
