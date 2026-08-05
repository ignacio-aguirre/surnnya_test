<?php
include('func.php');
session_start();
$rubro=nget('rubro');
echo opciones_cond('articulos','rubro='.$rubro." and (select cantidad from existencias where existencias.articulo=idarticulos)>0");
?>