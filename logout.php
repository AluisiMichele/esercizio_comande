<?php
session_start(); 
session_unset(); //rimozione variabili delle sessioni
session_destroy(); //distruzione dati della sessione corrente
header("Location: login.php"); 
exit();
?>
