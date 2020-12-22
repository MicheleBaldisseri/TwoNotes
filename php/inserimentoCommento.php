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

if(empty($values['contenuto'])) array_push($errors, "Compila il campo contenuto");
if(empty($values['idPost'])){
    header("Location: errorPage.php");
    exit();
}
if(empty($values['username'])){
    header("Location: errorPage.php");
    exit();
}

$res = $manager->transformString($values['contenuto']);
if(!$res) array_push($errors, "Errore con il contenuto del post, controlla i tag di aiuto inseriti");
else $values['contenuto'] = $res;

if(count($errors)==0){
    $res = $manager->insertComment($values);

    if($res){
        header("Location: postPage.php?idPost=".$_GET['idPost']);
        $_SESSION['successInsert'] = true;
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