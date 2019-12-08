<?php
	if(!defined("haug")){exit("Nothing here...");}
	main::require_class(array(
		'static' => true
	));
	$__this = main::$main->__this;
	if(isset($_req['student'])){
		request::set('module', 'view');
	}
	echo html::module();
?>
