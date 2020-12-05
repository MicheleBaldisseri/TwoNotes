<?php
require_once "includes/Manager.php";
session_start();
$paginaHTML = file_get_contents('views/index.html');

$manager = new Manager();
$user = $manager->setupSession();

$stringHeader = '';
if($user->getUsername()!=null){
	$stringHeader = '
	<div>
		<ul>
<<<<<<< HEAD
			<li>Benvenuto '. $user->getNome() .'!<li>
=======
			<li><p>Benvenuto '. $user->getNome() .'!</p><li>
>>>>>>> 7371a8f5572816e33320b093fc0680da616d8ec0
			<li><a href="php/logout.php" xml:lang="en">Logout</a></li>
		</ul>
	</div>';
}else{
	$stringHeader = '
	<div>
		<ul>
			<li><a href="php/login.php" xml:lang="en">Login</a></li>
			<li>oppure</li>
			<li><a href="php/registrazione.php">Registrati</a></li>
		</ul>
	</div>';	
}
$paginaHTML = str_replace("<HEADERDESTRO />", $stringHeader, $paginaHTML);

$res = $manager->connect();
if($res == false){
	die ("Errore nell'apertura del DB"); //TODO
}else{
	$listaPost = $manager->getPostList();
    $manager->disconnect(); 
    $string = $manager->printPostList($listaPost);

	echo str_replace("<LISTAPOST />", $string, $paginaHTML);
}

?>