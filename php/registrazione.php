<?php
require_once "../includes/Manager.php";
session_start();
$paginaHTML = file_get_contents('../views/registrazione.html');

$manager = new Manager();
$user = $manager->setupSession();

if($user->getUsername()!=null){
    //gestire il fatto di essere in una pagina sbagliata
}

$stringErrors = '';
if(isset($_SESSION['registerErrors'])){
    //mostrare errori form

    $stringErrors = "<div id='registerErrors'>";
    foreach($_SESSION['registerErrors'] as $error){
        $stringErrors .= "<p>".$error."</p>";
    }
    $stringErrors .= "</div> ";

    unset($_SESSION['registerErrors']);
}

$paginaHTML = str_replace('ERRORIREGISTRAZIONE',$stringErrors,$paginaHTML);

echo $paginaHTML;

?>