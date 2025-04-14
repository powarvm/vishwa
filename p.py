import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="avantika"
)

mycursor = mydb.cursor()

mycursor.execute("SELECT menuname FROM menumaster limit 1")

myresult = mycursor.fetchall()

for x in myresult:
  print(x)