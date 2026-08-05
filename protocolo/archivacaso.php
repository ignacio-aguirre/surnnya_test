<?php 
include("funciones.php");
session_start();
tranca();
$id=$_GET["id"];
ejecute("update casos set activo=0 where idcasos=".$id);
inserte("insert into casos_log(caso,fecha,estado) values(".$id.",curdate(),0)");
loguea("Desactivar Caso",$id,"0");
Redirect("casos");
?>