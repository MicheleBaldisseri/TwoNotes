<?php

session_start();
require_once '../includes/Manager.php';

$manager = new Manager();
$user = $manager->setupSession();

$errors = array();
$values = array();

$values['contenuto'] = isset($_POST['contenuto']) ? strip_tags(addslashes($_POST['contenuto'])) : null;
$values['idPost'] = isset($_GET['idPost']) ? addslashes($_GET['idPost']) : null;
$values['username'] = addslashes($user->getUsername());

if(empty($values['contenuto'])) array_push($errors, '<a href="#postTextarea">Compila il campo del commento</a>');
if(empty($values['idPost'])){
    header("Location: errorPage.php");
    exit();
}
if(empty($values['username'])){
    header("Location: errorPage.php");
    exit();
}

$res = $manager->transformString($values['contenuto']);
if(!$res) array_push($errors, '<a href="#postTextarea">Errore con il contenuto del commento, controlla i <span xml:lang="en">tag</span> di aiuto inseriti</a>');
else $values['contenuto'] = $res;

if (!preg_match("/^[\s\S]{1,500}$/", $values['contenuto'])) 
        array_push($errors, '<a href="#postTextarea">Nel commento sono ammessi da 1 a 500 caratteri </a>');

if(count($errors)==0){
    $res = $manager->insertComment($values);

    if($res){
        header("Location: postPage.php?idPost=".$_GET['idPost']);
        $_SESSION['success'] = "Commento inserito con successo!";
        exit();
    }else{
        array_push($errors, "Errore di inserimento del commento");
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