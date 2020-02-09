# karsoaji-oki-techtask-php
Suggested recipes for lunch API

## Installation
- Clone the repository with git clone
- Go to project directiory
- Run `composer install`

## Support Test Using PHPUnit
We have a test file to do the lunch controller test. You can run it by running the command `php bin/phpunit tests/Controller/LunchControllerTest.php`
in the prject folder. You can create your own test file, by placing it in the test folder

## Running project
- Go to project directiory
- Run `symfony serve`

## Endpoint support
- [/lunch](https://github.com/congky/karsoaji-oki-techtask-php/new/master?readme=1#lunch)

## /lunch
parameter :
- use-by (optional) : recipes with ingredients past the `use-by` date will not be displayed, format Y-m-d
- best-before (optional) : recipes with ingredients that have passed the 'best-before' date but have not yet passed 'use-by' will be displayed at the bottom, format Y-m-d

response OK :
```
{
 "code" : 200,
 "status" : "OK",
 "response" : [
  {
    "title": "Fry-up",
    "ingredients": [
        "Bacon",
        "Eggs",
        "Baked Beans",
        "Mushrooms",
        "Sausage",
        "Bread"
    ]
  }, ...
 ]
}
```

response FAIL :
```
{
 "code" : "EXCEPTION CODE",
 "status" : "FAIL",
 "message" : "Error Message"
}
```
