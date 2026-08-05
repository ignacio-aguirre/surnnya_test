<?php
session_start();
include("Funciones.php");
$dni=nget("dni");
echo json_encode(un_registro("select * from otrosnnya where dni=".$dni));
?>