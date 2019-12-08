<?php
  force_gzip();

  // Predefined constants

  // DB_NAME which is actually name of the db file
  define('DB_NAME', 'thisisthedb.sq3');

  define("APPL_DIR", dirname(__FILE__));
  define("DIR_LIB", APPL_DIR."/library");

  // Initialization
  require(DIR_LIB."/init.php");
  $_req = request::get('_request');

  main::$main->content = $content = html::content($_req);
  echo $content;

  function force_gzip(){
		if(!defined("GZIP_STARTED")){
			define("GZIP_STARTED", 1);
			define("OB", 1);
			if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false)
			{ob_start('ob_gzhandler'); ob_start();}
			else
			ob_start();
		}
	}
