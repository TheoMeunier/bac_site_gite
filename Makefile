# Docker 🐳
build: ##build les container docker
	docker-compose up --build -d

start: ##lancer les container docker
	docker-compose start

stop: ##Arreter les container docker
	docker-compose stop

rm: stop ##Supprimer les container docker
	docker-compose rm -f

#Composer
install: ##On install composer
	composer install

update: ##on update composer
	composer update

#Symfony 🎶
cc: #on vide le cache
	php bin/conole c:c

migration: ## on crée une migration
	docker-compose exec web sh -c 'php bin/console make:migration'

migrate: #on migre les migrations
	docker-compose exec web sh -c 'php bin/console d:m:m'

login: ##on crée la partie conexion
	php bin/console make:auth

register: ##on crée la partie enregistrement
	php bin/console make:registration-form

