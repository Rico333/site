<?php 
declare( strict_types = 1 ); // strict type mode
error_reporting( E_ALL );
session_start();
// запускает сессию и Устанавливает для группы в сессии - нужно для того, чтобы переменные сессиис с одинаковыми именами не переопределялись
// session_start(['session.name' => 'PHPSESID']);

include_once( $_SERVER['DOCUMENT_ROOT'].'/site/commons/dbconnect.php');
if( $pdo == null ){
  header( "location: /site/messagepage.php?message=Извените ошибка БД сервера 1" );
  exit();
}


// $tablethemes = $section['tablethemes'];
// $tableposts = $section['tableposts'];
//

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>








<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="mobile-web-app-capable" content="yes" />
	<title> Site </title>
	<link rel="stylesheet" type="text/css" href="/site/css/index.css" >
</head>
<body>

<table  id="maintable" >
<tr><td>
	<?php include_once(  $_SERVER['DOCUMENT_ROOT'].'/site/header.php' ); ?>
</td></tr>

<tr id="tr_manicontent"><td id="td_maincontent">


	<table id="id_tablethemelist" >
		<tbody>
			
		<tr>
			<td colspan="2">Форум</td>
			<td class="node3" >Темы</td>
			<td class="node4" >Сообщений</td>
			<td class="node5" >Последнее сообщение</td>
		</tr>
			

		<?php 
  			$query = 'SELECT * FROM sections';
			$prepare_section = $pdo->prepare( $query );
			$result  = $prepare_section->execute();

  			if( $result == false ){
				header( "location: /site/messagepage.php?message=Извените ошибка БД сервера 2" );
  				exit();
  			}


  			//$prepare_section = &$prepare; 
  			while( $section = $prepare_section->fetch() ){

  				// amount themes
				$query = 'SELECT COUNT(*) FROM '.$section['tablethemes'];
				$prepare = $pdo->prepare( $query );
				$result  = $prepare->execute();
				if( $result ){ $countthemes = ($prepare->fetch())[0]; }else{ $countthemes = 0; }
				// amount answers

				$query = 'SELECT COUNT(*) FROM '.$section['tableposts'];
				$prepare = $pdo->prepare( $query );
				$result  = $prepare->execute();
				if( $result ){ $countposts = ($prepare->fetch())[0];  }else{ $countposts = 0; }
				// last answer

				$query = 'SELECT * FROM '.$section['tablethemes'].' ORDER BY lmid DESC LIMIT 1';
				try{
					$prepare = $pdo->prepare( $query );
					$result  = $prepare->execute();
					if( $result ){
						$theme = $prepare->fetch();
						$lastmessage = 
						$theme['lmnick']."   "."<a href='/site/pages/postspage.php?a=".$theme['id']."&b=".$section['id']."#p".$theme['lmid']."'><img src='/site/img/ico/ico1.png'/></a><br/>".
						$theme['lmdate'];
					}
				}catch( Exception $e ){
					$lastmessage = '';
				}
				
/*
				//
				$query = 'SELECT id_answer, id_theme, id_author, chdate FROM '.$section['tableposts'].' ORDER BY id_answer DESC LIMIT 1';
				$post = null;
				$nickauthor = '';
				try{
					$prepare = $pdo->prepare( $query );
					$result  = $prepare->execute();
					if( $result ){
						$post = $prepare->fetch();
					}
				}catch( Exception $e ){}
				if( $post ){
					$query = 'SELECT nick FROM users WHERE id=:id_author LIMIT 1';
					$prepare = $pdo->prepare( $query );
					$result  = $prepare->execute( array('id_author' => $post['id_author']));
					if( $result ){
						 $nickauthor = ($prepare->fetch())['nick'];
					}
					$lastmessage = 
				}

				a = posts.id_theme  b = id_section   '#' = id_answer
				$params['lmnick']."   "."<a href='/site/pages/postspage.php?a=".$params['id']."&b=".$id_section."#p".$params['lmid']."'><img src='/site/img/ico/ico1.png'/></a><br/>"

				if( $result ){ $countthemes = 0; }else{ $countthemes = $prepare[0]; }
				*/

  				echo  "<tr>
					<td class='node1'>
						<img src='/site/img/ico/ico1.png'/>
					</td>
					<td class='node2'><a href='pages/themelist.php?a=".$section['id']."'>".
						$section['tablethemes'].'</a><br/>'.$section['createdata']
					."</td>
					<td class='node3'>".
						$countthemes
					."</td>
					<td class='node4'>".
						$countposts
					."</td>
					<td class='node5'>".
						$lastmessage
					."</td>
				</tr>";
  			}
  			$query   = null;
  			$section = null;
  			$theme   = null;

		?>
		</tbody>
	</table>

</td></tr>

<tr><td>
	<?php include_once(  $_SERVER['DOCUMENT_ROOT'].'/site/footer.php' ); ?>
</td></tr>
</table>
</body>
</html>