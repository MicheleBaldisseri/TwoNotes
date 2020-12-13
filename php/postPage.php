<?php

require_once "../includes/Manager.php";
session_start();

$paginaHTML = file_get_contents('../views/postPage.html');

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
	$stringHeader = '
	<div>
		<ul>
			<li><a href="login.php" xml:lang="en">Login</a></li>
			<li>oppure</li>
			<li><a href="registrazione.php">Registrati</a></li>
		</ul>
	</div>';	
}
$paginaHTML = str_replace("HEADERDESTRO", $stringHeader, $paginaHTML);

if(isset($_GET['idPost'])){
	$paginaHTML = str_replace("DETTAGLIOPOST", $manager->printSinglePost($_GET['idPost']), $paginaHTML);
	$paginaHTML = str_replace("LISTACOMMENTI", $manager->printComments($_GET['idPost']), $paginaHTML);
	$paginaHTML = str_replace("ID_POST", $_GET['idPost'], $paginaHTML);
}else{
	//gestire il fatto che non si dovrebbe essere qui
	//exit();
}

$stringErrors = '';
if(isset($_SESSION['commentErrors'])){
//mostrare errori form

    $stringErrors = "<div id='commentErrors'>";
    foreach($_SESSION['commentErrors'] as $error){
        $stringErrors .= "<p>".$error."</p>";
    }
    $stringErrors .= "</div> ";

    unset($_SESSION['commentErrors']);

    $paginaHTML = str_replace('VALORETCOMMENTO',$_SESSION['commentValues']['contenuto'],$paginaHTML);
}else{
    $paginaHTML = str_replace('VALORECOMMENTO','',$paginaHTML);
}

unset($_SESSION['registerValues']);

$paginaHTML = str_replace('ERROREINSERIMENTOCOMMENTO',$stringErrors,$paginaHTML);

echo $paginaHTML;

?>