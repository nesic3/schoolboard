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
      $sql = "SELECT * FROM students AS s WHERE 1 < 2";
			if(isset($_arr['id']) && $_arr['id']){
				$sql .= " AND s.id = '$_arr[id]' ";
			}
      $result = db::_query($sql);
      foreach ($result as $row) {
        $_tmp[] = $row;
      }
      return $_tmp;
    }
		public static function load($_arr = array()){
			if(!isset($_arr['id'])){
				die('No ID specified');
			}
			$_tmp = self::fetch($_arr);
			return ($_tmp) ? $_tmp[0] : $_tmp;
		}
		public static function view($_arr = array()){

			// Getting student information
			$_data = self::load(array(
		    'id' => $_arr['id']
		  ));
			#main::ppre($_data);
			if(!$_data) die('No student found.');

			// Getting student grade information
			$_grades = array();


			$avg = 10;
			$result = ($avg>=7) ? 'Pass' : 'Fail';
			// Geting results into array
			$_result = array(
				'id' => $_data['id'],
				'name' => "$_data[firstname] $_data[surname]",
				'grades' => $_grades,
				'avg' => $avg,
				'result' => $result
			);
			#exit();

			// Depends on the results display information in JSON or XML
			if($avg>=7){
				header('Content-Type: application/json; charset=UTF-8', true, 200);
				echo json_encode($_result, JSON_UNESCAPED_UNICODE, JSON_NUMERIC_CHECK);
			}else{
				header('Content-Type: application/xml; charset=utf-8');
			}
		}
  }
