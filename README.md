## Gorynych Skeleton

Skeleton API powered by [Gorynych](https://github.com/Assasz/gorynych).

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
./vendor/bin/doctrine orm:schema-tool:create
```

Set up test environment:

```
# .env.test
DATABASE_URL='sqlite://${PROJECT_DIR}/var/sqlite/db_test.sqlite'
BASE_URI='http://localhost'
```

### Utilities

Load fixtures for specified environment (`dev` by default):

```
php bin/console gorynych:load-fixtures --env=dev
```

Generate basic API for existing resources:

```
php bin/console gorynych:generate-api [resourceNamespace]
```

With this command, Gorynych will generate for you:
* resource operations performing 
basic `GET`, `POST`, `PUT`, `DELETE` actions: `App\Ports\Operation`
* API test cases for above 
operations: `App\Tests\Functional\Api`
* test fixtures: `config/fixtures`
* Open API documentation: `openapi/openapi.yaml`

Just delete all operations with tests and try it yourself ;)