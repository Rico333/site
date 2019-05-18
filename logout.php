<?php
	session_start();
	 // log out
    // Очистить данные сессии для текущго сценария
    $_SESSION = [];
    // Удалить cookie, соответствующие SID(индетификатор пользовотеля) 
    unset( $_COOKIE[session_name()] );
    // Уничтожить хранилище сессии
    session_destroy();

    header( 'location: /site/index.php' );
?>