<?php
    session_start();
    $paginaHTML = file_get_contents('../views/login.html');

    $manager = new Manager();
    $user = $manager->setupSession();

    if($user->getUsername()!=null){
        header("Location: index.php");
        exit();	
    }
    
    $error = '';
    if(isset($_SESSION['loginError'])){
        $error = '<p id="erroreLogin">'.$_SESSION['loginError'].'</p>';
        unset($_SESSION['loginError']);
    }
    $paginaHTML = str_replace("ERRORELOGIN", $error, $paginaHTML);


    $un = '';
    if(isset($_SESSION['oldUsername'])){
        $un = $_SESSION['oldUsername'];
        unset($_SESSION['oldUsername']);
    }
    $paginaHTML = str_replace("VALUEUSERNAME", $un, $paginaHTML);

    echo $paginaHTML;

?>