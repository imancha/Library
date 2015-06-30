# Library

Library Site with Laravel 5

##Requirements

	PHP >= 5.4
	Mcrypt PHP Extension
	OpenSSL PHP Extension
	Mbstring PHP Extension
	Tokenizer PHP Extension
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

    https://github.com/imancha/Library/release

Extract it in www(or htdocs if you using XAMPP) folder and put it for example in `library` folder.

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
After that, copy `.env.example` and rename it as `.env` and put connection and change default database connection name, only database connection, put name database, database username and password.

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

Or import database from `../database/Library.sql`

-----
<a name="step5"></a>
### Step 5: Start Page

If you install on your localhost in folder `library`, you can type on web browser:

	http://localhost/library/public

Or run:

	php artisan serve

Then type on web browser:

	http://localhost:8000

You can now view the public homepage. If you want to view the admin homepage, you can type on web browser:

	http://localhost/library/public/admin

Or run:

	php artisan serve

Then type on web browser:

	http://localhost:8000/admin

And fill the login form with account below.

Staff Account:

	email   : staff@imail.com
	password: imancha

Kabag Account:

	email   : kabag@imail.com
	password: imancha

-----
## Troubleshooting

### Site loading very slow

	composer dump-autoload
	php artisan optimize

-----
### Pretty URLs

The framework ships with a public/.htaccess file that is used to allow URLs without index.php. If you use Apache to serve your Laravel application, be sure to enable the mod_rewrite module. 
If the .htaccess file that ships with Laravel does not work with your Apache installation, try this one:

	Options +FollowSymLinks
	RewriteEngine On
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteRule ^ index.php [L]

-----
### Virtual Host

If the site can't be accessed, try to create virtual host first. Navigate to `C:/xampp/apache/conf/extra` or wherever you installed xampp and open up `httpd-vhosts.conf`.
Then at the very bottom of the file paste the following:

	<VirtualHost *:80>
		DocumentRoot "C:/xampp/htdocs/Library/public"
		ServerName library.dev
		<Directory "C:/xampp/htdocs/Library/public">
			<IfModule mod_rewrite.c>
				Options +FollowSymLinks
				RewriteEngine On
				RewriteCond %{REQUEST_FILENAME} !-d
				RewriteCond %{REQUEST_FILENAME} !-f
				RewriteRule ^ index.php [L]
			</IfModule>
			Require all granted
			AllowOverride All
		</Directory>
	</VirtualHost>

And to open the homepage, type on web browser:

	http://library.dev
	
-----
### License

This is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
