# Laravel SCIM server with OAuth and client manager demo

## Installation

Download the project from github

Copy .env.example to .env and set APP_URL and database config

Run the following from the root folder:
```
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan passport:keys
php artisan serve
```

default email and password for admin access

```
email: admin@email.com
password: 123456
```

default email and password for SCIM manager access (user that can create OAuth client credentials to request access tokens which can be used to access the SCIM API)

```
email: scim@email.com
password: 123456
```

Use Postman to import demo.postman_collection.json for testing purposes.
