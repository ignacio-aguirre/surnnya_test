<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
registre();?>
</div>
<div class="container">
<button class="btn btn-primary" onclick='navega("sector?id=0")'>Nuevo</button>
&nbsp;<button class="btn btn-success" onclick='navega("sectores_excel")'>Excel</button>
<div class="table-responsive">
<table class="table">
<tr class="bg-primary"><th>id</th><th>Nombre</th><th>Dependencia</th><th>Usuarios</th><th>Acciones</th></tr>
<?php 
$reg = registros("select sectores.*,(select count(*) from usuarios where usuarios.baja is null and sector=sectores.id) as cant, depe.denominacion as depen   
from sectores left join sectores depe on depe.id=sectores.dependencia where sectores.baja is null order by  denominacion");
$cant = mysqli_num_rows($reg);
while	($r = mysqli_fetch_assoc($reg)) {
 echo "<tr><td>".$r["id"]."</td><td>".$r["denominacion"]."</td><td>".$r["depen"]."</td><td>".$r["cant"];
 $url_aux="sector?id=".$r['id'];	
 $url_au2="sector_eliminar?id=".$r['id'];	

 echo "</td><td><a href='".$url_aux."'> Editar </a>&nbsp;<a href='".$url_au2."'> Eliminar </a></td></tr>";
};
?>
</table></div>
</div>
</body>
</html>