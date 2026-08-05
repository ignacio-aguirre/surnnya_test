<?php
include("Funciones.php"); 
session_start();
$_SESSION["prestacion"]="Desvincular Archivos de un Alta";
include("encabezado-test.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
registre();

$id=$_GET["id"];
$r=un_registro("select operacion, vacante, nota, nota_derivacion from altasybajas where idaltasybajas=".$id);
$iid=$r["vacante"];
$sql="select admi_alta,admi_baja, Apellidos, Nombres, nombre as hogar from hogares_admision left join sujetos on legajo=admi_legajo left join dispositivos on dispositivos.id=admi_hogar where idhogares_admision=".$iid;
$da = un_registro($sql);
?>

</div>

<div class="container">
<?php echo $da["Apellidos"].", ".$da["Nombres"]."<br>";
  echo "Fecha Alta:".ffec($da["admi_alta"])."<br>";
  echo "Hogar: ".$da["hogar"]."<br>";
  if($da["admi_baja"]!="") echo "Fecha Baja:".ffec($da["admi_baja"])."<br><hr>";
  echo "<div class='row'>";
  if($r["operacion"]=="A"){
	echo "<div class='col-md-4'>Nota de Alta</div>
        <div class='col-md-4'>Nota Derivaci&oacute;n</div></div>
	<div class='row'>
         <div class='col-md-4'>".si($r["nota"]>"0","<a href='alta_desvincular?id=".$id."&tipo=NA'>Desvincular</a>","")."</div>
         <div class='col-md-4'>".si($r["nota_derivacion"]>"0","<a href='alta_desvincular?id=".$id."&tipo=ND&todos=1'>Desvincular de Alta y Legajo</a><br>
<a href='alta_desvincular?id=".$id."&tipo=ND&todos=0'>Desvincular Solo del Alta</a>","")."</div></div>";
  }
  else{
	echo "<div class='col-md-4'>Nota de Baja</div></div>
        <div class='row'>
        <div class='col-md-4'>".si($r["nota"]>"0","<a href='alta_desvincular?id=".$id."&tipo=NA'>Desvincular</a>","")."</div></div>";
   
  }; 	
?>

</div>

</body>

</html>