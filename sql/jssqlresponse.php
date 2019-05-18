<?php 
declare( strict_types = 1 ); // strict type mode
error_reporting( E_ALL );

include_once( $_SERVER['DOCUMENT_ROOT'].'/site/commons/checkauthorize.php');
if( $is_authorize == false ){
	header("Location: /site/messagepage.php?message=Please registration or Log in before add answer" );
	exit();
}

if(     (!isset( $_POST ))    ){
		header("Location: /site/messagepage.php?message=not all field was filled 1" );
		exit();
}
if(     (!isset( $_POST['idtheme'] ))   ){
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

$str = $_POST['idtheme'];
$str = stripslashes($str);
$str = htmlspecialchars($str);
$str = trim( $str );
$id_theme = $str;

$str = $_POST['message'];
$str = stripslashes($str);
$str = htmlspecialchars($str);
$str = trim( $str );
$message= $str;

$str = $_POST['idsection'];
$str = stripslashes($str);
$str = htmlspecialchars($str);
$str = trim( $str );
$id_section= $str;


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


// add post
$query   = 'INSERT INTO '.$section['tableposts'].' VALUES(NULL, :id_theme, :id_author, NOW(), NOW(), :message );';
$prepare = $pdo->prepare( $query );
$result  = $prepare->execute( array(':id_theme' => $id_theme, ':id_author' => $_SESSION['id'], ':message' => $message )  );


//  get id_answer current message

$query   = 'SELECT max(id_answer) FROM '.$section['tableposts'].' WHERE id_theme=:id_theme';
$prepare = $pdo->prepare( $query );
$result  = $prepare->execute( array(':id_theme' => $id_theme) );
if( $result ){
	try{
		$post = $prepare->fetch();
		//echo '<pre>'; print_r($post); echo '</pre>';
		$id_answer = $post[0];
	}catch( Exception $e ){
		$id_answer = '0';
	}
}
else{	echo " ERROR get max(id_answer) "; }
//

// up count posts in theme table
// $query   = 'SELECT COUNT( id_theme ) FROM '.$section['tableposts'].' WHERE id_theme=:id_theme';
// $prepare = $pdo->prepare( $query );
// $result  = $prepare->execute( array(':id_theme' => $id_theme )  );
$countthemes = -1;

$query = 'SELECT posts FROM '.$section['tablethemes'].' WHERE id=:id_theme';
$prepare = $pdo->prepare( $query );
$result  = $prepare->execute( array( ':id_theme' => $id_theme ) );

if( $result != false ){
	$post = $prepare->fetch();
	$posts_count = intval( $post['posts'], 10 ) + 1;
	$query = 'UPDATE '.$section['tablethemes'].' SET posts=:posts_count WHERE id=:id_theme';
	$prepare = $pdo->prepare( $query );
	$result  = $prepare->execute( array(':posts_count' => $posts_count, ':id_theme' => $id_theme ) );
	if( !$result ){	echo " ERROR get posts 1 "; }
}
else{	echo " ERROR get posts 2"; }
//
//	update last message nick and last date message int table themes
$query = 'UPDATE '.$section['tablethemes'].' SET  lmdate=NOW(), lmnick=:lmnick, lmid=:lmid WHERE id=:id_theme';
$prepare = $pdo->prepare( $query );
$result  = $prepare->execute( array( ':lmnick' => $_SESSION['nick'], 'lmid' => $id_answer, ':id_theme' => $id_theme ) );
//




// update countthemes --- for last updated theme on top 

// get countthemes for @v1
$query = 'SELECT  countthemes FROM '.$section['tablethemes'].' WHERE id=:id_theme';
$prepare = $pdo->prepare( $query );
$result  = $prepare->execute( array( ':id_theme' => $id_theme ) );

if( $result ){
	$post = $prepare->fetch();
	$countthemes = intval( $post['countthemes'], 10 ); echo $post['countthemes'];

	$query = 'SELECT max(countthemes) FROM '.$section['tablethemes'];
	$prepare = $pdo->query( $query );
	$result = $prepare->execute();

	if( $result ){
		// echo '<pre>'; print_r($prepare); echo '</pre>';
		$post = $prepare->fetch();
		// echo '<pre>'; print_r($post); echo '</pre>';
		$last_countthemes = intval( $post[0], 10 );
		if( $countthemes != $last_countthemes ){
			// set maximum countthemes to current theme
			$query = 'UPDATE '.$section['tablethemes'].' SET countthemes=:last_countthemes WHERE id=:id_theme';
			$prepare = $pdo->prepare( $query );
			$result  = $prepare->execute( array( ':last_countthemes' => $last_countthemes, ':id_theme' => $id_theme ) );
	
			// update  themes 
			if( $result ){
				$query = 'SET @v1:= '.$countthemes.'; '.
				 'UPDATE '.$section['tablethemes'].' SET countthemes=(countthemes - 1) WHERE countthemes > @v1 AND id != :id_theme';
				//echo $countthemes."  ---  ".$last_countthemes;
				$prepare = $pdo->query( $query );
				$result = $prepare->execute( array( ':id_theme' => $id_theme ) );
			}else{	echo " ERROR get countthemes 1 "; }
		}
	}
}
else{	echo " ERROR get countthemes 2 "; }
//





//header( "location: /site/messagepage.php?message=Your response added" );

?>