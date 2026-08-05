<?php

require("Funciones.php");

session_start();

$fras= $_GET["fras"];

?>

Seleccione haciendo click en la fila que corresponda

<table id='tabla_busqueda' class="table table-striped table-bordered table-condensed table-hover">

<thead><tr class="bg-secondary" style='font-size:.8em;'>

<th>Legajo</th><th>Apellidos</th><th>Nombres</th><th>Apodos/Nombres Alternativos</th><th>Documento</th><th>Edad</th><th>Parada/Ranchada</th><th>Procedencia</th><th>Hogar</th></tr></thead>

<?php

$conn = registros(buscador_pibes($fras,0,0));

while ($da = mysqli_fetch_assoc($conn)) {

   $fun="elige(".$da['legajo'].',"'.$da["apellidos"].'","'.$da["nombres"].'","'.$da["edad_c"].'")';

   

   echo "<tr style='font-size:.8em;' onclick='".$fun."'>";

   echo "<td><strong>".$da['legajo']."</td>";

   echo "<td>".$da['apellidos']."</td>";

   echo "<td>".$da['nombres']."</td>";

   echo "<td>".$da['apodos']."</td>";

   echo "<td>".$da['SujetosDni']."</td>";

   echo "<td>".$da['edad_c']."</td>";

   echo "<td>".$da['para']." ".$da['Lugparada']."</td>";

   echo "<td>".$da['proc']." ".$da['Lugvivienda']."</td>";

   echo "<td>".$da['hoga']."</td>";

   echo "</tr>"; 

};

?>

</table>

</body>

</html>

