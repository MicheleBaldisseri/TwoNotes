<?php
require_once "../includes/Manager.php";
session_start();
$paginaHTML = file_get_contents('../views/registrazione.html');

$manager = new Manager();
$user = $manager->setupSession();

if($user->getUsername()!=null){
    header("Location: index.php");
    exit();	
}

$stringErrors = '';
if(isset($_SESSION['registerErrors'])){

    $stringErrors = "<div id='registerErrors'>";
    foreach($_SESSION['registerErrors'] as $error){
        $stringErrors .= "<p>".$error."</p>";
    }
    $stringErrors .= "</div> ";

    unset($_SESSION['registerErrors']);

    $paginaHTML = str_replace('<VALORENOME/>',stripslashes($_SESSION['registerValues']['nome']),$paginaHTML);
    $paginaHTML = str_replace('<VALORECOGNOME/>',stripslashes($_SESSION['registerValues']['cognome']),$paginaHTML);
    $paginaHTML = str_replace('<VALOREEMAIL/>',stripslashes($_SESSION['registerValues']['email']),$paginaHTML);
    $paginaHTML = str_replace('<VALOREPROVENIENZA/>',stripslashes($_SESSION['registerValues']['provenienza']),$paginaHTML);
    $paginaHTML = str_replace('<VALOREUSERNAME/>',stripslashes($_SESSION['registerValues']['username']),$paginaHTML);
    $paginaHTML = str_replace('<VALOREDATA/>',stripslashes($_SESSION['registerValues']['dataNascita']),$paginaHTML);

}else{

    $paginaHTML = str_replace('<VALORENOME/>','',$paginaHTML);
    $paginaHTML = str_replace('<VALORECOGNOME/>','',$paginaHTML);
    $paginaHTML = str_replace('<VALOREEMAIL/>','',$paginaHTML);
    $paginaHTML = str_replace('<VALOREPROVENIENZA/>','',$paginaHTML);
    $paginaHTML = str_replace('<VALOREUSERNAME/>','',$paginaHTML);
    $paginaHTML = str_replace('<VALOREDATA/>','',$paginaHTML);
}

$sesso = isset($_SESSION['registerValues']['sesso']) ? $_SESSION['registerValues']['sesso'] : null;
if($sesso == 'M') $paginaHTML = str_replace('SELECTEDM','checked="checked"',$paginaHTML);
else $paginaHTML = str_replace('SELECTEDM','',$paginaHTML);

if($sesso == 'F') $paginaHTML = str_replace('SELECTEDF','checked="checked"',$paginaHTML);
else $paginaHTML = str_replace('SELECTEDF','',$paginaHTML);

if($sesso == 'A') $paginaHTML = str_replace('SELECTEDA','checked="checked"',$paginaHTML);
else $paginaHTML = str_replace('SELECTEDA','',$paginaHTML);

unset($_SESSION['registerValues']);

$paginaHTML = str_replace('<ERRORIREGISTRAZIONE/>',$stringErrors,$paginaHTML);

echo $paginaHTML;

?>