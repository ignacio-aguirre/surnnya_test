<?php 
include("Funciones.php"); 
session_start();
if (!isset($_SESSION['gldispo'])|!isset($_POST['legajo'])) header ("Location: .");
$legajo=$_POST["legajo"];
$provincia_domicilio=tpost("provincia_dommicilio");
$partido_domicilio=tpost("partido_domicilio");
$localidad_domicilio=tpost("localidad_domicilio");
$callenro_domicilio=tpost("calle_altura");
$condicion_domicilio=tpost("condicion_domicilio");
$otros_domicilio=tpost("otros_domicilio");
$telefonos=tpost("telefonos");
$email=tpost("email");
ejecute("update sujetos set provincia_domicilio=".$provincia_domicilio.
", partido_domicilio=".$partido_domicilio.",localidad_domicilio=".$localidad_domicilio.", callenro_domicilio=".$callenro_domicilio.
",otros_domicilio=".$otros_domicilio.",condicion_domicilio=".$condicion_domicilio.",telefonos=".$telefonos.",email=".$email." where legajo=".$legajo);
Redirect("suje_cons_pae?legajo=".$legajo); 
?>



