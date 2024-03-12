<?php 
    session_start();
    
    if (isset($_SESSION['loggin'])) { 
        $_SESSION = array(); 

        session_destroy(); 
    } 
    
    $arr = 'Wylogowano poprawnie!';
	$messNotif = urlencode($arr);

    header("Location: index.php?success=$messNotif"); 
    exit(); 
?> 