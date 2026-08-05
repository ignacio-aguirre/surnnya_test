<?php
session_start();
include("funciones.php"); 
$dis=registros("select id, nombre from dispositivos where bandeja>0 and baja is null order by nombre");
while($d=mysqli_fetch_assoc($dis)){
	echo "<option value='".$d["id"]."'>".$d["nombre"]."</option>";
};
exit();
?>