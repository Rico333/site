<?php
	// header('Content-Type: text/html; charset=utf-8');
	echo '<br/>'.'__FILE__ = contentbase.php = '.__FILE__;
	echo '<br/>'.'__DIR__ = contentbase.php = '.__DIR__;
	echo '<br/>'.' _SERVER[ SCRIPT_NAME ] = contentbase.php = '.$_SERVER[ 'SCRIPT_NAME' ];
?>
<div width= "100%" height="100%" align="top" style="color: #EEEEEE;">
	<p>
		<?php 

			//$text = file_get_contents( $_SERVER['DOCUMENT_ROOT']."/site/pages/justText2.txt");
			$text = file_get_contents( $_SERVER['DOCUMENT_ROOT'].'/site/pages/justText2.txt' );
			$convertedText = mb_convert_encoding($text, 'utf-8', mb_detect_encoding($text, array('utf-8', 'cp1251')));
			//$convertedText = mb_convert_encoding($text, 'utf-8', mb_detect_encoding( $text) );
			$convertedText = trim($convertedText);
			echo $convertedText ;
			//echo $_SERVER['DOCUMENT_ROOT']."/site/pages/justText.txt";
		 ?>
	</p>
</div>