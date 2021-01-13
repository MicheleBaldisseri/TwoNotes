<?php

session_start();
require_once '../includes/Manager.php';

$manager = new Manager();
$user = $manager->setupSession();

if(!$user->isAdmin() || !isset($_GET['user'])){
    header("Location: errorPage.php");
    exit();
}

$res = $manager->deleteUser($_GET['user']);

if($res){
    header("Location: index.php");
    $_SESSION['success'] = "Utente eliminato con successo!";
}else{
    $_SESSION['errore'] = 'Errore con il <span xml:lang="en" lang="en">database</span>';
    header("Location: profilo.php?username=".$_GET['user']);
}

exit();

?>