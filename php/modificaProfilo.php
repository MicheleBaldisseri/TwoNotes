<?php

require_once "../includes/Manager.php";
session_start();

$paginaHTML = file_get_contents('../views/modificaProfilo.html');

$manager = new Manager();
$user = $manager->setupSession();
    
$stringHeader = '';
if($user->getUsername()!=null){
	$stringHeader = '
	<div>
		<ul>
			<li>Benvenuto <a href="profilo.php?username='.$user->getUsername().'" title="Vai al tuo profilo">'. $user->getNome() .'</a>!</li>
			<li><a href="logout.php" xml:lang="en" lang="en">Logout</a></li>
		</ul>
	</div>';
}else{
	header("Location: errorPage.php");
    exit();	
}
$paginaHTML = str_replace("<HEADERDESTRO/>", $stringHeader, $paginaHTML);

$stringErrors = '';
if(isset($_SESSION['modificaErrors'])){

    $stringErrors = "<ul id='phpErrors' class='listaSenzaPunti'>";
    foreach($_SESSION['modificaErrors'] as $error){
        $stringErrors .= "<li>".$error."</li>";
    }
    $stringErrors .= "</ul> ";

	unset($_SESSION['modificaErrors']);

	$paginaHTML = str_replace("<VALORENOME/>", stripslashes($_SESSION['modificaValues']['nome']), $paginaHTML);
	$paginaHTML = str_replace("<VALORECOGNOME/>", stripslashes($_SESSION['modificaValues']['cognome']), $paginaHTML);
	$paginaHTML = str_replace("<VALOREEMAIL/>", stripslashes($_SESSION['modificaValues']['email']), $paginaHTML);
	$paginaHTML = str_replace("<VALOREDATA/>", stripslashes($_SESSION['modificaValues']['dataNascita']), $paginaHTML);
	$paginaHTML = str_replace("<VALOREUSERNAME/>", stripslashes($_SESSION['modificaValues']['username']), $paginaHTML);

	$sesso = trim($_SESSION['modificaValues']['sesso']);
	if($sesso == 'M') $paginaHTML = str_replace('SELECTEDM','checked="checked"',$paginaHTML);	
	else $paginaHTML = str_replace('SELECTEDM','',$paginaHTML);
	
	if($sesso == 'F') $paginaHTML = str_replace('SELECTEDF','checked="checked"',$paginaHTML);
	else $paginaHTML = str_replace('SELECTEDF','',$paginaHTML);

	if($sesso == 'A') $paginaHTML = str_replace('SELECTEDA','checked="checked"',$paginaHTML);
	else $paginaHTML = str_replace('SELECTEDA','',$paginaHTML);

	unset($_SESSION['modificaValues']);

}else{
	if($user->getUsername()!=null){

		$paginaHTML = str_replace("<VALORENOME/>", stripslashes($user->getNome()), $paginaHTML);
		$paginaHTML = str_replace("<VALORECOGNOME/>", stripslashes($user->getCognome()), $paginaHTML);
		$paginaHTML = str_replace("<VALOREEMAIL/>", stripslashes($user->getEmail()), $paginaHTML);
		$paginaHTML = str_replace("<VALOREDATA/>", stripslashes($user->getDataNascita()), $paginaHTML);
		$paginaHTML = str_replace("<VALOREUSERNAME/>", stripslashes($user->getUsername()), $paginaHTML);
	
		$sesso = $user->getSesso();
		if($sesso == 'M') $paginaHTML = str_replace('SELECTEDM','checked="checked"',$paginaHTML);
		else $paginaHTML = str_replace('SELECTEDM','',$paginaHTML);
	
		if($sesso == 'F') $paginaHTML = str_replace('SELECTEDF','checked="checked"',$paginaHTML);
		else $paginaHTML = str_replace('SELECTEDF','',$paginaHTML);
	
		if($sesso == 'A') $paginaHTML = str_replace('SELECTEDA','checked="checked"',$paginaHTML);
		else $paginaHTML = str_replace('SELECTEDA','',$paginaHTML);
		
	}else{
		header("Location: errorPage.php");
		exit();	
	}
}
$paginaHTML = str_replace('<ERRORIMODIFICAPROFILO/>',$stringErrors,$paginaHTML);

echo $paginaHTML;

?>