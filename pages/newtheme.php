<?php 
declare( strict_types = 1 ); // strict type mode
error_reporting( E_ALL );
// запускает сессию и Устанавливает для группы в сессии - нужно для того, чтобы переменные сессиис с одинаковыми именами не переопределялись
// session_start(['session.name' => 'PHPSESID']);


include_once(  $_SERVER['DOCUMENT_ROOT'].'/site/commons/checkauthorize.php' );
if( $is_authorize == false ){
	header("Location: /site/messagepage.php?message=You must log in or registration before create new theme !");
	exit();
}


// get section for themes table and posta table

if( (!(isset( $_GET))) ||  (!(isset( $_GET['a'])))  ){
	header( "location: /site/messagepage.php?message=Section not Exists 1" );
	exit();
}
$str = $_GET['a'];
$str = stripslashes($str);
$str = htmlspecialchars($str);
$str = trim( $str );
$id_section = $str;

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
<form method='post' action='/site/sql/jssqlnewtheme.php' >
	<table id='tamblectheme'>
		<tr>
			<td>
				<span style="color: #FFFFFF;">Введите название темы :</span> <input class='cthemename' name='nametheme' type = 'text' required='true' maxLength="60" >
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
				<?php echo '<input name="idsection" type="hidden" value="'.$id_section.'" >'; ?>
				<input type='submit' value="Create New Theme" >
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