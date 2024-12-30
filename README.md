# Silly Docker for Laravel project

Very basic approach that's primarily designed to act as a snippet, or a starting point for simple development.

> [!IMPORTANT]
> Don't use it in production!

## Usage

> [!IMPORTANT]
>
> Update the configuration file when pushed to production (like i.w. the `LOG_LEVEL=debug` entry in the `.env` file)

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

## Notes

- PHP with Apache server requires root as a user therefore it's currently not possible to use it with normal user
- It seems like the CSS and JS should be put in the `public` folder

## Inspiration

- [laravel-apache-docker](https://github.com/veevidify/laravel-apache-docker/tree/master)
