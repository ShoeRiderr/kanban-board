### Configuration

You have to install redis on your machine or server

After git clone you should open terminal in directory with project and type:
- ```cp .env.example .env```
- ```composer install```
Then create database and add credentials to .env file. After that back to command line:
- ```php artisan migrate --seed```
- ```php artisan storage:link```

To run locally you have to type in command line:
- ```redis-server```
- ```php artisan queue:listen```
- ```npm i && npm run dev```
- ```npm run echo-server```
- ```php artisan serve```
