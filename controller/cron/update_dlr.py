import os
import json
import sys
import connection

import mysql.connector
import logging
import threading
import time



def thread_function(name):
    sent_sms='sent_sms';
    sendtabledetals ='az_sendnumbers';
    QuerySelect = "SELECT `smsc_id`,`time`,`msgdata`,`dlr_url` FROM "+sent_sms+" WHERE update_dlr=0 and `momt`='DLR' order by sql_id desc limit 1200"
    mycursor, mydb = connection.get_connection()
    mycursor.execute(QuerySelect)


    myresult = mycursor.fetchall()
    rowcount = len(myresult)


    if rowcount > 0:
        for x in myresult:
          smsc_id=x[0]
          # print(agent_id_db)
          sent_time=x[1]
          msgdata=x[2]
          dlr_url=x[3]
        # print(smsc_id)


    time.sleep(2)
    logging.info("Thread %s: finishing", name)

if __name__ == "__main__":
    format = "%(asctime)s: %(message)s"
    logging.basicConfig(format=format, level=logging.INFO,
                        datefmt="%H:%M:%S")

    # logging.info("Main    : before creating thread")
    x = threading.Thread(target=thread_function, args=(1,))
    # logging.info("Main    : before running thread")
    x.start()
    # logging.info("Main    : wait for the thread to finish")
    # x.join()
    logging.info("Main    : all done")


