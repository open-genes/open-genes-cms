# Open Longevity Genes CMS system for biologists

## Dev environment

Build or rebuild backend
```
sh open-genes.sh build
```
Build & run backend
```
sh open-genes.sh up --build
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
### Open http://cms.open-genes.develop:8081/

The default credentials are `admin` - `123`

DB will be available at localhost:3307, user `root` pass `secret` 

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
  The available roles are: `admin`, `editor`, `contributor`, `manager`

## Use xdebug

Build & run with xdebug enabled:
```
./open-genes.sh up --build xdebug
```

or ```./open-genes.sh up --build xdebug <your ip address>```
in case your ip address is not automatically detected by open-genes.sh

setup PHP Storm: https://blog.denisbondar.com/post/phpstorm_docker_xdebug

open-genes.sh detects xdebug ip address as follows:
```
    ip -4 -br addr show | grep "$CLIENT_HOST"
```

Port 9003 is default one for xdebug v3 and it cannot be changed
