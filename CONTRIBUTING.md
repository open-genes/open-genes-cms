# Open Longevity Genes

## Dev environment

_Note: To get this work, please checkout and run https://gitlab.com/open-genes/open-genes first (projects use shared db)_

Build or rebuild backend
```
sh open-genes.sh build
```
Build & run backend, detached mode
```
sh open-genes.sh up -d --build
```
Run backend, detached mode
```
sh open-genes.sh up
```
Stop backend, detached mode
```
sh open-genes.sh down
```
Run backend, foreground mode
```
sh open-genes.sh up --no-detach
```
Build composer dependencies
```
docker run --rm -v $PWD/app:/app composer install
```

Add to your /etc/hosts:
```
127.0.0.1 open-genes.develop cms.open-genes.develop
```
if you haven't local .env file yet, copy it from .env.sample
```
cp app/.env.sample app/.env
```
Open http://open-genes.develop:8080/api, http://cms.open-genes.develop:8080/

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
    cd console
    php yii.php migrate
    ```
* create new user for cms: 
    ```
    cd console
    php yii.php user/create user_name password email role
    ```
* re-assign roles for user: 
    ```
    cd console
    php yii.php user/assign user_name role [revokeOtherRoles=]true
    ```
  For now there are two roles available, `admin` and `editor`

## Use xdebug

Build & run with xdebug enabled:
```
./open-genes.sh up --build xdebug
```

or ```./open-genes.sh up --build xdebug <your ip address>```
in case your ip address is not automatically detected by open-genes.sh

setup PHP Storm: File -> Setting, Languages & Frameworks -> PHP -> Debug -> DBGp Proxy
* Host: your host external ip, accessible from within php container
* Port: 9003

open-genes.sh detects xdebug ip address for eth0 interface as follows:
```
    ip -4 -br addr show eth0
```

Port 9003 is default one for xdebug v3 and it cannot be changed
