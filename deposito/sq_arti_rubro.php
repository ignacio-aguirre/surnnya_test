<?php
include('func.php');
session_start();
$id=nget('articulo');
echo un_campo('select rubro from articulos where idarticulos='. nulea($id));
?>