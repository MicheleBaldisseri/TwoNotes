<?php

session_start();
require_once '../includes/Manager.php';

$manager = new Manager();
$user = $manager->setupSession();

if(!$user->isAdmin() || !isset($_GET['id']) || !isset($_GET['idPost'])){
    header("Location: errorPage.php");
    exit();
}

$res = $manager->deleteComment($_GET['id']);

if($res){
    $_SESSION['success'] = "Commento eliminato con successo!";
    header("Location: postPage.php?idPost=".$_GET['idPost']);
}else{
    $_SESSION['errore'] = "Errore con il database";
    header("Location: postPage.php?idPost=".$_GET['idPost']);
}

exit();

?>