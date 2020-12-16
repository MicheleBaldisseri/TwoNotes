<?php
require_once '../includes/Manager.php';
session_start();

$manager = new Manager();
if(!isset($_POST['username']) || !isset($_POST['psw'])){
    //gestire il fatto che non si potrebbe accedere a questa pagina se non settati
}else{
    $manager->login($_POST['username'],$_POST['psw']);

    if (!isset($_SESSION['username'])){
        header('Location: login.php');
        $_SESSION['oldUsername']=$_POST['username'];
        exit();
    } else {
        header('Location: index.php');
        exit();
    }
}

?>