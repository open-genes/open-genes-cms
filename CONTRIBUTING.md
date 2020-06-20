# Open Longevity Genes

## Dev environment

Build backend
```
docker-compose up -d
```
Build composer dependencies
```
docker run --rm -v $PWD/app:/app composer install
```
open http://127.0.0.1:8080/

Add to your /etc/hosts:
```
127.0.0.1 open-genes.develop cms.open-genes.develop
```
if you haven't local .env file yet, copy it from .env.sample
```
cp app/.env.sample app/.env
```
Open http://open-genes.dev:8080/api, http://cms.open-genes.dev:8080/

DB will be available at localhost:3307 with root-secret credentials. Please ask the team for the db dump for development.  


For the first time local deployment you may need to create  `app/cms/runtime/assets` dir and make it writable for container user.

Enter php container:
```
docker ps
(copy hash of opengenes_php container)
docker exec -it (container_hash) bash
```

Inside the php container you can: 
* apply db migrations:
    ```
    cd common/console
    php yii.php migrate
    ```
* create new user for cms: 
    ```
    cd common/console
    php yii.php user/create user_name password email role
    ```
* re-assign roles for user: 
    ```
    cd common/console
    php yii.php user/assign user_name role [revokeOtherRoles=]true
    ```
  For now there are two roles available, `admin` and `editor`
