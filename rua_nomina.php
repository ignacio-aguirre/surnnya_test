<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="N&oacute;mina RUA";
include("encabezado-test.php");
$estado="0";
if(isset($_GET["estado"])) $estado=$_GET["estado"];
if(isset($_GET["Excel"])) Redirect("rua_nomina_excel");
?>
<div class="container">
<button  class="btn-success" onclick="navega('rua_nomina_excel')">Excel</button>
<div class='table-responsive pre-scrollable'>
<table class='table table-striped table-bordered'>
<tr class="bg-primary text-white" style="font-size:.90em">
<th>Id</th><th>Apellido y Nombre</th><th>Edad</th><th>Alta</th><th>Ingreso puesto</th><th>Poder</th><th>Organismo</th><th>Baja</th></tr>
<?php
  $sql="select rua_nomina.*, sujetos.legajo , sujetos.apellidos as apel, sujetos.nombres, edadcalc(f_nacimiento,sujetosEdad,SujetosMeses,SujetosActEdad,curdate()) as edad_calc, deno  
   from rua_nomina
   left join sujetos on rua_nomina.legajo=sujetos.legajo
   left join tablas on tipo='PRUA' and valo=rua_nomina.poder
   where 1 order by apel, Nombres";
   $conn = registros($sql);
   $conta=0;
   while ($da = mysqli_fetch_assoc($conn)) {
      $conta=$conta+1;
      $lega=$da['legajo'];
      $apel=$da["apel"];
      $nomb= $da["nombres"];
      echo "<tr style='font-size:.90em' onclick='ver(".$da["id"].")'><td>".$da["id"].
      "</td><td>".$apel.", ".$nomb."</td><td>".$da["edad_calc"].
"</td><td>".ffec($da["f_ingreso"])."</td><td>".ffec($da["f_alta_laboral"])."</td><td>".$da["deno"]."</td><td>".$da["organismo"]."</td><td>".ffec($da["f_baja"])."</td></tr>";
	    };   
?>

</table>

</div>

<?php if(isset($conta)){ echo 'Total ';echo $conta;echo ' registros ';};?><br>


</body>
<script>
function ver(id){
	navega("rua_ver?id="+id);
}
</script>
</html>