<?php
	class csm{
		private static $__instance=null;
		public static $csm;
		public function __construct($_arr = array()){
		}
		public static function __init($_arr = array()){
      //
		}
		public static function getInstance($_arr = array()){
			if(!isset(self::$__instance) || self::$__instance===null){
				self::$__instance = new csm();
			}
			self::$csm = self::$__instance;
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
    public static function calculate($_arr = array()){
      $_student = self::get('student');
      $_grades = array_column(self::get('grades'), 'grade');

      // Average calculation
      $avg = array_sum($_grades)/count($_grades);

      $result = ($avg>=7) ? 'Pass' : 'Fail';

			// Geting results into array
			$_result = array(
				'id' => $_student['id'],
				'name' => "$_student[firstname] $_student[surname]",
				'grades' => $_grades,
				'avg' => $avg,
				'result' => $result
			);

      header('Content-Type: application/json; charset=UTF-8', true, 200);
      echo json_encode($_result, JSON_UNESCAPED_UNICODE, JSON_NUMERIC_CHECK);
    }
  }
