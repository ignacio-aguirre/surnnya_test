<?php
include("funciones.php"); 
session_start();
$dispositivo=$_SESSION['hogar'];
$texto=$_GET["texto"];
$palabras=parsea($texto);
$condicion="where baja is null and dispositivo=".$dispositivo;
foreach($palabras as $pal){
	$condicion=$condicion." and (nombre like '%".$pal."%' or apellido like '%".$pal."%')";
};
$adultos=registros("select apellido,nombre,celular,id  
from movil_adultos ".$condicion."  order by apellido,nombre");
$adulto=json_encode([]);
if(mysqli_num_rows($adultos)==1){$adulto=json_encode(mysqli_fetch_assoc($adultos));};
echo $adulto;
exit();
?>