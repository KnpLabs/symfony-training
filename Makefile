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

.PHONY: migrate
migrate:
	docker-compose run --rm php bin/console doctrine:migrations:migrate
