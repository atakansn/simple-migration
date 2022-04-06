# Simple Migration Example


### Installation
#### `composer require migration/app`


#### Edit ENV

- DB_HOST
- DB_NAME
- DB_USER
- DB_PASSWORD
- DB_PORT

| Command | Description  |
| ------------- | ------------------------------ |
| `php migrate`      | Sends all migrations to the database.    |
| `php migrate create <migration name>`   | Create a migration file.  |
| `php migrate down`   | Deletes inserted databases  |


> ### php migrate

![Migrate](https://i.ibb.co/n8Lgv6s/migrate.png)

> ### php migrate create <migration name>

![Create](https://i.ibb.co/28pydQd/create2.png)
  
> ### php migrate down

![Down](https://i.ibb.co/XXyv8JK/down.png)


 #### Displays a warning if the migration name is left break.
  
 ![Empty](https://i.ibb.co/ZSmdDfy/empty.png)
  
