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
      $sql = "SELECT s.* ";
			$sql .= " , sb.name AS schoolboard ";
			$sql .= " FROM students AS s ";
			$sql .= " LEFT JOIN school_boards AS sb ON sb.id = s.school_board_id ";
			$sql .= " WHERE 1 < 2";

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
			if(!$_arr['id']){
				die('Invalid ID');
			}
			$_tmp = self::fetch($_arr);
			return ($_tmp) ? $_tmp[0] : $_tmp;
		}
		public static function view($_arr = array()){

			// Getting student information
			$_student = self::load(array(
		    'id' => $_arr['id']
		  ));
			#main::ppre($_data);
			if(!$_student) die('No student found.');

			// Getting student grade information
			$_grades = grades::fetch(array(
				'student_id' => $_arr['id']
			));
			if(!$_grades) die('No grades for selected student.');
			#main::ppre($_grades);

			switch($_student['school_board_id']){
				case 1:
					csm::_set(array(
						'student' => $_student,
						'grades' => $_grades
					));
					csm::calculate();
				break;
				case 2:
					csmb::_set(array(
						'student' => $_student,
						'grades' => $_grades
					));
					csmb::calculate();
				break;
				default:
					die('No schoolboard specified for this student.');
				break;
			}
			exit();

			// Depends on the results display information in JSON or XML
			if($avg>=7){

			}else{


			}
		}
  }
