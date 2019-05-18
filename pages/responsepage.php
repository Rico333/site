<?php 
declare( strict_types = 1 ); // strict type mode
error_reporting( E_ALL );
session_start();
// запускает сессию и Устанавливает для группы в сессии - нужно для того, чтобы переменные сессиис с одинаковыми именами не переопределялись
// session_start(['session.name' => 'PHPSESID']);




include_once(  $_SERVER['DOCUMENT_ROOT'].'/site/commons/checkauthorize.php' );
if( $is_authorize == false ){
	header("Location: /site/messagepage.php?message=You must log in or registration before add answer !");
	exit();
}

if( (!(isset( $_GET))) ||  (!(isset( $_GET['a'])))  ||  (!(isset( $_GET['b'])))  ){
	header( "location: /site/messagepage.php?message=Theme not Exists 1" );
	exit();
}
$str = $_GET['a']; 
$str = stripslashes($str);
$str = htmlspecialchars($str);
$str = trim( $str );
$id_theme = $str;

$str = $_GET['b'];
$str = stripslashes($str);
$str = htmlspecialchars($str);
$str = trim( $str );
$id_section = $str;


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


// get nametheme
$query = 'SELECT nametheme FROM '.$section['tablethemes'].' WHERE id=:id_theme LIMIT 1';
$prepare = $pdo->prepare( $query );
$result  = $prepare->execute( array(':id_theme' => $id_theme ) );
if( $result == false ){
  header( "location: /site/messagepage.php?message=Theme not Exists 2" );
  exit();
}
$post = $prepare->fetch();
if( $post == false  || (!isset( $post['nametheme']))  ){
  header( "location: /site/messagepage.php?message=Theme not Exists 3" );
  exit();
}
$nametheme = $post['nametheme'];
//


header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


?>



<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title> Site </title>
	<style rel="stylesheet" type="text/css">
		*{
			color: #000000;
			font-weight: bold;
			font-style: italic;
		}
		body{
			background-image: url( "/site/img/background.gif" );
			padding: 0px;
			margin: 0px;
			width: 100%x;
			max-width: 100%
		}
		.id_tablethemelist {
			//vertical-align: top;
			//background-color: rgba(0,0,0,0.5);
		}
		table{
			/*background-color: rgba(0,0,0,0.5);*/
		}
	</style>
	<link rel="stylesheet" type="text/css" href="/site/css/newtheme.css" >
</head>
<body align='center'>
<table widht="100%" style="min-width: 100%; margin: 0px; padding: 0px;  position: relative;">
<tr><td>
	<?php include_once(  $_SERVER['DOCUMENT_ROOT'].'/site/header.php' ); ?>
</tr></td>
<tr><td>
	

<div style="min-width: 50%; text-align: center; display: inline-block;">
<form method='post' action='/site/sql/jssqlresponse.php' >
	<table id='tamblectheme' style="table-layout: fixed; word-wrap: break-word;">
		<tr>
			<td style="max-width: 100%; word-wrap: break-word;">
				<span style="color: #FFFFFF;"><?php echo $nametheme ?></span> 
			</td>
		</tr>
		<tr height='5px'><td></td></tr>
		<tr>
			<td align='center'>
				<textarea name='message' required='true' maxLength="60000" ></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<input name='idtheme'   type='hidden' value="<?php echo $id_theme ?>" >
				<input name='idsection' type='hidden' value="<?php echo $id_section ?>" >
				<input type='submit' value="Send Anwer" >
			</td>
		</tr>
	</table>
</form>
</div>


</tr></td>

<tr><td>
	<?php include_once(  $_SERVER['DOCUMENT_ROOT'].'/site/footer.php' ); ?>
</tr></td>
</table>
</body>
</html>