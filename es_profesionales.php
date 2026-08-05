<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
$sql="select es_profesionales.*, deno, usuarios.apellido as uape, usuarios.nombre as unom,
(select count(*) from es_participaciones where fecha_rechazo is null and fecha_fin is null and fecha_inicio is not null and profesional=es_profesionales.id) as casos from es_profesionales left join tablas on tipo='ESESP' and valo=profesion
 left join usuarios on usuario=usuarios.id  where es_profesionales.baja is null order by es_profesionales.apellido, es_profesionales.nombre";
$reg = registros($sql);
$cant = mysqli_num_rows($reg);?>
</div>
<div class="container">
<button onclick='navega("es_profesional_editar?id=0")' class='btn-primary'>Nuevo</button>&nbsp;&nbsp;
<div class="table-responsive pre-scrollable">
<table class="table table-striped">
<tr class="bg-info"><th>Apellido y Nombre</th><th>Profesi&oacute;n</th><th>Matr&iacute;cula(s)</th><th>Usuario</th><th>Alta</th><th>Casos</th><th>Acciones</th></tr>
<?php
while	($r = mysqli_fetch_assoc($reg)) 
	{
	echo "<tr>";
	echo "<td>".$r["apellido"].", ".$r["nombre"]."</td>";
	echo "<td>".$r["deno"]."</td>";
	echo "<td>".$r["matricula"]."</td>";
        echo "<td>".$r["uape"].", ".$r["unom"]."</td><td>".ffec($r["alta"])."</td><td>".$r["casos"]."</td>";
	$url_aux="es_profesional_editar?id=".$r['id'];	
		echo "<td><a href='".$url_aux."'> Editar </a>";
	echo "</td></tr>";
	};
?>
</table>
<?php echo $cant." registros.";?>
</div>
</div>
</body>
</html>