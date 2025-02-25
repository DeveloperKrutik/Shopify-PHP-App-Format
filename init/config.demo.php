<?php

  // CREATE NEW FILE IN THIS SAME PATH NAMED 'config.app.php' AND REPLACE THE `DEFAULT_VALUE` WITH YOUR DATA.

  // Changes we have to made while transforming from development to production
  // 1) change the [extensions.ui.paths] from all shopify.extension.toml file.
  // 2) update this file based on server configurations.

  // change this in production
  define('WORKING_DIR', 'DEFAULT_VALUE');
  define('HOST_URL', 'DEFAULT_VALUE');
  define('BASE_URL', HOST_URL.WORKING_DIR);
  // ... 

  define('APP_NAME', 'YOUR_APP_NAME');
  define('APP_EMAIL', 'YOUR_APP_EMAIL');
  define('APP_ADMIN_PATH', '/admin/apps/YOUR_APP_NAME_IN_LOWERCASE');
  
  define('ROUTER_TO_APP', '../app/');
  define('FILE_NOT_FOUND_PATH', 'common/404');
  define('ACCESS_SCOPES', 'REQUIRED_ACCESS_SCOPES');
  define('API_KEY', 'DEFAULT_VALUE');
  define('API_SECRET', 'DEFAULT_VALUE'); 

  // Database configs
  define('DB_USER', 'YOUR_DATABASE_USERNAME'); 
  define('DB_HOST', 'YOUR_DATABASE_HOSTNAME'); 
  define('DB_NAME', 'YOUR_DATABASE_NAME');          // Match this name with the db name in `/migrations/db_setup.php`, If you are directly going to run the sql file.
  define('DB_PASSWORD', 'YOUR_DATABASE_PASSWORD'); 
  // ...

  // App Function's id (get this from shopify's partners dashboard, App > YOUR_APP > Extensions) (optional)
  // define('APP_PROD_DISC_STANDARD_FUNCTION_ID', 'DEFAULT_VALUE'); 
  // define('APP_PAYMNT_CUSTMZ_STANDARD_FUNCTION_ID', 'DEFAULT_VALUE'); 
  // define('APP_SHIP_DISC_STANDARD_FUNCTION_ID', 'DEFAULT_VALUE'); 
  // ...
  
?>