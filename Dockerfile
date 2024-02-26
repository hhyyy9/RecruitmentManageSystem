FROM richardwong666/nginx-php:v7

MAINTAINER RichardWang <wangyuqi8080@gmail.com>

EXPOSE 80

#RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
#    && apt-get install -y nodejs

ENV NGINX_CONFIG /etc/nginx/nginx.conf

ENV  PHP_FPM_CONFIG /etc/php/8.1/fpm/php-fpm.conf

ENV START_PATH /usr/local/work

ENV FE_COMPILE_PATH $START_PATH/fe

ENV CONF_D_PATH /etc/nginx/conf.d

ENV VHOUST_CONDIFG_FILE vhost.conf

ENV FPM_CONFIG_FILE www.conf

ENV FPM_CONFIG_PATH /etc/php/8.1/fpm/pool.d

# just for test don't need too much workers
RUN sed -i "s/worker_processes auto/worker_processes 1/g" $NGINX_CONFIG
# no daemonize, in case of docker contianer exit
RUN sed -i "s/daemonize = yes/daemonize = no/g" $PHP_FPM_CONFIG

ENV START_SHELL start.sh

RUN mkdir -p $START_PATH

RUN rm -f $FPM_CONFIG_PATH/$FPM_CONFIG_FILE

RUN rm -f /etc/nginx/sites-enabled/*

COPY ./conf/$FPM_CONFIG_FILE $FPM_CONFIG_PATH/

COPY ./conf/$VHOUST_CONDIFG_FILE $CONF_D_PATH/

COPY ./$START_SHELL $START_PATH/

# compile fe files
#WORKDIR $FE_COMPILE_PATH

# COPY ./vue-app ./

# RUN npm install
 
# RUN npm run build

# RUN rm -rf /usr/share/nginx/html/*

# RUN cp -r dist/* /usr/share/nginx/html/

RUN wget -O /usr/bin/dumb-init https://github.com/Yelp/dumb-init/releases/download/v1.2.5/dumb-init_1.2.5_x86_64

RUN chmod +x /usr/bin/dumb-init;
RUN chmod +x $START_PATH/$START_SHELL;

ENTRYPOINT ["/usr/bin/dumb-init", "--"]

CMD ["/usr/local/work/start.sh", "--with", "--args"]
