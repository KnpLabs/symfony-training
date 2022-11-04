.PHONY: start
start: cp-env build install-deps
	docker-compose up -d

.PHONY: cp-env
cp-env:
	@cp -n .env.dist .env || true

.PHONY: build
build:
	docker-compose build

.PHONY: install-deps
install-deps:
	docker-compose run --rm php composer install

.PHONY: database-migrate
database-migrate:
	docker-compose run --rm php bin/console doctrine:migrations:migrate

.PHONY: database-create
database-create:
	docker-compose run --rm php bin/console doctrine:database:create

.PHONY: database-drop
database-drop:
	docker-compose run --rm php bin/console doctrine:database:drop --force

.PHONY: fixtures-load
fixtures-load:
	docker-compose run --rm php bin/console doctrine:fixtures:load