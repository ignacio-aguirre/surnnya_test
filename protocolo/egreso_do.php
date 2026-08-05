<?php
include("funciones.php");
session_start();
tranca();
$id=$_POST["id"];
$f_egreso=str_replace( "-","",$_POST["f_egreso"]);
$b_paradero="0";
if($_POST["b_paradero"]=="on") $b_paradero="1";
ejecute("update alojamientos set f_egreso=".$f_egreso.", b_paradero=".$b_paradero."  where id=".$id);
$caso=un_campo("select caso from acciones where id=".$id);
loguea("Egreso de Dispositivo",$caso,$id);
Redirect("alojamientos");
?>