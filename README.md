# Laravel Vue Axios Demo
This is demo for [my blog](https://viblo.asia/p/bai-16-su-dung-axios-de-goi-laravel-api-trong-vuejs-GrLZDw7OKk0) about calling Laravel APIs in Vue using Axios
# How to run
First clone the project and run the following command:
```
composer install
npm install
```
Next create `.env`:
```
cp .env.example .env
```
Then update Database info in `.env` to match your environment and generate project key and migrate DB:
```
php artisan key:generate
php artisan migrate
```
Finally start the project:
```
php artisan serve
npm run watch
```
