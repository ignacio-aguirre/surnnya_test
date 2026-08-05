<?php
include("../funciones.php"); 
session_start();
$x=tget("x");
$y=tget("y");
$id=nget("id");
ejecute("update domicilios set x=".$x.", y=".$y." where id=".$id);
exit();
?>