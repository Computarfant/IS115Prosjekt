# IS115Prosjekt
Repository for gruppeprosjekt i IS115

Create A new Database and update the configs in config.inc.php

$config["db"]["host"] = "localhost:your-port";

$config["db"]["user"] = "root";

$config["db"]["pass"] = "";

$config["db"]["database"] = "database name";



To run the tests, use the following command:

./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/testFiles/bookingServiceTest.inc.php

Simply replace bookingServiceTest.inc.php with the test file you want to execute.