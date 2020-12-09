<?php

session_start();
require_once '../includes/Manager.php';

$manager = new Manager();
$user = $manager->setupSession();

$errors = array();
$values = array();

$values['titolo'] = isset($_POST['titolo']) ? addslashes($_POST['titolo']) : null;
$values['immagine'] = is_uploaded_file($_FILES['myfile']['tmp_name']) ? addslashes(file_get_contents($_FILES['myfile']['tmp_name'])) : null;
$values['altImmagine'] = isset($_POST['altImmagine']) ? addslashes($_POST['altImmagine']) : null;
$values['contenuto'] = isset($_POST['contenuto']) ? addslashes($_POST['contenuto']) : null;
$values['username'] = $user->getUsername();

if(empty($values['titolo'])) array_push($errors, "Compila il campo Titolo");
if(empty($values['altImmagine']) && !empty($values['immagine'])) array_push($errors, "Compila il campo Alt Immagine");
if(empty($values['contenuto'])) array_push($errors, "Compila il campo Contenuto");

if(count($errors)==0){

    $res = $manager->insertPost($values);

    if($res){
        header("Location: postPage.php?idPost=".stripslashes($res));
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

header("Location: newPost.php");
exit();

?>