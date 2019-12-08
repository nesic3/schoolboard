<?php
	class students{
		private static $__instance=null;
		public static $students;
		public function __construct($_arr = array()){
		}
		public static function __init($_arr = array()){
      //
		}
		public static function getInstance($_arr = array()){
			if(!isset(self::$__instance) || self::$__instance===null){
				self::$__instance = new students();
			}
			self::$students = self::$__instance;
			self::__init($_arr);
			return self::$__instance;
		}
		public static function set($var, $val){
			self::$__instance->$var = $val;
		}
		public static function _set($_arr = array()){
			if(is_array($_arr) && $_arr){
				foreach($_arr as $k => $v){
					self::$__instance->$k = $v;
				}
			}
		}
		public static function get($var, $default = NULL){
			if(!isset(self::$__instance->$var)){
				self::set($var, $default);
			}
			return self::$__instance->$var;
		}
    public static function fetch($_arr = array()){
      $_tmp = array();
      $sql = "SELECT * FROM students WHERE 1 < 2";
      $result = db::_query($sql);
      foreach ($result as $row) {
        $_tmp[] = $row;
      }
      return $_tmp;
    }
  }
