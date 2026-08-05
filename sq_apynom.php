<?php
session_start();
include("Funciones.php");
$frase=$_GET["frase"];
$sql=buscador_pibes_lt($frase);
$reg=registros($sql);
if(mysqli_num_rows($reg)==1){
$r=mysqli_fetch_assoc($reg);
echo $r["apellidos"].", ".$r["nombres"]." (".$r["legajo"].")";
};
if(mysqli_num_rows($reg)>1){
echo "*";
while($r=mysqli_fetch_assoc($reg)){
 echo "<option value='".$r["legajo"]."'>".$r["apellidos"].", ".$r["nombres"]."</option>";
};
};
exit;
?>