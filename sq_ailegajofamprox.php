<?php
session_start();
include("Funciones.php");
$ult=un_campo("select max(legajofamilia) from ai_familias");
if($ult=="") {$ult="0";};
echo intval($ult)+1;
exit;
?>