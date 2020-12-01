<?php

require_once "DBConnection.php";

class Manager{
    private $dbconnection;

    public function __construct(){
		try {
			$this->dbconnection = new DBConnection();
		} catch (Exception $exc) {
			echo "Connection Error";
			exit();
		}
    }
    
    public function getPostList(){
        $select = "  SELECT * 
                    FROM post
                    ORDER BY DataOra DESC";

        $query = $this->dbconnection->query($select);

        return $query->fetch_all(MYSQLI_ASSOC);
    }

    public function printPostList($postList){
        foreach ($postList as $post) {
            $this->printPost($post);
        }
    }

    private function printPost($post){
		echo '
				<li>
					<a href="post.php?articleID='.$post['ID_post'].'">
						<h3 class="articleTitle">' . stripslashes($post['Titolo']) . '</h3>
                        <p class="description">' . stripslashes($post['Contenuto']) . '</p>
                        <p class="user">' . stripslashes($post['Utente']) . '</p>
					</a>
				</li>';
	}


}

?>

