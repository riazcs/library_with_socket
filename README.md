Please this project install linux machine.

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

````
database seed
php artisan db:seed
````
```
socket run command
nohup php artisan websocket:init > websocket.log 
```
