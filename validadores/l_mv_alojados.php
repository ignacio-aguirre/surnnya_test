<?php
include("../Funciones.php"); 
session_start();
$dispositivo=nget("dispositivo");
$texto=$_GET["texto"];
$lalo="";
$alojados=registros("select apellidos,nombres,sujetosdni,edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,curdate()) as edad, legajo 
from hogares_admision left join sujetos on admi_legajo=sujetos.legajo where admi_baja is null and admi_alta is not null and admi_hogar=".$dispositivo.
" and concat(apellidos,nombres) like '%".$texto."%' order by apellidos,nombres");
$legajo=json_encode([]);
if(mysqli_num_rows($alojados)==1){$legajo=json_encode(mysqli_fetch_assoc($alojados));};
echo $legajo;
exit();
?>