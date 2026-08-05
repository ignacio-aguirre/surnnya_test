<?php

include("Funciones.php");

session_start();

$_SESSION["prestacion"]="Datos Familiares y Escolaridad";

include("encabezado.php");

if (!isset($_SESSION['gldispo'])|!isset($_GET['legajo'])) header ("Location: index");

registre();

$lega= $_GET["legajo"];

if ($lega=="" ) ("Location: ConsultaSujetos");


$snsd="<OPTION VALUE='1'>SI</OPTION><OPTION VALUE='0'>NO</OPTION><OPTION VALUE=''>S/D</OPTION>";

$snts="<OPTION VALUE='1'>SI</OPTION><OPTION VALUE='0'>NO</OPTION><OPTION VALUE='2'>En Tr&aacute;mite</OPTION><OPTION VALUE=''>S/D</OPTION>";
$_SESSION["posicion"]="3";
include("mnu_superior.php");

?>

<script type="text/javascript">

function muestraContenido3() {

    if(peticion.readyState == 4) {

      if(peticion.status == 200) {

	var zona=document.getElementById("gfa");

        zona.innerHTML=peticion.responseText;

};

};

}

</script>
<div class="container">
<h3>Grupo Familiar o Conviviente <a href='sujeactfamilia?legajo=<?php echo $lega;?>'>Modificar</a></h3>
<div class="responsive-table">
<table class="table">
<tr class="bg-primary" style="font-size:.8em"><th>Parentesco</th><th>Apellidos</th><th>Nombres</th><th>Edad</th><th>Meses</th><th>F.Act.</th><th>Vive</th><th>Ocupaci&oacute;n</th><th>Telefonos</th><th>Domicilio</th><th>Observaciones</th></tr>

<?php 
  $conn = registros("select *, fami_actedad as actu from sujetos_familia where baja is null and fami_legajo=".$lega." order by fami_paren");

  $conta=1;

  while ($da = mysqli_fetch_assoc($conn)) {

   $conta=$conta+1;

   if($conta % 2==0) {echo "<tr bgcolor='white'>";} else {echo "<tr bgcolor='#E6E6E6'>";};



   echo "<td><strong>".parentesco($da['fami_paren'])."</td><td><strong>".$da['fami_apellidos']."</td><td><strong>".$da['fami_nombres']."</td><td><strong>".$da['fami_edad']."</td><td><strong>".$da['fami_meses']."</td><td><strong>".ffec($da['actu'])."</td><td><strong>";

if ($da['fami_vive']==1) {echo"Si";} else {if(gettype($da['fami_vive'])=="NULL") {echo "S/D";} else echo "No";};

echo "</td><td><strong>".$da['fami_ocup'];

  echo"</td><td><strong>".$da['fami_tele'];

  echo"</td><td><strong>".$da['fami_domi'];

   echo "</td><td><strong>".$da['fami_obse']."</td></tr>";

  };

?>

</table>

</div>

<?php $grup=un_registro("select * from grupos left join grupos_legajos on idgrupos=grupo where grupo_legajo=".$lega);?>



<h3>Escolaridad <a href='sujeactescuela?legajo=<?php echo $lega;?>'>Modificar</a></h3>



<div class="responsive-table">

<table class="table">

<tr class="bg-primary"><th>Escuela</th><th>Localidad</th><th>Cuando</th><th>Ult.Nivel Cursado</th><th>Referente y Turno</th><th>Obs.</th></tr>

<?php 

 $conn = registros("select * from sujetos_escuela inner join localidades on esco_loca=idlocalidades where baja is null and esco_legajo=".$lega);

 $conta=1;

 while ($da = mysqli_fetch_assoc($conn)) {

   $conta=$conta+1;

   if($conta % 2==0) {echo "<tr bgcolor='white'>";} else {echo "<tr bgcolor='#E6E6E6'>";};

   echo "<td><strong>".$da['esco_nomb']."</td><td><strong>".$da['descripcion']."</td><td><strong>".$da['esco_cuan']."</td><td><strong>".$da['esco_nive']."</td><td><strong>".$da['esco_refe']."</td><td><strong>".$da['esco_obse']."</td>";

   echo "</td></tr>";

  };

?>

</table>
</div>
</div>
</body>
</html>