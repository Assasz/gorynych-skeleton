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
DATABASE_URL='mysql://user:secret@localhost/mydb_test'
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