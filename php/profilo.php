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

$success = '';
if(isset($_SESSION['success'])){
	$success = '<div id="success_div" class="round_div shadow-div">'.$_SESSION['success'].'</div>';
	unset($_SESSION['success']);
}
$paginaHTML = str_replace("<SUCCESS/>", $success, $paginaHTML);

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

	header("Location: errorPage.php");
	exit();	
}



$buttonModifica = '';
if($_GET['username'] == stripslashes($user->getUsername())){
	$buttonModifica = '<a href="modificaProfilo.php">Modifica</a>';
}
$paginaHTML = str_replace("<LINKMODIFICA/>", $buttonModifica, $paginaHTML);

$buttonDelete = '';
if($user->isAdmin()){
	$buttonDelete = '<a href="deleteUser.php?user='.stripslashes($userProfile->getUsername()).'">Elimina il profilo</a>';
}
$paginaHTML = str_replace("<LINKELIMINA/>", $buttonDelete, $paginaHTML);

echo $paginaHTML;

?>