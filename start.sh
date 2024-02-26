#!/usr/bin/dumb-init /bin/sh

# must start the last process in foreground way to block the shell process, otherwise the contianer will exit once the shell done.
nginx -c $NGINX_CONFIG &

php-fpm8.1 --nodaemonize