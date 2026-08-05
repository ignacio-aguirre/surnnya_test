<?php
session_start();
include("funciones.php");
$empresa=nget("empresa");
$fecha=$_GET["fecha"];
$sol=registros("select distinct case when dispositivo>0 then nombre else denominacion end as texto, case when dispositivo>0 then concat('d',dispositivo) else concat('s',sector) end as valor from movil_viajes 
    left join dispositivos on movil_viajes.dispositivo=dispositivos.id 
    left join sectores on movil_viajes.sector=sectores.id 
    where movil_viajes.bandeja=7 and conciliado=0 and empresa=".$empresa." and fecha=".$fecha." order by texto");
while($s=mysqli_fetch_assoc($sol)){
    echo "<option value='".$s["valor"]."'>".$s["texto"]."</option>";
}
?>
