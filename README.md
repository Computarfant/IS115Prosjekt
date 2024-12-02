# Motell Booking System PHP

=======
Repository For Group Project in IS115

Gruppe 16 | Lennart Birkeland & Viktor Fjuk


## Configure Database Connection

Create A new Database and update the configs in .env

In the ENV file, comment out the database connection you do not want to use. 
There is one configuration for production and one for testing. 
The one which is not commented out will be used as the connection when you launch the project in the browser.


# Production environment
ENVIRONMENT=production
DB_HOST=localhost:your-port
DB_USER=
DB_PASS=
DB_NAME= 'database name'

# Test environment
ENVIRONMENT=test
DB_HOST=localhost:your-port
DB_USER=
DB_PASS=
DB_NAME= 'database name'
=======



## Testing With PHPunit

To run the tests, use the following commands:

./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/testFiles/bookingServiceTest.inc.php

./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/testFiles/roomAdminTest.inc.php

./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/testFiles/userServiceTest.inc.php

 
## Test Issues

If you get this error when trying to access the dbSetupfile in authentication:
Warning: require(C:\xampp\htdocs\IS115Prosjekt\vendor\composer/../myclabs/deep-copy/src/DeepCopy/deep_copy.php): Failed to open stream: No such file or directory in C:\xampp\htdocs\IS115Prosjekt\vendor\composer\autoload_real.php on line 41

DELETE the vendor folder and composer.lock file. Then reinstall composer with: composer install
