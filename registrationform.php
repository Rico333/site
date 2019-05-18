<div style="font-size: 20px; width: 400px; background-color: #E0AC7F; border: 3px outset silver; border-radius: 16px; overflow: hidden; filter: drop-shadow(10px 10px 4px rgba(0,0,0,0.5));">
	
<form  method="post" action="/site/registrationcheck.php">
	<h3>REGESTRATION</h3>
	<table>
		<?php
		/*
			if( isset( $_GET['validate'] ) ){
				if( $_GET['validate'] = 'not' ){
					$validate = $_GET['validate'];
					echo '<tr><td style="color: red">Login not Validate</td></tr>';
				}
			}
			//echo '<tr><td>'.$_GET['validate'].'</td></tr>';
			*/
		?>
		<tr>
			<td>Enter Nick Name</td><td><input name=nick type="text" maxLength="30" /></td>
		</tr>
		<tr>
			<td>Enter Mail</td><td><input name=mail type="text"/></td>
		</tr>
		<tr>
			<td>Enter Password</td> <td><input name=pass type="password"/></td> 
		</tr>
		<tr>
			<td>Confirm Password</td> <td><input type="password"/></td> 
		</tr>
		<tr>
			<td><input type="submit" value="Confirm" /></td>
		</tr>
	</table>
	<br/>
</form>
</div>