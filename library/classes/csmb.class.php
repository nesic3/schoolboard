<?php
	class csmb{
		private static $__instance=null;
		public static $csmb;
		public function __construct($_arr = array()){
		}
		public static function __init($_arr = array()){
      //
		}
		public static function getInstance($_arr = array()){
			if(!isset(self::$__instance) || self::$__instance===null){
				self::$__instance = new csmb();
			}
			self::$csmb = self::$__instance;
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

      $avg = array_sum($_grades)/count($_grades);
      $result = 'Fail';

      // If student has more than two grades
      if(count($_grades)>2){
        // Discard lowest grade
        asort($_grades);

        // Only one grade, but... // What if student two or more values for the lowest grade?
        array_shift($_grades);

        // Average calculation
        $avg = array_sum($_grades)/count($_grades);
        if($_grades[count($_grades)-1]>8){
          $result = 'Pass';
        }
      }else{
        //
      }
      $xml = new SimpleXMLElement('<xml/>');
      #$students = $xml->addChild('students');
      $student = $xml->addChild('student');
      $student->addChild('id', $_student['id']);
      $student->addChild('name', "$_student[firstname] $_student[surname]");

      $grades = $student->addChild('grades');
      foreach($_grades as $grade){
        $grades->addChild('grade', $grade);
      }
      $student->addChild('avg', $avg);
      $student->addChild('result', $result);

      header('Content-Type: application/xml; charset=utf-8');
      echo $xml->asXML();
    }
  }
