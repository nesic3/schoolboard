<?php
	if(!defined("haug")){exit("Nothing here...");}

  main::_exit(array(
    'content' => students::view(array(
      'id' => $_req['id']
    ))
  ))
?>
