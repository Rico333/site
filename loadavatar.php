<?php
	session_start();

	if(   (!(isset($_POST))) || (!(isset($_FILES))) || (!(isset($_FILES['image'])))   ){
		exit( "NOTHING");
	}
	//var_dump( $_FILES['image'] );

	$file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp  = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];


	$str = explode(  '.', $file_name );
	$str = end( $str );
	$file_ext = strtolower(   $str  );
    $extensions = array("jpeg","jpg","png","gif");

    $errors = array();

     if( in_array( $file_ext, $extensions ) === false ){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
     	//exit( "file must be jpeg or jpg or png or gif" );
      }
      
      //if($file_size > 2097152){$errors[]='File size must be excately 2 MB';}

      if($file_size > 120000 ){
         $errors[]='File size must be excately 100 kb';
      }
      $imgname = $_SESSION['nick'].'_'.$file_name;
      if( mb_strlen( $imgname ) > 200 ){
 		$errors[]="name of file is too length";
      }
      
      if( empty( $errors ) === false ){
		 print_r($errors);
		 exit();
      }

       move_uploaded_file( $file_tmp, "./img/avataruser/".$imgname );
       //echo "Success";

      include_once( 'commons/dbconnect.php' );
  	  if( $pdo == null ){
  		header( "location: messagepage.php?message=Извените ошибка БД сервера" );
  		exit();
  	  }

  	  $query = "UPDATE users SET img='$imgname' WHERE nick='".$_SESSION['nick']."'";
  	  $result = $pdo->query( $query );
  	  $_SESSION['img'] = $imgname;

	  header( 'location: ./profile.php')
?>