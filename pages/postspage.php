<?php 
declare( strict_types = 1 ); // strict type mode
error_reporting( E_ALL );
session_start();
// запускает сессию и Устанавливает для группы в сессии - нужно для того, чтобы переменные сессиис с одинаковыми именами не переопределялись
// session_start(['session.name' => 'PHPSESID']);

if( (!(isset( $_GET))) ||  (!(isset( $_GET['a']))) || (!(isset( $_GET['b'])))  ){
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

// for pages navigation
$limit_rows_on_page = 3;
if( isset( $_GET['c'] )  ){
	$str = $_GET['c'];
	$str = stripslashes($str);
	$str = htmlspecialchars($str);
	$str = trim( $str );
	if( !$str ){
		$cur_page = 0;
		$start_row = '0';
	}else{
		//$start_row = $str;
		$cur_page  = floor( intval( $str ) / $limit_rows_on_page );
		$start_row = (string)( $cur_page * $limit_rows_on_page );
	} 
	
}else{
	$cur_page  = 0;
	$start_row = '0';
}
//

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
$query = "SELECT nametheme, views FROM ".$section['tablethemes']." WHERE id=:id_theme LIMIT 1";
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


// update views
$theme_views = intval( $post['views'], 10 ) + 1;
$query = 'UPDATE '.$section['tablethemes'].' SET views=:theme_views WHERE id=:id_theme';
$prepare = $pdo->prepare( $query );
$result  = $prepare->execute( array(':theme_views' => $theme_views, ':id_theme' => $id_theme ) );
//


$btn_response = '<a href="/site/pages/responsepage.php?a='.$id_theme.'&b='.$id_section.'">
	<img src="/site/img/ico/response.gif" alt="Начать новую тему" title="Начать новую тему"></a>';


header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="mobile-web-app-capable" content="yes" />
	<title> Site </title>
	<link rel="stylesheet" type="text/css" href="/site/css/postspage.css" >
</head>
 
<body>
	



<table  id="maintable">
<tr><td>
	<?php include_once(  $_SERVER['DOCUMENT_ROOT'].'/site/header.php' ); ?>
</td></tr>


<tr id= "tr_manicontent" ><td id="td_maincontent">




	<table width="100%" align="left">
		<tr>
			<td>
				<?php echo '<a href="/site/pages/newtheme.php?a='.$id_section.'">'; ?>
					<img src="/site/img/ico/newtheme.gif" alt="Начать новую тему" title="Начать новую тему">
				</a>
				<?php echo $btn_response; ?>
			</td>
			<td id="td_pagethemes" align="right" >
			<?php
				// $query = 'SELECT COUNT(*) FROM '.$section['tableposts'].' WHERE id_theme=:id_theme';
				//$query = 'SELECT posts FROM '.$section['tablethemes'].' WHERE id=:id_theme;';
				$query = 'SELECT posts FROM '.$section['tablethemes'].' WHERE id='.$id_theme;
				$prepare = $pdo->query( $query );
				//$result  = $prepare->execute( array( ':id_theme' => $id_theme ) );
				$result  = $prepare->execute( );
				if( $result ){
					$total = intval( ($prepare->fetch())[0] );
					if( !$total ){ 
						$total = 0; 
						$total_pages  = 0;
					}else{
					 	$total_pages =  ceil( $total / $limit_rows_on_page ); 
					}
					if( $total > 1 ){
						include_once(  $_SERVER['DOCUMENT_ROOT'].'/site/commons/displaypanelswitcher.php' );
						$arr = create_displaypanelswitcher( $cur_page, $total_pages );
						$i = 0; $l = count( $arr ) - 1; $str = '';
						while( $i < $l ){
							if( $arr[ $i ] == $cur_page  ){
								$str .= '<strong style="color: #00FF00;">'.($arr[ $i+1 ]).' &nbsp &nbsp</strong>';
							}else{
								$str .= '<a href="/site/pages/postspage.php?a='.$id_theme.'&b='.$id_section.'&c='.($arr[ $i ] * $limit_rows_on_page ).'">'.($arr[ $i+1 ]).' &nbsp</a>';
							}
							$i = $i + 2;
						}
						echo $str;
					}
				}
			?>
			</td>
		</tr>
	</table>




	
	<table id="tableposts" >
		<tr>
			<td>Автор</td>
			<td ><div style='float: left'> Сообщение  </div><div style='float: right'> Дата </div></td>
		</tr>
		<?php

			
			$query = "SELECT * FROM ".$section['tableposts']." WHERE id_theme=:id_theme LIMIT ".$limit_rows_on_page." OFFSET ".$start_row.";";
			$prepare = $pdo->prepare( $query );
    		// $result  = $prepare->execute( array(':nick' => $nick, ':mail' => $mail, ':pass' => $pass)  );
  		    $result  = $prepare->execute( array(':id_theme' => $id_theme ) );
  		    if( $result == false ){
  		    	header( 'location : /site/index.php' );
  		    	exit();
  		    }
  		    while( $post = $prepare->fetch() ){
  		    	$str = '<tr><td>';

				$str = $str.'</td></tr>';

				$str = '<tr><td>';

  		    	$query2 = 'SELECT * FROM users WHERE id=:id;';
				$prepare2 = $pdo->prepare( $query2 );
				$result2  = $prepare2->execute( array(':id' => $post['id_author'] ) );
				if( $result2 != false ){
					$user = $prepare2->fetch();
					if( $user != false ){
						$str = "<tr><td><a name='p".$post['id_answer']."'></a>".$user['nick']." </td><td><div style='float: left;' > Название темы : ".$nametheme." </div><div style='float: right;'> ".$post['chdate']."</div></td></tr>";


						$str = $str.'<tr><td>';

						if( isset( $user['img']) && (!empty( $user['img']))  ){
							$str = $str."<img class='imgavatar' src='/site/img/avataruser/".$user['img']."' /><br/>";
						}
						$str = $str."регистрация \n".$user['rdata'];
						//$str = $str."<h3>".$user['nick']."<h3>";
						//$str = $str.$post['chdate'];

						$str = $str.'</td><td>';
						$str = $str.$post['message'];
						$str = $str.'</td></tr>';
						echo $str;
					}
				}
  		    }
		?>
	</table>

	<table width="100%" align="left">
		<tr>
			<td>
				<?php echo '<a href="/site/pages/newtheme.php?a='.$id_section.'">'; ?>
					<img src="/site/img/ico/newtheme.gif" alt="Начать новую тему" title="Начать новую тему">
				</a>
				<?php echo $btn_response; ?>
				<button style="border-radius: 20%; background-color: #E0AC7F; width: 100px; height: 30px;">New Theme</button>
			</td>
		</tr>
	</table>





</td></tr>

<tr><td>
	<?php include_once(  $_SERVER['DOCUMENT_ROOT'].'/site/footer.php' ); ?>
</td></tr>
</table>
</body>
</html>


