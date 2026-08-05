<?php
include("../funciones.php"); 
session_start();
$dispositivo=nget("dispositivo");
if($dispositivo=="0"){$dispositivo=$_SESSION['hogar'];};
$texto=$_GET["texto"];
if(intval($texto)>0 && strlen($texto)==6){
	$alojados=registros("select apellidos,nombres, legajo 
	from hogares_admision left join sujetos on admi_legajo=sujetos.legajo where admi_alta is not null and admi_baja is null and admi_hogar=".$dispositivo." and admi_legajo=".nget("texto")." order by apellidos,nombres");

}
else{
$palabras=parsea($texto);
$condicion="where admi_baja is null and admi_alta is not null and admi_hogar=".$dispositivo;
foreach($palabras as $pal){
	$condicion=$condicion." and (nombres like '%".$pal."%' or apellidos like '%".$pal."%')";
};

$alojados=registros("select apellidos,nombres, legajo 
from hogares_admision left join sujetos on admi_legajo=sujetos.legajo ".$condicion." order by apellidos,nombres");
};
$legajo=json_encode([]);
if(mysqli_num_rows($alojados)==1){$legajo=json_encode(mysqli_fetch_assoc($alojados));};

echo $legajo;
exit();
?>