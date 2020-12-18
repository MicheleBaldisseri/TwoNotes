<?php
require_once "../includes/Manager.php";
session_start();
$paginaHTML = file_get_contents('../views/index.html');

$manager = new Manager();
$user = $manager->setupSession();

$stringHeader = '';
if($user->getUsername()!=null){
	$stringHeader = '
	<div>
		<ul>
			<li>Benvenuto <a href="profilo.php?username='.stripslashes($user->getUsername()).'">'. stripslashes($user->getNome()) .'</a>!<li>
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

$listaPost;
if(isset($_GET['page'])){
	$listaPost = $manager->getPostList($_GET['page']);
}else{
	$listaPost = $manager->getPostList(1);
}

$stringList = $manager->printPostList($listaPost);

$paginaHTML = str_replace("LISTAPOST", $stringList, $paginaHTML);

echo $paginaHTML;

?>