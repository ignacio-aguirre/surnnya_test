<?php
include('Funciones.php');
session_start();
$_SESSION["prestacion"]="Roles";
include('encabezado.php');
if($_SESSION["menu"]=="mnu_dipp"){  die("Algo falló. Intento registrado");};
?>
</div>
<div class="container">
<h2>Seleccion&aacute; un Rol</h2>
<form class="form" action="roles_do">
	<div class="form-group has-warning">
		<select class="form-control" name="perfil">
		<?php
		  $reg=registros("select * from perfiles order by denominacion");
		  while($r=mysqli_fetch_assoc($reg)){
			echo "<option value='".$r["id"]."'>".$r["denominacion"]."</option>";
		  };	
		?>
		</select>
	</div>
	<div class="form-group has-warning">
		<input type="submit" class="btn btn-primary" value="Seleccionar">
	</div>
</form>
<p class="text-warning">Seleccion&aacute; un rol para navegar m&aacute;s opciones del Sistema</p>
</div>
</body>
</html>