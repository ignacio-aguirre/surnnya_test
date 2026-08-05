<?php 
include("funciones.php");
session_start();
$trimestral=nget("id");
$tri=un_registro("select * from trimestrales where id=".$trimestral);
$nnya=$tri["legajo"];
$trimestre=$tri["trimestre"];
$anio=$tri["anio"];
$hogar=$tri["hogar"];
inserte("insert into trim_firmas(anio,trimestre,hogar,legajo,usuario,fecha,trimestral) values(".$anio.",".$trimestre.",".$hogar.",".$nnya.",0,curdate(),".$trimestral.")");
Redirect("informes");
?>