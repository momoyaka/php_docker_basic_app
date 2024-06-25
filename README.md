# php_docker_basic_app
docker * (nginx + php + postgresql + pgadmin + redis) 

хост dev.localhost

Стартует просто от docker compose up --build

Скрипт на http://dev.localhost

Команды для бд

`
cat ./sql/init_db.sql | docker exec -i php_docker_basic_app-db-1 psql -U dev -d dev`

`cat ./sql/test.sql | docker exec -i php_docker_basic_app-db-1 psql -U dev -d dev`
