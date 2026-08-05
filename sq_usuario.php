<?php
session_start();
include("Funciones.php");
$cuil=tget("cuil");
$r=un_registro("select * from usuarios where cuil=".$cuil);
$resp="";
if(!is_null($r)){
if($r["cuil"]!=""){$resp="Usuario Existente ".$r["apellido"].", ".$r["nombre"]." *".$r["estado"]."*";};
};
echo $resp;
exit;
?>