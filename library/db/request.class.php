<?php
	class request{
		private static $_instance=null;
		public static $request;
		
		public static function getInstance($_arr = array()){
			if(!isset(self::$_instance) || self::$_instance===null){
				self::$_instance = new request();
			}
			self::$request = self::$_instance;
			return self::$_instance;
		}
		public function __construct(){
		}
		public static function set($var, $val){
			if(!is_array($val)){
				$val = db::_real_escape_string($val);
			}
			self::$_instance->$var = $val;
		}
		public static function _set($_arr = array()){
			if(is_array($_arr) && $_arr){
				foreach($_arr as $k => $v){
					if(!is_array($v)){
						$v = db::_real_escape_string($v);
						self::$_instance->$k = trim($v);
					}else{
						array_walk_recursive($v, function(&$item, $key) {
							$item = addslashes($item);
						});
						self::$_instance->$k = $v;
					}
				}
			}
		}
		public static function get($var, $default = NULL){
			if(!isset(self::$_instance->$var)){
				self::set($var, $default);
			}
			return self::$_instance->$var;
		}
		public static function shift($_arr = array()){
			$_temp = array();
			foreach($_arr as $k => $v){
				@preg_match("/^p(\d+$)/is", $k, $_tmp);
				if($_tmp && isset($_tmp[1])){
					$pkv = $_tmp[1]-1;
					if($pkv==0){
						continue;
					}
					$_temp["p$pkv"] = $v;
				}else{
					$_temp[$k] = $v;
				}
			}
			return $_temp;
		}
	}
?>