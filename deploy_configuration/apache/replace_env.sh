#!/bin/bash
envsubst '${SMILE_INSTANCE_URL}' < /template-000-default.conf  > /etc/apache2/sites-available/000-default.conf
envsubst '${SMILE_CORE_POD_NAME} ${SMILE_INSTANCE_URL} ${MODE}' < /template-default-ssl.conf > /etc/apache2/sites-available/default-ssl.conf