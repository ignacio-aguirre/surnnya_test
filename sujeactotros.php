<?php
include("Funciones.php");
session_start();
$f_adop_decretada=fpost("f_adop_decretada");
$cud=npost("cud");
$decreto_5=npost("decreto_5");
$legajo=npost("legajo");
ejecute("update sujetos set f_adop_decretada=".$f_adop_decretada.", cud=".$cud.", decreto_5=".$decreto_5." where legajo=".$legajo);
Redirect("suje_otros?legajo=".$legajo);
?>