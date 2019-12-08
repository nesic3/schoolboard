<?php
	if(!defined("haug")){exit("Nothing here...");}

  if(!isset($_req['student'])){
    die('Please specify student ID.');
  }

  main::_exit(array(
    'content' => students::view(array(
      'id' => $_req['student']
    ))
  ))
?>
