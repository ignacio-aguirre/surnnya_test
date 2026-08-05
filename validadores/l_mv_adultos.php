<?php
include("../Funciones.php"); 
session_start();
$dispositivo=nget("dispositivo");
$texto=$_GET["texto"];
$adultos=registros("select apellido,nombre,dni,celular,id  
from movil_adultos where baja is null and dispositivo=".$dispositivo.
" and concat(apellido,nombre) like '%".$texto."%' order by apellido,nombre");
$adulto=json_encode([]);
if(mysqli_num_rows($adultos)==1){$adulto=json_encode(mysqli_fetch_assoc($adultos));};
echo $adulto;
exit();
?>