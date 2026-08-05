<?php 
include("funciones.php");
session_start();
tranca();
$id=$_GET["id"];
ejecute("update casos set activo=1 where idcasos=".$id);
inserte("insert into casos_log(caso,fecha,estado) values(".$id.",curdate(),1)");
loguea("Reactivar Caso",$id,"0");
Redirect("casos_desactivados");
?>