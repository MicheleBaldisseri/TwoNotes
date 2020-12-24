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
			<li><a href="login.php" xml:lang="en">Login</a> oppure</li>
			<li><a href="registrazione.php">Registrati</a></li>
		</ul>
	</div>';	
}
$paginaHTML = str_replace("<HEADERDESTRO/>", $stringHeader, $paginaHTML);

$inserisciCommento = '<div id="newComment" class="sezione round_div shadow-div">
<ERROREINSERIMENTOCOMMENTO/>
<p>Consigli utili per i commenti:</p>
	<ul>
		<li>Per inserire una parola in lingua inglese usare il comando: [en] &#60;testo in inglese&#62; [/en]</li>
		<li>Per inserire una abbreviazione usare: [abbr=&#60;abbreviazione estesa&#62;] &#60;abbreviazione&#62; [/abbr]</li>
		<li>Inserire i precedenti consigli senza i simboli &#60; e &#62;</li>
	</ul>
	<form action="inserimentoCommento.php?idPost=<ID_POST/>" method="post">
		<label for="postTextarea">Inserisci qui il tuo commento:</label> 
		<textarea id="postTextarea" class="inputForm" name="contenuto" rows="5" cols="10" placeholder="Inserisci qui il tuo commento..." required="required" value="<VALORECOMMENTO/>"></textarea>
		<input type="submit" class="round-button general-button" value="Invia"></input>
	</form>
</div>';



if(isset($_GET['idPost'])){
	if($user->getUsername()!=null) $paginaHTML = str_replace("<INSERIMENTOCOMMENTO/>", $inserisciCommento, $paginaHTML);
	else $paginaHTML = str_replace("<INSERIMENTOCOMMENTO/>", '', $paginaHTML);

	$paginaHTML = str_replace("<DETTAGLIOPOST/>", $manager->printSinglePost($_GET['idPost'],$user), $paginaHTML);
	$paginaHTML = str_replace("<LISTACOMMENTI/>", $manager->printComments($_GET['idPost']), $paginaHTML);
	$paginaHTML = str_replace("<ID_POST/>", $_GET['idPost'], $paginaHTML);
}else{
	header("Location: errorPage.php");
    exit();	
}


$stringErrors = '';
if(isset($_SESSION['commentErrors'])){

    $stringErrors = "<div id='commentErrors'>";
    foreach($_SESSION['commentErrors'] as $error){
        $stringErrors .= "<p>".$error."</p>";
    }
    $stringErrors .= "</div> ";

    unset($_SESSION['commentErrors']);

    $paginaHTML = str_replace('<VALORECOMMENTO/>',stripslashes($_SESSION['commentValues']['contenuto']),$paginaHTML);
}else{
    $paginaHTML = str_replace('<VALORECOMMENTO/>','',$paginaHTML);
}

unset($_SESSION['commentValues']);

$paginaHTML = str_replace('<ERROREINSERIMENTOCOMMENTO/>',$stringErrors,$paginaHTML);

echo $paginaHTML;

?>