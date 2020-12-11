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
			<li>Benvenuto <a href="profilo.php?username='.$user->getUsername().'">'. $user->getNome() .'</a>!<li>
			<li><a href="logout.php" xml:lang="en">Logout</a></li>
		</ul>
	</div>';
}else{
	//gestire il fatto di essere in una pagina sbagliata	
}
$paginaHTML = str_replace("HEADERDESTRO", $stringHeader, $paginaHTML);

$stringErrors = '';
if(isset($_SESSION['modificaErrors'])){
    //mostrare errori form

    $stringErrors = "<div id='registerErrors'>";
    foreach($_SESSION['modificaErrors'] as $error){
        $stringErrors .= "<p>".$error."</p>";
    }
    $stringErrors .= "</div> ";

	unset($_SESSION['modificaErrors']);
}
$paginaHTML = str_replace('ERRORIMODIFICAPROFILO',$stringErrors,$paginaHTML);

if($user->getUsername()!=null){

	$paginaHTML = str_replace("VALORENOME", $user->getNome(), $paginaHTML);
	$paginaHTML = str_replace("VALORECOGNOME", $user->getCognome(), $paginaHTML);
	$paginaHTML = str_replace("VALOREEMAIL", $user->getEmail(), $paginaHTML);
	$paginaHTML = str_replace("VALOREDATA", $user->getDataNascita(), $paginaHTML);
	$paginaHTML = str_replace("VALOREUSERNAME", $user->getUsername(), $paginaHTML);
	$paginaHTML = str_replace("VALOREPROVENIENZA", $user->getProvenienza(), $paginaHTML);

	$sesso = $user->getSesso();
	if($sesso == 'M') $paginaHTML = str_replace('SELECTEDM','checked',$paginaHTML);
	else $paginaHTML = str_replace('SELECTEDM','',$paginaHTML);

	if($sesso == 'F') $paginaHTML = str_replace('SELECTEDF','checked',$paginaHTML);
	else $paginaHTML = str_replace('SELECTEDF','',$paginaHTML);

	if($sesso == 'A') $paginaHTML = str_replace('SELECTEDA','checked',$paginaHTML);
	else $paginaHTML = str_replace('SELECTEDA','',$paginaHTML);
	
}else{
	//Gestire errore database
}

echo $paginaHTML;

?>