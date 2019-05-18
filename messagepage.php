<?php 
declare( strict_types = 1 ); // strict type mode
error_reporting( E_ALL );
// запускает сессию и Устанавливает для группы в сессии - нужно для того, чтобы переменные сессиис с одинаковыми именами не переопределялись
// session_start(['session.name' => 'PHPSESID']);
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
			//color: #CCCCCC;
			//background-color: #444444;
		}
		a{
			color: #FFFFFF;
		}
		body{
			background-image: url( '/site/img/background.gif' );
		}
	</style>
</head>
<body>
	<?php include_once(  $_SERVER['DOCUMENT_ROOT'].'/site/header.php' ); ?>
	<link rel="stylesheet" type="text/css" href="/site/css/messagewindowstyle.css" >
	<div width="100%" height="1000px" style="text-align: center; min-height: 1000px;" >
		
		<p><b><a href="/site/index.php" >return to main page</a></b></p>

		<div  class="messagewindowstyle" style="width: 50%; min-width: 200px; min-height: 200px; display: inline-block">
			<?php
				// echo $_SERVER['SERVER_NAME'].'/site/index.php';
				if( isset( $_GET ) && isset( $_GET['message'])  ){
					$str = $_GET['message'];
					$str = stripslashes($str);
    				$str = htmlspecialchars($str);
    				$str = trim( $str );
					echo "<p><b>$str</b></p>";
				}else{
					//echo "<p><b><a href='http://localhost/site/index.php'>return to main page</a></b></p>";
				}
			?>

		</div>
	</div>
	<?php include_once(  $_SERVER['DOCUMENT_ROOT'].'/site/footer.php' ); ?>
</body>
</html>