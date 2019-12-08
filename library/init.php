<?php
	define("haug", "bre");

	// More definitions
	require_once(DIR_LIB."/defines.php");

	date_default_timezone_set('Europe/Belgrade');

	// Error Log
	error_reporting(E_ALL);
	@ini_set("display_errors", 1);
	@ini_set("log_errors", 1);
	@ini_set("error_log", APPL_DIR."/log/0err0rs.log");

	set_time_limit(60);

	// Load MAIN Class
	require_once(DIR_DB."/main.class.php");
	main::getInstance();
	main::set('project', 'SchoolBoard');

	// Load DB Class
	require_once(DIR_DB."/db.class.php");
	db::getInstance();

	require_once(DIR_DB."/html.class.php");
	html::getInstance();

	// Load request class
	require_once(DIR_DB."/request.class.php");
	request::getInstance();

	// CSM Board
	require_once(DIR_CLASSES."/csm.class.php");
	csm::getInstance();

	// CSM Board
	require_once(DIR_CLASSES."/csmb.class.php");
	csmb::getInstance();

	// Load students Class
	require_once(DIR_CLASSES."/students.class.php");
	students::getInstance();

	// Load students Class
	require_once(DIR_CLASSES."/grades.class.php");
	grades::getInstance();

	// Main initilization
	main::init();

	// AGI is
	if(!defined("AGI")){

		// Load additional classes
	}else{
		$_qry = array();
		if(isset($_SERVER['argc']) && isset($_SERVER['argv']) && isset($_SERVER['argv'][1]) && $_SERVER['argc']>1){
			parse_str(str_replace(array("\n","\r\n"),'&',$_SERVER['argv'][1]), $_qry);
		}
	}
?>
