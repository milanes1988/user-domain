install: install_vendors ci_phpunit
tests: tests_unit 

install_vendors:
	composer self-update
	composer install --no-interaction

# Run by CI server
ci_phpunit: install_vendors tests_unit

tests_unit:
	./bin/phpunit 
