<?php
include('func.php');
session_start();
$articulo=nget('articulo');
$cantidad=nget('cantidad');
inserte('insert into temporal_pedidos(usuario,articulo,cantidad) values('.$_SESSION["usuario"].",".$articulo.",".$cantidad.")");
?>