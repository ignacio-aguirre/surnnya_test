<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
$sql="select menues.*,
(select count(*) from usuarios where perfil in (select perfiles.id from perfiles where menu_nuevo=idmenues) and usuarios.baja is null) as cantidad 
 from menues order by nombre";
$reg = registros($sql);
$cant = mysqli_num_rows($reg);?>
</div>

<div class="container">

<button class="btn-sm btn-primary" onclick='navega("unmenu?id=0")'>Nuevo</button>&nbsp;&nbsp;
<button class="btn-sm btn-success" onclick='navega("menues_excel")'>Excel</button><br><br>
<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr class="bg-primary"><th>Id</th><th>Nombre</th><th>url</th><th>Cant.Usuarios</th><th>Acciones</th></tr>
</thead>
<tbody>
<?php
   while($r= mysqli_fetch_assoc($reg)) 
	{
	echo "<tr>";
	echo "<td>".$r["idmenues"]."</td>";
	echo "<td>".$r["nombre"]."</td>";
	echo "<td>".$r["descripcion"]."</td>";
	echo "<td>".$r["cantidad"]."</td>";
    	$url_aux='"unmenu?id='.$r["idmenues"].'"';	
	echo "<td><button class='btn-sm btn-primary' onclick='navega(".$url_aux.")'>Editar</button>&nbsp;&nbsp;&nbsp;";
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