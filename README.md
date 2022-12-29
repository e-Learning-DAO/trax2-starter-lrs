### LRS-to-IPFS is a fork of [trax2-starter-lrs](https://github.com/trax-project/trax2-starter-lrs) a beaufutul project because simple, clean and effective.

We added the feature of storing xAPI statements on IPFS, to allow users of saving permanently the learning experience and associate it with a personal Cardano crypto wallet.

There are many other ways to achieve the same goal by adopting other LRSs and data transfers technique, however, we found this way to be quick and easy.

The instructions below are slightly modified compared to the original project.

---------------------------------------------------------------------

# TRAX LRS 2.0.3 - Starter Edition


## About TRAX LRS

TRAX LRS is an xAPI conformant Learning Record Store (LRS) built with Laravel.

It focuses on the core features of an LRS, and that's it!

We want to keep it simple and clean, and give you the freedom to build what you want around it.

Fore further information, visit http://traxlrs.com


## Sofware License & Copyright

TRAX LRS **Starter Edition** is distributed under the [GNU-GPL3 license](https://www.gnu.org/licenses/gpl-3.0.fr.html).

Copyright 2022 Sébastien Fraysse, http://fraysse.eu, sebastien@fraysse.eu.


## Server Requirements

### Apache 2.4

- mod_rewrite

### PHP 7.4 to 8.0

Check that your PHP version and configuration is valid both for PHP Web & CLI.

- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO (PDO_MYSQL / PDO_PGSQL)
- Tokenizer
- XML

### Database

- MySQL: 5.7.7 or 8.0
- MariaDB: 10.3 or 10.4
- PostgreSQL: 12 or 13

### Utilities

- Git
- Composer 2

## Fresh install

### First Steps

Assuming that you want to install TRAX LRS in a folder named **traxlrs**:

```
git clone https://github.com/eLearningDAO/trax2-starter-lrs traxlrs
cd traxlrs
composer install
```

### File Permissions

The folders `storage` and `bootstrap/cache` must be writable both by the webserver and the console user.
Assuming that the ownership has been properly set, you should be able to assign a `0775` permission
to the folders and subfolders and a `644` permission to the files.
Check this post for further details: https://laracasts.com/discuss/channels/laravel/proper-folder-permissions

If you are not sure how to configure this, you can use the following commands **FOR TESTING PURPOSE ONLY**.

```
chmod -R 777 bootstrap/cache
chmod -R 777 storage
```

### Web Server

For security reasons, only the `public` folder should be accessible by the web server.
Create a virtual host and configure the document root to `traxlrs/public`.


### Database

Create an empty database with the `utf8mb4_unicode_ci` encoding.
Then, at the root of the application folder, make a copy of the `.env.example` file,
rename it `.env` and enter your database settings.

*MySQL/MariaDB example:*

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=traxlrs
DB_USERNAME=root
DB_PASSWORD=
```

*PostgreSQL example:*

```ini
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=traxlrs
DB_USERNAME=postgres
DB_PASSWORD=aaaaaa
```

### Pinata
Create your account at https://www.pinata.cloud/ and create the `API Key` from https://app.pinata.cloud/developers and configure in `.env` for following parameters.
```
PINATA_API_KEY=
PINATA_API_SECRET=
```

### App URL

In the `.env` file, you must set the public URL of your TRAX LRS application :

```ini
APP_URL=http://traxlrs.test
```

### Last Steps

```
php artisan key:generate
php artisan migrate
```


## Admin Account

You can now create an admin account with the following command.
This will give your credentials to log into the application.

```
php artisan admin:create
```

Additional commands are available to manage the admin accounts:

```powershell
php artisan admin:list
php artisan admin:update
php artisan admin:delete
```

## Cron Job for Pinata Push 
```
php artisan trax:push2ipfs
```

## Configure Moodle to Pass xAPI data to TraxLRS
1. Install `Logstore xAPI` from https://moodle.org/plugins/logstore_xapi
2. Create the `client` in TraxLRS.
3. Setup the credentials in `Logstore xAPI` in moodle.

## Production server

In the `.env` file, changes settings from:

```ini
APP_ENV=local
APP_DEBUG=true
```

To:

```ini
APP_ENV=production
APP_DEBUG=false
```

To optimize performances, you can run the following commands.

```powershell
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
```

The `php artisan config:cache` command must be ran again after each config change.

## Known issues

### SQLSTATE[42000]: Syntax error or access violation: 1071

If you get this error during the `php artisan migrate` command, check your version of MySQL or MariaDB.
Since TRAX LRS 2.0.2, MySQL versions older than 5.7.7 are not supported anymore.
MariaDB versions older than 10.3 are not supported.

### 404 error on the main page

TRAX LRS has a `/public/.htaccess` file with some Apache directives.
When these directives are ignored by Apache, this leads to a 404 error.
In this case, check the `httpd.conf` file of Apache and try to set the `AllowOverride` option to `All`:

```xml
<Directory "path/to/laravel/project/public">
    Allowoverride All
</Directory>
```

