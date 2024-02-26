FROM mysql:latest

MAINTAINER RichardWang <wangyuqi8080@gmail.com>



ENV INIT_DIR /docker-entrypoint-initdb.d

ENV SQL_FILE init.sql

COPY ./$SQL_FILE $INIT_DIR/


RUN chmod a+x $INIT_DIR/$SQL_FILE
