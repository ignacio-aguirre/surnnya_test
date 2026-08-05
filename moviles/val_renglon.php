<?php
session_start();
include("funciones.php"); 
$id=nget("renglon");
$d=un_registro("select * from movil_renglones where id=".$id);
echo json_encode($d);
exit();
?>