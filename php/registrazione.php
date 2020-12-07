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

    $paginaHTML = str_replace('VALORENOME',$_SESSION['registerValues']['nome'],$paginaHTML);
    $paginaHTML = str_replace('VALORECOGNOME',$_SESSION['registerValues']['cognome'],$paginaHTML);
    $paginaHTML = str_replace('VALOREEMAIL',$_SESSION['registerValues']['email'],$paginaHTML);
    $paginaHTML = str_replace('VALOREPROVENIENZA',$_SESSION['registerValues']['provenienza'],$paginaHTML);
    $paginaHTML = str_replace('VALOREUSERNAME',$_SESSION['registerValues']['username'],$paginaHTML);
    $paginaHTML = str_replace('VALOREDATA',$_SESSION['registerValues']['dataNascita'],$paginaHTML);

}else{

    $paginaHTML = str_replace('VALORENOME','',$paginaHTML);
    $paginaHTML = str_replace('VALORECOGNOME','',$paginaHTML);
    $paginaHTML = str_replace('VALOREEMAIL','',$paginaHTML);
    $paginaHTML = str_replace('VALOREPROVENIENZA','',$paginaHTML);
    $paginaHTML = str_replace('VALOREUSERNAME','',$paginaHTML);
    $paginaHTML = str_replace('VALOREDATA','',$paginaHTML);
}

$sesso = isset($_SESSION['registerValues']['sesso']) ? $_SESSION['registerValues']['sesso'] : null;
if($sesso == 'M') $paginaHTML = str_replace('SELECTEDM','checked',$paginaHTML);
else $paginaHTML = str_replace('SELECTEDM','',$paginaHTML);

if($sesso == 'F') $paginaHTML = str_replace('SELECTEDF','checked',$paginaHTML);
else $paginaHTML = str_replace('SELECTEDF','',$paginaHTML);

if($sesso == 'A') $paginaHTML = str_replace('SELECTEDA','checked',$paginaHTML);
else $paginaHTML = str_replace('SELECTEDA','',$paginaHTML);

$paginaHTML = str_replace('ERRORIREGISTRAZIONE',$stringErrors,$paginaHTML);

echo $paginaHTML;

?>