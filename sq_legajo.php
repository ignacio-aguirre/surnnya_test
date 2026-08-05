<?php
session_start();
include("Funciones.php");
$legajo=$_GET["legajo"];
if($legajo>="100000") {echo un_campo("select Legajo from sujetos where Legajo=".$legajo);exit;};
echo "";
exit;
?>