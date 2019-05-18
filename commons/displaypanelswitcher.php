<?php
	function create_displaypanelswitcher( $cur_page, $total_pages ){
		$arr = [];
		if( $total_pages > 1 ){
			if( $cur_page > 0 ){
				$arr[] = ($cur_page-1);
				$arr[] = 'prev.';
			}
			if( $cur_page > 4 ){
				$arr[] = 0;
				$arr[] = '1...';
				$i = $cur_page - 3;
			}else{
				$i = 0;
			}
			$l = $i + 7; if( $l > $total_pages ){ $l = $total_pages; }
			while( $i < $l ){
				$arr[] = $i;
				$arr[] = (string)(++$i);
			}
			if( $i < $total_pages ){
				$arr[] = $total_pages-1;
				$arr[] = '...'.($total_pages);
			}
			if( $cur_page < $total_pages-1 ){
				$arr[] = ($cur_page+1);
				$arr[] = '.next';
			}
		}
		return $arr;
	}
	/*  use 
	// get total_pages
	$query = 'SELECT COUNT(*) FROM '.$section['tablethemes'];
	$prepare = $pdo->query( $query );
	$result  = $prepare->execute();
	if( $result ){
		$total_themes = intval( ($prepare->fetch())[0] );
		if( !$total_themes ){ 
			$total_themes = 0; 
			$total_pages  = 0;
		}else if( $total_themes > $limit_themes_on_page ){
		 	$total_pages =  ceil( $total_themes / $limit_themes_on_page ); 
		}
	// include
		include_once(  $_SERVER['DOCUMENT_ROOT'].'/site/commons/displaycountpages.php' );
	// execute
		$arr = create_dcpages( $cur_page, $total_pages );
		$i = 0; $l = count( $arr ) - 1; $str = '';
		while( $i < $l ){
			if( $arr[ $i ] == $cur_page  ){
				$str .= '<a href="/site/pages/themelist.php?a='.$id_section.'&b='.($arr[ $i ]).'" style="color:#00FF00">'.($arr[ $i+1 ]).'&nbsp &nb</a>';
			}else{
				$str .= '<a href="/site/pages/themelist.php?a='.$id_section.'&b='.($arr[ $i ]).'">'.($arr[ $i+1 ]).'&nbsp &nbsp  </a>';
			}
			$i = $i + 2;
		}
		echo $str;
	}

	*/
?>