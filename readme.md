# Realtime Laravel Web Apps restaurant ordering system (waiter, cook) with Node, Redis and Socket.io

##Installation
You can install the package using the Composer package manager. You can install it by running this command in your project root:

`composer update`

Edit .env file to fill database credentials
run `php artisan migrate`

`php artisan key:generate`

`php artisan cache:clear`

`php artisan config:cache`


##Install Redis Server

##Install Node.js

Then run

`npm install`

To launch the web-socket, use the command:

`node socket.js`

##Usage
Create users (cook, waiter, manager). Change user's role from 
Database (cook/waiter/manager). The manager can change user's role.

Open two browsers and login with two users you created (cook, waiter).