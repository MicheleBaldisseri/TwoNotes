<?php

session_start();
session_destroy();
session_start();

$_SESSION['success'] = "Logout avvenuto con successo!";
header('Location: index.php');
exit();
?>