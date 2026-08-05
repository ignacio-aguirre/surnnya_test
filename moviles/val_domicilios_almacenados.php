<?php
include("funciones.php"); 
session_start();
$t=$_GET["t"];
$tipo_dispositivo=tget("td");
$dispositivo=nget("dispo");
$palabras=parsea($t);
if($tipo_dispositivo=="'d'"){
$condicion=" where dispositivo=".$dispositivo." ";
}
else{
	$condicion=" where sector=".$dispositivo." ";
}
foreach($palabras as $pal){
	$condicion=$condicion." and (domicilio like '%".$pal."%' or referencia  like '%".$pal."%')";
};

$domicilios=registros(
	"select * from movil_domicilios".$condicion." order by domicilio");
$o="";
while($d=mysqli_fetch_assoc($domicilios)){
 $o=$o."<option value='".$d["iddomicilios"]."'>".$d["domicilio"]."</option>";
 
};

echo $o;
exit();
?>