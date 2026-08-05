<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
?>
</div>
<div class="container">
<div class="table-responsive">
	<table class="table table-striped">
		<tr class="bg-dark text-white"><th>DO</th><th>Dispositivo</th><th align='center'>Plazas</th><th align='center'>Alojados</th><th align='center'>Disponibilidad</th></tr>
<?php
$reg=registros("
SELECT direccion_operativa,nombre, plazas, count(*) as alojados, plazas-count(*) as disponibles from hogares_admision 
left join dispositivos on admi_hogar=dispositivos.id
where admi_alta is not null and admi_baja is null and direccion_operativa in (1,2) and baja is null
group by direccion_operativa,nombre, plazas having count(*)<plazas order by direccion_operativa,nombre");
while($r=mysqli_fetch_assoc($reg)){
	echo "<tr><td>".si($r["direccion_operativa"]=="2","Infancia","Adolescencia")."</td><td>".$r["nombre"]."</td><td align='center'>".$r["plazas"]."</td><td align='center'>".
	$r["alojados"]."</td><td align='center'>".$r["disponibles"]."</td></tr>";
}
?>
</table>
</div>
</div>
