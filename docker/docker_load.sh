docker-compose up -d
sleep 10
cat datapgsql/contact_list_db.sql | docker exec -i docker_postgres_1 psql -U postgres contact_list_db
cat datapgsql/contact_list_db_insert.sql | docker exec -i docker_postgres_1 psql -U postgres contact_list_db
#cat data/sait.sql |pv | docker exec -i docker_mysql_1 mysql -uroot -password --init-command="SET autocommit=0  sait;"