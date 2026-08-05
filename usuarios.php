<?php
include("Funciones.php");
session_start();
include("encabezado.php");
registre();
$orden="";
if(isset($_GET["orden"])) $orden=$_GET["orden"];
$sql="select usuarios.id, apellido as apel, usuarios.nombre as nomb, cuil, sectores.denominacion as ndispo, perfiles.denominacion as nperfil, usuarios.email, intentos 
	from usuarios 
	left outer join sectores on sector=sectores.id 
	left outer join perfiles on perfiles.id=perfil 
	where usuarios.baja is null ";
if ($orden=="") $sql=$sql." order by apellido, usuarios.nombre";
if ($orden=="dispo") $sql=$sql." order by sectores.denominacion, apellido, usuarios.nombre";
if ($orden=="perfil") $sql=$sql." order by nperfil, apellido, usuarios.nombre";
$usu = registros($sql);
$cant = mysqli_num_rows($usu);?>
</div>

<div class="container">

<button onclick='navega("usuario_nuevo")' class='btn-primary'>Nuevo</button>&nbsp;&nbsp;<button onclick='navega("usuarios_excel")' class='btn-success'>Excel</button><br>
<div class="table-responsive pre-scrollable">
<table class="table table-striped">
<tr class="bg-success" style="font-size:.8em"><th><a href='usuarios'>Apellido y Nombre</a></th><th>CUIL</th><th><a href='usuarios?orden=dispo'>Sector<a></th><th><a href='usuarios?orden=perfil'>Perfil</a></th><th>Intentos</th><th>Acciones</th></tr>
<?php
while	($u = mysqli_fetch_assoc($usu)) 
	{
	echo "<tr style='font-size:.8em'>";
	echo "<td>".$u["apel"].", ".$u["nomb"]."</td>";
	echo "<td>".$u["cuil"]."</td>";
	echo "<td>".$u["ndispo"]."</td>";
        echo "<td>".$u["nperfil"]."</td><td>".$u["intentos"]."</td>";
	$url_aux="unusuario?vusuario=".$u['id'];	
		echo "<td><a href='".$url_aux."'> Editar </a>&nbsp;&nbsp;&nbsp;";
	$url_aux="usuario_elimina?vusuario=".$u['id'];	
		echo "<a href='".$url_aux."' style='font-color:red'> Eliminar </a>&nbsp;&nbsp;&nbsp;";
	echo "</td></tr>";
	};
?>
</table>
</div>
</div>
</body>
</html>