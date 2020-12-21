<?php
require_once '../includes/Manager.php';
session_start();

$manager = new Manager();
if(!isset($_POST['username']) || !isset($_POST['psw'])){
    header("Location: errorPage.php");
    exit();
}else{
    $manager->login(addslashes($_POST['username']),addslashes($_POST['psw']));

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