<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Dispositivos de Alojamiento";
include("encabezado.php");?>
</div>
<div class="container">

<button class="btn-primary" onclick='navega("hogares")'>Ver Hogares Activos</button>&nbsp;&nbsp;


<div class="table-responsive pre-scrollable">

<table class="table striped-table">

<tr style="font-size:.8em">

<th>Acciones</th><th>Unidad T&eacute;cnica</th><th>Denominaci&oacute;n</th><th>Modalidad</th><th>Poblaci&oacute;n</th><th>Instituci&oacute;n</th><th>Domicilio</th><th>Tel&eacute;fonos</th><th>e-mail</th></tr>

<?php

$sql="select * from dispositivos left join tablas on tipo='SUPUT' and valo=unidad_tecnica where dispositivos.baja is not null order by deno, nombre"; 

$conn = registros($sql);

$conta=1; 

while ($da = mysqli_fetch_assoc($conn)) {

   $conta=$conta+1;

   

   echo "<tr style='font-size:.8em'><td>";

   if($_SESSION['gl_todos_dispo']==1|$_SESSION['gl_admi']==1) echo "<a href='un_hogar.php?iid=".$da["id"]."'><img height='15' width='15' src='imagenes/editar.png' title='Editar'></a>";

   echo "<a href='consultahogar.php?id=".$da["id"]."'><img height='15' width='15' src='imagenes/pdf-icon.png' title='Consultar'></a>";
   echo "&nbsp;&nbsp;&nbsp;<a href='hogar_reactivar.php?id=".$da["id"]."'><img height='15' width='15' src='imagenes/flecha.png' title='Reactivar'></a></td>";

   echo "<td>".$da['deno']."</td>";

   echo "<td>".$da['nombre']."</td>";

   echo "<td>".$da['Hogares_Especialidad']."</td>";

   echo "<td>".$da['poblacion']."</td>";

   echo "<td>".$da['Hogares_RazSocial']."</td>";

   echo "<td>".$da['domicilio']."-".$da['localidad']."</td>";

   echo "<td>".$da['telefonos']."</td>";

   echo "<td>".$da['Hogares_Mail']."</td></tr>";

    };

?>

</tr>

</table>

</div>
</div>
</body>



</html>