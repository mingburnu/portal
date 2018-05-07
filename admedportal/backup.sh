#!/bin/bash

userid='root';
password='Passw0rd';
nowday=`date "+%Y-%m-%d"`;
delday=`date --date='7 days ago' "+%Y-%m-%d"`;

### db
now_s=`date`;
echo "start backup med db $nowday";
`echo "$now_s start backup med_$nowday.sql.gz" >> /backup/med/db/backup.log`;
`cd /backup/med/db;mysqldump -u $userid -p$password --max_allowed_packet=1G --single-transaction laravel > /backup/med/db/med_$nowday.sql;gzip med_$nowday.sql`;

now_e=`date`;
`echo "$now_e backup med_$nowday.sql.gz" >> /backup/med/db/backup.log`;

now_ds=`date`;
echo "del backup db med $delday";
`echo "$now_ds del med_$delday.sql.gz" >> /backup/med/db/backup.log`;
`cd /backup/med/db;rm -rf /backup/med/db/med_$delday.sql.gz`;
now_de=`date`;
`echo "$now_de del med_$delday.sql.gz" >> /backup/med/db/backup.log`;

### web
now_s=`date`;
echo "start backup web $nowday";
`echo "$now_s start backup web_$nowday.bz2" >> /backup/med/db/backup.log`;

`cd /var/www;tar -jcvf web_$nowday.bz2 medportal admedportal;mv web_$nowday.bz2 /backup/med/db`;

now_e=`date`;
`echo "$now_e backup web_$nowday.bz2" >> /backup/med/db/backup.log`;

now_ds=`date`;
echo "del backup web $delday";
`echo "$now_ds del web_$delday.bz2" >> /backup/med/db/backup.log`;
`cd /backup/med/db;rm -rf web_$delday.bz2`;

now_de=`date`;
`echo "$now_de del web_$delday.bz2" >> /backup/med/db/backup.log`;

### web scp
sshpass -p 'Pa$$word' scp /backup/med/db/web_$nowday.bz2 root@127.0.0.1:/home/root/backup/med`

### db scp
sshpass -p 'Pa$$w0rd' scp /backup/med/db/med_$nowday.sql.gz root@127.0.0.1:/home/root/backup/med`