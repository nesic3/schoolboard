<?php
	if(!defined("haug")){exit("Nothing here...");}
	$_students = students::fetch();
	main::ppre($_students);
?>
