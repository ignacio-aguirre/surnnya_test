<?php
session_start();
include("funciones.php"); 
$sec=registros("select id, denominacion from sectores where bandeja>0 and baja is null order by denominacion");
while($s=mysqli_fetch_assoc($sec)){
	echo "<option value='".$s["id"]."'>".$s["denominacion"]."</option>";
};
exit();
?>