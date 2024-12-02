# IS115Prosjekt
Repository for gruppeprosjekt i IS115

Create A new Database and update the configs in .env

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

To run the tests, use the following commands:

./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/testFiles/bookingServiceTest.inc.php

./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/testFiles/roomAdminTest.inc.php

./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/testFiles/userServiceTest.inc.php

In the ENV file, comment out the database connection you do not want to use. There is one configuration for production and one for testing. The one which is not commented out will be used as the connection when you launch the project in the browser. 