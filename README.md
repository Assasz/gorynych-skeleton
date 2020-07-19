## Gorynych Skeleton

Skeleton API powered by [Gorynych](https://github.com/Assasz/gorynych)
and Doctrine ORM.

### Installation

Via Composer:

```
composer create-project assasz/gorynych-skeleton=dev-master
```

Set up the database:

```
# .env
DATABASE_URL='mysql://user:secret@localhost/mydb'
```

```
# creates database schema
./vendor/bin/doctrine orm:schema-tool:create

# loads fixtures for dev environment 
php bin/console gorynych:load-fixtures --env=dev
```

Set up test environment:

```
# .env.test
DATABASE_URL='sqlite://${PROJECT_DIR}/var/sqlite/db_test.sqlite'
BASE_URI='http://localhost'
```

### API Generator

Gorynych ships simple, yet powerful API generator for your
application resources:

```
php bin/console gorynych:generate-api [resourceNamespace]
```

With this command, Gorynych will generate for you:
* `Get`, `Remove`, `Replace` operations for all item resources
* `Get`, `Insert` operations for all collection resources
* API functional test cases for above 
operations: `App\Tests\Functional\Api`
* test fixtures: `config/fixtures`
* Open API 3 documentation: `openapi/openapi.yaml`

#### Quick demo

```
rm -rf src/Ports/Operation/* && rm -rf tests/Functional/Api
php bin/console gorynych:generate-api App\Application\Resource
./vendor/bin/phpunit
```

#### Notices

* Domain entities must be located under `src/Domain/Entity`
path.
* `openapi/openapi.yaml` file will always be overwritten, 
so don't modify this file directly - use annotations 
and following command to keep documentation always 
up to date: 

```
php bin/console gorynych:update-api-docs
```