help:
		@echo ""
		@echo "usage: make COMMAND"
		@echo ""
		@echo "Commands:"
		@echo "  clean               Clean all directories"
		@echo "  docker-start        Start docker containers"
		@echo "  docker-stop         Stop all container and clear"
		@echo "  logs                Tail logs"
		@echo "  schema-create     	 Doctrine schema create"
		@echo "  schema-update     	 Doctrine schema update"
		@echo "  fetch-currencies    Run exchange command"
		@echo "  run-tests           Run exchange tests"

clean:
	@rm -Rf data/db/mysql/*
	@rm -Rf exchange/vendor
	@rm -Rf exchange/composer.lock

docker-start:
	docker-compose up -d --build

docker-stop:
	@docker-compose down -v
	@make clean

logs:
	@docker-compose logs -f

composer-start:
	pushd exchange/ && php composer.phar install

doctrine-start:
	pushd exchange/ && php bin/console doctrine:schema:create

doctrine-update:
	pushd exchange/ && php bin/console doctrine:schema:update --force

fetch-currencies:
	pushd exchange/ && php bin/console fetch:currencies

run-tests:
	pushd exchange/ && php bin/phpunit