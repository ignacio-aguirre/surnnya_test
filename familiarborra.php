<?php
include("Funciones.php");
session_start();
registre();
if (!isset($_GET['id'])) Redirect(".");
$id=$_GET["id"];
$lega=$_GET["legajo"];
ejecute("update sujetos_familia set baja=curdate() where fami_legajo=".$lega." and idsujetos_familia=".$id);
Redirect("sujeactfamilia?legajo=".$lega);
?>
