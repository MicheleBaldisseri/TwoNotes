<?php
    require_once "../includes/Manager.php";
    session_start();
    $paginaHTML = file_get_contents('../views/login.html');

    $manager = new Manager();
    $user = $manager->setupSession();

    if($user->getUsername()!=null){
        header("Location: index.php");
        exit();	
    }

    $stringErrors = '';
    if(isset($_SESSION['loginError'])){

        $stringErrors = "<ul id='phpErrors' class='listaSenzaPunti'>";
        foreach($_SESSION['loginError'] as $err){
            $stringErrors .= "<li>".$err."</li>";
        }
        $stringErrors .= "</ul>";

        unset($_SESSION['loginError']);
    }
    
    $paginaHTML = str_replace("<ERRORELOGIN/>", $stringErrors, $paginaHTML);


    $un = '';
    if(isset($_SESSION['oldUsername'])){
        $un = $_SESSION['oldUsername'];
        unset($_SESSION['oldUsername']);
    }
    $paginaHTML = str_replace("<VALUEUSERNAME/>", $un, $paginaHTML);

    echo $paginaHTML;

?>