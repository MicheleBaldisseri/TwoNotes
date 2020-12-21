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
$user = $manager->setupSession();

if($user->getUsername()==null){
	header("Location: errorPage.php");
    exit();	
}

$errors = array();
$values = array();

$values['nome'] = isset($_POST['nome']) ? addslashes($_POST['nome']) : null;
$values['cognome'] = isset($_POST['cognome']) ? addslashes($_POST['cognome']) : null;
$values['dataNascita'] = isset($_POST['data']) ? addslashes($_POST['data']) : null;
$values['email'] = isset($_POST['email']) ? addslashes($_POST['email']) : null;
$values['sesso'] = isset($_POST['gender']) ? addslashes($_POST['gender']) : null;
$values['provenienza'] = isset($_POST['provenienza']) ? addslashes($_POST['provenienza']) : null;
$values['username'] = isset($_POST['username']) ? addslashes($_POST['username']) : null;
$values['oldPassword'] = isset($_POST['oldpsw']) ? addslashes($_POST['oldpsw']) : null;
$values['newPassword'] = isset($_POST['newpsw']) ? addslashes($_POST['newpsw']) : null; 
$values['confermaPassword'] = isset($_POST['conf-psw']) ? addslashes($_POST['conf-psw']) : null;

if(empty($values['nome'])) array_push($errors, "Compila il campo Nome");
if(empty($values['cognome'])) array_push($errors, "Compila il campo Cognome");
if(empty($values['dataNascita'])) array_push($errors, "Compila il campo Data di Nascita");
if(empty($values['email'])) array_push($errors, "Compila il campo Email");
if(empty($values['sesso'])) array_push($errors, "Compila il campo Sesso");
if(empty($values['provenienza'])) array_push($errors, "Compila il campo Provenienza");
if(empty($values['username'])) array_push($errors, "Compila il campo Username");
if(empty($values['oldPassword'])) array_push($errors, "Compila il campo Vecchia Password");
if(empty($values['confermaPassword']) && !empty($values['newPassword'])) array_push($errors, "Compila il campo Conferma Nuova password");

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
    if($values['newPassword']!=$values['confermaPassword'])array_push($errors, "Le password non corrispondono");
    if(!$user->isPasswordCorrect($values['oldPassword']))array_push($errors, "Password errata");

    if(count($errors)==0){
        if($manager->modificaProfilo($values,addslashes($user->getUsername()))){
            if(!empty($values['newPassword'])){
                $manager->login($values['username'],$values['newPassword']);
            }else{
                $manager->login($values['username'],$values['oldPassword']);
            } 
            header("Location: profilo.php?username=".stripslashes($values['username']));
            exit();
        }
    }else{
        $_SESSION['modificaValues'] = $values;
        $_SESSION['modificaErrors'] = $errors;
    }

}else{
    $_SESSION['modificaValues'] = $values;
    $_SESSION['modificaErrors'] = $errors;
}

header("Location: modificaProfilo.php");
exit();

?>