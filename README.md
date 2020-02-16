# Open Longevity Genes

Мануальный деплой:

Создать базу данных
Установить композер
Создать файл .env на основе примера и записать в него доступы
ВАЖНО: установить локальный адрес 127.0.0.1 вместо localhost



Yii2 web app

## Dev environment

### Build backend
```
docker-compose up -d
```
Open http://127.0.0.1:8080/

DB wil be available at localhost:3307 root-secret

To watch changes:
```$xslt
$ npm run sass-watch
```
---

If you haven't got local .env file yet, copy it from .env.sample.

```
cp app/.env.sample app/.env
```

### Build styles
```
docker run --rm -ti -v $(pwd):/var/www catchdigital/node-sass npm run sass
```

