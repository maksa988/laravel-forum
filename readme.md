# Laravel Forum

This is an open source forum that was built and maintained at Laracasts.com.

## Installation

### Prerequisites

* To run this project, you must have PHP 7 installed.
* You should setup a host on your web server for your local domain. For this you could also configure Laravel Homestead or Valet. 
* If you want use Redis as your cache driver you need to install the Redis Server. You can either use homebrew on a Mac or compile from source (https://redis.io/topics/quickstart). 

### Step 1

> To run this project, you must have PHP 7 installed as a prerequisite.

Begin by cloning this repository to your machine, and installing all Composer & NPM dependencies.

```bash
git clone git@github.com:maksa988/laravel-forum.git forum
cd forum && composer install && npm install
php artisan forum:install
npm run dev
```

### Step 2.

Next, boot up a server and visit your forum. If using a tool like Laravel Valet, of course the URL will default to `http://forum.test`. 

Visit: `http://forum.test/register` to register a new forum account.

### Step 3.

Use your forum! Visit `http://forum.test/` to create a new account and publish your first thread.