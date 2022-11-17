# To Do List

Ceci est un site web pour organiser des tâches.

### Pré-requis
    * PHP
    * Composer
    * Symfony cli
    * Docker
    * Docker-compose

-> symfony check:requirements

### Lancer environnement de développment

    composer install
    npm install
    npm run build
    docker-compose up -d
    symfony server:start -d

### Installer la base de données

php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate

#### Charger les fixtures

    php bin/console doctrine:fixtures:load

#### GIT

    git checkout [branche] // changer de branche
    git branch -d [branche] // supprimer la branche en local

#### Test
    * création de la base de données test
php bin/console --env=test doctrine:database:create
php bin/console --env=test make:migration
php bin/console --env=test doctrine:migrations:migrate
    * faire les tests
php bin/phpunit --coverage-html var/test/test-coverage
