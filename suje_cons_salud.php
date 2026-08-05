<?php
session_start();
include('Funciones.php');
$_SESSION['prestacion']="Registro Gabinete de Salud";
include('encabezado.php');
if (!isset($_SESSION['gldispo'])|!isset($_GET['legajo'])) header ("Location: index");
registre();
$lega= $_GET["legajo"];
$tipo="";
if ($lega=="" ) Redirect("Location: consultasujetos");
if (isset($_GET["tipo"])) $tipo=$_GET["tipo"] ;
$_SESSION["posicion"]="5";
include("mnu_superior.php");
?>
</div>
<div class="container">
<div class="table-responsive">
	<table class="table-condensed">
	<tr class="bg-primary" style="font-size:.9em"><th>Fecha Solicitud</th><th>Fecha Acci&oacute;n</th><th>Dispositivo</th><th>Tipo Acci&oacute;n</th><th>Profesi&oacute;n</th><th>Estado</th><th>Observaciones</th></tr>
	<?php
	$reg=registros("select es_participaciones.*,nombre from es_participaciones left join dispositivos on solicitante=dispositivos.id where legajo=".$lega." and fecha_rechazo is null order by fecha_ingreso desc");
	while($r=mysqli_fetch_assoc($reg)){
	 echo "<tr style='font-size:.9em'><td>".ffec($r["fecha_ingreso"])."</td><td>Solicitud</td><td>".$r["nombre"].$r["solicitante_especificar"]."</td><td></td><td></td><td></td></tr>";
	 $acc=registros("select es_acciones.*,tipos.deno as tipoa, espe.deno as prof,nombre, esta.deno as estado_acc from es_acciones left join dispositivos on dispositivos.id=dispositivo 
	 left join tablas tipos on tipos.tipo='ESTIA' and tipos.valo=es_acciones.tipo 
	 left join tablas espe on espe.tipo='ESESP' and espe.valo=especialidad
	 left join tablas esta on esta.tipo='ESEA' and esta.valo=estado
	 where solicitud=".$r["id"]." order by fecha");
	 while($a=mysqli_fetch_assoc($acc)){
	   echo "<tr style='font-size:.9em'><td></td><td>".ffec($a["fecha"])."</td><td>".$a["nombre"]."</td><td>".$a["tipoa"]."</td><td>".$a["prof"]."</td><td>".$a["estado_acc"]."</td><td>".$a["observaciones"]."</td></tr>";
	 };
	if($r["fecha_fin"]!=""){
	 echo "<tr style='font-size:.9em'><td></td><td>".ffec($r["fecha_fin"])."</td><td></td><td></td><td>Cierre</td><td>".$r["motivo_estado"]."</td></tr>";

        };
	};
	?>
	</table>
</div>
</div>
</html>