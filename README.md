# backend - Event Attendance System

### Install Package
```
composer install
```

### Copy .env.example to .env
```
cp .env.example .env
```

### Generate App Key
```
php artisan key:gen
```

### Generate jwt secret key
```
php artisan jwt:secret
```

### Run migration ( make sure .env file has been setup properly )
```
php artisan migrate
```

### Run server
```
php artisan server
```
