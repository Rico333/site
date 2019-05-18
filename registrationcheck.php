<?php
	session_start();
	
	if(     (!isset( $_POST )) || (!isset($_POST['nick']))  || (!isset($_POST['mail'])) || (!isset($_POST['pass'])) 
						       ||   empty($_POST['nick'])   ||   empty($_POST['mail'])  ||   empty($_POST['pass'])       ){
		header("Location: /site/registration.php?validate=1");
		exit();
	}

	include_once( $_SERVER['DOCUMENT_ROOT'].'/site/commons/checkauthorize.php');
	if( $is_authorize ){
		header("Location: /site/messagepage.php?message=Please log out before registration");
		exit();
	}

    include_once( $_SERVER['DOCUMENT_ROOT'].'/site/commons/regexp.php');


	$str = $_POST['nick'];
	$str = stripslashes($str);
    $str = htmlspecialchars($str);
    $str = trim( $str );
	if( !preg_match( $reg_nick, $str) ){ 
		header("Location: /site/registration.php?validate=2");
		exit();
	}
	$nick = $str;

	

	$str = $_POST['mail'];  
	$str = stripslashes($str);
    $str = htmlspecialchars($str);
    $str = trim( $str );
	// if( empty($mail) || (filter_var($mail, FILTER_VALIDATE_EMAIL) === false) ){ 
	if( empty($str) || (!preg_match( $reg_mail, $str) ) ){ 
		header("Location: /site/registration.php?validate=3");
		//echo FILTER_VALIDATE_EMAIL."<br/>".$mail;
		//echo "eriewrp";
		exit();
	}
	$mail = $str;



	$str = $_POST['pass'];
	$str = stripslashes($str);
    $str = htmlspecialchars($str);
    $str = trim( $str );
	if( !preg_match( $reg_password, $str ) ){ 
		header("Location: /site/registration.php?validate=4");
		exit();
	}
	$pass = $str;



    include_once( $_SERVER['DOCUMENT_ROOT'].'/site/commons/dbconnect.php');
  	if( $pdo == null ){
  		header( "location: /site/messagepage.php?message=Извените ошибка БД сервера" );
  		exit();
  	}
  
	// SELECT COUNT(*) FROM coursescompleted where person=:p
	// $query = "SELECT id FROM users WHERE nick='$nick'";
	// $query  = 'SELECT COUNT(*) FROM users WHERE nick='."'$nick'";

    $query = 'SELECT id FROM users WHERE nick='.'"'.$nick.'"';
    $result = $pdo->query( $query );

    $query   = 'SELECT id FROM users WHERE nick=:nick';
    $prepare = $pdo->prepare( $query );
    $result  = $prepare->execute( array(':nick' => $nick)  );


    if ( $result === false || $prepare->fetch() !== false ) {
    	/*
    	foreach( $result as $key => $value){
			echo 'key = '.$key.' , $value = '.print_r($value).'<br/>';
    		//echo '<br/>';
    	}
    	*/
    	//exit ("Извините, введённый вами логин уже зарегистрирован. Введите другой логин.");
    	header("Location: /site/registration.php?validate=5");
    	exit();
    }else{

    	//exit ("its good");
    }

    $pass = password_hash( $pass, PASSWORD_DEFAULT );
    // если такого нет, то сохраняем данные
    //$query = 'INSERT INTO users (nick,mail,pass) VALUES('."'$nick','$mail','$pass'".')';
    //$result = $pdo->query($query);

    $query   = 'INSERT INTO users (nick, mail, pass, rdata) VALUES(:nick, :mail, :pass, NOW() );';
    $prepare = $pdo->prepare( $query );
    $result  = $prepare->execute( array(':nick' => $nick, ':mail' => $mail, ':pass' => $pass)  );

    // DELETE FROM users WHERE nick='Swer';
    // Проверяем, есть ли ошибки
    if ($result !== false)
    {
    	$query  = 'SELECT * FROM users WHERE nick='."'$nick'";
    	$prepare = $pdo->query( $query );
    	$params =  $prepare->fetch();
    	$_SESSION['nick'] = $params['nick']; 
    	$_SESSION['id']   = $params['id'];//эти данные очень часто используются, вот их и будет "носить с собой" вошедший пользователь
    	$_SESSION['img']  = $params['img'];
        //echo "Вы успешно зарегистрированы! Теперь вы можете зайти на сайт. <a href='./index.php'>Главная страница</a>";

        $str = $_SESSION['nick'].'  Вы успешно зарегистрированы !';
  		header( "Location: /site/messagepage.php?message=$str");

    	exit();
    }else{
    	exit ("Извините, регистрация не удалась.");
    }




	header("Location: /site/index.php");

?>