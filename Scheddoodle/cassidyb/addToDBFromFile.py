'''
Oh God I hope this works.
'''

import MySQLdb

try:
    readFilePath = './UFL.txt'
    userLines = open(readFilePath, 'r')
except Exception, e: print e


conn = MySQLdb.connect(host = 'localhost', user = 'scheddoodle', passwd = 'davidlibennowell', db = 'scheddoodle')

cursor = conn.cursor()

'''
cassidyb\tBrendan\tCassidy\n
levyd\tDaniel Louis\tLevy 
'''

for user in userLines:
    firstName = user.split('\t')[1]
    lastName = user.split('\t')[2].strip()
    username = user.split('\t')[0]
    cursor.execute ('UPDATE users SET firstNames="' + firstName + '" where name= "' + username + '";')
    cursor.execute ('UPDATE users SET lastNames="' + lastName + '" where name = "' + username + '";')
    print "Added", firstName, lastName, "to username", username

cursor.close()
conn.close()
userLines.close()
