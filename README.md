# TDL-Back

Create database : 

# todolist database
docker exec -w /var/www/project  www_tdl_back php bin/console doctrine:database:create

# todolist_test database environment
docker exec -w /var/www/project  www_tdl_back php bin/console doctrine:database:create --env=test

# Execute Test 
docker exec -w /var/www/project www_tdl_back php bin/phpunit