<?php
include("../Funciones.php"); 
session_start();
$dispositivo=nget("dispositivo");
$texto=$_GET["calle"];
$domicilios=registros("select * from movil_domicilios where dispositivo=".$dispositivo." and concat(callenro,case when referencia is null then '' else referencia end) like '%".$texto."%' order by callenro");
$a=[];
while($d=mysqli_fetch_assoc($domicilios)){
//	array_push($a,["callenro"=>$d["callenro"],"localidad"=>$d["localidad"],"referencia"=>$d["referencia"]]);
 array_push($a,$d);
};
$resp=json_encode($a);
echo $resp;
exit();
?>