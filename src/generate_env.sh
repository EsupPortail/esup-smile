composer i

ENV_FILE=/var/www/html/smile/.env
ENV_FILE_EXAMPLE=/var/www/html/smile/.env_example

#rm $ENV_FILE 

# Run only if .env not exists
# For kubernetes, ignored by .gitignore
cat $ENV_FILE_EXAMPLE | while read ligne ; do
  echo ${ligne}=$(eval "echo \$$ligne") >> $ENV_FILE
done
php-fpm