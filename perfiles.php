<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
$sql="select perfiles.*, menues.nombre,(select count(*) from usuarios where perfil=perfiles.id and baja is null) as cantidad from perfiles left join menues on menu_nuevo=idmenues order by denominacion";
$reg = registros($sql);
$cant = mysqli_num_rows($reg);?>
</div>

<div class="container">
<script>
	function editar(id){
		navega("unperfil?id="+id)
	}
</script>

<button class="btn-sm btn-primary" onclick='navega("unperfil?id=0")'>Nuevo</button>&nbsp;&nbsp;
<button class="btn-sm btn-success" onclick='navega("perfiles_excel")'>Excel</button><br><br>
<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr class="bg-info"><th>Nombre</th><th>Men&uacute;</th><th>Permiso</th><th>Definici&oacute;n</th><th># Usu</th><th>Acciones</th></tr>
</thead>
<tbody>
<?php
   while($r= mysqli_fetch_assoc($reg)) 
	{
	echo "<tr>";
	echo "<td>".$r["denominacion"]."</td>";
	echo "<td>".$r["nombre"]."</td>";
	echo "<td>".permisos($r)."</td>";
	echo "<td>".$r["definicion"]."</td>";
	echo "<td>".$r["cantidad"]."</td>";
	
	echo '<td><button class="btn-sm btn-primary" onclick="editar('.$r["id"].')">Editar</button>&nbsp;&nbsp;&nbsp;';
	echo "</td></tr>";
	};
?>
</tbody>
</table>
</div>
</div>
<?php
 function permisos($r){
  $t=si($r["soloconsulta"]=="1","CONSULTA",si($r["menu_nuevo"]=="","NINGUNO","CARGA"));
  return $t;
 };
?>
</body>

</html>