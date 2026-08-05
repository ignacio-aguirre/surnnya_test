<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Nueva Acci&oacute;n";
noconsulta();
if(!isset($_GET['lega'])){Redirect(".");}; 
$lega=$_GET['lega'];
$grup=un_campo("select grupos.apellidos from grupos_legajos left join grupos on grupo=idgrupos where grupo_legajo=".$lega);
$hogar=un_campo("select admi_hogar from hogares_admision where admi_legajo=".$lega." and admi_alta is not null and admi_baja is null");
$nhogar="";
if($hogar>"0") {$nhogar=un_campo("select nombre from dispositivos where dispositivos.id=".$hogar);};
$dispo=$_SESSION["gldispo"];
$ddisp=$_SESSION["glnombdispo"];
$gtipo=un_campo("select grupo_intervenciones from sectores where id=".$dispo);
$condicion=" where 1 ";
if($gtipo>"0") $condicion=" where tablas.tipo='TINT' and grupos_tipo like '%".$gtipo."%' "; 
$sql="select valo, concat(info,'-',deno) as denom from tablas ".$condicion." order by denom";
$conn = registros($sql);
$opci3="";
while ($da = mysqli_fetch_assoc($conn)) $opci3=$opci3."<option value='".$da['valo']."'>".$da['denom']."</option>";
$_SESSION['Hospitales']="<option value='0'>--Ninguno</option>";
$hosp=registros("select * from salud_establecimientos order by descripcion");
while($h=mysqli_fetch_assoc($hosp)){
$_SESSION['Hospitales']=$_SESSION['Hospitales']."<option value='".$h["idsalud_establecimientos"]."'>".$h["descripcion"]."</option>";
};


$oper=substr($_SESSION['glusua'],0,stripos($_SESSION['glusua'],","));
include("encabezado-test.php")
?>

</div>
<div class="container">
<h2><?php echo un_campo("select concat(Apellidos,', ',Nombres) from sujetos where legajo=".$lega);?></h2>
<h2>Datos de la Acci&oacute;n</h2>
<div class="table-responsive">
<table class="table">

<tr class="bg-primary"><th>Efector</th><th>Fecha</th><th>Agentes Participantes</th><th>Legajo</th></tr>

<tr><td><?php echo $ddisp;?></td><input type='hidden' name='idispo' id='disp' value='<?php echo $_SESSION["gldispo"];?>'>

<td><input id='fecha' name='ifecha' size='10' maxlength='10' onblur='valida_fecha(this.id)' value='<?php echo $_SESSION["DiaHoy"]?>' disabled></td>

<td><input id='oper' size='30' maxlength='45'  onblur='valida_0("oper")' value='<?php echo $oper;?>'></td>
<td><input size="6" maxlength='6' readonly id="lega" value="<?php echo $lega;?>"></td>
</tr>
</table>
</div>
<input type='hidden' id='dispo' value='<?php echo $dispo;?>'>

<div class="table-responsive">
<table class="table">
<tr class="bg-primary"><th>Tipo de Acci&oacute;n</th></tr>

<tr><td><select id='tipo' name='itipo'> <?php echo $opci3;?></select></td></tr>
</table>
<h4>Para acciones de articulaci&oacute;n</h4>

<table class="table">
<tr class="bg-primary"><th>Efector de Salud</th></tr>
<tr><td><select id="hosp" name="hosp"><?php echo $_SESSION["Hospitales"]?></select></td></tr>

</table>
</div>

<div class="table-responsive">
<h4>Replicaci&oacute;n</h4>

<table class="table">

<tr class="bg-primary"><th>Grupo de Hermanos</th><th>Hogar</th></tr>

<tr><td><input type='text' readonly id='grup'>&nbsp;<input type="checkbox" name="todos" id="todos" checked value="todos">&nbsp;Replicar en Todos los Hermanos<br></td>
<td><input type='text' readonly id='hogar' value="<?php echo $nhogar?>">&nbsp;<input type="checkbox" name="todos_delhogar" id="todos_delhogar" <?php echo si($_SESSION["gldispo"]=="12",""," readonly ")?> value="todos">&nbsp;Replicar en todos los NNYA de este hogar</td></tr>

</table>
<table class="table">

<tr class="table-responsive">

<th>Resumen de la acci&oacute;n (m&aacute;ximo 2048 caracteres) - Actual: <input type='text' size='2' readonly id='usado'></th>

</tr>

<tr>

<td><textarea class="form-control" cols="120" rows="10" name="iobse" onkeyup="limite('obse','2048','usado')" onblur='valida_obse()' id="obse"></textarea></td>

</tr>

</table>
</div>

<button class='btn-primary' onclick='enviardatos()'>Registrar</button>

</div>

<script langtype='text/javascript'>
enfoca('oper');
todos = document.getElementById('todos');
todos.checked=false;
document.getElementById("grup").value="<?php echo $grup?>";
</script>


</div>
</body>



<script type="text/javascript">

if("<?php echo $_SESSION['gldispo']?>"=="12"||"<?php echo $_SESSION['gldispo']?>"=="2") document.getElementById("fecha").disabled=false;

function valida_obse() {

var obse=document.getElementById("obse");

var texto=obse.value;

while (texto.indexOf("'")>-1) texto=texto.replace("'",'"');
while (texto.indexOf("%")>-1) texto=texto.replace("%",'por ciento');

obse.value=texto;

}



function enviardatos(){
valida_fecha("fecha");
valida_0("oper");
valida_obse();
var fecha=document.getElementById("fecha").value;
var dispo=document.getElementById("dispo").value;
var oper=document.getElementById("oper").value;
var lega=document.getElementById("lega").value;
var tipo=document.getElementById("tipo").value;
var hosp=document.getElementById("hosp").value;
var obse=document.getElementById("obse").value;
var todos=document.getElementById("todos").checked;
var grup=document.getElementById("grup");
var hogar="<?php echo $hogar?>";
if(todos && grup) {todo="1";} else todo="0";
var todo_hogar=document.getElementById("todos_delhogar").checked;
if(todo_hogar && hogar!="") {todohogar="1";} else todohogar="0";
ok=true;
if(fecha=="") {alert("debe completar fecha");return false;};
if(oper=="") {alert("debe completar operador");return false;};
navega("nuevainter2?fecha="+fecha+"&lega="+lega+"&oper="+oper+"&tipo="+tipo+"&hosp="+hosp+"&obse="+obse+"&todo="+todo+"&todohogar="+todohogar);
return true;
}
</script>
</html>