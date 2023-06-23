#!/bin/bash

ENV_FILE=/smile-app/.env
ENV_FILE_EXAMPLE=/smile-app/.env_example

rm $ENV_FILE 

# Run only if .env not exists
# For kubernetes, ignored by .gitignore
cat $ENV_FILE_EXAMPLE | while read ligne ; do
  echo ${ligne}=$(eval "echo \$$ligne") >> $ENV_FILE
done
apache2-foreground