# Welcome

To start, fork this repo with all branches :
- main (step 1)
- step-2 (step 2)
- step-3 (step 3)
- algo

## To run the application at the step 2 :
- you must have php 8.2 installed
- complete .env file or create your own .env.dev.local file with your database configuration example:
  `DATABASE_URL="mysql://user:password@127.0.0.1:3306/fulll?serverVersion=8&charset=utf8mb4"`
- run :
    - `composer install`
    - `bin/console doctrine:database:create`
    - `bin/console doctrine:schema:create`
    - `bin/console doctrine:fixtures:load` (In order to create 2 users Id 1 and 2)
- to display the available commands, run :
    - `bin/console list fulll`

### To Launch BDD tests
- create your own .env.test.local file with your database configuration example:
  `DATABASE_URL="mysql://user:password@127.0.0.1:3306/fulll?serverVersion=8&charset=utf8mb4"`
- run :
    - `composer install`
    - `bin/console doctrine:database:create --env=test`
    - `bin/console doctrine:schema:create --env=test`
    - `APP_ENV=test vendor/bin/behat`

**That's it !**
   