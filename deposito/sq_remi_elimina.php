<?php
include('func.php');
session_start();
$articulo=nget('articulo');
ejecute("delete from temporal_pedidos where usuario=".$_SESSION["usuario"]." and articulo=".$articulo);
?>