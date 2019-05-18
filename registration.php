<?php 
declare( strict_types = 1 ); // strict type mode
error_reporting( E_ALL );

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once(  $_SERVER['DOCUMENT_ROOT'].'/site/commons/checkauthorize.php' );
if( $is_authorize ){
	header("Location: ./index.php");
	exit();
}

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
			background-image: url("/site/img/background.gif");
		}
		#id_table_index td {
			vertical-align: top;
		}
	</style>
</head>
<body>
	<?php include_once("header.php"); ?>
	<table id="id_table_index" border="1px" width="100%" height="100%" >
		<tbody>
		<?php
			if( isset( $_GET['validate'] ) ){
				$error = "";
				switch( $_GET['validate'] ){
					case('1'):
					$error = 'Not all fields is filled';
					break;
					case('2'):
					$error = 'Name Not Validate';
					break;
					case('3'):
					$error = 'Mail Not Validate';
					break;
					case('4'):
					$error = 'Password Not Validate';
					break;

					case('5'):
					$error = 'Nick already exists';
					break;
					case('6'):
					$error = 'Mail already exist';
					break;
				}
				if( !empty($error) ) echo '<tr><td style="color: red; text-align: center;">'.$error.'</td></tr>';
			}
			//echo '<tr><td>'.$_GET['validate'].'</td></tr>';
		?>
		<tr height="1000px" style='min-height: 1000px;' >
			<td width="60%" style="vertical-align: top;" align="center">
				<?php include("./registrationform.php"); ?>
			</td>
		</tr>
		</tbody>
	</table>
	<?php include_once("footer.php"); ?>
</body>
</html>