<?php
include("funciones.php");
session_start();
$hogar=$_SESSION["hogar"];
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$nnya=$_SESSION["nnnya_actual"];
$trimestral=un_campo("select id from trimestrales where anio=".$anio." and trimestre=".$trimestre." and hogar=".$hogar." and legajo=".$nnya);
$id=un_campo("select id from trim_convivencial where hogar=".$hogar." and trimestre=".$trimestre." and anio=".$anio." and legajo=".$nnya);
if(!$id>0) $id=inserte("insert into trim_convivencial(hogar,trimestre,anio,legajo,trimestral) values(".$hogar.",".$trimestre.",".$anio.",".$nnya.",".$trimestral.")");
$descripcion=tpost("descripcion");
ejecute("update trim_convivencial set
descripcion=".$descripcion.", 
usuario=".$_SESSION["usuario"].", fecha=curdate(), trimestral=".$trimestral." where id=".$id);
Redirect("transicion?proximo=salud_fisica&id=".$trimestral);
?>