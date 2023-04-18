# Symfony Training

This is the boilerplate project for KNP Labs Symfony training.

## Requirements

To run this project with docker you will need:

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/)

## Installation

```bash
make start
```

### Migrations

Once the stack has started, you may apply Doctrine migrations:

```bash
make database-create
make database-migrate
```

You can now access the application on [localhost](http://127.0.0.1/login).

### Fixtures

For most of trainings, you will need some fixtures to be loaded. To do so, run:

```bash
make fixtures-load
```

At this point, you should be able to log in and access the application (Email: `admin@mail.com`, Password: `admin`)

## Commands

| Commands         | Description                       |
|------------------|-----------------------------------|
| start            | Setup and start the stack         |
| cp-env           | Copie default .env if none exists |
| build            | Build Docker's container          |
| install-deps     | Install Composer dependencies     |
| database-create  | Create database if none exists    |
| database-drop    | Drop database                     |
| database-migrate | Run Doctrine migrations           |
| fixtures-load    | Load fixtures                     |
