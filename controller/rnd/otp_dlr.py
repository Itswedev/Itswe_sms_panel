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


def update_thread_function():
    global mycursor3,mydb3
    global sent_sms,sendtabledetals,send_sms,send_job_tbl
    
    while True:
        try:
            mycursor3,mydb3= connection.get_connection()
            sendtabledetals = 'az_sendnumbers'
            sent_sms = 'otp_sent'
            new_status ='Other'
            get_err_code = '045'
            today = date.today()
            QuerySelect = "SELECT `smsc_id`,`time`,`dlr_url`,LOCATE('NACK',msgdata),`dlr_mask`,SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(url_decode2(msgdata),' ', -2),' ',1),'err:',-1) FROM "+sent_sms+" WHERE update_dlr=0 and `momt`='DLR' order by sql_id desc limit 2000"

            mycursor3.execute(QuerySelect)
            myresult_sent_sms = mycursor3.fetchall()
            dlr_count = len(myresult_sent_sms)
            master_ids = []
            if dlr_count > 0:
                for dlr_row in myresult_sent_sms:
                    msgdata_nack=dlr_row[3]
                    delivered_time=dlr_row[1]
                    dlr_url=dlr_row[2]
                    dlr_mask=dlr_row[4]
                    err_code=dlr_row[5]
                    smsc_name=dlr_row[0]
                    # smsc_name = ""


                    if msgdata_nack > 0 :
                       new_status='Failed'
                       get_err_code = '045'
                       update_master_dlr="update az_sendnumbers set status='"+str(new_status)+"', err_code='"+str(get_err_code)+"',delivered_date="+str(delivered_time)+" where id='"+str(dlr_url)+"'"
                       mycursor3.execute(update_master_dlr)
                       mydb3.commit()
                       master_ids.append(dlr_url)
                    else :
                        if dlr_mask == 1:
                            # print("DLR MAsk - "+str(dlr_mask))
                            new_status='Delivered'
                            get_err_code = '000'
                            update_master_dlr="update az_sendnumbers set status='"+str(new_status)+"', err_code='"+str(get_err_code)+"',delivered_date="+str(delivered_time)+" where id='"+str(dlr_url)+"'"
                            mycursor3.execute(update_master_dlr)
                            mydb3.commit()
                            master_ids.append(dlr_url)

                            # update_error_code="update "+sent_sms+" set update_dlr=1 where dlr_url='"+dlr_url+"'"
                            # mycursor3.execute(update_error_code)
                            # mydb3.commit()
                        else : 
                            get_err_code = err_code

                            map_error_code ="select count(err_status) from tbl_errorcode where err_code='"+str(get_err_code)+"'"
                            mycursor3.execute(map_error_code)
                            myresult_count_error_code = mycursor3.fetchone()

                            for y in myresult_count_error_code:
                                status_count=y

                            # map_gateway ="select gateway_id from az_sms_gateway where smsc_id='"+smsc_name+"' limit 1"
                            # # print(map_gateway)
                            # mycursor3.execute(map_gateway)
                            # myresult_gateway = mycursor3.fetchone()

                            # for x in myresult_gateway:
                            #     gateway_id=x
                            new_status='Other'
                            if status_count > 0 :
                                status_query ="select err_status from tbl_errorcode where err_code='"+str(get_err_code)+"'  limit 1"
                                # print(status_query)
                                # print(dlr_url)

                                mycursor3.execute(status_query)
                                myresult_get_status = mycursor3.fetchone()
                                if myresult_get_status is not None:
                                    status_count = len(myresult_get_status)
                                    if status_count > 0 :
                                        new_status='Other'
                                        for new_stat in myresult_get_status:
                                            new_status=new_stat

                                        update_master_dlr="update az_sendnumbers set status='"+str(new_status)+"', err_code='"+str(get_err_code)+"',delivered_date="+str(delivered_time)+" where id='"+str(dlr_url)+"'"
                                            # print(update_master_dlr)
                                            # mycursor3.reset()
                                        mycursor3.execute(update_master_dlr)
                                        mydb3.commit()
                                        master_ids.append(dlr_url)

                                            # update_error_code="update "+sent_sms+" set update_dlr=1 where dlr_url='"+dlr_url+"'"
                                            # mycursor3.execute(update_error_code)
                                            # mydb3.commit()
                                    else :
                                        update_master_dlr="update az_sendnumbers set status='"+str(new_status)+"', err_code='"+str(get_err_code)+"',delivered_date="+str(delivered_time)+" where id='"+str(dlr_url)+"'"
                                        mycursor3.execute(update_master_dlr)
                                        mydb3.commit()
                                        master_ids.append(dlr_url)
                                else :
                                        new_status='Other'
                                        update_master_dlr="update az_sendnumbers set status='"+str(new_status)+"', err_code='"+str(get_err_code)+"',delivered_date="+str(delivered_time)+" where id='"+str(dlr_url)+"'"
                                        mycursor3.execute(update_master_dlr)
                                        mydb3.commit()
                                        master_ids.append(dlr_url)
                            else :
                                new_status='Other'
                                update_master_dlr="update az_sendnumbers set status='"+str(new_status)+"', err_code='"+str(get_err_code)+"',delivered_date="+str(delivered_time)+" where id='"+str(dlr_url)+"'"
                                mycursor3.execute(update_master_dlr)
                                mydb3.commit()
                                master_ids.append(dlr_url)

                                # update_error_code="update "+sent_sms+" set update_dlr=1 where dlr_url='"+dlr_url+"'"
                                # mycursor3.execute(update_error_code)
                                # mydb3.commit()
                print("All DLR updated............")
                dlr_ids=','.join([str(ids) for ids in master_ids])
                update_sent_sms_tbl_qry = "update "+sent_sms+" set update_dlr=1 where dlr_url in ("+dlr_ids+")"
                mycursor3.execute(update_sent_sms_tbl_qry)
                mydb3.commit()
                mycursor3.close()
                mydb3.close()
                time.sleep(10)
        except Exception as e:
                today = date.today()
                print("Exception time")
        finally:
            mydb3.close()
                # mycursor3.close()
            # mydb3.close()



otp_dlr = threading.Thread(target=update_thread_function,daemon=True, name='update_dlr')

# y = threading.Thread(target=thread_function,daemon=True, name='Monitor2')
otp_dlr.start()
otp_dlr.join()