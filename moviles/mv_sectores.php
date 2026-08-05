<?php 
session_start();
include("funciones.php");

$status="";
$_SESSION["prestacion"]="Sectores";
include("encabezado.php");
$bandeja="1";
$sectores=registros("select id,denominacion,bandeja,deno from sectores  
 left join tablas on tipo='ETRA' and valo=transporte 
 where bandeja=".$bandeja." order by denominacion");

?>
<br><br>
</div>
<div class="container">
<div class="table-responsive col-md-12 pre-scrollable">
	
	<table class="table col-md-6">
		<tr><th>Nombre</th><th>Empresa</th><th>Opciones</th></tr>
		<?php
			while($s=mysqli_fetch_assoc($sectores)){
				echo "<tr><td>".$s["denominacion"]."</td><td>".$s["deno"]."</td><td>".
				"<button class='btn-sm btn-primary' onclick='editar(".$s["id"].")'>Editar</button>".
				"</td></tr>";
			}
		?>
		
	</table>	
</div>	
</div>
<script>
	function editar(id){
		navega("mv_sector_editar?id="+id);
	}
</script>
</body>