<?php
session_start();
include("funciones.php");
$_SESSION["prestacion"]="N&oacute;mina alojados";
include("encabezado.php");
$dispositivo=$_SESSION["hogar"];

$alojados=registros("select nombres,apellidos,legajo from hogares_admision 
	left join sujetos on admi_legajo=sujetos.legajo 
	where admi_hogar=".$dispositivo." and admi_alta is not null and admi_baja is null order by nombres,apellidos");
$ndispo=un_campo("select nombre from dispositivos where id=".$dispositivo);
?>
<h4><?php echo "Alojados en ".$ndispo?></h4>
<div class="table-responsive">
	<table class="table table-striped">
		<?php while($a=mysqli_fetch_assoc($alojados)){
			echo "<tr class='text-dark' style='font-size:.9em'><td>".$a["nombres"]." ".$a["apellidos"]."</td></tr>";
		}
		?>
	</table>
</div>
<button class="btn-success" onclick="window.close()">Cerrar</button>

</div>