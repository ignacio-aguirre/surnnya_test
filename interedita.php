<?php
include("Funciones.php");
session_start();
?>
<script type="text/javascript">
function valida_campos1() {
var oper=document.getElementById("oper");
if (oper.value.length==0) return false;
return true;
}



function valida_campos2() {
var lega=document.getElementById("lega");
var apel=document.getElementById("apel");
var nomb=document.getElementById("nomb");
var apod=document.getElementById("apod");
if(lega.value=="") return false;
return true;
}

function valida_campos3() {
var obse=document.getElementById("obse");
if (obse.value=="") return false;
if(obse.value.length>2048)  {status("excede tamaño máximo de texto");return false;};
return true;
}

function valida_obse() {
var obse=document.getElementById("obse");
var texto=obse.value;
while (texto.indexOf("'")>-1) texto=texto.replace("'",'"');
obse.value=texto;
}
</script>

<?php
$_SESSION["prestacion"]="Editar Intervenci&oacute;n";
if (!isset($_GET['iid'])) header ("Location: ".$_SESSION['menu']);
$opci="";
$id=$_GET['iid'];
$sql="select *, sectores.denominacion as dispo  from intervenciones inner join sectores on inter_dispo=sectores.id where idintervenciones=".$id;
$di = un_registro($sql);
$dispo=$di['inter_dispo'];
$ddisp=$di['dispo'];
$oper=$di['inter_oper'];
$lega=$di['inter_legajo'];
$apod="";
$tipo=$di['inter_tipo'];
$hosp=$di['inter_hosp'];
$obse=$di['inter_obse'];

$conn = registros("select valo, concat(info,'-',deno) as denom from tablas where tipo='TINT' order by denom");
$opci3="";
while ($da = mysqli_fetch_assoc($conn)) $opci3=$opci3."<option value='".$da['valo']."'>".$da['denom']."</option>";
$_SESSION['Hospitales']="<option value='0'>--Ninguno</option>";
$hos=registros("select * from salud_establecimientos order by descripcion");
while($h=mysqli_fetch_assoc($hos)){
$_SESSION['Hospitales']=$_SESSION['Hospitales']."<option value='".$h["idsalud_establecimientos"]."'>".$h["descripcion"]."</option>";
};


include("encabezado-test.php");
?>
</div>
<div class='container'>
<h3>Datos de la intervenci&oacute;n</h3>
<form class="form" method='GET' action='interedita1' onsubmit="return valida_campos1()" >
 <div class="table-responsive">
  <table class='table'>
   <tr class="bg-primary"><th>Efector</th><th>Operadores</th></tr>
   <tr><td><?php echo $ddisp;?></td><td><input id='oper' size='40' maxlength='45' name='ioper' onblur='valida_0("oper")' required value='<?php echo $oper;?>'></td>

<script langtype='text/javascript'>





</script>

<input type="hidden" name='iid' value='<?php echo $id;?>'/>

</tr>



</table>
</div>

<input class="form-control"type="submit" value="Modificar Datos">

</form>
<h3>NNYA Sujeto de la Intervenci&oacute;n: <?php echo un_campo("select concat(apellidos,' , ', nombres) from sujetos where legajo=".$lega)?></h3>
<h4>Clasificaci&oacute;n</h4>
<form class="form" method='GET' action='interedita3' onsubmit="return valida_campos3()" >
<div class="table-responsive">
<table class="table">
<tr class="bg-primary"><th>Tipo de Intervenci&oacute;n</th></tr>
<tr><td><select id='tipo' name='itipo'> <?php echo $opci3;?></select></td></tr>
<h4>Para acciones de Articulaci&oacute;n</h4>
<tr class="bg-primary"><th>Efector de Salud</th></tr>
<tr><td><select id="hosp" name="hosp"><?php echo $_SESSION["Hospitales"]?></select></td></tr>
</table>

<table class="table">

<tr class="bg-primary"><th>Resumen de la intervenci&oacute;n (m&aacute;ximo 2048 caracteres)</th></tr>

<tr><td><textarea cols="120" rows="10" name="iobse" onblur='valida_obse()' id="obse"><?php echo $obse;?></textarea></td></tr>

</table>
</div>

<input  type="hidden" name='iid' value='<?php echo $id;?>'/>

<script langtype='text/javascript'>

<?php if($tipo!="") echo "seleccionar('tipo','".$tipo."');"; ?>
<?php if($hosp!="") echo "seleccionar('hosp','".$hosp."');"; ?>

enfoca('oper');

</script>

<input class="form-control" type="submit" value="Modificar Datos">

</form>

</div>

</body>

</html>