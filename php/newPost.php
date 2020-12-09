<?php
require_once "../includes/Manager.php";
session_start();
$paginaHTML = file_get_contents('../views/newPost.html');

$manager = new Manager();
$user = $manager->setupSession();

if($user->getUsername()!=null){
    //gestire il fatto di essere in una pagina sbagliata
}

$stringErrors = '';
if(isset($_SESSION['postErrors'])){
//mostrare errori form

    $stringErrors = "<div id='postErrors'>";
    foreach($_SESSION['postErrors'] as $error){
        $stringErrors .= "<p>".$error."</p>";
    }
    $stringErrors .= "</div> ";

    unset($_SESSION['postErrors']);

    $paginaHTML = str_replace('VALORETITOLO',$_SESSION['postValues']['titolo'],$paginaHTML);
    $paginaHTML = str_replace('VALOREALT',$_SESSION['postValues']['altImmagine'],$paginaHTML);
    $paginaHTML = str_replace('VALORECONTENUTO',$_SESSION['postValues']['contenuto'],$paginaHTML);
}else{
    $paginaHTML = str_replace('VALORETITOLO','',$paginaHTML);
    $paginaHTML = str_replace('VALOREALT','',$paginaHTML);
    $paginaHTML = str_replace('VALORECONTENUTO','',$paginaHTML);
}

unset($_SESSION['registerValues']);

$paginaHTML = str_replace('ERRORIPOST',$stringErrors,$paginaHTML);

echo $paginaHTML;

?>