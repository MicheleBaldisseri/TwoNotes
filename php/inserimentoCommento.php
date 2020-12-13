<?php

session_start();
require_once '../includes/Manager.php';

$manager = new Manager();
$user = $manager->setupSession();

$errors = array();
$values = array();

$values['contenuto'] = isset($_POST['contenuto']) ? addslashes($_POST['contenuto']) : null;
$values['idPost'] = isset($_GET['idPost']) ? addslashes($_GET['idPost']) : null;


if(empty($values['contenuto'])) array_push($errors, "Compila il campo contenuto");
if(empty($values['idPost'])){
    //gestione posizione non voluta
} 


if(count($errors)==0){

    $res = $manager->insertComment($values);

    if($res){
        header("Location: postPage.php?idPost=".$_GET['idPost']);
        $_SESSION['successInsert'] = true;
        exit();
    }else{
        $_SESSION['postValues'] = $values;
        $_SESSION['postErrors'] = $errors;
    }

}else{
    $_SESSION['postValues'] = $values;
    $_SESSION['postErrors'] = $errors;
}

header("Location: postPage.php?idPost=".$_GET['idPost']);
exit();

?>