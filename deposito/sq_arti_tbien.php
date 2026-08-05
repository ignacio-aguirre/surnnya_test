<?php
include('func.php');
session_start();
$id=nget('articulo');
$_SESSION['articulo']=$id;
echo un_campo('select tipo_bien from articulos where idarticulos='. nulea($id));
?>