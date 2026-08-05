<?php
session_start();
include("Funciones.php");
$numero=nget("rib");
$reg=registros("select sujetos.legajo, apellidos, nombres, rib_anio,rib_numero,rib_reparticion from sujetos where cerrado=0 and rib_numero=".$numero);
if(mysqli_num_rows($reg)==1){
$r=mysqli_fetch_assoc($reg);
echo nrib($r)." ".$r["apellidos"].", ".$r["nombres"]." (".$r["legajo"].")";
};
if(mysqli_num_rows($reg)>1){
echo "*";
while($r=mysqli_fetch_assoc($reg)){
 echo "<option value='".$r["legajo"]."'>".nrib($r)." ".$r["apellidos"].", ".$r["nombres"]."</option>";
};
};
exit;
function nrib($r){
 if($r["rib_anio"]==""){return "";}
 else{
   return "RIB-".$r["rib_anio"]."-".intval($r["rib_numero"])."-".trim($r["rib_reparticion"]);
 };
}
?>