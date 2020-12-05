<?php
    session_start();
    $paginaHTML = file_get_contents('../views/login.html');
    
    if(isset($_SESSION['loginError'])){
        $string = '<p id="erroreLogin">'.$_SESSION['loginError'].'</p>';
        $paginaHTML = str_replace("<ERRORELOGIN />", $string, $paginaHTML);
        unset($_SESSION['loginError']);
    }else{
        $paginaHTML = str_replace("<ERRORELOGIN />", '', $paginaHTML);
    }

    echo $paginaHTML;

?>