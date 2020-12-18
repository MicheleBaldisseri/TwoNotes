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
            $string = '<p>Nessun Risultato</p>';
        }
        return $string;
        
    }

    private function printPost($post){
        if($post['immagine']!=null){
            $base64 = 'data:image/jpeg;base64,' . base64_encode($post['immagine']);
        } 

        $timestamp = strtotime($post['dataOra']);
	    $new_date = date("d/m/Y H:i:s", $timestamp);

		$string =
                '<li>
                    <div class="postContent round_div shadow-div textAlignCenter">
                        <h1>' . stripslashes($post['titolo']) . '</h1>
                        <p>' . stripslashes($post['contenuto']) . '</p>';
                        if($post['immagine']!=null){
                            $string .= '<img src="'.$base64.'" alt="'.stripslashes($post['altImmagine']).'"/>';
                        }
                        
        $string .=      '<p class="infoPost">Pubblicato da: 
                            <a href="profilo.php?username='. stripslashes($post['utente']) .'" class="linkToButton">' . stripslashes($post['utente']) . '</a>  
                            '.$new_date.'
                        </p>
                        <a id="goToPost" class="linkToButton" href="postPage.php?idPost='.$post['postID'].'">Vai al post</a>
                        <a class="linkToButton" href="#percorso">Torna su</a> 
                    </div>              
                </li>';
        return $string;
    }

    // OPERAZIONE INSERIMENTO POST ---------------------------------------------------------------------------

    public function insertPost($values){
        $this->connect();
        $errors = array();
        $select = "  INSERT INTO post (titolo, dataora, immagine, altImmagine, contenuto, utente) VALUES 
            ('".$values['titolo']."',now(), '".$values['immagine']."', '".$values['altImmagine']."', '".$values['contenuto']."', '".$values['username']."')";
        $lastid = null;
        if(!$this->dbconnection->query($select)){
            array_push($errors, "Errore nell'inserimento");
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
        return ($res[0] ? $res[0] : null);
    }

    public function printSinglePost($idPost){
        $post = $this->getSinglePost($idPost);

        $string = '';
        if($post){
            if($post['immagine']!=null){
                $base64 = 'data:image/jpeg;base64,' . base64_encode($post['immagine']);
            }

            $timestamp = strtotime($post['dataOra']);
	        $new_date = date("d/m/Y H:i:s", $timestamp);

            $string = '<h1>'.stripslashes($post['titolo']).'</h1>
            <p>'.stripslashes($post['contenuto']).'</p>';
            if($post['immagine']!=null){
                $string .= '<img src="'.$base64.'" alt="'.stripslashes($post['altImmagine']).'"/>';
            }    
            $string .= '<p class="infoPost">
                Pubblicato da: 
                <a href="profilo.php?username='.stripslashes($post['utente']).'" class="linkToButton">'.stripslashes($post['utente']).'</a> 
                '.$new_date.'
            </p>';
        }else{
            $string = "Non è stato trovato il post, ci scusiamo.";
        }
        return $string;
    }

    //OPERAZIONI CON COMMENTI ---------------------------------------------------------------------------

    private function getComments($idPost){
        $this->connect();
        $this->dbconnection->query('SET NAMES utf8');
        $select = "  SELECT * 
                    FROM commenti
                    WHERE post = '".$idPost."' 
                    ORDER BY dataOra DESC";

        $query = $this->dbconnection->query($select);
        $this->disconnect();
        return $query->fetch_all(MYSQLI_ASSOC);
    }

    public function printComments($idPost){
        $comments = $this->getComments($idPost);
        $string = '';
        if($comments){
            foreach ($comments as $comment) {
                $string .= $this->printSingleComment($comment);
            }
        }else{
            $string = "Non ci sono commenti!";
        }
        return $string;
    }

    private function printSingleComment($comment){
        $timestamp = strtotime($comment['dataOra']);
	    $new_date = date("d/m/Y H:i:s", $timestamp);

        return '<li>
            <div class="singleComment shadow-div round_div">
                <p class="infoPost"><a href="profilo.php?username='.stripslashes($comment['utente']).'" class="linkToButton">'.stripslashes($comment['utente'])
                .'</a> '.$new_date.'</p>
                <p>'.stripslashes($comment['contenuto']).'</p>                             
            </div>
        </li>';
    }

    public function insertComment($values){
        $res = true;
        $this->connect();
        $errors = array();
        $select = "  INSERT INTO Commenti (post,utente,dataOra,contenuto) VALUES 
            ('".$values['idPost']."','".$values['username']."', now(), '".$values['contenuto']."')";

        if(!$this->dbconnection->query($select)){
            array_push($errors, "Errore nell'inserimento");
            $res = false;
        }
        $this->disconnect();
        return $res;
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
        if($user->recover($username)){
            if($user->isPasswordCorrect($password)){
                $user->setSessionVar();
            }else{
                unset($_SESSION['username']);
                $_SESSION['loginError'] = "Password errata";
            }
        }else{
            unset($_SESSION['username']);
            $_SESSION['loginError'] = "Username non esiste";
        }
    }

    public function register($values){
        $errors = array();
        $this->connect();
        $select = "  SELECT * 
                    FROM utenti 
                    WHERE username = '".$values['username']."'";
        $query = $this->dbconnection->query($select);
        $this->disconnect();
        $query->fetch_all(MYSQLI_ASSOC);

        if ($query->num_rows > 0) {
            array_push($errors, "Username gia' utilizzato");
        }

        $this->connect();
        $select = "  SELECT * 
                    FROM utenti
                    WHERE email = '".$values['email']."'";
        $query = $this->dbconnection->query($select);
        $this->disconnect();
        $query->fetch_all(MYSQLI_ASSOC);

        if ($query->num_rows > 0) {
            array_push($errors, "Email gia' utilizzata");
        }

        if(count($errors)==0){
            $this->connect();
            $select = "  INSERT INTO utenti VALUES
                ('".$values['username']."','".md5($values['password'])."',
                '".$values['nome']."','".$values['cognome']."',
                '".$values['dataNascita']."','".$values['email']."',
                '".$values['sesso']."','".$values['provenienza']."',0)";

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

    // OPERAZIONE MODIFICA PROFILO ---------------------------------------------------------------------------

    public function modificaProfilo($values,$oldUsername){
        $errors = array();
        $this->connect();
        $select = "  SELECT * 
                    FROM utenti
                    WHERE username = '".$values['username']."' AND username != '".$oldUsername."';";
        $query = $this->dbconnection->query($select);
        $this->disconnect();
        $query->fetch_all(MYSQLI_ASSOC);

        if ($query->num_rows > 0) {
            array_push($errors, "Username gia' utilizzato");
        }

        $this->connect();
        $select = "  SELECT * 
                    FROM utenti
                    WHERE email = '".$values['email']."' AND username != '".$oldUsername."';";
        $query = $this->dbconnection->query($select);
        $this->disconnect();
        $query->fetch_all(MYSQLI_ASSOC);

        if ($query->num_rows > 0) {
            array_push($errors, "Email gia' utilizzata");
        }

        if(count($errors)==0){
            
            $this->connect();
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
}

?>

