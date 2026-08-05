<?php
session_start();
include("funciones.php");
$codigo=tpost("codigo");
$id=npost("id");

$codigo_control=tsql(un_campo("select c_autenticacion from usuarios where id=".$id));

if($codigo==$codigo_control){
	ejecute("update usuarios set f_autenticado=curdate(),c_autenticacion=null where id=".$id);
	$_SESSION['usuario']=$id;
	Redirect($_SESSION["menu"]);
}else{
	
	Redirect("salir");
}
?>