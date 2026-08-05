<?php 
include("Funciones.php");
session_start();
include("encabezado-test.php");
?>
<script>
function nueva_persona(){
url="af_personas?id=0";
navega(url);
};
</script>
<div class="container">
<button type='button' onclick='nueva_persona()'>Nueva Persona</button>
<div class="table-responsive">
<table class="table">
<tr>
<th>Id</th> <th align="left">Apellidos, Nombres</th><th>DNI</th><th>Familia</th><th>V&iacute;nculo</th><th>Conviviente</th></tr>
<?php
$conn = registros("select * from personas left join af_familias on familia_pertenencia=idaf_familias
left join tablas on tipo='AFVIN' and valo=vinculo order by denominacion, apellidos, nombres");
while ($da = mysqli_fetch_assoc($conn)) {
   $url_aux=	"af_personas?id=".$da['idpersonas'];	
   echo colorfila()."<td align='center'><a href='".$url_aux."'>".$da['idpersonas']."</a></td>";
   echo "<td>".$da['apellidos'].", ".$da['nombres']."</td>";
   echo "<td>".$da['nrodoc']."</td>";
   echo "<td>".$da['denominacion']."</td>";
   echo "<td>".$da['deno']."</td>";
   echo "<td>".si($da['conviviente']==1,"SI","NO")."</td>";
   echo "</tr>"; };
?>

</table>
</div>
</div>
</body>
</html>
