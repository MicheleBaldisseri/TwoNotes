<?php
require_once '../includes/Manager.php';
session_start();

$manager = new Manager();
if(!isset($_POST['username']) || !isset($_POST['psw'])){
    
    header("Location: errorPage.php");
    exit();

}else{
    $errors = array();

    if (!preg_match("/^[\.\w-]{2,20}$/", trim($_POST['username']))) 
        array_push($errors, '<a href="#username"><span xml:lang="en" lang="en">Username</span> inserito non valido</a>');
    if (!preg_match("/^[\w(#$%&=!)]{4,20}$/", trim($_POST['psw']))) 
        array_push($errors, '<a href="#psw"><span xml:lang="en" lang="en">Password</span> inserita non valida</a>');

    if(count($errors)!=0){
        header('Location: login.php');
        $_SESSION['loginError']=$errors;
        $_SESSION['oldUsername']=$_POST['username'];
        exit();
    }
    
    $manager->login(trim($_POST['username']),trim($_POST['psw']));

    if (!isset($_SESSION['username'])){
        header('Location: login.php');
        $_SESSION['oldUsername']=$_POST['username'];
        exit();
    } else {
        $_SESSION['success'] = '<span xml:lang="en" lang="en">Login</span> avvenuto con successo!';
        header('Location: index.php');
        exit();
    }
}

?>