# first time setup
### 1. hosts file
Add fitnesi-app.local to 127.0.0.1 in hosts file


### 2. access console and run laravel commands
docker-compose run php sh
- composer install
- php artisan key:generate
- php artisan jwt:secret
- php artisan migrate --seed
- exit

### 3. access node and run basic setup
docker-compose run node sh
- npm install
- take some tea of coffee as node will pull in some dependencies ( https://i.redd.it/tfugj4n3l6ez.png )
- npm run prod

### 4. check .env config
- If you prefer to use HRM(Hot Reload), set NPM_START_COMMAND="npm run hot"


### 5. run the project
docker-compose up


# Other commands
### to access any container
- docker-compose exec -it php sh
- docker-compose exec -it nginx sh
- docker-compose exec -it node sh

### run any command to any container
docker-compose run nginx /bin/sh -c "date"


### drop database tables & migrate with refresh seed 
docker-compose run php php artisan migrate:refresh --seed


### or if container is running(docker-compose up)
docker-compose exec -it php php artisan migrate:refresh --seed


#### run node watcher
docker-compose run node npm run watch


### run one time command to compile production app
docker-compose run node npm run prod