<?php
include("Funciones.php");
session_start();
$id=nget("id");
$menu=nget("menu");
$posicion=nget("posicion");
$url=tsql(un_campo("select url_principal from reportes where id=".$id));
$esta=un_campo("select idmenues_contenido from menues_contenido where menu=".$menu." and posicion=".$posicion." and idreporte=".$id." limit 1");
if($esta>"0") die("Ya estaba incluido en ese men&uacute;. Presione atr&aacute;s para continuar");
$ultimo=un_campo("select max(orden) from menues_contenido where menu=".$menu." and posicion=".$posicion)+1;
inserte("insert into menues_contenido(menu, posicion, orden, idreporte,url) values(".$menu.",".$posicion.",".$ultimo.",".$id.",".$url.")");
Redirect("un_reporte?id=".$id);
