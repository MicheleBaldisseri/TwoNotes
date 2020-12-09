<?php

require_once "DBConnection.php";
require_once "User.php";

class Manager{
    private $dbconnection;

    public function __construct(){
        $this->dbconnection = new DBConnection();
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
    
    public function getPostList(){
        $this->connect();
        $this->dbconnection->query('SET NAMES utf8');
        $select = "  SELECT * 
                    FROM Post
                    ORDER BY dataOra DESC";

        $query = $this->dbconnection->query($select);
        $this->disconnect();
        return $query->fetch_all(MYSQLI_ASSOC);
    }

    public function printPostList($postList){
        $string = '';
        if(count($postList)!=0){
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
		$string =
                '<li>
                    <div class="postContent round_div shadow-div">
                        <h1>' . stripslashes($post['titolo']) . '</h1>
                        <p>' . stripslashes($post['contenuto']) . '</p>';
                        if($post['immagine']!=null){
                            $string .= '<img src="'.$base64.'" rc="'.stripslashes($post['altImmagine']).'"/>';
                        }
                        
        $string .=      '<p class="infoPost">Pubblicato da: 
                            <a href="php/profiloUtente.php?username='. stripslashes($post['utente']) .'" class="linkToButton">' . stripslashes($post['utente']) . '</a>, 
                            08/12/2020 23:39 <a class="linkToButton goTo" href="php/postPage.php?idPost='.$post['postID'].'">Vai al post</a>
                        </p>
                    </div>              
                </li>';
        return $string;
    }

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
            if($user->isPasswordRight($password)){
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
                    FROM Utenti
                    WHERE username = '".$values['username']."'";
        $query = $this->dbconnection->query($select);
        $this->disconnect();
        $query->fetch_all(MYSQLI_ASSOC);

        if ($query->num_rows > 0) {
            array_push($errors, "Username gia' utilizzato");
        }

        $this->connect();
        $select = "  SELECT * 
                    FROM Utenti
                    WHERE email = '".$values['email']."'";
        $query = $this->dbconnection->query($select);
        $this->disconnect();
        $query->fetch_all(MYSQLI_ASSOC);

        if ($query->num_rows > 0) {
            array_push($errors, "Email gia' utilizzata");
        }

        if(count($errors)==0){
            $this->connect();
            $select = "  INSERT INTO Utenti VALUES
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

    public function insertPost($values){
        $this->connect();
        $errors = array();
        $select = "  INSERT INTO Post (titolo, dataora, immagine, altImmagine, contenuto, utente) VALUES 
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
}

?>

