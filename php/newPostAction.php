<?php

$supported_image = array(
    'gif',
    'jpg',
    'jpeg',
    'png'
);

session_start();
require_once '../includes/Manager.php';

$manager = new Manager();
$user = $manager->setupSession();

if($user->getUsername()==null){
	header("Location: errorPage.php");
    exit();	
}

$errors = array();
$values = array();

$values['titolo'] = isset($_POST['titolo']) ? trim(strip_tags(addslashes($_POST['titolo']))) : null;
$values['immagine'] = isset($_FILES['myfile']['name']) ? trim(addslashes($_FILES['myfile']['name'])) : null;
$values['altImmagine'] = isset($_POST['altImmagine']) ? trim(strip_tags(addslashes($_POST['altImmagine']))) : null;
$values['contenuto'] = isset($_POST['contenuto']) ? trim(strip_tags(addslashes($_POST['contenuto']))) : null;
$values['username'] = $user->getUsername();

if(empty($values['titolo'])) array_push($errors, '<a href="#title">Compila il campo Titolo</a>');
if(empty($values['altImmagine']) && !empty($values['immagine'])) array_push($errors, '<a href="#altImmagine">Compila il campo Descrizione Immagine</a>');
if(!empty($values['altImmagine']) && empty($values['immagine'])) array_push($errors, '<a href="#altImmagine">Compila il campo Descrizione Immagine solo se un\'immagine è caricata</a>');
if(empty($values['contenuto'])) array_push($errors, '<a href="#content">Compila il campo Contenuto</a>');

if(!empty($values['immagine'])){
    $file_tmp = $_FILES['myfile']['tmp_name'];
    $size = filesize($file_tmp);

    if($size>500*1024) array_push($errors, '<a href="#myfile">Immagine troppo grande! Inserisci un immagine minore di 500 KB</a>');

    $ext = strtolower(pathinfo($values['immagine'], PATHINFO_EXTENSION));
    if (!in_array($ext, $supported_image)) array_push($errors, '<a href="#myfile">Estensione immagine non valida</a>');
}

if (!preg_match("/^[\s\S]{2,30}$/", $values['titolo'])) 
        array_push($errors, '<a href="#title">Nel titolo sono ammessi da 2 a 30 caratteri</a>');
if (!empty($values['immagine']) && !preg_match("/^[\s\S]{5,75}$/", $values['altImmagine'])) 
        array_push($errors, '<a href="#altImmagine">Nella descrizione dell\'immagine sono ammessi da 5 fino a 75 caratteri</a>');
if (!preg_match("/^[\s\S]{5,1000}$/", $values['contenuto'])) 
        array_push($errors, '<a href="#content">Nel contenuto sono ammessi da 5 a 1000 caratteri</a>');

$resTitolo = $manager->transformString($values['titolo']);
if(!$resTitolo) array_push($errors, '<a href="#title">Errore con il titolo del <span xml:lang="en">post</span>, controlla i <span xml:lang="en">tag</span> di aiuto inseriti</a>');


$resContenuto = $manager->transformString($values['contenuto']);
if(!$resContenuto) array_push($errors, '<a href="#content">Errore con il contenuto del <span xml:lang="en">post</span>, controlla i <span xml:lang="en">tag</span> di aiuto inseriti</a>');


if(count($errors)==0){

    if(!empty($values['immagine'])){
        $rnd = time();
        $path = "../upload/".$rnd.$values['immagine'];

        move_uploaded_file($_FILES["myfile"]["tmp_name"],$path);
        $values['immagine'] = $rnd.$values['immagine'];
    }

    $tempTitolo = $values['titolo'];
    $tempContenuto = $values['contenuto'];
    $values['titolo'] = $resTitolo;
    $values['contenuto'] = $resContenuto;

    $res = $manager->insertPost($values);

    if($res){
        header("Location: postPage.php?idPost=".stripslashes($res));
        $_SESSION['success'] = '<span xml:lang="en">Post</span> inserito con successo!';
        exit();
    }else{
        $values['titolo'] = $tempTitolo;
        $values['contenuto'] = $tempContenuto;
        $_SESSION['postValues'] = $values;
    }

}else{
    $_SESSION['postValues'] = $values;
    $_SESSION['postErrors'] = $errors;
}

header("Location: newPost.php");
exit();

?>