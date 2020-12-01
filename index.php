<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Two Notes</title>
    <meta name="title" content="Two Notes"/>
    <meta name="description" content="Sito realizzato per un progetto per il corso di Tecnologie Web per realizzare un social di musica"/>
    <meta name="keywords" content="login TwoNotes"/>
    <meta name="author" content="Giulio Zanatta"/>
    <meta name="language" content="italian it"/>
    <link rel="stylesheet" type="text/css" href="styles/stile.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="styles/stile_small.css" media="handheld, screen and (max-width:640px), only screen and (max-device-width:640px)"/>
</head>
<body>
    <div id="header">
        <img src="img/TwoNotes-4.svg"  alt="Logo Two Notes caratterizzato dalla scritta Two Notes Unita da due note musicali sulla lettera o"/>
        <div class="right">
            <ul>
                <li><a href="php/aboutUs.php">Chi siamo</a></li>
                <li><a href="php/login.php">Login</a></li>
                <li><a href="php/registrazione.php">Registrati</a></li>
            </ul>
        </div>
    </div>

   <div id="search" class="contenitoreCentrale round_div shadow-div">
        <div class="left search-form">
            <form>
                <input id="search-text" type="text" placeholder="Search..">
                <button type="submit" id="search-button" class="round-button general-button">Cerca</button>
            </form>
        </div>
        <div class="new-post left">
            <button id="post-btn" type="submit" class="round-button post-button general-button">Crea Post</button>
        </div>
       
    </div>

    <div class="contenitoreCentrale post-container round_div shadow-div">
        <span id="backtotop" class="right">
            <a href="index.html">
                Torna su
            </a>
        </span>
    </div>

    <div id="footer">
        <p>Sito creato per un progetto di tecnologie Web all'università di Padova - All right reserved.</p>
    </div>
</body>
</html>