<?php 
include("funciones.php");
session_start();
tranca();
$id=$_POST["id"];
$apel=tsql($_POST["apellidos"]);
$nomb=tsql($_POST["nombres"]);
$email=tsql($_POST["email"]);
$repa=tsql($_POST["reparticion"]);
$sect=tsql($_POST["sector"]);
$grup=nulea($_POST["grupal"]);
$carg=nulea($_POST["carga"]);
$sist=nulea($_POST["sistema"]);
if($id==0) $id=inserte("insert into usuarios (apellidos,nombres,email) values(".$apel.",".$nomb.",".$email.")");
ejecute("update usuarios set apellidos=".$apel.", nombres=".$nomb.", email=".$email.", reparticion=".$repa.", sector=".$sect.", grupal=".$grup.", supervisa_sector=".$carg.", supervisa_sistema=".$sist." where idusuarios=".$id);
Redirect("usuarios");
?>