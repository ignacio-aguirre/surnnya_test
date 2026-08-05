<?php
include("funciones.php"); 
session_start();
$dispositivo=nget("dispositivo");
$texto=$_GET["calle"];
$domicilios=registros("select * from movil_domicilios where dispositivo=".$dispositivo." and concat(domicilio,case when referencia is null then '' else referencia end) like '%".$texto."%' order by domicilio");
$a=[];
while($d=mysqli_fetch_assoc($domicilios)){
 array_push($a,$d);
};
$resp=json_encode($a);
echo $resp;
exit();
?>