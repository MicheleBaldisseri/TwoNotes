<?php

session_start();
session_destroy();
session_start();

$_SESSION['success'] = '<span xml:lang="en" lang="en">Logout<span> avvenuto con successo!';
header('Location: index.php');
exit();
?>