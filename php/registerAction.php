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

$values['nome'] = isset($_POST['nome']) ? addslashes($_POST['nome']) : null;
$values['cognome'] = isset($_POST['cognome']) ? addslashes($_POST['cognome']) : null;
$values['dataNascita'] = isset($_POST['data']) ? addslashes($_POST['data']) : null;
$values['email'] = isset($_POST['email']) ? addslashes($_POST['email']) : null;
$values['sesso'] = isset($_POST['gender']) ? addslashes($_POST['gender']) : null;
$values['provenienza'] = isset($_POST['provenienza']) ? addslashes($_POST['provenienza']) : null;
$values['username'] = isset($_POST['username']) ? addslashes($_POST['username']) : null;
$values['password'] = isset($_POST['psw']) ? addslashes($_POST['psw']) : null; 
$values['confermaPassword'] = isset($_POST['conf-psw']) ? addslashes($_POST['conf-psw']) : null;

if(empty($values['nome'])) array_push($errors, "Compila il campo Nome");
if(empty($values['cognome'])) array_push($errors, "Compila il campo Cognome");
if(empty($values['dataNascita'])) array_push($errors, "Compila il campo Data di Nascita");
if(empty($values['email'])) array_push($errors, "Compila il campo Email");
if(empty($values['sesso'])) array_push($errors, "Compila il campo Sesso");
if(empty($values['provenienza'])) array_push($errors, "Compila il campo Provenienza");
if(empty($values['username'])) array_push($errors, "Compila il campo Username");
if(empty($values['password'])) array_push($errors, "Compila il campo Password");
if(empty($values['confermaPassword'])) array_push($errors, "Compila il campo Ripeti password");

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
    if($values['password']!=$values['confermaPassword'])array_push($errors, "Le password non corrispondono");

    if(count($errors)==0){
        if($manager->register($values)){
            $manager->login($values['username'],$values['password']);
            
            header("Location: index.php");
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