YOUR_DIR="/docker-entrypoint-initdb.d"
for file in "$YOUR_DIR"/*; do
    psql -U admin -d demo -f "${file}"
done