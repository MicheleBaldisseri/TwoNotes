<?php

session_start();
require_once '../includes/Manager.php';

$manager = new Manager();
$user = $manager->setupSession();

$errors = array();
$values = array();

$values['contenuto'] = isset($_POST['contenuto']) ? addslashes($_POST['contenuto']) : null;
$values['idPost'] = isset($_GET['idPost']) ? addslashes($_GET['idPost']) : null;
$values['username'] = addslashes($user->getUsername());

if(empty($values['contenuto'])) array_push($errors, "Compila il campo contenuto");
if(empty($values['idPost'])){
    //gestione posizione non voluta
} 
if(empty($values['username'])){
    //gestione posizione non voluta
}



if(count($errors)==0){
    $res = $manager->insertComment($values);

    if($res){
        header("Location: postPage.php?idPost=".$_GET['idPost']);
        $_SESSION['successInsert'] = true;
        exit();
    }else{
        $_SESSION['commentValues'] = $values;
        $_SESSION['commentErrors'] = $errors;
    }

}else{
    $_SESSION['commentValues'] = $values;
    $_SESSION['commentErrors'] = $errors;
}

header("Location: postPage.php?idPost=".$_GET['idPost']);
exit();

?>