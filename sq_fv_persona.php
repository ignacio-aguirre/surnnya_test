<?php
session_start();
include("Funciones.php");
$tdoc=nget("tdoc");
$ndoc=nget("ndoc");
$r=un_registro("select * from fv_personas where tipo_documento=".$tdoc." and numero_documento=".$ndoc);
echo json_encode($r);
exit;
?>