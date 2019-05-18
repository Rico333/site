<?php
	if( !isset($_SESSION) ) {
     	session_start();
	}
	if ( session_status() == PHP_SESSION_NONE ) {
  		session_start();
	}

	if( isset($_SESSION['nick']) && isset($_SESSION['id']) ){
		$is_authorize = true;
	}else{
		$is_authorize = false;
	}
?>