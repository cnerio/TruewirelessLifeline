<?php
 $config = parse_ini_file($_SERVER['DOCUMENT_ROOT']. "/config.ini");
 //print_r($config);
  // DB Params
  define('DB_HOST', $config["dbhost"]);
  define('DB_USER', $config["dbuser"]);
  define('DB_PASS', $config["dbpass"]);
  define('DB_NAME', $config["dbname"]);
  //echo $_SERVER['DOCUMENT_ROOT'];
  
  // App Root
  define('APPROOT', dirname(dirname(__FILE__)));

 
  $GLOBALS["urlroot"] = $config["urlroot"];
  // URL Root
  define('URLROOT', $GLOBALS["urlroot"]);
  // Site Name
  define('SITENAME', 'Galaxy Lifeline');
  // App Version
  define('APPVERSION', '1.0.0');