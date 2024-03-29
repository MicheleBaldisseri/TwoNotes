<?php

class User {

    private $dbconnection;

	private $username = null;
    private $nome = null;
    private $cognome = null;
    private $dataNascita = null;
    private $email = null;
    private $sesso = null;
    private $provenienza = null;
    private $admin = false;
    private $password = null;

	public function __construct($dbc) {
        $this->dbconnection = $dbc;
    }
    
    public function recover($_username){
        
      $this->dbconnection->connectToDatabase();
      $query = $this->dbconnection->query("SELECT * FROM utenti WHERE username = '$_username'");
      $this->dbconnection->disconnect();

      if ($query->num_rows > 0) {
        $res = $query->fetch_assoc();
        $this->username = $res['username'];
        $this->nome = $res['nome'];
        $this->cognome = $res['cognome'];
        $this->dataNascita = $res['dataNascita'];
        $this->email = $res['email'];
        $this->sesso = $res['sesso'];
        $this->admin = $res['isAdmin'];
        $this->password = $res['password'];

        return true;
      }else{
        return false;
      }
    }

	  public function isRegistered() {
		  return ($this->username!=null);
    }

    public function getUsername() {
		return $this->username;
    }
    
    public function getNome() {
		return $this->nome;
    }

    public function getCognome() {
		return $this->cognome;
    }

    public function getDataNascita() {
		return $this->dataNascita;
    }

    public function getEmail() {
		return $this->email;
    }

    public function getSesso() {
		return $this->sesso;
    }
    
    public function isAdmin(){
        return $this->admin;
    }

    public function isPasswordCorrect($password){
      return md5($password) == $this->password;
    }

	  public function setSessionVar() {
        $_SESSION['username'] = $this->getUsername();
    }

}