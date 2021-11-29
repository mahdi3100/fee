# Fee 

Fee is a php app using composer to handles operations provided in CSV format and calculates a commission fee based on defined rules.


## Tree of calcule/fee application

for the tree of main files of app 

```bach 
├── composer.json
├── composer.lock
├── csv
│   └── csv.csv
├── Readme.md
├── script.php
├── src
│   └── Service
│       ├── CalculeTransaction.php
│       ├── ClientPrivateRule.php
│       ├── Currencies.php
│       └── NewCSV.php
├── tests
│   └── Service
│       └── NewCSVTest.php
└── vendor
    ├── autoload.php
    ├── bin
    │   ├── php-parse -> ../nikic/php-parser/bin/php-parse
    │   └── phpunit -> ../phpunit/phpunit/phpunit
    ├── composer
    │   ├── autoload_classmap.php
    │   ├── autoload_files.php
    │   ├── autoload_namespaces.php
    │   ├── autoload_psr4.php
    │   ├── autoload_real.php
    │   ├── autoload_static.php
    │   ├── ClassLoader.php
    │   ├── installed.json
    │   ├── installed.php
    │   ├── InstalledVersions.php
    │   └── LICENSE
    

```

 
**csv:** directory that contains CSV files.

**src:** directory that contains that contains php classes .

**tests:** directory that contains that contains php test classes for PHPunit

**root Files:**

*"script.php":* main file to lunch the app from the command line , it takes 1 arg which is the path of csv file.

**src/ Files:**
		 
*"CalculeTransaction.php":* it contains the class InfoTransaction and child class CalculeTransaction .
		 
*"ClientPrivateRule.php":* it contains the class ClientPrivateRule .
		 
*"Currencies.php":* it contains the class Currencies .
		 
*"NewCSV.php":* it contains the class NewCSV .
		 
		 
****tests/ Files:**:**
	
*"NewCSVTest.php":* it contains the class NewCSVTest and an extended class from phpunit .
 
## Requirements 

PHP => 7.0

## Difficulties

The difficulty of this project to understand is in the class ClientPrivateRule , where the logic of the rule is a little complicalted.

## Usage 

##### Dev Usage

```bach
cd /to/path/where_composer_json
php script.php csv/csv.csv



```
##### PHPunit Usage

```bach
cd /to/path/where_composer_json
./vendor/bin/phpunit --testdox tests
```

## Note

Respecting the privacy of this test , the test is not on GITHub . Please , contact me for any bug from my website *https://mehdi.contact* or by my address *belhadj.mehdi93@gmail.com*.

## Contributing 

Belhadj Mehdi


## License 

[MIT](https://choosealicense.com/licenses/mit/) 
