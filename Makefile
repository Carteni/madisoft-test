default: webpack
cs:
	./vendor/bin/php-cs-fixer fix --verbose

cs-dry-run:
	./vendor/bin/php-cs-fixer fix --verbose --dry-run

test:
	./vendor/bin/phpunit

test-coverage:
	./vendor/bin/phpunit --coverage-text

test-coverage-html:
	./vendor/bin/phpunit --coverage-html=coverage

cache:
	php bin/console cache:clear

cache-prod:
	php bin/console cache:clear --env=prod

fixtures:
	php ./bin/console doctrine:schema:drop --force && php ./bin/console doctrine:schema:create && php ./bin/console doctrine:schema:update --force && php ./bin/console doctrine:fixtures:load --no-interaction

fixtures-test:
	php ./bin/console doctrine:database:create --env=test --if-not-exists && php ./bin/console doctrine:schema:drop --force --env=test && php ./bin/console doctrine:schema:create --env=test && php ./bin/console doctrine:schema:update --force --env=test && php ./bin/console doctrine:fixtures:load --env=test --no-interaction

webpack:
	sudo ./node_modules/.bin/encore dev

webpack-prod:
	sudo ./node_modules/.bin/encore production

server:
	php ./bin/console server:start 0.0.0.0:8000

server-stop:
	php ./bin/console server:stop

db-create:
	php ./bin/console doctrine:database:create

db-drop:
	php ./bin/console doctrine:database:drop --force

schema-update:
	php ./bin/console doctrine:schema:update --force

entity-generate:
	php ./bin/console doctrine:generate:entities AppBundle
