<?php

require_once "../includes/Manager.php";
session_start();

$paginaHTML = file_get_contents('../views/postPage.html');

$manager = new Manager();
$user = $manager->setupSession();

$stringHeader = '';
$messaggioAutenticazione = '';
if($user->getUsername()!=null){
	$stringHeader = '
	<div>
		<ul>
			<li>Benvenuto <a href="profilo.php?username='.$user->getUsername().'" title="Vai al tuo profilo">'. $user->getNome() .'</a>!</li>
			<li><a href="logout.php" xml:lang="en" lang="en">Logout</a></li>
		</ul>
	</div>';
}else{
	$messaggioAutenticazione = '<p id="needLogin">Effettua l\'autenticazione per inserire un commento.</p>'; 
	$stringHeader = '
	<div>
		<ul>
			<li><a href="login.php" xml:lang="en" lang="en">Login</a> oppure</li>
			<li><a href="registrazione.php">Registrati</a></li>
		</ul>
	</div>';	
}
$paginaHTML = str_replace("<HEADERDESTRO/>", $stringHeader, $paginaHTML);
$paginaHTML = str_replace("<MESSAGGIOAUTENTICAZIONE/>", $messaggioAutenticazione, $paginaHTML);

$success = '';
if(isset($_SESSION['success'])){
	$success = '<div id="success_div" class="round_div shadow-div"><p>'.$_SESSION['success'].'</p></div>';
	unset($_SESSION['success']);
}
$paginaHTML = str_replace("<SUCCESS/>", $success, $paginaHTML);

$inserisciCommento = '<div id="newComment" class="sezione round_div shadow-div">
<ERROREINSERIMENTOCOMMENTO/>
<p>Consigli utili per i commenti:</p>
	<ul>
		<li>Per inserire una parola in lingua inglese usare il comando: [en] &#60;testo in inglese&#62; [/en]</li>
		<li>Per inserire una abbreviazione usare: [abbr=&#60;abbreviazione estesa&#62;] &#60;abbreviazione&#62; [/abbr]</li>
		<li>Inserire i precedenti consigli senza i simboli &#60; e &#62;</li>
	</ul>
	<form action="inserimentoCommento.php?idPost=<ID_POST/>" title="Nuovo Commento" method="post" onsubmit="return validateForm();">
		<div>
			<label for="postTextarea">Inserisci qui il tuo commento:</label> 
			<span>
				<textarea id="postTextarea" class="inputForm" name="contenuto" rows="5" cols="10" placeholder="Inserisci qui il tuo commento..." required="required"><VALORECOMMENTO/></textarea>
			</span>
			<input type="submit" class="round-button general-button" value="Invia" />
		</div>
	</form>
</div>';



if(isset($_GET['idPost'])){

	$currentPage = 1;
	if(isset($_GET['page'])) $currentPage = $_GET['page'];

	$pageTotalCount = $manager->getTotalPageCommentCount($_GET['idPost']);
	if($currentPage>$pageTotalCount && $pageTotalCount!=0)$currentPage=$pageTotalCount;
	$navigazione = $manager->printNavigazioneCommenti($currentPage,$pageTotalCount,$_GET['idPost']);

	$paginaHTML = str_replace("<NAVIGAZIONE/>", $navigazione, $paginaHTML);

	if($user->getUsername()!=null) $paginaHTML = str_replace("<INSERIMENTOCOMMENTO/>", $inserisciCommento, $paginaHTML);
	else $paginaHTML = str_replace("<INSERIMENTOCOMMENTO/>", '', $paginaHTML);

	$paginaHTML = str_replace("<DETTAGLIOPOST/>", $manager->printSinglePost($_GET['idPost'],$user), $paginaHTML);
	$paginaHTML = str_replace("<LISTACOMMENTI/>", $manager->printComments($_GET['idPost'],$user,$currentPage), $paginaHTML);
	$paginaHTML = str_replace("<ID_POST/>", $_GET['idPost'], $paginaHTML);
}else{
	header("Location: errorPage.php");
    exit();	
}


$stringErrors = '';
if(isset($_SESSION['commentErrors'])){

    $stringErrors = "<ul id='phpErrors' class='listaSenzaPunti'>";
    foreach($_SESSION['commentErrors'] as $error){
        $stringErrors .= "<li>".$error."</li>";
    }
    $stringErrors .= "</ul> ";

    unset($_SESSION['commentErrors']);

    $paginaHTML = str_replace('<VALORECOMMENTO/>',stripslashes($_SESSION['commentValues']['contenuto']),$paginaHTML);
}else{
    $paginaHTML = str_replace('<VALORECOMMENTO/>','',$paginaHTML);
}

unset($_SESSION['commentValues']);

$paginaHTML = str_replace('<ERROREINSERIMENTOCOMMENTO/>',$stringErrors,$paginaHTML);

echo $paginaHTML;

?>