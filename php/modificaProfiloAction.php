<?php

function checkValidDate($date)
{
    return (bool)strtotime($date) && date("Y-m-d", strtotime($date)) == $date;
}

function checkFutureDate($date)
{
    $date1=  new DateTime($date);
    $date2= new DateTime();

    return $date2->diff($date1)->y < 10 ;
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
$error = false;

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

if(empty($values['nome'])) array_push($errors, '<a href="#nome">Compila il campo Nome</a>');
if(empty($values['cognome'])) array_push($errors, '<a href="#cognome">Compila il campo Cognome</a>');
if(empty($values['dataNascita'])) array_push($errors, '<a href="#dataNascita">Compila il campo Data di nascita</a>');
if(empty($values['email'])) array_push($errors, '<a href="#email">Compila il campo Email</a>');
if(empty($values['sesso'])) array_push($errors, '<a href="#maschio">Compila il campo Sesso</a>');
if(empty($values['provenienza'])) array_push($errors, '<a href="#provenienza">Compila il campo Provenienza</a>');
if(empty($values['username'])) array_push($errors, '<a href="#username">Compila il campo Username</a>');
if(empty($values['oldPassword'])) array_push($errors, '<a href="#psw">Compila il campo Vecchia password</a>');
if(empty($values['confermaPassword']) && !empty($values['newPassword'])) array_push($errors, '<a href="#conf-psw">Compila il campo Conferma nuova password</a>');

if(count($errors)==0){
    if(!filter_var($values['email'], FILTER_VALIDATE_EMAIL)){
        array_push($errors, '<a href="#email">Email non valida</a>');
    }
    if(!checkValidDate($values['dataNascita'])){
        array_push($errors, '<a href="#dataNascita">Formato della data di nascita non valida. Formato corretto: gg/mm/yyyy</a>');
    }else{
        if(checkFutureDate($values['dataNascita'])){
            array_push($errors, '<a href="#dataNascita">Sei troppo giovane, devi avere almeno 10 anni</a>');
        }
    }
    if($values['newPassword']!=$values['confermaPassword'])array_push($errors, '<a href="#conf-psw">Le password non corrispondono</a>');
    if(!$user->isPasswordCorrect($values['oldPassword']))array_push($errors, '<a href="#psw">Le password corrente non è corretta</a>');

    if(count($errors)==0){
        if($manager->modificaProfilo($values,addslashes($user->getUsername()))){
            if(!empty($values['newPassword'])){
                $manager->login($values['username'],$values['newPassword']);
            }else{
                $manager->login($values['username'],$values['oldPassword']);
            } 
            $_SESSION['success'] = "Profilo modificato con successo!";
            header("Location: profilo.php?username=".stripslashes($values['username']));
            exit();
        }else{
            $error = true;
        }
    }else{
        $error = true;
        $_SESSION['modificaErrors'] = $errors;
    }

}else{
    $error = true;
    $_SESSION['modificaErrors'] = $errors;
}

if($error == true){
    $_SESSION['modificaValues'] = $values;
}

header("Location: modificaProfilo.php");
exit();

?>