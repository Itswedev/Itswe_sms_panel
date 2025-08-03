import mysql.connector
from mysql.connector import Error

def get_connection():
	try:
		
		mydb = mysql.connector.connect(
		  host="127.0.0.1",
		  user="itswe",
		  password="NcbagqPkhdt#^98ajtd",
		  database="itswe_client"
		)
		if mydb.is_connected():
			
	    #    db_Info = mydb.get_server_info()
		#    print("Connected to MySQL Server version ", db_Info)
		   cursor = mydb.cursor(buffered=True)
		   return cursor , mydb
		        # cursor.execute("select database();")
		        # record = cursor.fetchone()
		        # print("You're connected to database: ", record)
	except Error as e:
	    print("Error while connecting to MySQL", e)



	# mycursor = mydb.cursor()

	# mycursor.execute("SELECT * FROM vsms_dtls")

	# myresult = mycursor.fetchall()

	# for x in myresult:
	#   agent_id_db=x[1]
	#   public_key_db=x[2]
	#   private_key_db=x[3]
	#   service_key_db=x[4]



# [END app]

get_connection()
