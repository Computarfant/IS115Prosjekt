# IS115Prosjekt
Repository for gruppeprosjekt i IS115

Create A new Database and update the configs in config.inc.php

$config["db"]["host"] = "localhost:your-port";

$config["db"]["user"] = "root";

$config["db"]["pass"] = "";

$config["db"]["database"] = "database name";



To run the tests, use the following commands:

./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/testFiles/bookingServiceTest.inc.php

./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/testFiles/roomAdminTest.inc.php

./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/testFiles/userServiceTest.inc.php

In the ENV file, comment out the database connection you do not want to use. There is one configuration for production and one for testing. The one which is not commented out will be used as the connection when you launch the project in the browser. 