<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Two Notes</title>
    <meta name="title" content="Two Notes"/>
    <meta name="description" content="Sito realizzato per un progetto per il corso di Tecnologie Web per realizzare un social di musica"/>
    <meta name="keywords" content="login, TwoNotes"/>
    <meta name="author" content="Stefano Dal Poz"/>
    <meta name="language" content="italian it"/>
    <link rel="stylesheet" type="text/css" href="../styles/stile.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="../styles/stile_small.css" media="handheld, screen and (max-width:640px), only screen and (max-device-width:640px)"/>
</head>
<body>
    <div id="header">
        <img src="../img/TwoNotes-4.svg"  alt="Logo Two Notes caratterizzato dalla scritta Two Notes Unita da due note musicali sulla lettera o"/>
        <div class="right">
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="aboutUs.php">Chi siamo</a></li>
                <li><a href="#">Contatti</a></li>
            </ul>
        </div>
    </div>
    <div class="contenitoreCentrale">
        <div class="height_login round_div shadow-div">
            <div class="left orange_left left-border-radius">
                <div id="dentroLeft">
                    <h1>Benvenuto nel social musicale</h1><br>
                    <img src="../img/TwoNotes-4.svg" alt="Logo Two Notes caratterizzato dalla scritta Two Notes Unita da due note musicali sulla lettera o"/>
                </div>
            </div>
            <div  class="right right-border-radius white_right">
                <div id="dentroRight">
                    <p class="textAccedi">ACCEDI</p>
                    <form action="#" class="formAccedi">
                        <label for="username"><p class="textForm">Username</p></label><br>
                        <input type="text" name="username" id="username" class="input" placeholder="Username"required>
                        <label for="psw" ><p class="textForm">Password</p></label><br>
                        <input type="password" name="psw" id="psw" class="input" placeholder="Password" required><br>
                        <p class="spazio"></p>
                        <input type="submit" value="Accedi" class="general-button round-button orange-button"><br>
                    </form>
                    <p class="textOppure">Oppure</p>
                    <div class="buttonRegistrati">
                        <a href="registrazione.php"><p class="general-button round-button yellow-button">Registrati</p></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer">
        <p>Sito creato per un progetto di tecnologie Web all'università di Padova - All right reserved.</p>
    </div>
</body>
</html>