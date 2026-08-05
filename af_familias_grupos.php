<?php
require("Funciones.php");
session_start();
$_SESSION["prestacion"]="Registro de Grupos de Familias en Seguimiento";
registre();
include("encabezado.php");
$id=$_GET["id"];
?>

<div class="container">
<div class="table-responsive">
<table class="table" id="vinculos">
<tr><th>Persona</th><th>Apellido y Nombre</th><th>V&iacute;nculo</th><th>Edad</th><th>Ocupaci&oacute;n</th><th>Conviviente</th><th>Acciones</th></tr>
<?php
$reg=registros("select personas.*,deno,edadcalc(fecha_nacimiento,edad,0,fecha_actualizacion,curdate()) as edc from personas 
 left join tablas on tipo='AFVIN' and valo=vinculo where familia_pertenencia=".$id." order by vinculo, edc");
while($r=mysqli_fetch_assoc($reg)){
  echo "<tr><td>".$r["idpersonas"]."</td><td>".$r["apellidos"].", ".$r["nombres"]."</td><td>".$r["deno"]."</td><td>".$r["edc"].
 "</td><td>".$r["ocupacion"]."</td><td>".si($r["conviviente"]=="1","SI","NO")."</td><td>".
 "Editar <img src='imagenes/mas.png' height='25' width='25' onclick='editar(".$r["idpersonas"].")'>&nbsp;&nbsp;";
 if($r["vinculo"]!="1"){echo  "Desvincular<img src='imagenes/eliminar.png' height='25' width='25' onclick='desvincular(".$r["idpersonas"].")'>";};
 echo "</td></tr>";
 };
?>
</table>
</div>
</div>

<script type="text/javascript">
function editar(id){
 navega("af_personas?id="+id);
}
function desvincular(persona){
navega("af_familias_el_conviviente?persona="+persona+"&familia=<?php echo $id?>");
return false;
}


</script>
</body>
</html>