<?php

class DBConnection{

	private $host = "localhost";
	private $username = "root";
    private $password = "";
    private $database = "twonotes";
	private $connectionMYSQL;

	public function connectToDatabase() {
		$this->connectionMYSQL = mysqli_connect($this->host,$this->username,$this->password, $this->database );
		if (!$this->connectionMYSQL)
			return false;
		else
			return true;
	}

	public function disconnect() {
		if (!$this->connectionMYSQL)
			$this->connectionMYSQL->close();
	}

	public function getConnection() {
		return $this->connectionMYSQL;
	}

	public function getError() {
		return $this->connectionMYSQL->errno;
	}

	public function getErrorMessage() {
		return $this->connectionMYSQL->error;
	}

	public function affectedRows() {
		return $this->connectionMYSQL->affected_rows;
	}

	public function query($query) {
		return mysqli_query($this->connectionMYSQL,$query);
	}

}

?>
