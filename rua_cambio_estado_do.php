<?php
/* a eliminar */
include("Funciones.php"); 
session_start();
$id=nget("id");
$estado=nget("estado");
$comentarios=tget("comentarios");
$usuario=tsql($_SESSION["glusua"]);
inserte("insert into rua_estados(registro,estado,comentarios,usuario,fecha) values(".$id.",".$estado.",".$comentarios.",".$usuario.", curdate())");
ejecute("update rua_nomina set estado=".$estado." where id=".$id);
if($estado=="5"){
	ejecute("update rua_nomina set f_baja=curdate() where id=".$id);
};
Redirect("rua_ver?id=".$id);
?>