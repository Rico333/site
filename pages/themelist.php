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


// for pages navigation
$limit_rows_on_page = 3;

if( isset( $_GET['b'] )  ){
	$str = $_GET['b'];
	$str = stripslashes($str);
	$str = htmlspecialchars($str);
	$str = trim( $str );
	if( !$str ){
		$cur_page = 0;
		$start_row = '0';
	}else{
		$start_row = $str;
		$cur_page  = floor( intval( $start_row ) / $limit_rows_on_page );
	} 
	
}else{
	$cur_page  = 0;
	$start_row = '0';
}

//



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
	<link rel="stylesheet" type="text/css" href="/site/css/themelist.css" >
</head>
<body>

<table  id="maintable">
<tr><td>
	<?php include_once(  $_SERVER['DOCUMENT_ROOT'].'/site/header.php' ); ?>
</td></tr>

<tr id= "tr_manicontent" ><td id="td_maincontent">


	<table width="100%" align="left" >
		<tr>
			<td>
				<?php echo '<a href="/site/pages/newtheme.php?a='.$id_section.'">'; ?>
					<img src="/site/img/ico/newtheme.gif" alt="Начать новую тему" title="Начать новую тему">
				</a>
			</td>
			<td id="td_pagethemes" align="right" >
				<?php
				/*
					$query = 'SELECT COUNT(*) FROM '.$section['tablethemes'];
					$prepare = $pdo->query( $query );
					$result  = $prepare->execute();
					if( $result ){
						$total_themes = intval( ($prepare->fetch())[0] );
						if( !$total_themes ){ 
							$total_themes = 0; 
							$total_pages  = 0;
						}else if( $total_themes > $limit_rows_on_page ){
						 	$total_pages =  ceil( $total_themes / $limit_rows_on_page ); 
						}
						if( $total_pages > 1 ){
							if( $cur_page > 0 ){
								echo '<a href="/site/pages/themelist.php?a='.$id_section.'&b='.($cur_page-1).'"> prev. &nbsp &nbsp  </a>';
							}
							if( $cur_page > 4 ){
								echo '<a href="/site/pages/themelist.php?a='.$id_section.'&b=0">1...&nbsp &nbsp  </a>';
								$i = $cur_page - 3;
							}else{
								$i = 0;
							}
							$l = $i + 7; if( $l < 5 ){ $l = 5; } if( $l > $total_pages ){ $l = $total_pages; }
							while( $i < $l ){
								if( $i == $cur_page  ){
									echo '<a href="/site/pages/themelist.php?a='.$id_section.'&b='.$i.'" style="color:#00FF00">'.(++$i).'&nbsp &nbsp  </a>';
								}else{
									echo '<a href="/site/pages/themelist.php?a='.$id_section.'&b='.$i.'">'.(++$i).'&nbsp &nbsp  </a>';
								}
							}
							if( $i < $total_pages ){
								echo '<a href="/site/pages/themelist.php?a='.$id_section.'&b='.$i.'">...'.(++$i).'&nbsp &nbsp  </a>';
							}
							if( $cur_page < $total_pages-1 ){
								echo '<a href="/site/pages/themelist.php?a='.$id_section.'&b='.($cur_page+1).'"> .next &nbsp &nbsp  </a>';
							}
						}
						
					}
					*/
					
					$query = 'SELECT COUNT(*) FROM '.$section['tablethemes'];
					$prepare = $pdo->query( $query );
					$result  = $prepare->execute();
					if( $result ){
						$total = intval( ($prepare->fetch())[0] );
						if( !$total ){ 
							$total = 0;
							$total_pages = 0;
						}else{
						 	$total_pages =  ceil( $total / $limit_rows_on_page ); 
						}
						if( $total_pages > 1 ){
							include_once(  $_SERVER['DOCUMENT_ROOT'].'/site/commons/displaypanelswitcher.php' );
							$arr = create_displaypanelswitcher( $cur_page, $total_pages );
							$i = 0; $l = count( $arr ) - 1; $str = '';
							while( $i < $l ){
								if( $arr[ $i ] == $cur_page  ){
									// $str .= '<a href="/site/pages/themelist.php?a='.$id_section.'&b='.($arr[ $i ] * $limit_rows_on_page).'" style="color:#00FF00">'.($arr[ $i+1 ]).' &nbsp</a>';
									$str .= '<strong style="color: #00FF00;">'.($arr[ $i+1 ]).' &nbsp &nbsp</strong>';
								}else{
									$str .= '<a href="/site/pages/themelist.php?a='.$id_section.'&b='.($arr[ $i ] * $limit_rows_on_page).'">'.($arr[ $i+1 ]).' &nbsp</a>';
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

	


	<table id="id_tablethemelist" >
		<tbody>
			
		<tr>
			<td colspan="3">Темы</td>
			<td class="node4" >Автор</td>
			<td class="node5" >Ответов</td>
			<td class="node6" >Просмотров</td>
			<td class="node7" >Последнее сообщение</td>
		</tr>
			

		<?php 
  			//$query = 'SELECT * FROM jsthemes ORDER BY id DESC LIMIT 20;';
  			//$query = 'SELECT * FROM jsthemes ORDER BY id DESC;';
  			//$result = $pdo->query( $query );

  			//$query = 'SELECT * FROM '.$section['tablethemes'].' ORDER BY id DESC LIMIT 20';
  			//$query = 'SELECT * FROM '.$section['tablethemes'].' ORDER BY countthemes DESC LIMIT 20';
  			$query = 'SELECT * FROM '.$section['tablethemes'].' ORDER BY countthemes DESC LIMIT '.$limit_rows_on_page.' OFFSET '.$start_row;
			$prepare = $pdo->prepare( $query );
			// $result  = $prepare->execute( array(':theme' => $section['tablethemes']) );
			$result  = $prepare->execute( );

  			if( $result == false ){
				header( "location: /site/messagepage.php?message=Извените ошибка БД сервера 2" );
  				exit();
  			}


  			while( $params = $prepare->fetch() ){
  				echo "<tr>
					<td class='node1'>
						<img src='/site/img/ico/ico1.png'/>
					</td>
					<td class='node2'>
						<img src='/site/img/ico/ico1.png'/>
					</td>
					<td class='node3'><a href='/site/pages/postspage.php?a=".$params['id']."&b=".$id_section."'>".
						$params['nametheme'].'</a><br/>'.$params['putdate']
					."</td>
					<td class='node4'>".
						$params['nick_author']
					."</td>
					<td class='node5'>".
						$params['posts']
					."</td>
					<td class='node6'>".
						$params['views']
					."</td>
					<td class='node7'>".
						$params['lmnick']."   "."<a href='/site/pages/postspage.php?a=".$params['id']."&b=".$id_section."&c=".($params['posts']-1)."#p".$params['lmid']."'><img src='/site/img/ico/ico1.png'/></a><br/>".
						$params['lmdate']
					."</td>
				</tr>";
  			}
  			$query = null;
  			$params = null;

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