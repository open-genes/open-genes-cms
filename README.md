# Open Genes CMS system for biologists

## Dev environment

Build or rebuild backend
```
sh open-genes-cms.sh build
```
Build & run backend
```
sh open-genes-cms.sh up --build
```

Build & run backend, detached mode (runs in background)
```
sh open-genes-cms.sh up -d --build
```
Run backend, detached mode (runs in background)
```
sh open-genes-cms.sh up
```
Stop backend, detached mode
```
sh open-genes-cms.sh down
```
Run backend, foreground mode
```
sh open-genes-cms.sh up --no-detach
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

The default credentials are `admin` `123`

DB will be available at http://localhost:3307/ <br>
user `root` pass `secret`

### Enter php container:
```
docker ps
```
copy hash of `opengenes_php` container
```
docker exec -it (container_hash) bash
```

### Inside the php container you can:
* run data parsers:
  (see more in "parsers" section)
    ```bash
  cd console
  php yii.php  get-data/get-diseases-from-biocomp       [onlyNew default=true] true [geneNcbiIds default null] 1,2,3
  php yii.php get-data/get-gene-expression              [onlyNew default=true] true [geneNcbiIds default null] 1,2,3
  php yii.php get-data/get-gene-info                    [onlyNew default=true] true [geneNcbiIds default null] 1,2,3
  php yii.php get-data/get-go-terms                     [onlyNew default=true] true [geneNcbiIds default null] 1,2,3 [countRows default 2000] 2000
  php yii.php get-data/get-protein-atlas                [onlyNew default=true] true [geneNcbiIds default null] 1,2,3 [geneSearchName default null] BLM
  php yii.php get-data/get-protein-classes              [onlyNew default=true] true [geneNcbiIds default null] 1,2,3 [geneSearchName default null] BLM
  php yii.php get-data/get-orthologs                    [geneIdsAfter default=0]
  ...
    ```
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

### Use xdebug

Build & run with xdebug enabled:
```
./open-genes-cms.sh up --build xdebug
```

or ```./open-genes-cms.sh up --build xdebug <your ip address>```
in case your ip address is not automatically detected by open-genes-cms.sh

setup PHP Storm: https://blog.denisbondar.com/post/phpstorm_docker_xdebug

open-genes-cms.sh detects xdebug ip address as follows:
```
    ip -4 -br addr show | grep "$CLIENT_HOST"
```

Port 9003 is default one for xdebug v3 and it cannot be changed

## Run data parsers:
On droplet (test/demo/prod) or into the docker container (dev):
```bash
cd console
# parse diseaases from http://edgar.biocomp.unibo.it/gene_disease_db/csv_files/
php yii.php  get-data/get-diseases-from-biocomp       [onlyNew default=true] true [geneNcbiIds default null] 1,2,3

# parse gene expression from ncbi
php yii.php get-data/get-gene-expression              [onlyNew default=true] true [geneNcbiIds default null] 1,2,3

# parse gene summary from mygene.com
php yii.php get-data/get-gene-info                    [onlyNew default=true] true [geneNcbiIds default null] 1,2,3

# parse GO-terms from http://api.geneontology.org
php yii.php get-data/get-go-terms                     [onlyNew default=true] true [geneNcbiIds default null] 1,2,3 [countRows default 2000] 2000

# parse full protein info from https://www.proteinatlas.org/search/
php yii.php get-data/get-protein-atlas                [onlyNew default=true] true [geneNcbiIds default null] 1,2,3 [geneSearchName default null] BLM

# parse protein classes from https://www.proteinatlas.org/search/
php yii.php get-data/get-protein-classes              [onlyNew default=true] true [geneNcbiIds default null] 1,2,3 [geneSearchName default null] BLM

# parse orthologs from https://api.ncbi.nlm.nih.gov/
php yii.php get-data/get-orthologs                    [geneIdsAfter default=0]

# examples:
# php yii.php  get-data/get-diseases-from-biocomp - get diseases only for the new genes
# php yii.php  get-data/get-diseases-from-biocomp false - get diseases for ALL genes
# php yii.php  get-data/get-diseases-from-biocomp false 114548,3600 - get diseases only for 114548 and 3600 genes

# php yii.php get-data/get-go-terms - get GO terms only for the new genes
# php yii.php get-data/get-go-terms false 114548,3600 - get GO terms only for 114548 and 3600 genes
...
```
## Run tests
```bash
  sh open-genes-cms-test.sh db up
  sh open-genes-cms-test.sh
  sh open-genes-cms-test.sh db down
```
