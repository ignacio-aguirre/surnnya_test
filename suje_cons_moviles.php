<?php
session_start();
include('Funciones.php');
$_SESSION['prestacion']="Uso de m&oacute;viles";
include('encabezado-test.php');
if (!isset($_SESSION['gldispo'])|!isset($_GET['legajo'])) header ("Location: index");
registre();
$lega= $_GET["legajo"];
$tipo="";
if ($lega=="" ) Redirect("Location: consultasujetos");
if (isset($_GET["tipo"])) $tipo=$_GET["tipo"] ;
$_SESSION["posicion"]="10";
include("mnu_superior.php");
?>
</div>
<div class="container">
<div class="table-responsive pre-scrollable">
	<p class="text-primary">M&aacute;ximo: &Uacute;ltimos 300</p>
	<table class="table-condensed">
	<thead>
	<tr class="bg-primary"><th>Dispositivo</th><th>Fecha y hora</th><th>Motivo</th><th>Comentarios</th></tr>
	</thead>
	<tbody>
	<?php
	$reg=registros("select fecha,hora,comentarios, deno,nombre from movil_pasajeros left join movil_viajes on viaje=movil_viajes.id left join dispositivos on dispositivo=dispositivos.id left join tablas on tablas.tipo='MVMT' and valo=movil_viajes.motivo_recurso where tipo_pasajero=1 and legajo=".$lega." and estado='APR' and movil_viajes.bandeja=7 and cumplido>-1 order by fecha desc, hora limit 300");
	while($r=mysqli_fetch_assoc($reg)){
	 echo "<tr><td>".$r["nombre"]."</td><td>".ffec($r["fecha"])." ".substr($r["hora"],0,5)."</td><td>".$r["deno"]."</td><td>".$r["comentarios"]."</td></tr>";
	 
	};
	?>
	</tbody>	
	</table>
</div>
</div>
</html>