<?php

session_start();
require_once '../includes/Manager.php';

$manager = new Manager();
$user = $manager->setupSession();

$errors = array();
$values = array();

$values['contenuto'] = isset($_POST['contenuto']) ? trim(strip_tags(addslashes($_POST['contenuto']))) : null;
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

if (!preg_match("/^[\s\S]{1,500}$/", $values['contenuto'])) 
        array_push($errors, '<a href="#postTextarea">Nel commento sono ammessi da 1 a 500 caratteri </a>');

$resContenuto = $manager->transformString($values['contenuto']);
if(!$resContenuto) array_push($errors, '<a href="#postTextarea">Errore con il contenuto del commento, controlla i <span xml:lang="en">tag</span> di aiuto inseriti</a>');



if(count($errors)==0){
    $temp = $values['contenuto'];
    $values['contenuto'] = $resContenuto;

    $res = $manager->insertComment($values);

    if($res){
        header("Location: postPage.php?idPost=".$_GET['idPost']);
        $_SESSION['success'] = "Commento inserito con successo!";
        exit();
    }else{
        $values['contenuto'] = $temp;
        $_SESSION['commentValues'] = $values;
    }

}else{
    $_SESSION['commentValues'] = $values;
    $_SESSION['commentErrors'] = $errors;
}

header("Location: postPage.php?idPost=".$_GET['idPost']);
exit();

?>