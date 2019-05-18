<?php
	try {
    	$pdo = new PDO(
      					'mysql:host=localhost;dbname=test',
      					'root',
      					'root',
      					[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
      				  );
  	}catch (PDOException $e) {
  		$pdo = null;
    	// echo "Невозможно установить соединение с базой данных";
		// header("Location: ./index.php");
    	// exit();
  	}
  	// 1-10     ---  users
  	// 80 - 89  ---  admins
  	// 70 - 79  ---  moderators
  	// ALTER TABLE users ADD access INT(2) NOT NULL DEFAULT '1';
?>