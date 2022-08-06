# Blog

Written on Laravel
### Features and instruments used

- Blog and admin parts
- Login and registration
- Validation
- Profile page
- Posts management
- Comments
- Follow/unfollow system
- Likes system
- Ajax requests
- Sorting
- Websockets:
    - Notifications
- Admin panel:
    - CRUD posts/comments/categories
    - Publish/unpublish posts/comments/postcategories


### Installation and deployment

1. Clone repo and install all dependencies:

```
composer install
npm i
```
`npm run dev` or `npm run prod`, depends on what environment you're on.

Make sure you created .env `cp .env.example .env`,

and generate laravel app key `php artisan key:generate`.

2. Create database and set corresponds properties in .env:
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
1. We use [beyondcode/laravel-websockets](https://github.com/beyondcode/laravel-websockets) for notification system, for that we need to set next .env variables:
```
BROADCAST_DRIVER=pusher
```
2. Set Pusher's (Pusher Channels broadcaster) properties (it does not matter what you set as your PUSHER_ variables, just make sure they are unique for each project):
```
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=
```
3. Set your SSL certificates paths(for HTTPS scheme):
```
LARAVEL_WEBSOCKETS_SSL_LOCAL_CERT=
LARAVEL_WEBSOCKETS_SSL_LOCAL_PK=
```
4. Once we have configured our WebSocket apps and Pusher settings, we can start the Laravel WebSocket server by issuing the artisan command:
```
php artisan websockets:serve
```
5. Finally, start up the queue:
```
php artisan queue:work
```
## Tech stack used

- Laravel
- Mysql for db
- Redis for queues and jobs
- [beyondcode/laravel-websockets](https://github.com/beyondcode/laravel-websockets) for notifications system
- [PHPFaker](https://github.com/FakerPHP/Faker) for seeds
