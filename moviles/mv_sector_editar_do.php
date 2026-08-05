<?php
session_start();
include("funciones.php");
$id=nget("id");
$transporte=nget("transporte");
ejecute("update sectores set transporte=".$transporte." where id=".$id);
Redirect("mv_sectores");
?>