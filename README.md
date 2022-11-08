# Symfony Training

## Installation

```bash
make start
```

### Migrations

One the stack has started, you may apply Doctrine migrations once MySQL is ready.

```bash
make database-create
make database-migrate
```

You can now access the application on [localhost](http://127.0.0.1/login).

## Commands

| Commands     	| Description                       |
|-----------------	|-----------------------------------|
| start        	| Setup and start the stack         |
| cp-env       	| Copie default .env if none exists |
| build        	| Build Docker's container          |
| install-deps    	| Install Composer dependencies     |
| database-create 	| Create database if none exists    |
| database-drop   	| Drop database                     |
| database-migrate	| Run Doctrine migrations           |
| fixtures-load 	| Load fixtures           	        |
