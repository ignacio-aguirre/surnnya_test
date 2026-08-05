<?php
include('func.php');
session_start();
$rubro=nget('rubro');
echo opciones_cond('articulos','rubro='.$rubro);
?>