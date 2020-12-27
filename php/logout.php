<?php

session_start();
session_destroy();

$_SESSION['success'] = "Logout avvenuto con successo!";
header('Location: index.php');
exit();
?>