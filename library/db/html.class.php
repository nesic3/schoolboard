<?php
	Class html{
		private static $__instance=null;
		public static $html;
		public $_colors = null;
		public function __construct($_arr = array()){

		}
		public static function getInstance($_arr = array()){
			if(!isset(self::$__instance) || self::$__instance===null){
				self::$__instance = new html();
			}
			self::$html = self::$__instance;
			return self::$__instance;
		}
		public static function set($var, $val){
			self::$__instance->$var = $val;
		}
		public static function get($var, $default = NULL){
			if(!isset(self::$__instance->$var)){
				self::set($var, $default);
			}
			return self::$__instance->$var;
		}
		public static function content($_arr = array()){
			$_req = request::get('_request');
			$page = self::page();
			$_req = request::get('_request');
			ob_start();
			if(isset($_arr['modal'])){
				echo $page;
			}else{
				//include(DIR_INCLUDES."/theme.php");
				include(DIR_HTML."/head.php");
				include(DIR_HTML."/header.php");
				echo $page;
				include(DIR_HTML."/footer.php");
			}
			$content = ob_get_clean();
			if(self::get("sanitize", false)){
				$content = self::sanitize_output($content);
			}
			return $content;
		}
		public static function page($_arr = array()){
			#$_arr = $_req = main::$main->__request;
			#main::ppre(request::get('_request')); exit();
			#main::ppre(main::$main->__request); exit();
			$_arr['page'] = (isset($_arr['page'])) ? $_arr['page'] : main::$main->__page;
			$page_file = $_arr['page'];
			ob_start();
			$_params = main::get('_params');
			$_params['_req'] = request::get('_request');
			main::set('_params', $_params);
			extract(main::get('_params'));
			include(DIR_PAGES."/$page_file.php");
			$page = ob_get_clean();

			$html = "";
			#$html .= "<div id=\"main\" role=\"main\">";
				#$html .= "<div id=\"content\">";
					$html .= $page;
				#$html .= "</div>";
			#$html .= "</div>";
			return $html;
		}
		public static function module($_arr = array()){
			#if(isset(request::get('_request')['module']) && !empty(request::get('_request')['module'])){
			if(request::get('module')){
				#self::$html->__module = request::get('_request')['module'];
				self::$html->__module = request::get('module');
				#$m_file = request::get('_request')['module'];
				$m_file = request::get('module');
				$m = DIR_MODULES."/".main::$main->__class_name."/".$m_file.".php";
				if(!file_exists($m)){
					exit("missing module: $m");
				}else{
					#var_dump($m);
					#var_dump(file_exists($m));
					ob_start();
					extract(main::get('_params'));
					include($m);
					return ob_get_clean();
				}
			}else{
				request::set('module', 'index');
				return self::module(array($_arr));
				/*
				$_r = request::get('_request');
				$_r['module'] = 'index';
				request::set('_request', $_r);
				return self::module(array($_arr));
				*/
			}
			return "";
		}
		public static function checked($f){
			if($f){
				return " checked=\"checked\"";
			}
			return "";
		}
		public static function disabled($f){
			if($f){
				return " disabled";
			}
			return "";
		}

		public static function sanitize_output($buffer){
			#exit("@@@");
			$search = array(
				'/(\t)+/s',  // strip tabs
				'/\>[^\S ]+/s',  // strip whitespaces after tags, except space
				'/[^\S ]+\</s',  // strip whitespaces before tags, except space
				'/(\s)+/s'       // shorten multiple whitespace sequences
			);
			$replace = array(
					" ",
					#">\r\n",
					">",
					#"\r\n<",
					"<",
					"\\1"
			);
			$buffer = preg_replace($search, $replace, $buffer);
			return $buffer;
		}
		public static function sanitize_output_css($buffer, $obgzh = true){
			// Remove comments
			$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
			// Remove space after colons
			$buffer = str_replace(': ', ':', $buffer);
			// Remove whitespace
			$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
			// Enable GZip encoding.
			if($obgzh){
				#var_dump(ob_list_handlers());
				if (!in_array('ob_gzhandler', ob_list_handlers())) {
					ob_start('ob_gzhandler');
				}else{
					ob_start();
				}
				#ob_start("ob_gzhandler");
				// Enable caching
				header('Cache-Control: public');
				// Expire in one day
				header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');
				// Set the correct MIME type, because Apache won't set it for us
				header("Content-type: text/css");
			}
			return $buffer;
		}
		public static function fa($name, $size = "", $class = "", $extend = ""){
			$size = ($size!="") ? " fa-$size" : "";
			$class = ($class!="") ? " ".((is_array($class)) ? implode(" ", $class) : "$class") : "";
			return "<i class=\"fa fa-$name$size$class\"$extend></i>";
		}
		public static function entypo($name, $size = "", $class = "", $extend = ""){
			$size = ($size!="") ? " icon-$size" : "";
			$class = ($class!="") ? " ".((is_array($class)) ? implode(" ", $class) : "$class") : "";
			return "<span class=\"icon icon-$name$size$class\"$extend></span>";
		}
	}
?>
