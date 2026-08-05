<?php
include("funciones.php"); 
session_start();
$t=$_GET["t"];
$palabras=parsea($t);
$condicion=" where true ";

foreach($palabras as $pal){
	$condicion=$condicion." and (direccion like '%".$pal."%' or localidad  like '%".$pal."%' or ref_general like '%".$pal."%')";
};

$domicilios=registros(
	"select * from domicilios ".$condicion." order by direccion");
$o="";
while($d=mysqli_fetch_assoc($domicilios)){
 $o=$o."<option style='font-size:-9em'value='".$d["id"]."'>".formatea_dom($d["direccion"]).
 "</option>";
};
echo $o;
exit();
?>