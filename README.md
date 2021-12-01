### 1. Downloade Project
Run this at the command line<br>
   ```bash
    https://github.com/aysetas/laravel-spaceX-restApi-passport.git
   ```
### 2. Install Laravel
- For laravel packages and dependencies.
```bash
Composer install
```
- Copy `.env.example` to `.env` and change app url, app api url and database info.

- For passport
```bash
 php artisan passport:install
```
-  For generate app key.
```bash
php artisan key:generate
``` 

- For generate database
 ```bash
php artisan migrate 
``` 
## 3.Run The Project

- To run in browser
 ```bash
php artisan serve
``` 
- To run in Swagger
 ```bash
php artisan l5-swagger:generate
 ``` 
- To run in Test
 ```bash
 php artisan test 
 ``` 
or
 ```bash
 "./vendor/bin/phpunit"
 ```
## 4. Example Endpoinds

Name | Link
------------ | -------------
Get All Capsules API | https://api.spacexdata.com/v3/capsules
Get Capsules By Status API | https://api.spacexdata.com/v3/capsules?status=active
Get Capsule By Serial API | https://api.spacexdata.com/v3/capsules/C112

## 5. Test Used

- #### Unit
- #### Integration

## 6. Package Used

- **[Passport](https://laravel.com/docs/8.x/passport)**
- **[Swagger](https://github.com/DarkaOnLine/L5-Swagger/wiki/Installation-&-Configuration)**

## 7. Technologies Used

- PHP Laravel Framework
- Mysql
- Heroku
