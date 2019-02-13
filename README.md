# testwork
A symfony project

## Setup
1. Run `composer install` in the parent directory to install the required dependencies;
2. Change your username and password in `.env` file for the database. Currently
MySQL (MariaSQL specifically) is used in the project.
3. Run `php bin/console doctrine:database:create` to create the database;
4. Either run `php bin/console doctrine:migrations:migrate` to set up the database OR
4. import the database file `db.sql` into the database chosen for the project. This also includes
some data.
5. Run `php bin/console server:run` to start the server.

## Requirements
PHP and possible dependencies on Linux (usually available through the package manager)
