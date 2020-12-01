<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Two Notes</title>
    <meta name="title" content="Two Notes"/>
    <meta name="description" content="Sito realizzato per un progetto per il corso di Tecnologie Web per realizzare un social di musica"/>
    <meta name="keywords" content="registrazione, TwoNotes"/>
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
                <li><a href="../index.php">HOME</a></li>
                <li><a href="login.php">LOGIN</a></li>
            </ul>
        </div>
    </div>
    <div class="contenitoreCentrale allwidth smallReg">
        <div id="registrazione" class="round_div shadow-div">
            <h2>Registrati a TwoNotes</h2>
            <form action="#" class="formRegistrazione">
                <div class="regleft">
                    <label for="nome"><p class="textForm">Nome</p></label><br>
                    <input type="text" name="nome" id="nome" class="input" placeholder="Nome" required>
                    <label for="dataNascita"><p class="textForm">Data di nascita</p></label><br>
                    <input type="date" name="data" id="dataNascita" class="input" required>
                    <label for="sesso"><p class="textForm">Sesso</p></label><br>
                    <input type="radio" id="maschio" name="gender" value="maschio" class="radio" required>
                    <label for="maschio">Maschio</label>
                    <input type="radio" id="femmina" name="gender" value="femmina" class="radio">
                    <label for="femmina">Femmina</label>
                    <input type="radio" id="altro" name="gender" value="altro" class="radio">
                    <label for="altro">Altro</label><br>
                    <label for="username"><p class="textForm">Username</p></label><br>
                    <input type="text" name="username" id="username" class="input" placeholder="Username" required>
                </div>
                <div class="right">
                    <label for="cognome" ><p class="textForm">Cognome</p></label><br>
                    <input type="text" name="cognome" id="cognome" class="input" placeholder="Cognome" required><br>
                    <label for="email"><p class="textForm">Email</p></label><br>
                    <input type="email" name="email" id="email" class="input" placeholder="Email" required>
                    <label for="provenienza"><p class="textForm">Provenienza</p></label><br>
                    <input type="text" name="provenienza" id="provenienza" class="input" placeholder="Provenienza" required>
                    <label for="psw"><p class="textForm">Password</p></label><br>
                    <input type="password" name="psw" id="psw" class="input" placeholder="Password" required>
                </div>
                <p id="bottone"class="buttonRegistrati">
                    <input type="submit" value="Registrati" class="general-button round-button orange-button">
                </p>
                <br>
            </form>
        </div>
    </div>
    <div id="footer">
        <p>Sito creato per un progetto di tecnologie Web all'università di Padova - All right reserved.</p>
    </div>
    
</body>