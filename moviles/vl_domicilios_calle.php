<?php
include("../funciones.php"); 
session_start();
$id=nget("id");
$calle=tget("calle");
ejecute("update domicilios set calle=".$calle."where id=".$id);
exit();
?>