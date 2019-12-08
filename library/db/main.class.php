<?php
	class main{
		private static $_instance=null;
		public static $main=null;

		public $__page=null;
		public $__this=null;
		public $__class=null;
		public $__class_name=null;
    public static function getInstance(){
			if(!isset(self::$_instance) || self::$_instance===null){
				self::$_instance = new main();
			}
			self::$main = self::$_instance;
			return self::$_instance;
		}

		public function __construct($_arr = array()){
			if(isset($_arr['init'])){
				self::init($_arr);
			}
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
		public static function ppre($_arr){
			echo "<pre>"; print_r($_arr); echo "</pre>";
		}

		public static function init($_arr = array()){

			// In case I need to use it like this
			$qry = (isset($_SERVER['QUERY_STRING'])) ? $_SERVER['QUERY_STRING'] : "";
			parse_str(str_replace(array("\n","\r\n"), '&', $qry), $_qry);

			// Predefined
			$_qry = array_merge($_qry, $_REQUEST);

			request::_set($_qry);
			request::set('_request', $_qry);
			main::set('_params', array(
				'__request' => $_qry
			));
			$__request = $_qry;

			self::db($_qry);
			self::load($_qry);
    }
		public static function db($_arr = array()){
			db::connect();
		}
		public static function load($_arr = array()){
			#self::ppre($_arr); exit();
			$_arr = array_merge($_arr, $_REQUEST);
			$page = $pageo = (isset($_arr['page'])) ? $_arr['page'] : "students";
			// Check if page file exists
			if(!empty($page)){
				switch($page){
					// AJAX (not a football club)
					case "ajax":
					break;
					default:
						if(!file_exists(DIR_PAGES."/$page.php")){
							error_log("pageFileMissing: ".DIR_PAGES."/$page.php");
							$page = $page = "404";
						}
					break;
				}
			}
			self::$main->__page = $page;
			$cf = self::$main->__class = DIR_CLASSES."/$page.class.php";
			$c = self::$main->__class_name = self::get_class(basename($page, ".php"));

			// Setting the default action
			if(!isset($_arr['action'])){
				//$_arr['action'] = 'view';
			}

			if(isset($_arr['action'])){
				if(!file_exists($cf)){
					error_log("missing class: $cf");
					//die()
				}else{
					self::require_class(array(
						'static' => true
					));
					// Checking method in a class
					if(!method_exists($c, $_arr['action'])){
						error_log("no such method $c:`$_arr[action]`");
						//die()
					}else{
						if(isset($_arr['module'])){
							//
						}
						$action = $_arr['action'];
						#var_dump($c, $action);
						$_result = $c::$action($_arr);
					}

					// Non static
				}
			}
		}

		public static function get_class($f){
			return $f;
			// use it for UC FIRST
			$c = "";
			if(strpos($f, "_")!==false){
				$_e = explode("_", $f);
				foreach($_e as $e){
					$c .= ucfirst($e);
				}
			}else{
				$c = ucfirst($f);
			}
			return $c;
		}
		public static function require_class($_arr = array()){
			$c = self::$main->__class;
			if(!file_exists($c)){
				exit("missing class: $c");
			}
			require_once($c);
			$c = self::$main->__class_name;
			if(isset($_arr['static'])){
				$c::getInstance();
				$c::set('table', $c);
				$$c = self::$main->__this = $c::getInstance();
			}else{
				$$c = self::$main->__this = new $c();
			}
		}
		public static function obclean($_arr = array()){
			if(ob_get_contents()!==false){ ob_clean(); }
			if(ob_get_contents()!==false){ ob_end_clean(); }
		}
		public static function toUrl($url = "", $out = false){
			if($url!=""){
				$url = "$url";
			}
			if(strpos($url, "/")===0){
				$url = ROOTURL."/$url";
			}
			if(!$url){
				$url = ROOTURL;
			}
			self::obclean();
			header("location:$url");
			self::_exit(array(
				'content' => ''
			));
		}
		public static function _exit($_arr = array()){
			if(isset($_arr['content'])){
				echo $_arr['content'];
			}
			db::_close();
			if(isset($_arr['return'])){
				return true;
			}
			exit();
		}
  }
