<?php

require_once "../includes/Manager.php";
session_start();

$paginaHTML = file_get_contents('../views/profilo.html');

$manager = new Manager();
$user = $manager->setupSession();

if(!isset($_GET['username'])){
	header("Location: errorPage.php");
    exit();	
}

$stringHeader = '';
if($user->getUsername()!=null){
	$stringHeader = '
	<div>
		<ul>
            ';
            if($_GET['username'] == stripslashes($user->getUsername())){
                $stringHeader .= '<li>Benvenuto '. stripslashes($user->getNome()) .'!<li>';
            }else{
                $stringHeader .= '<li>Benvenuto <a href="profilo.php?username='.stripslashes($user->getUsername()).'">'. stripslashes($user->getNome()) .'</a>!<li>';
            }
            $stringHeader .= '<li><a href="logout.php" xml:lang="en">Logout</a></li>
            </ul>
        </div>';
}else{
	$stringHeader = '
	<div>
		<ul>
			<li><a href="login.php" xml:lang="en">Login</a> oppure</li>
			<li><a href="registrazione.php">Registrati</a></li>
		</ul>
	</div>';	
}
$paginaHTML = str_replace("<HEADERDESTRO/>", $stringHeader, $paginaHTML);

$userProfile = $manager->getUser($_GET['username']);

if($userProfile!=null){

	$timestamp = strtotime($userProfile->getDataNascita());
	$new_date = date("d/m/Y", $timestamp);

	$paginaHTML = str_replace("<NOME/>", stripslashes($userProfile->getNome()), $paginaHTML);
	$paginaHTML = str_replace("<COGNOME/>", stripslashes($userProfile->getCognome()), $paginaHTML);
	$paginaHTML = str_replace("<EMAIL/>", stripslashes($userProfile->getEmail()), $paginaHTML);
	$paginaHTML = str_replace("<DATANASCITA/>", $new_date, $paginaHTML);
	$paginaHTML = str_replace("<SESSO/>", $userProfile->getSesso(), $paginaHTML);
	$paginaHTML = str_replace("<USERNAME/>", stripslashes($userProfile->getUsername()), $paginaHTML);
	$paginaHTML = str_replace("<PROVENIENZA/>", stripslashes($userProfile->getProvenienza()), $paginaHTML);
	$paginaHTML = str_replace("<RUOLO/>", ($userProfile->isAdmin() ? 'Admin' : 'Utente'), $paginaHTML);
}else{
	//Gestire errore database
}


$buttonModifica = '';
if($_GET['username'] == stripslashes($user->getUsername())){
	$buttonModifica = '<a class="linkToButton" id="annulla" href="modificaProfilo.php">Modifica</a>';
}
$paginaHTML = str_replace("<LINKMODIFICA/>", $buttonModifica, $paginaHTML);

echo $paginaHTML;

?>