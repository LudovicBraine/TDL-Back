# TDL-Back

# todolist database
docker exec -w /var/www/project  www_tdl_back php bin/console doctrine:database:create

# todolist_test database environment
docker exec -w /var/www/project  www_tdl_back php bin/console doctrine:database:create --env=test

# Execute Test 
docker exec -w /var/www/project www_tdl_back php bin/phpunit

# Migrations
docker exec -w /var/www/project www_tdl_back php bin/console  make:migration
docker exec -w /var/www/project www_tdl_back php bin/console  doctrine:migrations:migrate

# Load fixtures
docker exec -w /var/www/project www_tdl_back php bin/console  doctrine:fixtures:load --append