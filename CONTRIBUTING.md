# Open Longevity Genes

## Dev environment

Build backend
```
docker compose up -d
```
open http://127.0.0.1:8080/

DB wil be available at localhost:3307 root-secret

if you haven't local .env file yet, copy it from .env.sample
```
cp app/.env.sample app/.env
```

Build frontend (?)
```
docker run --rm -ti -v $(pwd):/var/www catchdigital/node-sass npm run sass
```
