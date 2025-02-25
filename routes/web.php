<?php

  /* 
  * following 3 lines are here for testing & debugging purpose.
  * uncomment them for seeing PHP warning and error messages on web display or on console->network for ajax files.
  * NOTE: Must make sure to comment them again before pushing your changes.
  */
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL & ~E_NOTICE); // Exclude notices to be shown on display/console.
  
  include_once("../init/config.app.php");
  include_once('../vendor/autoload.php');

  /*
  *  Documentation for router: https://phprouter.com/
  */
  use Lib\Router;

  Router::get(WORKING_DIR.'/', 'index');

  // AJAX requests
  Router::post(WORKING_DIR.'/home/page' , '/ajax/home/getPageData');

?>