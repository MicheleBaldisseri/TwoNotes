<?php
require_once "includes/Manager.php";

$manager = new Manager();
$res = $manager->connect();
$paginaHTML = file_get_contents('views/index.html');

if($res == false){
	die ("Errore nell'apertura del DB"); //TODO
}else{
	$listaPost = $manager->getPostList();
    $manager->disconnect(); 
    $string = $manager->printPostList($listaPost);

	echo str_replace("<LISTAPOST />", $string, $paginaHTML);
}

?>