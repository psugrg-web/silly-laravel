# Silly Laravel project

The very basic *Laravel* project for learning purposes. It contains the notes with description of most important steps in the *Laravel* project. 

> [!IMPORTANT]
> Obviously, don't use it in production!

## First steps

### Create Docker image

> [!IMPORTANT]
>
> - Create `.env` file with configuration in the `./app` directory. You can use `.env.example` file as a starting point. Just use `cp .env.example .env`.
> - Create and export *MySql* root password by calling `export DB_ROOT_PASSWORD=root-password` **use your own password here!**
> - Export `UID` to expose the user id as an environment variable by calling `export UID=${UID}`[^1].

Run the following command to compile and run the complete suite

```sh
docker compose build && docker compose up -d
```

> [!NOTE]
>
> Visit [silly-damp](https://github.com/psugrg-web/silly-damp) for more information on the docker image for this project.

### Initialize the application

Attach to the application container, got to the `app` directory and perform the following steps

Install *composer* packages

```sh
composer install
```

Generate application key

```sh
php artisan key:generate
```

Migrate database (initialize)

```sh
php artisan migrate
```

> [!TIP]
>
> Navigate to [localhost:8080](localhost:8080) in your browser to access the application, and [localhost:8081](localhost:8081) to access *phpMyAdmin*.

[^1]: This should be done even if there's an automatic Bash `UID` read only variable present since it is ignored by the docker.

## Most important steps

### Configuration file

The configuration is stored in the `.env` file inside the `app` directory.

> [!IMPORTANT]
>
> Update the configuration file when pushed to production (like i.w. the `LOG_LEVEL=debug` entry in the `.env` file)

### Artisan

The *Laravel* project contains the `artisan` tool to help you configure your application.

Run the following command from the `/app` directory to see all options the *artisan* has.

```sh
php artisan
```

> [!IMPORTANT]
>
> The *artisan* command is available *only* from the directory of your *Laravel* application. In this case it's the `/app` directory.

### Database

The database is configured during the project initialization. In case of this project, the *MySql* has been selected.

Run `php artisan db::show` to get the information about the database configuration.

### Migrations

Migrations essentially are the automation to control your database. Use it to create, delete or update yor DB.

#### Reset DB and start from scratch

> [!CAUTION]
>
> This will destroy all entries in the DB, use it carefully!

Execute `php artisan migrate:refresh` to drop all your entries and re-run all migrations.

#### Rollback las migration

Execute `php artisan migrate:rollback` to revert the last migration.

#### Create migration

Run `php artisan make:migration` to create new migration (migration file). Type a name e.g. `create_flights_table` and hit enter.

##### Add new fields in the new table

Open the file that has been created and edit the `up()` method. Add as many fields as you need.

To add a new *string* field named *title*, add the following to the migration file:

```php
$table->string('title');
```

#### Run migrations

Execute `php artisan migrate` to run all migrations. This will re-configure your database (or create it from scratch if it doesn't exist).

## Notes

- PHP with Apache server requires root as a user therefore it's currently not possible to use it with normal user
- It seems like the CSS and JS should be put in the `public` folder
