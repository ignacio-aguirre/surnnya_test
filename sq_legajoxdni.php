<?php
session_start();
include("Funciones.php");
$dni=$_GET["dni"];
if($dni>="1000000") {echo un_campo("select legajo from sujetos where sujetosDNI=".$dni);exit;};
echo "";
exit;
?>