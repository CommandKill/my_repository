# Easy-CMS

## Dependency

* [Bootstrap](http://getbootstrap.com/)
* [Sentry 2](https://cartalyst.com/manual/sentry/installation/laravel-4)
* [Laravel-4-Generators](https://github.com/JeffreyWay/Laravel-4-Generators#scaffolding)
* [Time ago](https://github.com/rmm5t/jquery-timeago)
* [select2](http://ivaynberg.github.io/select2/)
* [fileinput](https://github.com/kartik-v/bootstrap-fileinput/)
* [jquery file upload](https://github.com/blueimp/jQuery-File-Upload)

## Requirements
* PHP GD >=2.0 (for ubuntu server install `$sudo apt-get install php5-gd`)

## Getting started

- change permission allow to read and write to `/autobot-cms/app/storage/`

		$ chmod 777 -R storage/

- open `/public/.htaccess` set environment variable to your location

  		SetEnv LARAVEL_ENV dev
  		
	>  this project default env is 'dev' when you run `php artisan` on production will not work must append `--env=production` too like this:
	    
	    php artisan app:install --env=production

- copy `/default.env.location.php` and rename to `/.env.dev.php` up to **LARAVEL_ENV**

- Install dependency package first

		$ composer update

- and then run setup project

		$ php artisan app:install

- and you have adding some seed you can call
		
		$ php artisan app:seed

- or if you want refresh all of installation call this

		$ php artisan app:refresh

## How to import geo and car base

- geo

        $ mysql -u yourusename -p yourdbusername < geo.sql   <- enter
        $ yourdbpassword

- carbase

        $ mysql -u yourusename -p yourdbusername < carbase.sql   <- enter
        $ yourdbpassword

file for download

- http://128.199.200.28/easycar/public/carbase.tar.gz
- http://128.199.200.28/easycar/public/geo_2014-06-12.sql

## ElasticSearch

- we used this lib https://github.com/shift31/laravel-elasticsearch
- read this for develop http://www.elasticsearch.org/guide/en/elasticsearch/client/php-api/current/_overview.html and call every function via 'Es::'

## Tips

- When create new controller must call this `composer dump-autoload`
		
## Login in AutoBot CMS

* user: nattapong.kongmun@gmail.com
* password: admin
