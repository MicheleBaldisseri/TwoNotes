<?php
require_once "includes/Manager.php";
session_start();

$manager = new Manager();

$user = $manager->setupSession();

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