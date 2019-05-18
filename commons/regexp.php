<?php

// "/^[a-z]{3,}$/i"
$reg_nick = "/^[\d\a-z+]{3,30}/is";
// "/^[\d\+]{5,30}$/"
// "/^[\d\a-z+]{5,30}/is"
$reg_password = "/^[\d\a-z+]{5,30}/is";
$reg_mail = "/^.{1,100}@.{1,30}\..{1,30}$/is";

// if( empty($mail) || (filter_var($mail, FILTER_VALIDATE_EMAIL) === false) )

	// http://www.php.su/articles/?cat=regexp&page=008
	// $arr = [];
	// preg_match("/^[\d\+]+$/",$str, $arr); // only digit or +
	// print_r( $arr  );
	// exit();
	// ^    -- begin string
	// [\d\+]    -- only digits or +
	// +  	-- 1 или большее число раз
	// $    -- end string


	// "/^.{1,100}@.{1,30}\..{1,30}$/is"
	// "/^.+@.+\..+$/is"  начало - любойой символ любое кол-во раз -  @  - любойой символ любое кол-во раз  -  .  -  любойой символ любое кол-во раз  -  конец строки  / i - Не учитывать регистр s - однострочный

?>