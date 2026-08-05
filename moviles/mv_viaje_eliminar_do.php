<?php
include("funciones.php");
session_start();
$id=nget("id");
$v=un_registro("select * from movil_viajes where id=".$id);
if($_SESSION["perfil_moviles"]=="1" && $v["bandeja"]==$_SESSION["bandeja"]){
   
   ejecute("delete from  movil_viajes  where id=".$id);
   ejecute("delete from movil_pasajeros where viaje=".$id);

};

if($_SESSION["perfil_moviles"]=="2"){Redirect("mv_viajes_ver");};
Redirect("mv_vdispo_ver");
?>
