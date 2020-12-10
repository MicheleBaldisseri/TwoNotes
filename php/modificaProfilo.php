<?php

require_once "../includes/Manager.php";
session_start();

$paginaHTML = file_get_contents('../views/modificaProfilo.html');
    
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

echo $paginaHTML;

?>