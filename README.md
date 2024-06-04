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

You can now access the application on [localhost](http://127.0.0.1).

## Commands

| Commands         | Description                       |
|------------------|-----------------------------------|
| start            | Setup and start the stack         |
| cp-env           | Copie default .env if none exists |
| build            | Build Docker's container          |
| install-deps     | Install Composer dependencies     |
| database-create  | Create database if none exists    |
| database-drop    | Drop database                     |
