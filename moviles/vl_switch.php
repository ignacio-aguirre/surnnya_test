<?php
include("../funciones.php"); 
session_start();
$id=nget("id");
$cump=un_campo("select cumplido from movil_viajes  where id".$tipo);
if($cump=="0"){$resp="1";$tres="Ok";};
if($cump=="1"){$resp="2";$tres="No cumplido";};
if($cump=="2"){$resp="1";$tres="Ok";};
ejecute("update movil_viajes set cumplido=".$resp." where id=".$id);
echo $tres;
exit();
?>