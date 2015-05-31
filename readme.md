# Library

Library Site with Laravel 5

##Requirements

	PHP >= 5.4.0
	MCrypt PHP Extension
	SQL server(for example MySQL)

-----
##How to install:
* [Step 1: Get the code](#step1)
* [Step 2: Use Composer to install dependencies](#step2)
* [Step 3: Create database](#step3)
* [Step 4: Install](#step4)
* [Step 5: Start Page](#step5)

-----
<a name="step1"></a>
### Step 1: Get the code - Download the repository

    https://github.com/imancha/Library/archive/master.zip

Extract it in www(or htdocs if you using XAMPP) folder and put it for example in library folder.

-----
<a name="step2"></a>
### Step 2: Use Composer to install dependencies

Laravel utilizes [Composer](http://getcomposer.org/) to manage its dependencies. First, download a copy of the composer.phar.
Once you have the PHAR archive, you can either keep it in your local project directory or move to
usr/local/bin to use it globally on your system.
On Windows, you can use the Composer [Windows installer](https://getcomposer.org/Composer-Setup.exe).

Then run:

    composer install
to install dependencies Laravel and other packages.

-----
<a name="step3"></a>
### Step 3: Create database

Now you can create database on your database server(MySQL). You must create database with utf-8 collation(uft8_general_ci), to install and application work perfectly.
After that, copy .env.example and rename it as .env and put connection and change default database connection name, only database connection, put name database, database username and password.

Then run:

    php artisan key:generate
to generate key for the application.

-----
<a name="step4"></a>
### Step 4: Install

Now that you have the environment configured, you need to create a database configuration for it. For create database tables use this command:

    php artisan migrate

And to initial populate database use this:

    php artisan db:seed

-----
<a name="step5"></a>
### Step 5: Start Page

If you install on your localhost in folder library, you can type on web browser:

	http://localhost/library/public

You can now view the library homepage.

-----
## Troubleshooting

### Site loading very slow

	composer dump-autoload
	php artisan optimize

-----
### License

This is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
