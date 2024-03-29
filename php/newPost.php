<?php
require_once "../includes/Manager.php";
session_start();
$paginaHTML = file_get_contents('../views/newPost.html');

$manager = new Manager();
$user = $manager->setupSession();

$stringHeader = '';
if($user->getUsername()!=null){
	$stringHeader = '
	<div>
		<ul>
			<li>Benvenuto <a href="profilo.php?username='.stripslashes($user->getUsername()).'" title="Vai al tuo profilo">'. stripslashes($user->getNome()) .'</a>!</li>
			<li><a href="logout.php" xml:lang="en" lang="en">Logout</a></li>
		</ul>
	</div>';
}else{
    unset($_SESSION['loginError']);
    $errors = array();
    array_push($errors,'Devi autenticarti prima di scrivere un nuovo <span xml:lang="en" lang="en">post</span>!');
    $_SESSION['loginError'] = $errors;
    header("Location: login.php");
    exit();
}
$paginaHTML = str_replace("<HEADERDESTRO/>", $stringHeader, $paginaHTML);

$stringErrors = '';
if(isset($_SESSION['postErrors'])){

    $stringErrors = "<ul id='phpErrors' class='listaSenzaPunti'>";
    foreach($_SESSION['postErrors'] as $error){
        $stringErrors .= "<li>".$error."</li>";
    }
    $stringErrors .= "</ul> ";

    unset($_SESSION['postErrors']);
    
    $paginaHTML = str_replace('<VALORETITOLO/>',htmlspecialchars(stripslashes($_SESSION['postValues']['titolo'])),$paginaHTML);
    $paginaHTML = str_replace('<VALOREALT/>',stripslashes($_SESSION['postValues']['altImmagine']),$paginaHTML);
    $paginaHTML = str_replace('<VALORECONTENUTO/>',stripslashes($_SESSION['postValues']['contenuto']),$paginaHTML);
}else{
    $paginaHTML = str_replace('<VALORETITOLO/>','',$paginaHTML);
    $paginaHTML = str_replace('<VALOREALT/>','',$paginaHTML);
    $paginaHTML = str_replace('<VALORECONTENUTO/>','',$paginaHTML);
}

unset($_SESSION['registerValues']);

$paginaHTML = str_replace('<ERRORIPOST/>',$stringErrors,$paginaHTML);

echo $paginaHTML;

?>