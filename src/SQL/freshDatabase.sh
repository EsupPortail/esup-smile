#!/bin/bash
host="localhost"
port=8432
user=$1
pw=$2
database="demo"
SCRIPT_DIR="$( cd -- "$( dirname -- "${BASH_SOURCE[0]:-$0}"; )" &> /dev/null && pwd 2> /dev/null; )";
SQL_directory="$SCRIPT_DIR/"
errorTab=""
errorN=0


if [ -z "$user" ]
then
  echo "User is empty"
  exit 0
elif [ -z "$pw" ]; then
  echo "Password is empty"
  exit 0
fi

# Version local
#host="localhost"
#port=8432
#user="admin"
#pw="admin"
#database="demo"
#SQL_directory="./"
# Version Preprod

#host="pgsql.unicaen.fr"
#port=5432
#user="admin_smile_pp"
#pw="XbkCtwLIll"
#database="smile_pp"
#SQL_directory="./"



for file in "$SQL_directory"/*.sql "$SQL_directory"/**/*.sql
do
  if test -f "$file"; then
    echo "$file"
#    psql postgresql://$user:$pw@$host:$port/$database -f "$file"
    errorMsg=$(psql postgresql://$user:$pw@$host:$port/$database -f "$file" 2>&1)
#    errorMsg=$(psql postgresql://$user:$pw@$host:$port/$database -f "$file" 2>&1)

    IFS=$'\n'
    for val in $errorMsg;
    do
      if [[ "$val" == *"ERROR"* ]]
      then
        errorN=$((errorN+1))
        errorTab="$errorTab$val\n"
      fi
    done
  fi
done
echo "$errorN Error(s) found:"
echo -e "$errorTab"
