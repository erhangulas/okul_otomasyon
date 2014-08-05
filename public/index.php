<?php

//mysql client'lari sql dump (sql export) verirken viewlarin basina create algorithm gibi bir ibare ekliyor. onlar silinip create view kalmalı
//mysql client ise yaramadigi acil durumlarda wampin altindaki mysql dizinine komut satiri ile gidilip mysql -u root -p komutu ile giriş yapilabilir
//tablolar arasinda farklilik olmamasi icin her tablonun MyIsam olmali..


define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));
define('ROOT_DIR', realpath(dirname(__FILE__) . '/../'));
define("ROOT_PUBLIC",ROOT_DIR."/public/");
define('APPLICATION_PATH', BASE_PATH . '/application');

//error_reporting(E_ALL  || ~E_NOTICE);

mb_internal_encoding("UTF-8");
ini_set('default_charset','UTF-8');

date_default_timezone_set('Europe/Istanbul');



set_time_limit(0);

set_include_path('.'
                  . PATH_SEPARATOR . ROOT_DIR . '/library'
                  . PATH_SEPARATOR . '/usr/share/pear'
                  //. PATH_SEPARATOR . ROOT_DIR . '/application/forms'
                  . PATH_SEPARATOR . ROOT_DIR . '/application/model'
                  . PATH_SEPARATOR . get_include_path());

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV',
              (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV')
                                         : 'production'));

require_once 'Zend/Loader/Autoloader.php';

$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->setFallbackAutoloader(true);


// Zend_Application
require_once 'Zend/Application.php';

$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);



/*
$modules = array('yonetim',"admin");
foreach ($modules as $modul) {
    set_include_path(get_include_path() . PATH_SEPARATOR . ROOT_DIR . '/application/modules/'. $modul .'/models');
    set_include_path(get_include_path() . PATH_SEPARATOR . ROOT_DIR . '/application/modules/'. $modul .'/forms');
    set_include_path(get_include_path() . PATH_SEPARATOR . ROOT_DIR . '/application/modules/'. $modul .'/views');
    set_include_path(get_include_path() . PATH_SEPARATOR . ROOT_DIR . '/application/modules/'. $modul .'/controllers');
}
*/


$application->bootstrap();
$application->run();
