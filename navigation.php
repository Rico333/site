<?php include_once(  $_SERVER['DOCUMENT_ROOT'].'/site/commons/checkauthorize.php' ); ?>

<div class="navigation">
	<link rel="stylesheet" type="text/css" href="/site/css/navigation.css" >
	<table>
		<tr>
			<?php 
				// if( $is_authorize === false ) echo '<td style="visibility: hidden"></td>';
			?>
			<td><a href="/site/index.php">Main</a></td>
			<td><a href="https://gcup.ru">Search</a></td>			
			<?php 
				if( $is_authorize === true ){
					echo '<td><a href="/site/logout.php"  >Log Out</a></td>';
					echo '<td><a href="/site/profile.php" >Profile</a></td>';
				}else{
					echo '<td><a href="/site/registration.php" >Registration</a></td>';
				}
			?>
		</tr>
		<?php 
			if( $is_authorize !== true ) include( $_SERVER['DOCUMENT_ROOT'].'/site/navigationlogin.php' );
		?>
	</table>

</div> 