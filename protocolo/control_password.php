<?php 
include("funciones.php");
session_start();
$pass=$_GET["actual"];
if ($pass<>"") {
  $almacenada = un_campo("select password from usuarios where idusuarios=".$_SESSION["usuario"]);
  if (password_verify($pass,$almacenada) ) {echo "1";} else {echo "0";};
};
?>
