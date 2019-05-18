<?php 
declare( strict_types = 1 ); // strict type mode
error_reporting( E_ALL );
session_start();
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
			font-size: 1em;
			line-height: 1em;
			font-family: "Lucida Grande", "Trebuchet MS", Helvetica, Arial, sans-serif;
		}
		a{
			color: #FFFFFF;
		}
		body{
			background-image: url( "/site/img/background.gif" );
			margin: 0px;
			padding: 0px;
		}
		.index_tab_td {
			vertical-align: top;
			background-color: rgba(0,0,0,0.5);
		}
	</style>
</head>
<body>
<table>
<tr><td>
	<?php include_once(  $_SERVER['DOCUMENT_ROOT'].'/site/header.php' ); ?>
</tr></td>
<tr><td>

	<table id="id_table_index" border="1px" width="100%" height="100%" >
		<tbody>
		<tr height="1000px" style='min-height: 1000px;' >
			<td class="index_tab_td" width="20%">
				<?php include_once(  $_SERVER['DOCUMENT_ROOT'].'/site/pagenavigator.php' ); ?>
			</td>
			<td  class="index_tab_td" width="80%" style="vertical-align: top; padding: 1%;">
				<?php include("pages/contentbase.php"); ?>
			</td>
		</tr>
		</tbody>
	</table>

</tr></td>
<tr><td>
	<?php include_once(  $_SERVER['DOCUMENT_ROOT'].'/site/footer.php' ); ?>
</tr></td>
</table>
	<?php

		echo '<table border="4px" style=" color: #FFFFFF;">' . "\n";

		foreach ($_SERVER as $key => $value) {
			echo "<tr><td>$key</td><td>$value</td></tr>";
		}

		echo '</table>';


		echo '<br/><br/><h3>SESSION</h3<br/><br/>'.(session_name())."<br/>".(session_id())."<br/>";
		echo '<table border="4px" style=" color: #FFFFFF;">' . "\n";

		foreach ($_SESSION as $key => $value) {
			echo "<tr><td>$key</td><td>$value</td></tr>";
		}

		echo '</table>';

		echo password_hash("rasmuslerdorf", PASSWORD_DEFAULT);

		$str = dirname( $_SERVER['SCRIPT_FILENAME'],1);
		echo '<br/>'.$str;

		$str = dirname( $_SERVER['HTTP_REFERER'], 1 );
		echo '<br/>'.$str;

		echo '<br/>'.'__FILE__ = '.__FILE__;
		echo '<br/>'.'__DIR__ = '.__DIR__;
	?>


</body>
</html>