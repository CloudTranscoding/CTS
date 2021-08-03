[![Build Status](https://api.travis-ci.org/voku/pagination.svg?branch=master)](https://travis-ci.org/voku/pagination)
[![Coverage Status](https://coveralls.io/repos/voku/pagination/badge.svg?branch=master&service=github)](https://coveralls.io/github/voku/pagination?branch=master)
[![codecov.io](https://codecov.io/github/voku/pagination/coverage.svg?branch=master)](https://codecov.io/github/voku/pagination?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/voku/pagination/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/voku/pagination/?branch=master)
[![Codacy Badge](https://api.codacy.com/project/badge/grade/4576482a3fc44cd196b566a422da9751)](https://www.codacy.com/app/voku/pagination)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/f2907ec9-2647-45bb-9606-8d1382a75d4d/mini.png)](https://insight.sensiolabs.com/projects/f2907ec9-2647-45bb-9606-8d1382a75d4d)
[![Latest Stable Version](https://poser.pugx.org/voku/pagination/v/stable)](https://packagist.org/packages/voku/pagination) 
[![Total Downloads](https://poser.pugx.org/voku/pagination/downloads)](https://packagist.org/packages/voku/pagination) 
[![Latest Unstable Version](https://poser.pugx.org/voku/pagination/v/unstable)](https://packagist.org/packages/voku/pagination)
[![PHP 7 ready](http://php7ready.timesplinter.ch/voku/pagination/badge.svg)](https://travis-ci.org/voku/pagination)
[![License](https://poser.pugx.org/voku/pagination/license)](https://packagist.org/packages/voku/pagination)

Paginator
==========

Pagination, without a database dependency.

## Install / Download
You can download it from here, or require it using [composer](https://packagist.org/packages/voku/pagination).
```json
{
    "require": {
      "voku/pagination": "2.*"
    }
}
```

##Install via "composer require"
```shell
composer require voku/pagination
```

## Usage
1. include the composer-autoloader
2. instantiate a new object pass in the number of items per page and the instance identifier, this is used for the GET parameter such as ?p=2
3. pass the set_total method the total number of records
4. show the records 
5. call the page_links method to create the navigation links

```php
use voku\helper\Paginator;

// include the composer-autoloader
require_once dirname(__DIR__) . '/vendor/autoload.php';

$pages = new Paginator('10','p');
$pages->set_total('100'); //or a number of records

// display the records here

echo $pages->page_links();
```
if using a database you limit the records by placing $pages->get_limit() in your query, this will limit the number of records

```php
SELECT * FROM table $pages->get_limit()
```
 
by default the page_links method created links starting with ? this can be changed by passing in a parameter to the method:

```php
echo $pages->page_links('&');
```

The method also allows you to pass in extra data such as a series of GET's

```php
echo $pages->page_links('?' . 'status=' . $_GET['status'] . '&active=' . $_GET['active'] . '&');
``` 
 
## Database example

```php
use voku\helper\Paginator;

// include the composer-autoloader
require_once dirname(__DIR__) . '/vendor/composer/autoload_real.php';

// create new object pass in number of pages and identifier
$pages = new Paginator('10','p');

// get number of total records
$rows = $db->query('SELECT id FROM table');
$total = count($rows);

// pass number of records to
$pages->set_total($total); 

$data = $db->query('SELECT * FROM table ' . $pages->get_limit());
foreach($data as $row) {
  // display the records here
}

// create the page links
echo $pages->page_links();
```

## MVC example

using this class in an MVC environment its almost the same, only the database or dataset calls come from the model instead of the page directly.

in the controller:

```php
use voku\helper\Paginator;

// create a new object
$pages = new Paginator('10','p');

// set the total records, calling a method to get the number of records from a model
$pages->set_total( $this->_model->get_all_count() );

// calling a method to get the records with the limit set
$data['records'] = $this->_model->get_all( $pages->get_limit() );

// create the nav menu
$data['page_links'] = $pages->page_links();

// then pass this to the view, may be different depending on the system
$this->_view->render('index', $data);
```

## API example

```php
use voku\helper\Paginator;

// include the composer-autoloader
require_once dirname(__DIR__) . '/vendor/autoload.php';

// create new object pass in number of pages and identifier
$pages = new Paginator('10','p');

// get number of total records
$rows = $db->query('SELECT id FROM table');
$total = count($rows);

// pass number of records to
$pages->set_total($total); 

$data = $db->query('SELECT * FROM table ' . $pages->get_limit());
foreach($data as $row) {
  // display the records here
}

// create the api-call
header('Content-Type: application/json');
echo json_encode($pages->page_links_raw());
```

... OR ...

```php
use voku\helper\Paginator;

// include the composer-autoloader
require_once dirname(__DIR__) . '/vendor/autoload.php';

$page = (int)$_GET['page'];
$perPage = (int)$_GET['per_page'];

$data = array('some', 'kind', 'of', 'data');

// use the helper-class to reduce the number of pages
$result = PaginatorHelper::reduceData($data, $perPage, $page);

// create the api-call
header('Content-Type: application/json');
echo json_encode($pages->page_links_raw());
```
