#!bin/bash

mysql -uroot -p$MYSQL_ROOT_PASSWORD <<EOF
source $INIT_PATH/$SQL_FILE;