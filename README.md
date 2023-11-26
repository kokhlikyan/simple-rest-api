# Simple REST API

### Run the project locally

```
git clone https://github.com/kokhlikyan/simple-rest-api.git

cd project folder

composer install

```

after that you need to create a .env file and copy all the contents from .env.example to .env

### you need to change important environment for database connection and for smtp connection

```.dotenv

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

```

### after that you can do the migration and run the project

```
php artisan migrate

php artisan serve

```
