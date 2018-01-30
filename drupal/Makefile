UID := $(shell id -u)
GID := $(shell id -g)
CC := docker-compose
CLINAME := drupal-cli
NAME := apache2
UUID :=

HELP_FUN = \
    %help; \
    while(<>) { \
        if(/^([a-z0-9_-]+):.*\#\#(?:@(\w+))?\s(.*)$$/) { \
            push(@{$$help{$$2 // 'options'}}, [$$1, $$3]); \
        } \
    }; \
    print "usage: make [target]\n\n"; \
    for ( sort keys %help ) { \
        print "$$_:\n"; \
        printf("\033[36m  %-20s %s\033[0m\n", $$_->[0], $$_->[1]) for @{$$help{$$_}}; \
        print "\n"; \
    }

ifndef CONTAINER
	URLCONTAINER := 'http://localhost/'
else ifeq ($(CONTAINER),adminer)
	URLCONTAINER := 'http://localhost:8080/?server=db&username=drupal&db=drupal'
else ifeq ($(CONTAINER),mail)
	URLCONTAINER := 'http://localhost:8025/'
else
	URLCONTAINER := 'http://localhost/'
endif

.PHONY: help build rebuild up down start stop open log shell update cim cex cr clean wshow
.SILENT: open cr
.DEFAULT: all

help:
	@perl -e '$(HELP_FUN)' $(MAKEFILE_LIST)

create: app.sample.env initenv.sh	##@startup Créer les fichiers prérequis pour le lancement du projet
	./initenv.sh

build: docker-compose.yml app.env ##@startup Compile le projet
	$(CC) build

rebuild: docker-compose.yml app.env ## Recompile le projet
	$(CC) down -v
	$(CC) build --no-cache --force-rm

up: ## Démarre tous les containers
	$(CC) up

down: ## Stop tous les containers et supprime tous les containers, networks, volumes, et images.
	$(CC) down

start: ## Démarre tous les containers en mode deamon
	$(CC) start

stop: ## Stop tous les containers
	$(CC) stop

install: create build ##@startup Lance la création du projet (lance les commandes suivantes : `create`, `build`)

all: create build start open ##@startup Lance le projet (lance les commandes suivantes : `create`, `build`, `start`, `open`)

open: ## Ouvre l'URL du container dans le navigateur par défaut
	python -m webbrowser -t $(URLCONTAINER) >/dev/null 2>&1

log: ## Log du container passé en parametre - NAME=php-fpm [default: apache2]
	$(CC) logs -f --tail=30 $(NAME)

shell: ## Ouvre la console du container passé en paramètre - CLINAME=cli [default: drupal-cli]
	$(CC) run --rm $(CLINAME) bash

update: ## Met à jour le projet
	$(CC) run --rm --user="$(UID)" $(CLINAME) composer install
	cim

cim: ## Importe les nouvelles configurations dans Drupal
	$(CC) run --rm $(CLINAME) drush cset system.site uuid $(UUID) -y
	$(CC) run --rm $(CLINAME) drush cim -y
	cr

cex: ## Export les configurations de Drupal
	$(CC) run --rm $(CLINAME) drush cex -y

cr: ## Vide les caches
	$(CC) run --rm $(CLINAME) drush cr

clean: ## Nettoie le code avec le standart Drupal
	$(CC) run --rm $(CLINAME) phpcbf --ignore=*/css/*,*/js/* themes/custom
	$(CC) run --rm $(CLINAME) phpcbf --ignore=*/css/*,*/js/* modules/custom

wshow: ## Affiche les 50 dernières erreurs Drupal
	$(CC) run --rm $(CLINAME) drush watchdog-show --tail --full --count=50
