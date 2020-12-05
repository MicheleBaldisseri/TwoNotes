<?php
require_once '../includes/Manager.php';

$manager = new Manager();
if(!isset($_POST['username']) || !isset($_POST['username'])){
    //gestire il fatto che non si potrebbe accedere a questa pagina se non settati
}else{
    $manager->login($_POST['username'],$_POST['psw']);

    if (!isset($_SESSION['username'])){
        header('Location: login.php');
        exit();
    } else {
        header('Location: ../index.php');
        exit();
    }
}

?>