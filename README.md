# Silly Docker-based LAMP (Linux Apache Mysql PHP)

Very basic approach that's primarily designed to act as a snippet for simple development.

## Usage

> [!IMPORTANT]
>
> - Create `.env` file with configuration in the `./app` directory. You can use `.env.example` file as a starting point. Just use `cp .env.example .env`.
> - Create and export *MySql* root password by calling `export DB_ROOT_PASSWORD=root-password` **use your own password here!**.
> - Export `UID` to expose the user id as an environment variable by calling `export UID=${UID}`[^1].

Run the following command to compile and run the complete suite

```sh
docker compose build && docker compose up -d
```

## Application initialisation

Attach to the application container and perform the following steps

Install *composer* packages

```sh
composer install
```

Migrate database (initialize)

```sh
php artisan migrate
```

> [!TIP]
>
> Navigate to [localhost:8080](localhost:8080) in your browser to access the application, and [localhost:8081](localhost:8081) to access *phpMyAdmin*.

[^1]: This should be done even if there's an automatic Bash `UID` read only variable present since it is ignored by the docker.

## Notes

- PHP with Apache server requires root as a user therefore it's currently not possible to use it with normal user

## Inspiration

- [laravel-apache-docker](https://github.com/veevidify/laravel-apache-docker/tree/master)
