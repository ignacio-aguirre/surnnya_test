<?php
session_start();
include("funciones.php");
$empresa=nget("empresa");
$fechas=registros("select distinct fecha from movil_viajes where bandeja=7 and conciliado=0 and empresa=".$empresa." order by fecha");
while($f=mysqli_fetch_assoc($fechas)){
    echo "<option value='".fsql(ffec($f["fecha"]))."'>".ffec($f["fecha"])."</option>";
}
?>
