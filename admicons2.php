<?php
include("Funciones.php");
session_start();
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
include("encabezado-test.php");
$opci=str_replace("Completar","Todas",$_SESSION["Opc_Hoga_Cate"]);
$cate="";
$esta="A";
$hogar="";
?>

<div class="container">
<?php
if(isset($_GET['mensaje']))  echo $_GET['mensaje']."<br>";?>
<form class="form-inline" enctype="multipart/form-data">
<div class="form-group has-warning">
 <label class="label-form" for="i_cate">Categor&iacute;as</label>
 <select class="form-control" name="icate" id="i_cate"><?php echo $opci;?></select>
</div>

<div class="form-group has-warning">
 <label class="label-form" for="i_esta">Estados</label>
 <select class="form-control"  name="iesta" id="i_esta"><option value=''>---Todos</option><option value='A'>Activos</option><option value='S'>Suspendidos</option></select>
</div>

<div class="form-group has-warning">
<label class="label-form" for="i_hoga">Hogar</label>
<select class="form-control" name="ihogar" id="i_hoga"><?php echo str_replace("Completar","Todos",$_SESSION['Opc_Hoga']);?></select>
</div>

<input name="submit" type="submit" value="Consultar" />
</form>
<div class="table-responsive">
<table class='table table-striped table-bordered'>

<tr><th>Acciones</th><th>Hogar</th><th>Apellido y Nombre</th><th>Edad (hoy)</th><th>Fecha Asign.</th><th>Categor&iacute;a</th><th>Admisor</th><th>Derivante</th><th>Sit.Socio Hab.</th>



<?php

if (isset($_GET["icate"]))

{

$cate=$_GET["icate"];

$hogar=$_GET["ihogar"];

$esta=$_GET["iesta"];

echo "<script type='text/javascript'>seleccionar('i_cate','".$cate."');seleccionar('i_esta','".$esta."');seleccionar('i_hoga','".$hogar."');</script>";

        

	$sql="select hogares_admision.*, datediff(curdate(),admi_fderiv) as dife, sujetos.legajo , Apellidos, Nombres, edadcalc(f_nacimiento,sujetosEdad,sujetosMeses,SujetosActEdad,curdate()) as edad_calc ,hogares_ca.deno as dcate, hogares_de.deno as deriv ,  hogares_proc.deno as proc,  case when tipo_dispositivo=1 then concat('AF: ',af_familias.denominacion) else nombre end as hogar from hogares_admision  left join sujetos on admi_legajo=sujetos.legajo 
        left join tablas hogares_de on admi_deriv=hogares_de.valo and hogares_de.tipo='ADDER' ";
	$sql=$sql." left join tablas hogares_ca on admi_cate=hogares_ca.valo and hogares_ca.tipo='ADDER' ";

	$sql=$sql." left join tablas hogares_proc on admi_proc=hogares_proc.valo and hogares_proc.tipo='HOSSH' ";

	

	$sql=$sql." left join dispositivos on admi_hogar=dispositivos.id ";

	$sql=$sql." left join af_familias on admi_fami=idaf_familias ";



	$sql=$sql." where admi_fderiv is not null and admi_alta is null";

        if($esta=="A") $sql=$sql." and admi_susp is null ";

        if($esta=="S") $sql=$sql." and admi_susp is not null ";

        if($hogar!='')  $sql=$sql." and admi_hogar=".$hogar;

	$sql=$sql." order by  admi_fderiv desc,Apellidos,Nombres ";

	$conn = registros($sql);

	$conta=1;

	while ($da = mysqli_fetch_assoc($conn)) {

         if ($cate==""||$da['admi_cate']==$cate) {

         $conta=$conta+1;

         $apel=$da["Apellidos"];

	 $nomb= $da["Nombres"];

	 echo "<tr><td>";
              if(gettype($da["admi_susp"])=="NULL" && $_SESSION['glcons']!="1") echo "<a href='admialta?iid=".$da["idhogares_admision"]."'>ALTA</a>*";

              if(gettype($da["admi_susp"])=="NULL" && $_SESSION['glcons']!="1") echo "<a href='admisusp?iid=".$da["idhogares_admision"]."'><img height='15' width='15' src='imagenes/pausa.png'></a>";

              echo "*<a href='admigest?iid=".$da["idhogares_admision"]."'>GES</a>";

              echo "</td>";

	      echo "<td>".$da["hogar"]."</td>";

      	      echo "<td>".$apel." , ".$nomb."</td>";

      	      echo "<td>".$da["edad_calc"]."</td>";              	

	      echo "<td>".ffec($da["admi_fderiv"])."</td>";	

	      echo "<td>".$da["dcate"]."</td>";

	      echo "<td>".$da["admi_admi"]."</td>";

	      echo "<td>".$da["deriv"]."</td>";

	      echo "<td>".$da["proc"]."</td>";

      	      echo "</tr>";};};	

	



};



?>

</table>

<?php if(isset($conta)){ echo 'Total ';echo $conta-1;echo ' registros ';};?>

</div></div>

<script type="text/javascript">enfoca("i_cate");seleccionar("i_esta","A");</script>

</body>

</html>