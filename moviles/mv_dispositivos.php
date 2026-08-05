<?php 
session_start();
include("funciones.php");

$status="";
$_SESSION["prestacion"]="Men&uacute; dispositivos";
include("encabezado.php");
$bandeja="1";
$dispositivos=registros("select id,nombre,bandeja,deno,celular_moviles from dispositivos 
 left join tablas on tipo='ETRA' and valo=transporte 
 where bandeja=".$bandeja." order by nombre");

?>
<br><br>
</div>
<div class="container">
<div class="table-responsive col-md-12 pre-scrollable">
	<h4>Datos dispositivos</h4>
	<table class="table col-md-6">
		<tr><th>Nombre</th><th>Empresa</th><th>Opciones</th></tr>
		<?php
			while($d=mysqli_fetch_assoc($dispositivos)){
				echo "<tr><td>".$d["nombre"]."</td><td>".$d["deno"]."</td><td>".
				
				"<button class='btn-sm btn-primary' onclick='editar(".$d["id"].")'>Editar</button>".
				"</td></tr>";
			}
		?>
		
	</table>	
</div>	
</div>
<script>
	function editar(id){
		navega("mv_dispositivo_editar?id="+id);
	}
</script>
</body>