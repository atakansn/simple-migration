# Simple Migration Example

An application for MySQL that can create database tables with the help of console in simple applications.

## Installion

```bash
  composer require migration/app
```

Create migrate.php file.

Paste the following codes into the migrate file.

````php
#!usr/bin/php
<?php

use SimpleMigration\Application;
use SimpleMigration\Database\Connection;

require __DIR__ . '/vendor/autoload.php';

$database = require __DIR__ . '/Database/database.php';

$connection = new Connection($database);

$app = new Application($connection, $argv);
$app->run();

````


Edit the database.php file according to your mysql database.

````php
<?php

return [
    'connection' => 'mysql',
    'host' => 'localhost',
    'database' => 'migration_exam',
    'user' => 'root',
    'password' => 'root',
    'port' => 3306,
];
````

### Command descriptions

| Command | Description  |
| ------------- | ------------------------------ |
| `php migrate`      | Sends all migrations to the database.    |
| `php migrate create <migration name>`   | Create a migration file.  |
| `php migrate down`   | Deletes inserted databases  |



## Screenshots

> ### php migrate


![Migrate](https://i.ibb.co/n8Lgv6s/migrate.png)


> ### php migrate create <migration name>


![Create](https://i.ibb.co/28pydQd/create2.png)


> ### php migrate down


![Down](https://i.ibb.co/XXyv8JK/down.png)



#### Displays a warning if the migration name is left break.


![Empty](https://i.ibb.co/ZSmdDfy/empty.png)

