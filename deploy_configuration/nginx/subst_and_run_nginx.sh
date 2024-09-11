#!/bin/bash
envsubst '${SMILE_CORE_POD_NAME} ${SMILE_INSTANCE_URL} ${MODE}' < /etc/nginx/tmp/nginx.conf.template > /etc/nginx/nginx.conf
nginx -g 'daemon off;'