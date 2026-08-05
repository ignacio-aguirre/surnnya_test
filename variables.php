<?php 
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Variables del sistema";
include("encabezado.php"); 
?>
</div>
<div class="container">
<div class="table-responsive pre-scrollable">
<table class="table">
<tr class="bg-primary"><th>Acr&oacute;nimo</th><th>Nombre</th><th>Acciones</th></tr>
<?php
  $var=registros("select * from variables order by nombre");
  while($v=mysqli_fetch_assoc($var)){
   echo "<tr><td>".$v["acronimo"]."</td><td>".$v["nombre"]."<td><button class='btn-sm btn-success' onclick='categ(".$v["id"].")'>Categor&iacute;as</button></td></tr>";

  };	
?>
</table>
</div> 
</div> 
</body>
</html>



