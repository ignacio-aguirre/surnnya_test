<?php 
include("Funciones.php"); 
session_start();
if (!isset($_SESSION['gldispo'])|!isset($_POST['legajo'])) header ("Location: .");
$legajo=$_POST["legajo"];
$tipovivienda=npost("tipovivienda");
$especificar=tpost("especificar");
$re=un_registro("select id,tipovivienda from sujetos_vivienda where legajo=".$legajo." order by fecha desc limit 1");
$id=$re["id"];
if($id=="" || intval($re["tipovivienda"])!=intval($tipovivienda)) {$id=inserte("insert into sujetos_vivienda(legajo,tipovivienda,especificar,fecha) values(".$legajo.",".$tipovivienda.",".$especificar.",curdate())");}
else{ejecute("update sujetos_vivienda set especificar=".$especificar." where id=".$id);}; 
Redirect("suje_cons_viviendalegajo=".$legajo); 
?>



