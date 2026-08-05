<?php
include("Funciones.php");
session_start();
include("encabezado.php");
registre();
$sql="select localidades_nueva.*, paises.descripcion as npais from localidades_nueva left join paises on pais=idpaises where localidades_nueva.baja is null order by nombre";
$dato = registros($sql);
$cant = mysqli_num_rows($dato);?>
</div>

<div class="container">

<button onclick='navega("localidad_nuevo")' class='btn-primary'>Nueva</button>&nbsp;&nbsp;<br>
<div class="table-responsive pre-scrollable">
<table class="table table-striped">
<tr class="bg-success" style="font-size:.8em"><th>Nombre</th><th>Pa&iacute;s</th><th>Provincia</th><th>Partido</th><th>Acciones</th></tr>
<?php
while	($r = mysqli_fetch_assoc($dato)) 
	{
	echo "<tr style='font-size:.8em'>";
	echo "<td>".$r["nombre"]."</td>";
	echo "<td>".$r["npais"]."</td>";
	echo "<td>".$r["provincia"]."</td>";
        echo "<td>".$r["partido"]."</td>";
	$url_aux="localidad_eliminar?id=".$r['id'];	
	echo "<td><a href='".$url_aux."' style='font-color:red'> Eliminar </a>&nbsp;&nbsp;&nbsp;";
	echo "</td></tr>";
	};
?> 
</table>
</div>
</div>
</body>
</html>