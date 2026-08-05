<?php
include("../funciones.php"); 
session_start();
$id=nget("id");
$barrio=tget("barrio");
ejecute("update domicilios set barrio=".$barrio."where id=".$id);
exit();
?>