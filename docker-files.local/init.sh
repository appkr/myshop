#!/usr/bin/env bash

if [ ! -d $MYSQL_DATA_DIR/mysql ]; then
    /usr/bin/supervisorctl stop mysql

    rm -rf $MYSQL_DATA_DIR/*
    mkdir -p $MYSQL_PID_DIR
    chmod 777 $MYSQL_PID_DIR
    usermod -d $MYSQL_DATA_DIR mysql
    mysqld --user=mysql --initialize-insecure
    chown -R mysql:mysql $MYSQL_DATA_DIR $MYSQL_PID_DIR

    /usr/bin/supervisorctl start mysql

    sleep 5

    mysql -v -e "CREATE USER 'root'@'%' IDENTIFIED BY '${MYSQL_ROOT_PASSWORD}'; GRANT ALL PRIVILEGES ON *.* TO 'root'@'%'; FLUSH PRIVILEGES;"
fi;
