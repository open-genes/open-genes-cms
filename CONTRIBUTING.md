# Open Longevity Genes

## Dev environment

Build backend
```
docker compose up -d
```
Build composer dependencies
```
docker run --rm -v $PWD/app:/app composer install
```
open http://127.0.0.1:8080/

if you haven't local .env file yet, copy it from .env.sample
```
cp app/.env.sample app/.env
```
DB wil be available at localhost:3307 root-secret

Enter php container:
```
docker ps
(copy hash from php container)
docker exec -it (container_hash)
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
---

Build frontend
```
docker run --rm -ti -v $(pwd):/var/www catchdigital/node-sass npm run sass
```
