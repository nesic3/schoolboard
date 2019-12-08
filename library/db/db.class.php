<?php
	class db
	{
		private static $_instance=null;
		public static $DB;

		/*
		public $db_host;
		public $db_user;
		public $db_pass;
		public $db_name;
		*/

		public $iid;
		public $__db;

		//public $mysql_type = "mysqli";

		public static function getInstance($_arr = array()){
			if(!isset(self::$_instance) || self::$_instance===null){
				self::$_instance = new DB();
			}
			self::$DB = self::$_instance;
			return self::$_instance;
		}

		public function __construct(){
		}
		public static function set($var, $val){
			self::$_instance->$var = $val;
		}
		public static function _set($_arr = array()){
			if(is_array($_arr) && $_arr){
				foreach($_arr as $k => $v){
					self::$_instance->$k = $v;
				}
			}
		}
		public static function get($var, $default = NULL){
			if(!isset(self::$_instance->$var)){
				self::set($var, $default);
			}
			return self::$_instance->$var;
		}
    public static function connect($try = 0){
			if(!file_exists(DB_FILE)){
				die('Database is not defined!');
			}
      $dbf = new PDO('sqlite:'.DB_FILE);
      self::$DB->__db = $dbf;
    }
		public static function _query($sql){
			$rez = self::$DB->__db->query($sql) or die(print_r(self::$DB->__db->errorInfo(), true)."\n\n"."<b><pre>$sql<pre></b>");
			return $rez;
		}
		public static function _close(){
			unset(self::$DB->__db);
		}

		public static function _real_escape_string($str){
			return addslashes($str);
		}
  }
