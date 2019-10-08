# Open Longevity Genes

## Dev environment

Build backend
```
docker compose up -d
```
open http://127.0.0.1:8080/

DB wil be available at localhost:3307 root-secret

Build frontend (?)
```
docker run --rm -ti -v $(pwd):/var/www catchdigital/node-sass npm run sass
```
