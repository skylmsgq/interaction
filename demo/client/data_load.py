import time
import serial
from get_data import *

threshold =  65

aqi_id = "d97626a1-6b41-45f5-8f3f-7420f9d60d3c"
aqi_key = '954c00c0-b01a-4863-a75b-1ed238d38f35'
aqi_world = "pm2.5"

aqi_id = "d97626a1-6b41-45f5-8f3f-7420f9d60d3c"
aqi_key = '954c00c0-b01a-4863-a75b-1ed238d38f35'
aqi_world = "pm2.5"

mesg_id = "03cf1c90-dc2e-44ad-9a6a-e5862fdfd57a"
mesg_key = '954c00c0-b01a-4863-a75b-1ed238d38f35'
mesg_world = "time"

aqi_infor  = []
mesg_infor = []
aqi_infor = set_request(aqi_id, aqi_key, aqi_world)
mesg_infor = set_request(mesg_id, mesg_key, mesg_world)

flag = ""
aqi_value = 0
comment_count = 0

ser = serial.Serial(1)
line = ser.readline()

while line:
    print(time.strftime("%Y-%m-%d %X\t") + line.strip())
    #get the aqi value and the counts of commentss
    aqi_value = from_ckan(aqi_infor, 1)
    comment_count = from_ckan(mesg_infor, 2)
    #comment_count = 43
    print 'The desity of pm2.5: '+str(aqi_value)
    print 'The the number of comments: ' + str(comment_count)
    print 'The threshold is: ' + str(threshold)

    #serial content to write
    flag = send_serial(aqi_value, comment_count, threshold)
    line = ser.readline()
    sep  = int(time.strftime("%S")) % 2
    if sep == 0:
            ser.write(flag)
    time.sleep(1)
ser.close()


