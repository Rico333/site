<?php

	include_once( $_SERVER['DOCUMENT_ROOT'].'/site/commons/checkauthorize.php');
	if( $is_authorize == false ){
		header("Location: /site/messagepage.php?message=Please registration or Log in before create new theme" );
		exit();
	}

	if(     (!isset( $_POST ))    ){
		header("Location: /site/messagepage.php?message=not all field was filled 1" );
		exit();
	}
	if(     (!isset( $_POST['nametheme'] ))   ){
		header("Location: /site/messagepage.php?message=not all field was filled 2" );
		exit();
	}
	if(     (!isset( $_POST['message'] ))   ){
		header("Location: /site/messagepage.php?message=not all field was filled 3" );
		exit();
	}
	if(     (!isset( $_POST['idsection'] ))   ){
		header("Location: /site/messagepage.php?message=not all field was filled 4" );
		exit();
	}

	$str = $_POST['nametheme'];
	$str = stripslashes($str);
    $str = htmlspecialchars($str);
    $str = trim( $str );
    $nametheme = $str;

    $str = $_POST['message'];
	$str = stripslashes($str);
    $str = htmlspecialchars($str);
    $str = trim( $str );
    $message = $str;

    $str = $_POST['idsection'];
	$str = stripslashes($str);
    $str = htmlspecialchars($str);
    $str = trim( $str );
    $id_section = $str;


	$id_author = $_SESSION['id'];
	$nick_author = $_SESSION['nick'];

	// 'ALTER TABLE jsthemes ADD COLUMN nick_author VARCHAR(30) NOT NULL AFTER id_author;'

	include_once( $_SERVER['DOCUMENT_ROOT'].'/site/commons/dbconnect.php');
  	if( $pdo == null ){
  		header( "location: /site/messagepage.php?message=Извените ошибка БД сервера" );
  		exit();
  	}



  	// get section for themes table and posta table

	$query = 'SELECT * FROM sections WHERE id=:id_section';
	$prepare = $pdo->prepare( $query );
	$result  = $prepare->execute( array(':id_section' => $id_section) );
	
	if( $result == false ){
		header( "location: /site/messagepage.php?message=Section not Exists 2" );
		exit();
	}
	$section = $prepare->fetch();
	if( $section == false ){
		header( "location: /site/messagepage.php?message=Section not Exists 3" );
		exit();
	}
	
	//


  	// $query = 'INSERT INTO jsthemes (id_author, nick_author, nametheme) VALUES '."('$id_author', '$nick_author', '$nametheme');";
  	// $result = $pdo->query( $query );

  	$query   = 'INSERT INTO '.$section['tablethemes'].' (id_author, nick_author, nametheme, lmnick) VALUES(:id_author, :nick_author, :nametheme, :lmnick);';
	$prepare = $pdo->prepare( $query );
	$result  = $prepare->execute( array(':id_author' => $id_author, ':nick_author' => $nick_author, ':nametheme' => $nametheme, ':lmnick' => $nick_author)  );

  	if( $result == false ){
		header("Location: /site/messagepage.php?message=New javascript theme not be created 1" );
  		exit();
  	}

  	// $query = "SELECT id FROM jsthemes WHERE id_author='$id_author' AND nametheme='$nametheme';";
  	// $result = $pdo->query($query);

  	$query   = 'SELECT id FROM '.$section['tablethemes'].' WHERE id_author=:id_author AND nametheme=:nametheme;';
	$prepare = $pdo->prepare( $query );
	$result  = $prepare->execute( array(':id_author' => $id_author, ':nametheme' => $nametheme) );


  	if( $result == false ){
		header("Location: /site/messagepage.php?message=New javascript theme not be created 2" );
  		exit();
  	}
	$params   = $prepare->fetch();
  	$id_theme = $params['id'];


  	//echo $message."<br/>".$id_theme."<br/>".$id_author."<br/>";

  	// $query = 'INSERT INTO jsposts (id_theme, id_author, putdate, chdate, message) VALUES '."('$id_theme', '$id_author', NOW(), NOW(), '$message');";
  	// $result = $pdo->query($query);

	$query = 'INSERT INTO '.$section['tableposts'].' (id_theme, id_author, putdate, chdate, message) VALUES (:id_theme, :id_author, NOW(), NOW(), :message);';
	$prepare = $pdo->prepare( $query );
	$result = $prepare->execute( array(':id_theme' => $id_theme, ':id_author' => $id_author, ':message' => $message) );
  	
  	if( $result == false ){
		header("Location: /site/messagepage.php?message=New javascript theme not be created 3" );
  		exit();
  	}
 	//	update last message nick and last date message int table themes

	$query = 'SELECT id_answer FROM '.$section['tableposts'].' ORDER BY id_answer DESC LIMIT 1';
	$prepare = $pdo->prepare( $query );
	$result  = $prepare->execute();

	if( $result ){
		$id_answer = ($prepare->fetch())['id_answer'];
		$query = 'UPDATE '.$section['tablethemes'].' SET  lmid=:lmid WHERE id=:id_theme';
		$prepare = $pdo->prepare( $query );
		$result  = $prepare->execute( array( 'lmid' => $id_answer, ':id_theme' => $id_theme ) );
	}
	//
  	// set countthemes
	$query = 'SELECT max(countthemes) FROM '.$section['tablethemes'];
	$prepare = $pdo->prepare( $query );
	$result  = $prepare->execute();
	if( $result ){
		// echo '<pre>'; print_r($prepare); echo '</pre>';
		$post = $prepare->fetch();
		// echo '<pre>'; print_r($post); echo '</pre>';
		$countthemes = intval( $post[0], 10 ) + 1; echo 'post countthemes = '.$post[0].' --- cur countthemes = '.$countthemes.'</br>';

		$query = 'UPDATE '.$section['tablethemes'].' SET countthemes=:countthemes WHERE id=:id_theme';
		$prepare = $pdo->prepare( $query );
		$result  = $prepare->execute( array( ':countthemes' => $countthemes, ':id_theme' => $id_theme ) );
		if( !$result ){ echo ' ERROR get max( countthemes )'; }
	}
	else{ echo ' ERROR get max( countthemes )'; }
  	//



  	// header("Location: /site/messagepage.php?message=New Theme Javascript Created Successfully !!!" );

?>