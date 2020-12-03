<?php

require_once "DBConnection.php";

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
                    FROM post
                    ORDER BY DataOra DESC";

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
					<a href="post.php?articleID='.$post['ID_post'].'">
						<h3 class="articleTitle">' . stripslashes($post['Titolo']) . '</h3>
                        <p class="description">' . stripslashes($post['Contenuto']) . '</p>
                        <p class="user">' . stripslashes($post['Utente']) . '</p>
					</a>
                </li>';
        return $string;
	}


}

?>

