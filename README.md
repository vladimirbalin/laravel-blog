# Blog

Written on Laravel
### Features and instruments used

- Main and admin parts
- Login and registration
- Profile update
- Adding new, updating and deleting posts
- Comments: create, edit, delete
- Follow/unfollow system
- Likes system
- Sockets:
    - Notifications (notify user, whose post was liked or who was followed)
- Admin part:
    - Publish/unpublish posts/comments/postcategories
    - CRUD

### Installation and deployment

1. Clone repo and install all dependencies:

```
composer install
npm i
```
Make sure you created .env `cp .env.example .env`

And don't forget to generate laravel app key `php artisan key:generate`

2. Create database and set correspond properties in .env
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=notes
DB_USERNAME=
DB_PASSWORD=
```
3. Populate db with migrations and seeds:
 ```
php artisan migrate --seed
 ```

### Now lets setup our broadcasting system
1. Set Pusher's (Pusher Channels broadcaster) properties for backend:
```
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=
```
2. Install laravel echo server globally and initialize it:
```
npm install laravel-echo-server --location=global
laravel-echo-server init
```
Setup laravel-echo-server 'laravel-echo-server.json'

3. For frontend we have already installed 'laravel-echo' package, we just need to start our laravel echo server:
```
laravel-echo-server start
```
4. Start up the queue:
```
php artisan queue:work
```

## Tech stack used

- Laravel
- [PHPFaker](https://github.com/FakerPHP/Faker) for seeds
- Mysql for db
- Redis for queues and jobs
