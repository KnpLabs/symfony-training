# Symfony Training

## Installation

```bash
cp .env.dist .env
docker-compose build
docker-compose run --rm php composer install
docker-compose up -d
```

## Migrations

```bash
docker-compose run --rm php bin/console doctrine:migrations:migrate
```

You can now access the application on [localhost](http://127.0.0.1/login).