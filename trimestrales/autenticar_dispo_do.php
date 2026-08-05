<?php
session_start();
include("funciones.php");
$codigo=tpost("codigo");
$id=npost("id");
$usuario=un_registro("select * from usuarios_hogares where id=".$id);
$codigo_control=tsql(un_campo("select c_autenticacion from usuarios_hogares where id=".$id));

if($codigo==$codigo_control){
	ejecute("update usuarios_hogares set f_autenticado=curdate(),c_autenticacion=null where id=".$id);
	$_SESSION['usuario']=$id;
	$par=un_registro("select * from parametros limit 1");
  $_SESSION["trimestre"]=$par["trimestre"];
  $_SESSION["anio"]=$par["trimestre_anio"];
  
	if($usuario["es_multihogar"]=="1"){Redirect("seleccionar_hogar");}
      else{Redirect("nomina");};
	
}else{
	
	Redirect("salir");
}
?>