<?php 
declare( strict_types = 1 ); // strict type mode
error_reporting( E_ALL );


include_once(  $_SERVER['DOCUMENT_ROOT'].'/site/commons/checkauthorize.php' );
if( $is_authorize == false ){
	header("Location: /site/messagepage.php?message=You must log in or registration view profile !");
	exit();
}


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
			color: #FFFFFF;
		}
		a{
			color: #FFFFFF;
		}
		body{
			background-image: url(img/background.gif);
			margin: 0px;
			padding: 0px;
		}
		#id_table_index td {
			vertical-align: top;
		}
		#params{
			width: 100%;
			//padding: 20px;
		}
		#params td{
			width: 50%;
			text-align: center;
		}
		#params input, select, option, td, .tabout{
			//color: #000000;
			background-color: rgba(0,0,0,0.5);
			//background-color: #E0AC7F;
		}
		td, table, input, textarea{
			border-radius: 8px;
		}
		.submit {
			background-color: #777777;
		}

	</style>
</head>
<body align="center" width="100%">
	<table width="100%" ><tbody>
	<tr><td>
	<?php include_once("header.php"); ?>
	</td></tr>
	<tr><td>
	<div align="center">
	<table id="id_table_index" border="1px" width="100%" height="100%" style="max-width: 600px; text-align: center; display: inline-block; clear: both;" >
		<tbody align="center">
		<tr height="1000px" align="center" style='min-height: 1000px; width: 100%' >
			<td width="40%">
				<div width=100% align="center" style="padding: 10px; color: #EEEEEE;">
					<h3>AVATAR</h3>
					<?php
						if( isset( $_SESSION ) && isset( $_SESSION['img'])  ){
							$img = '<img width="100px" height="100px" src="img/avataruser/'.$_SESSION['img'].'" style="border: 4px double green; border-radius: 10px" />';
							echo $img;

						}else{
							echo '<img width="100px" height="100px"  src="img/avataruser/unknownuser.jpg" style="border: 4px double green; border-radius: 10px" />';
						}
							echo '<br/><form id="formimage" method="post" action="loadavatar.php" enctype="multipart/form-data">';
							echo 'Choice Image: <input name="image" type="file"/>';
							echo '<input class="submit" form="formimage" type="submit" value="Load"/>';
							echo '</form>';
						
					?>
					<br/>
					<h2><?php echo $_SESSION['nick'] ?></h2>
				</div>
				<form id="forminfo" method="get" action="index.php"  >
					<table  id="params" border="4px" >
						<tr>
							<td>Страна : </td>
							<td><input name="country" type="text"/></td>
						</tr>
						<tr>
							<td>Город : </td>
							<td><input name="sity" type="text"/></td>
						</tr>
						<tr>
							<td>Хобби : </td>
							<td><input name="hoby" type="text"/></td>
						</tr>
						<tr>
							<td>Краткая информация : </td>
							<td><textarea class="tabout" name="about" maxLength="250" height="200px" type="text" style="min-height: 70px; min-width:90%; text-align: start; "></textarea></td>
						</tr>
						<tr>
							<td>День рождения : </td>
							<td>Д:<select name="bday">
								<option value="0" selected="selected">--</option>
								<?php
									$i = 1; $l = 32;
									while( $i < $l ){
										echo "<option value='$i'>$i</option>";
										++$i;
									}
								?>
								</select>
								М:<select name="bmonth">
								<option value="0" selected="selected">--</option>
								<?php
									$i = 1; $l = 13;
									while( $i < $l ){
										echo "<option value='$i'>$i</option>";
										++$i;
									}
								?>
								</select>
								Г:<select name="byear">
								<option value="0" selected="selected">--</option>
								<?php
									$l = intval( date( 'Y' ) ) + 1;
									$i = $l - 100;
									while( $i < $l ){
										echo "<option value='$i'>$i</option>";
										++$i;
									}
								?>
								</select>
							</td>
						</tr>
					</table><br/>
					<input class="submit" form="forminfo" type="submit" value="Save Changes"/>
				</form>
			</td>
			<?php
			/*
			<td width="60%" style="vertical-align: top; padding: 1%;">
				<textarea width="100%" height="100%" style="min-width: 100%; min-height: 100%; background-color: rgba(0,0,0,0.5);"></textarea>
			</td>
			*/ ?>
		</tr>
		</tbody>
	</table>
	</div>
	</td></tr>
	<tr><td>
	<?php include_once("footer.php"); ?>
	</td></tr>
	</tbody></table>
</body>
</html>