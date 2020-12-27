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



$currentPage = 1;
if(isset($_GET['page'])) $currentPage = $_GET['page'];

$pageTotalCount = $manager->getTotalPageCount();
if($currentPage>$pageTotalCount)$currentPage=$pageTotalCount;
$navigazione = $manager->printNavigazione($currentPage,$pageTotalCount);

$paginaHTML = str_replace("<NAVIGAZIONE/>", $navigazione, $paginaHTML);

$listaPost = $manager->getPostList($currentPage);
$stringList = $manager->printPostList($listaPost);

$paginaHTML = str_replace("<LISTAPOST/>", $stringList, $paginaHTML);

echo $paginaHTML;

?>