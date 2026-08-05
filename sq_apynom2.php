<?php
session_start();
include("Funciones.php");
$frase=$_GET["frase"];
$sql=buscador_pibes_lt($frase);
$reg=registros($sql);
while($r=mysqli_fetch_assoc($reg)){
 echo "<option value='".$r["legajo"]."'>".$r["apellidos"].", ".$r["nombres"]."</option>";
};
exit;
?>