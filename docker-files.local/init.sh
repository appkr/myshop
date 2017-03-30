#!/usr/bin/env bash

chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

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

    mysql -v -e "CREATE USER 'root'@'%' IDENTIFIED BY '${MYSQL_ROOT_PASSWORD}'; GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION; FLUSH PRIVILEGES;"
fi;

if [ ! -d $MYSQL_DATA_DIR/myshop ]; then
    mysql -v -e "CREATE DATABASE myshop DEFAULT CHARACTER SET = utf8mb4 DEFAULT COLLATE = utf8mb4_unicode_ci;"
    mysql -v -e "CREATE USER 'homestead'@'%' IDENTIFIED BY '${MYSQL_ROOT_PASSWORD}'; GRANT ALL PRIVILEGES ON myshop.* TO 'homestead'@'%'; FLUSH PRIVILEGES;"
    mysql -v -e "CREATE USER 'homestead'@'localhost' IDENTIFIED BY '${MYSQL_ROOT_PASSWORD}'; GRANT ALL PRIVILEGES ON myshop.* TO 'homestead'@'localhost'; FLUSH PRIVILEGES;"
fi;
