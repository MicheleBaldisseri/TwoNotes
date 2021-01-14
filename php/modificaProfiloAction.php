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

$values['nome'] = isset($_POST['nome']) ? trim(addslashes($_POST['nome'])) : null;
$values['cognome'] = isset($_POST['cognome']) ? trim(addslashes($_POST['cognome'])) : null;
$values['dataNascita'] = isset($_POST['data']) ? trim(addslashes($_POST['data'])) : null;
$values['email'] = isset($_POST['email']) ? trim(addslashes($_POST['email'])) : null;
$values['sesso'] = isset($_POST['gender']) ? trim(addslashes($_POST['gender'])) : null;
$values['username'] = isset($_POST['username']) ? trim(addslashes($_POST['username'])) : null;
$values['oldPassword'] = isset($_POST['oldpsw']) ? trim(addslashes($_POST['oldpsw'])) : null;
$values['newPassword'] = isset($_POST['newpsw']) ? trim(addslashes($_POST['newpsw'])) : null; 
$values['confermaPassword'] = isset($_POST['conf-psw']) ? trim(addslashes($_POST['conf-psw'])) : null;

if(empty($values['nome'])) array_push($errors, '<a href="#nome">Compila il campo Nome</a>');
if(empty($values['cognome'])) array_push($errors, '<a href="#cognome">Compila il campo Cognome</a>');
if(empty($values['dataNascita'])) array_push($errors, '<a href="#dataNascita">Compila il campo Data di nascita</a>');
if(empty($values['email'])) array_push($errors, '<a href="#email">Compila il campo <span xml:lang="en" lang="en">Email</span></a>');
if(empty($values['sesso'])) array_push($errors, '<a href="#maschio">Compila il campo Sesso</a>');
if(empty($values['username'])) array_push($errors, '<a href="#username">Compila il campo <span xml:lang="en" lang="en">Username</span></a>');
if(empty($values['oldPassword'])) array_push($errors, '<a href="#psw">Compila il campo Vecchia <span xml:lang="en" lang="en">password</span></a>');
if(empty($values['confermaPassword']) && !empty($values['newPassword'])) array_push($errors, '<a href="#conf-psw">Compila il campo Conferma nuova <span xml:lang="en" lang="en">password</span></a>');

if(count($errors)==0){
    if(!filter_var($values['email'], FILTER_VALIDATE_EMAIL)){
        array_push($errors, '<a href="#email">Formato <span xml:lang="en" lang="en">email</span> inserito non valido</a>');
    }
    if(!checkValidDate($values['dataNascita'])){
        array_push($errors, '<a href="#dataNascita">Formato della data di nascita non valida. Formato corretto: gg/mm/yyyy</a>');
    }else{
        if(checkFutureDate($values['dataNascita'])){
            array_push($errors, '<a href="#dataNascita">Sei troppo giovane, devi avere almeno 10 anni</a>');
        }
    }
    if($values['newPassword']!=$values['confermaPassword'])array_push($errors, '<a href="#conf-psw">Le <span xml:lang="en" lang="en">password</span> non corrispondono</a>');
    if(!$user->isPasswordCorrect($values['oldPassword']))array_push($errors, '<a href="#psw">La <span xml:lang="en" lang="en">password</span> corrente non è corretta</a>');

    if (!preg_match("/^(([(a-z)(A-Z)(àèìòù)]+[,.]?[\s]?|[a-zA-Z]+['-]?)+){2,20}$/", $values['nome'])) 
        array_push($errors, '<a href="#nome">Per il campo Nome sono ammesse solo lettere, da 2 a 20 caratteri</a>');
    if (!preg_match("/^(([(a-z)(A-Z)(àèìòù)]+[,.]?[\s]?|[a-zA-Z]+['-]?)+){2,20}$/", $values['cognome'])) 
        array_push($errors, '<a href="#cognome">Per il campo Cognome sono ammesse solo lettere, da 2 a 20 caratteri</a>');
    if (!preg_match("/^[\.\w-]{2,20}$/", $values['username'])) 
        array_push($errors, '<a href="#username">Per il campo <span xml:lang="en" lang="en">Username</span> sono ammessi numeri, lettere e i simboli . e - , da 2 a 20 caratteri</a>');
    if (!preg_match("/[\S]{2,32}@[\w]{2,32}((?:\.[\w]+)+)?(\.(it|com|edu|gov|org|net|info)){1}/", $values['email'])) 
        array_push($errors, '<a href="#email">Formato <span xml:lang="en" lang="en">email</span> inserito non valido</a>');
    if ($values['newPassword']!=null && !preg_match("/^[\w(#$%&=!)]{4,20}$/", $values['newPassword'])) 
        array_push($errors, '<a href="#newpsw">Per il campo Nuova <span xml:lang="en" lang="en">Password</span> sono ammessi numeri, lettere e i simboli #,$,%,&,=,! da 4 a 20 caratteri</a>');

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