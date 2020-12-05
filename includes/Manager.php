<?php

require_once "DBConnection.php";
require_once "User.php";

class Manager{
    private $dbconnection;

    public function __construct(){
		$this->dbconnection = new DBConnection();
    }

    public function connect(){
        return $this->dbconnection->connectToDatabase();
    }

    public function disconnect(){
        return $this->dbconnection->disconnect();
    }
    
    public function getPostList(){
        $select = "  SELECT * 
                    FROM Post
                    ORDER BY dataOra DESC";

        $query = $this->dbconnection->query($select);

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
		$string ='
				<li>
					<a href="post.php?articleID='.$post['postID'].'">
						<h3 class="articleTitle">' . stripslashes($post['titolo']) . '</h3>
                        <p class="description">' . stripslashes($post['contenuto']) . '</p>
                        <p class="user">' . stripslashes($post['utente']) . '</p>
					</a>
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
        session_start();
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
}

?>
