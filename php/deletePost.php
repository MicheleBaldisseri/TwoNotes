<?php

session_start();
require_once '../includes/Manager.php';

$manager = new Manager();
$user = $manager->setupSession();

if(!$user->isAdmin() || !isset($_GET['id'])){
    header("Location: errorPage.php");
    exit();
}

$imageName = $manager->recoverPostImage($_GET['id'])['immagine'];
$res = $manager->deletePost($_GET['id']);

if($res){
    header("Location: index.php");
    $_SESSION['success'] = "Post eliminato con successo!";
    if($imageName)unlink('../upload/'.$imageName);

}else{
    $_SESSION['errore'] = "Errore con il database";
    header("Location: postPage.php?idPost=".$_GET['id']);
}

exit();

?>