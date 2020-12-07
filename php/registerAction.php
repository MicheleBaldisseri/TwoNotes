<?php

function checkValidDate($date)
{
    return (bool)strtotime($date) && date("Y-m-d", strtotime($date)) == $date;
}

function checkFutureDate($date)
{
    return $date > date('Y-m-d');
}

session_start();
require_once '../includes/Manager.php';

$manager = new Manager();
$db = $manager->getConnection();

$errors = array();
$values = array();

$values['nome'] = $_POST['nome'];
$values['cognome'] = $_POST['cognome'];
$values['dataNascita'] = $_POST['data'];
$values['email'] = $_POST['email'];
$values['sesso'] = $_POST['gender'];
$values['provenienza'] = $_POST['provenienza'];
$values['username'] = $_POST['username'];
$values['password'] = $_POST['psw']; 

if(empty($values['nome'])) array_push($errors, "Compila il campo Nome");
if(empty($values['cognome'])) array_push($errors, "Compila il campo Cognome");
if(empty($values['dataNascita'])) array_push($errors, "Compila il campo Data di Nascita");
if(empty($values['email'])) array_push($errors, "Compila il campo Email");
if(empty($values['sesso'])) array_push($errors, "Compila il campo Sesso");
if(empty($values['provenienza'])) array_push($errors, "Compila il campo Provenienza");
if(empty($values['username'])) array_push($errors, "Compila il campo Username");
if(empty($values['password'])) array_push($errors, "Compila il campo Password");



if(count($errors)==0){
    if(!filter_var($values['email'], FILTER_VALIDATE_EMAIL)){
        array_push($errors, "Email non valida");
    }
    if(!checkValidDate($values['dataNascita'])){
        array_push($errors, "Formato della data di nascita non valida. Formato corretto: gg/mm/yyyy");
    }else{
        if(checkFutureDate($values['dataNascita'])){
            array_push($errors, "Data di nascita non valida");
        }
    }

    if(count($errors)==0){
        if($manager->register($values)){
            $manager->login($values['username'],$values['password']);
            
            header("Location: ../index.php");
            exit();
        }
    }else{
        $_SESSION['registerValues'] = $values;
        $_SESSION['registerErrors'] = $errors;
    }

}else{
    $_SESSION['registerValues'] = $values;
    $_SESSION['registerErrors'] = $errors;
}

header("Location: registrazione.php");
exit();

?>