<?php
include("funciones.php");
session_start();
$a=nget("articulo");
echo un_campo("select cantidad from existencias where articulo=".$a);
?>