<?php
	session_start();
	if(     (!isset( $_POST )) || (!isset($_POST['nick']))  || (!isset($_POST['pass'])) 
						       ||   empty($_POST['nick'])   ||   empty($_POST['pass'])       ){
		header("Location: /site/registration.php?validate=0");
		//header( 'Location: '.$_SERVER['DOCUMENT_ROOT'].'/site/registration.php?validate=0');
		exit();
	}

	include_once( $_SERVER['DOCUMENT_ROOT'].'/site/commons/regexp.php' );

	$str = $_POST['nick'];
	$str = stripslashes($str);
    $str = htmlspecialchars($str);
    $str = trim( $str );
	if( !preg_match( $reg_nick, $str) ){ // only digit or +
		exit(" Login Not Validate");
	}
	$nick = $str;



	$str = $_POST['pass'];
	$str = stripslashes($str);
    $str = htmlspecialchars($str);
    $str = trim( $str );
	if( !preg_match( $reg_password, $str ) ){ // only digit or +
		exit("Password Not Exists");
	}
	 $pass = $str;
	// $pass = password_hash( $str, PASSWORD_BCRYPT );


	include_once( $_SERVER['DOCUMENT_ROOT'].'/site/commons/dbconnect.php' );
  	if( $pdo == null ){
  		echo "Невозможно установить соединение с базой данных";
  		exit();
  	}


  	// $query = 'SELECT id, nick, img FROM users WHERE nick='."'$nick'".' AND pass='."'$pass'";
  	// $query = 'SELECT id, nick, img, pass FROM users WHERE nick='."'$nick'";
  	$query = 'SELECT * FROM users WHERE nick='."'$nick'";
  	// echo $query.'<br/>';
  	$result = $pdo->query($query);
  	if( $result === false ){
  		exit("Query Not Exists");
  	}
  	$params = $result->fetch();
  	if( $params === false || (!isset($params['nick']))  || (!isset($params['id'])) ){
  		exit("Parameters Not Exists");
  	}
  	if(  (!isset($params['pass'])) || (!password_verify( $pass, $params['pass']  )) ){
  		// $str = "Password not correct <br/>".$params['pass'];
  		exit( "Password not correct <br/>" );
  	}


  	$_SESSION['nick'] = $params['nick'];
  	$_SESSION['id']   = $params['id'];
  	$_SESSION['img']  = $params['img'];

  	

  	// echo "Вы успешно вошли на сайт! <a href='index.php'>Главная страница</a>";
  	$str = 'Добро пожаловать на сайт '.$_SESSION['nick'];
  	header( "Location: messagepage.php?message=$str");
    exit();
	header("Location: ./index.php");

  	// $query = "SELECT id FROM users WHERE nick='$nick'";
    // $news = $pdo->prepare($query);
    // $news->execute(['name' => $_POST['name']]);
/*
    $query = "SELECT id FROM users WHERE nick='$nick'";
    $result = $pdo->query( $query );

    if (!empty($result['id'])) {
    	exit ("Извините, введённый вами логин уже зарегистрирован. Введите другой логин.");
    }
    // если такого нет, то сохраняем данные
    $result = mysql_query ("INSERT INTO users (nick,password) VALUES('$login','$password')");
    // Проверяем, есть ли ошибки
    if ($result == 'TRUE')
    {
    echo "Вы успешно зарегистрированы! Теперь вы можете зайти на сайт. <a href='index.php'>Главная страница</a>";
    }else{
    	exit ("Извините, регистрация не удалась.");
    }

*/
    // log out
    // Очистить данные сессии для текущго сценария
    // $_SESSION = [];
    // Удалить cookie, соответствующие SID(индетификатор пользовотеля) 
    // @unset($_COOKIE[session_name()]);
    // Уничтожить хранилище сессии
    // session_destroy();


	
?>