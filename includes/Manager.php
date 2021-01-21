<?php

require_once "DB.php";
require_once "User.php";

class Manager{
    private $dbconnection;

    // OPERAZIONI CON DB ---------------------------------------------------------------------------

    public function __construct(){
        $this->dbconnection = new DB();
    }

    public function getConnection(){
        return $this->dbconnection;
    }

    public function connect(){
        return $this->dbconnection->connectToDatabase();
    }

    public function disconnect(){
        return $this->dbconnection->disconnect();
    }

    //OPERAZIONI CON POST ---------------------------------------------------------------------------
    
    public function getPostList($page, $search = null){
        $this->connect();
        $this->dbconnection->query('SET NAMES utf8');
        $select = "  SELECT * 
                    FROM post";

        if($search != null) $select .= " WHERE titolo COLLATE UTF8_GENERAL_CI LIKE '%".$search."%' OR contenuto COLLATE UTF8_GENERAL_CI LIKE '%".$search."%'";
                    
        $select .= " ORDER BY dataOra DESC
                    LIMIT 6 OFFSET ".($page-1)*6;

        $query = $this->dbconnection->query($select);
        $this->disconnect();
        return $query ? $query->fetch_all(MYSQLI_ASSOC) : null;
    }

    public function printPostList($postList){
        $string = '';
        if($postList){
            foreach ($postList as $post) {
                $string .= $this->printPost($post);
            }
        }else{
            $string = '<li class="errori extraMargin">Nessun <span xml:lang="en" lang="en">post</span> trovato!</li>';
        }
        return $string;
        
    }

    private function printPost($post){

        $timestamp = strtotime($post['dataOra']);
	    $new_date = date("d/m/Y H:i:s", $timestamp);

		$string =
                '<li>
                    <div class="postContent round_div shadow-div textAlignCenter">
                        <h2>' . stripslashes($post['titolo']) . '</h2>
                        <p class="contenutoPost">' . stripslashes($post['contenuto']) . '</p>';
                        if($post['immagine']!=null){
                            $string .= '<img src="../upload/'.stripslashes($post['immagine']).'" alt="'.htmlspecialchars($post['altImmagine']).'"/>';
                        }
                        
        $string .=      '<p class="infoPost">Pubblicato da 
                            <a href="profilo.php?username='. stripslashes($post['utente']) .'">' . stripslashes($post['utente']) . '</a>  
                            il '.$new_date.'
                        </p>
                        <a class="goToPost" href="postPage.php?idPost='.$post['postID'].'" title="'.htmlspecialchars($post['titolo']).'">Vai al <span xml:lang="en" lang="en">post</span></a>
                        <a class="printHide" href="#header">Torna su</a> 
                    </div>              
                </li>';
        return $string;
    }

    public function getTotalPageCount($search = null){
        $this->connect();
        $this->dbconnection->query('SET NAMES utf8');
        $select = "  SELECT CEILING(COUNT(*)/6) as totalePagine
                    FROM post";

        if($search != null) $select .= " WHERE titolo COLLATE UTF8_GENERAL_CI LIKE '%".$search."%' OR contenuto COLLATE UTF8_GENERAL_CI LIKE '%".$search."%'";

        $query = $this->dbconnection->query($select);
        $this->disconnect();
        return $query ? $query->fetch_all(MYSQLI_ASSOC)[0]['totalePagine'] : null;
    }

    public function printNavigazione($currentPage,$pageTotalCount){
        if($pageTotalCount<=1) return '';
        $navigazione = '<div class="navigazione">';

        if($currentPage > 1) 
            $navigazione .= "<a href='index.php?page=1'> Torna alla prima pagina</a>";
        
        $navigazione .= '<ul class="listaSenzaPunti">';
        if($currentPage > 1) {
            $navigazione .= "<li><a href='index.php?page=".($currentPage-1)."' title=\"Vai alla pagina precedente\">← Precedente</a></li>";
        }else{
	        $navigazione .= "<li>← Precedente</li>";
        }

        $navigazione .= "<li> ".$currentPage."/".$pageTotalCount." </li>";

        if($currentPage < $pageTotalCount) {
            $navigazione .= "<li><a href='index.php?page=".($currentPage+1)."' title=\"Vai alla pagina successiva\">Successiva →</a></li>";
        }else{
	        $navigazione .= "<li>Successiva →</li>";
        }
        $navigazione .= '</ul></div>';
        return $navigazione;
    }

    public function printNavigazioneRicerca($currentPage,$pageTotalCount,$search){
        if($pageTotalCount<=1) return '';

        $navigazione = '<div class="navigazione">';

        if($currentPage > 1) 
            $navigazione .= "<a href='ricercaPost.php?page=1&amp;contenutoRicerca=".$search."'> Torna alla prima pagina</a>";

        $navigazione .= '<ul class="listaSenzaPunti">';
        if($currentPage > 1) {
            $navigazione .= "<li><a href='ricercaPost.php?page=".($currentPage-1)."&amp;contenutoRicerca=".$search."' title=\"Vai alla pagina precedente\">← Precedente</a></li>";
        }else{
	        $navigazione .= "<li>← Precedente</li>";
        }

        $navigazione .= "<li> ".$currentPage."/".$pageTotalCount." </li>";

        if($currentPage < $pageTotalCount) {
            $navigazione .= "<li><a href='ricercaPost.php?page=".($currentPage+1)."&amp;contenutoRicerca=".$search."' title=\"Vai alla pagina successiva\">Successiva →</a></li>";
        }else{
	        $navigazione .= "<li>Successiva →</li>";
        }
        $navigazione .= '</ul></div>';
        return $navigazione;
    }

    // OPERAZIONE INSERIMENTO POST ---------------------------------------------------------------------------

    public function insertPost($values){
        $this->connect();
        $this->dbconnection->query('SET NAMES utf8');
        $errors = array();
        $select = "  INSERT INTO post (titolo, dataora, immagine, altImmagine, contenuto, utente) VALUES 
            ('".$values['titolo']."',now(), '".$values['immagine']."', '".$values['altImmagine']."', '".$values['contenuto']."', '".$values['username']."')";
        $lastid = null;
        if(!$this->dbconnection->query($select)){
            array_push($errors, "Errore nell'inserimento");
            $_SESSION['postErrors'] = $errors;
        }else{
            $lastid = $this->dbconnection->getLastId();
        }
        $this->disconnect();
        return $lastid;
    }

    // OPERAZIONI CON POST IN DETTAGLIO ---------------------------------------------------------------------------

    public function getSinglePost($idPost){
        $this->connect();
        $this->dbconnection->query('SET NAMES utf8');
        $select = "  SELECT * 
                    FROM post
                    WHERE postID = '".$idPost."'";

        $query = $this->dbconnection->query($select);
        $this->disconnect();
        $res = $query->fetch_all(MYSQLI_ASSOC);
        return ($res ? $res[0] : null);
    }

    public function printSinglePost($idPost,$user){
        $post = $this->getSinglePost($idPost);

        $string = '';
        if($post){

            $timestamp = strtotime($post['dataOra']);
	        $new_date = date("d/m/Y H:i:s", $timestamp);

            $string = '<h2>'.stripslashes($post['titolo']).'</h2>
            <p class="contenutoPost">'.stripslashes($post['contenuto']).'</p>';
            if($post['immagine']!=null){
                $string .= '<img src="../upload/'.stripslashes($post['immagine']).'" alt="'.htmlspecialchars($post['altImmagine']).'"/>';
            }    
            $string .= '<p class="infoPost">
                Pubblicato da 
                <a href="profilo.php?username='.stripslashes($post['utente']).'">'.stripslashes($post['utente']).'</a> 
                il '.$new_date.'
            </p>';

            if($user->isAdmin()) $string .= '<a class="adminLink" href="deletePost.php?id='.$post['postID'].'">Elimina il <span xml:lang="en" lang="en">post</span></a>';
            
        }else{
            $string = 'Non è stato trovato il <span xml:lang="en" lang="en">post</span>, ci scusiamo.';
        }
        return $string;
    }

    public function deletePost($id){
        $this->connect();
        $this->dbconnection->query('SET NAMES utf8');
        $delete = "  DELETE FROM post WHERE postID = '$id' ";

        $query = $this->dbconnection->query($delete);
        $this->disconnect();
        return $query;
    }

    public function recoverPostImage($id){
        $this->connect();
        $this->dbconnection->query('SET NAMES utf8');
        $select = "  SELECT immagine
                    FROM post
                    WHERE postID = '".$id."'";
        $query = $this->dbconnection->query($select);
        $this->disconnect();
        $res = $query->fetch_all(MYSQLI_ASSOC);
        return ($res ? $res[0] : null);
    }

    //OPERAZIONI CON COMMENTI ---------------------------------------------------------------------------

    private function getComments($idPost,$page){
        $this->connect();
        $this->dbconnection->query('SET NAMES utf8');
        $select = "  SELECT * 
                    FROM commenti
                    WHERE post = '".$idPost."' 
                    ORDER BY dataOra DESC
                    LIMIT 6 OFFSET ".($page-1)*6;

        $query = $this->dbconnection->query($select);
        $this->disconnect();
        $res = $query->fetch_all(MYSQLI_ASSOC);
        return ($res ? $res : null);
    }

    public function printComments($idPost,$user,$page){
        $comments = $this->getComments($idPost,$page);
        $string = '';
        if($comments){
            foreach ($comments as $comment) {
                $string .= $this->printSingleComment($comment,$user);
            }
        }else{
            $string = '<li class="errori">Non ci sono commenti!</li>';
        }
        return $string;
    }

    private function printSingleComment($comment,$user){
        $timestamp = strtotime($comment['dataOra']);
	    $new_date = date("d/m/Y H:i:s", $timestamp);

        $string = '<li>
            <div class="singleComment shadow-div round_div">
                <p class="infoPost"><a href="profilo.php?username='.stripslashes($comment['utente']).'">'.stripslashes($comment['utente'])
                .'</a> '.$new_date.'</p>
                <p>'.stripslashes($comment['contenuto']).'</p>';
                
                if($user->isAdmin()) $string .= '<a class="adminLink" href="deleteComment.php?id='.$comment['commentoID'].'&amp;idPost='.$comment['post'].'">Elimina il commento</a>';
                                 
           $string .= '<a class="printHide tornaSu" href="#header">Torna su</a>
            </div>
        </li>';

        return $string;
    }

    public function insertComment($values){
        $res = true;
        $this->connect();
        $this->dbconnection->query('SET NAMES utf8');
        $errors = array();
        $select = "  INSERT INTO commenti (post,utente,dataOra,contenuto) VALUES 
            ('".$values['idPost']."','".$values['username']."', now(), '".$values['contenuto']."')";

        if(!$this->dbconnection->query($select)){
            array_push($errors, "Errore nell'inserimento");
            $_SESSION['commentErrors'] = $errors;
            $res = false;
        }
        $this->disconnect();
        return $res;
    }

    public function deleteComment($id){
        $this->connect();
        $this->dbconnection->query('SET NAMES utf8');
        $delete = "  DELETE FROM commenti WHERE commentoID = '$id' ";

        $query = $this->dbconnection->query($delete);
        $this->disconnect();
        return $query;
    }

    public function getTotalPageCommentCount($post){
        $this->connect();
        $this->dbconnection->query('SET NAMES utf8');
        $select = "  SELECT CEILING(COUNT(*)/6) as totalePagine
                    FROM commenti
                    WHERE post='$post'";

        $query = $this->dbconnection->query($select);
        $this->disconnect();
        return $query ? $query->fetch_all(MYSQLI_ASSOC)[0]['totalePagine'] : null;
    }

    public function printNavigazioneCommenti($currentPage,$pageTotalCount,$post){
        if($pageTotalCount<=1) return '';

        $navigazione = '<div class="navigazione">';

        if($currentPage > 1) 
            $navigazione .= "<a href='postPage.php?page=1&amp;idPost=".$post."'> Torna alla prima pagina</a>";


        $navigazione .= '<ul class="listaSenzaPunti">';
        if($currentPage > 1) {
            $navigazione .= "<li><a href='postPage.php?page=".($currentPage-1)."&amp;idPost=".$post."' title=\"Vai alla pagina precedente\">← Precedente</a></li>";
        }else{
	        $navigazione .= "<li>← Precedente</li>";
        }

        $navigazione .= "<li> ".$currentPage."/".$pageTotalCount." </li>";

        if($currentPage < $pageTotalCount) {
            $navigazione .= "<li><a href='postPage.php?page=".($currentPage+1)."&amp;idPost=".$post."' title=\"Vai alla pagina successiva\">Successiva →</a></li>";
        }else{
	        $navigazione .= "<li>Successiva →</li>";
        }
        $navigazione .= '</ul></div>';
        return $navigazione;

    }


    // OPERAZIONI CON USERS ---------------------------------------------------------------------------

    public function setupSession(){
        $user = new User($this->dbconnection);
        if(isset($_SESSION['username'])){
            $user->recover($_SESSION['username']);
        }
        return $user;
    }

    public function login($username,$password){
        $user = new User($this->dbconnection);
        $errors = array();

        if($user->recover($username)){
            if($user->isPasswordCorrect($password)){
                $user->setSessionVar();
            }else{
                unset($_SESSION['username']);
                array_push($errors, '<a href="#psw"><span xml:lang="en" lang="en">Password</span> errata</a>');
                $_SESSION['loginError'] = $errors;
            }
        }else{
            unset($_SESSION['username']);
            array_push($errors, '<a href="#username"><span xml:lang="en" lang="en">Username</span> non esistente</a>');
            $_SESSION['loginError'] = $errors;
        }
    }

    public function register($values){
        $errors = array();
        $this->connect();
        $this->dbconnection->query('SET NAMES utf8');
        $select = "  SELECT * 
                    FROM utenti 
                    WHERE username = '".$values['username']."'";
        $query = $this->dbconnection->query($select);
        $this->disconnect();
        $query->fetch_all(MYSQLI_ASSOC);

        if ($query->num_rows > 0) {
            array_push($errors, '<a href="#username"><span xml:lang="en" lang="en">Username</span> già utilizzato</a>');
        }

        $this->connect();
        $select = "  SELECT * 
                    FROM utenti
                    WHERE email = '".$values['email']."'";
        $query = $this->dbconnection->query($select);
        $this->disconnect();
        $query->fetch_all(MYSQLI_ASSOC);

        if ($query->num_rows > 0) {
            array_push($errors, '<a href="#email"><span xml:lang="en" lang="en">Email</span> già utilizzata</a>');
        }

        if(count($errors)==0){
            $this->connect();
            $this->dbconnection->query('SET NAMES utf8');
            $select = "  INSERT INTO utenti VALUES
                ('".$values['username']."','".md5($values['password'])."',
                '".$values['nome']."','".$values['cognome']."',
                '".$values['dataNascita']."','".$values['email']."',
                '".$values['sesso']."',0)";

            if(!$this->dbconnection->query($select)){
                array_push($errors, "Errore nella registrazione");
            }
            $this->disconnect();

            if(count($errors)==0)return true;
        }

        $_SESSION['registerErrors'] = $errors;
        return false;

    }

    public function getUser($username){
        $user = new User($this->dbconnection);
        if($user->recover($username))return $user;
        return null;
    }

    public function deleteUser($user){
        $this->connect();
        $this->dbconnection->query('SET NAMES utf8');
        $delete = "  DELETE FROM utenti WHERE username = '$user' ";

        $query = $this->dbconnection->query($delete);
        $this->disconnect();
        return $query;
    }

    // OPERAZIONE MODIFICA PROFILO ---------------------------------------------------------------------------

    public function modificaProfilo($values,$oldUsername){
        $errors = array();
        $this->connect();
        $this->dbconnection->query('SET NAMES utf8');
        $select = "  SELECT * 
                    FROM utenti
                    WHERE username = '".$values['username']."' AND username != '".$oldUsername."';";
        $query = $this->dbconnection->query($select);
        $this->disconnect();
        $query->fetch_all(MYSQLI_ASSOC);

        if ($query->num_rows > 0) {
            array_push($errors, '<a href="#username"><span xml:lang="en" lang="en">Username</span> già utilizzato</a>');
        }

        $this->connect();
        $select = "  SELECT * 
                    FROM utenti
                    WHERE email = '".$values['email']."' AND username != '".$oldUsername."';";
        $query = $this->dbconnection->query($select);
        $this->disconnect();
        $query->fetch_all(MYSQLI_ASSOC);

        if ($query->num_rows > 0) {
            array_push($errors, '<a href="#email"><span xml:lang="en" lang="en">Email</span> già utilizzata</a>');
        }

        if(count($errors)==0){
            
            $this->connect();
            $this->dbconnection->query('SET NAMES utf8');
            $update = " UPDATE utenti
                    SET username = '".$values['username']."', nome = '".$values['nome']."', cognome = '".$values['cognome']."', email = '".$values['email']."',
                    sesso = '".$values['sesso']."', dataNascita = '".$values['dataNascita']."'";
                    if(!empty($values['newPassword'])) $update .= ", password = '".md5($values['newPassword'])."' ";
                    $update .= "WHERE username = '".$oldUsername."';";
            if(!$this->dbconnection->query($update)){
                array_push($errors, "Errore nella modifica");
                echo $update;
            }
            $this->disconnect();

            if(count($errors)==0)return true;
        }

        $_SESSION['modificaErrors'] = $errors;
        return false;
        
    }

    //ALTRO ------------------------------------------------------------------------------------------

    public function transformString($string){
        if(substr_count($string,'[en]')!=substr_count($string,'[/en]')) return false;
        if(substr_count($string,'[/abbr]')!=preg_match_all('/\[abbr=([^\]]+)]/',$string)) return false;

        $string = str_replace('[en]','<span xml:lang="en" lang="en">',$string);
        $string = str_replace('[/en]','</span>',$string);
        $string = str_replace('[/abbr]','</abbr>',$string);
        $string = preg_replace('/\[abbr=([^\]]+)]/','<abbr title="\1">',$string);

        return $string;
    }
}

?>

