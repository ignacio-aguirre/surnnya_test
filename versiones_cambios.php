<?php 
session_start();
include("Funciones.php");
$entorno=un_campo("select entorno from parametros");
$_SESSION["prestacion"]="Cambios en versiones del sistema - entorno: ".$entorno;
include("encabezado.php");

?>
<div class="container">
	<div class="table-responsive pre-scrollable">
		<table class="table">
			<tr class="bg-dark text-white"><th>Versi&oacute;n</th><th>Fecha</th><th>Cambios</th></tr>
			<?php
				$reg=registros("select * from versiones_cambios where modulo='SURNNYA' and entorno=".tsql($entorno)." order by fecha desc");
				while($r=mysqli_fetch_assoc($reg)){
					echo "<tr><td>".$r["ver_1"].".".$r["ver_2"].".".$r["ver_3"]."</td><td>".ffec($r["fecha"])."</td><td>".$r["log_cambios"]."</td></tr>";
				}
			?>
		</table>
	</div>
</div>