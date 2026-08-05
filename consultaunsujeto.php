<?php

include("Funciones.php");

session_start();

$lega= $_GET["vlegajo"]; 

Redirect("suje_cons_duros?legajo=".$lega);

?>

