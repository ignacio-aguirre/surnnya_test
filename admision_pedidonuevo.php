<?php
include("Funciones.php"); 
session_start();
noconsulta();
$_SESSION["prestacion"]="Nuevo Pedido de Recurso";
include("encabezado-test.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
$lega=$_GET["legajo"];
$fped=$_SESSION['DiaHoy'];
$idd="";
if(isset($_GET["fecha"])) $fped=$_GET["fecha"];
if(isset($_GET["idd"])) $idd=$_GET["idd"];
$deno=un_campo("select concat(apellidos,', ', nombres) as deno from sujetos where legajo=".$lega);
$cantidad=un_campo("select count(*) from hogares_admision where admi_legajo=".$lega." and admi_susp is null and admi_fped is not null and admi_alta is null");
?>
</div>
<div class="container">
<h4><?php echo $deno;?></h4>
<?php if($cantidad>"0") die("Hay un pedido de recurso vigente para este NNYA<br>Presion&aacute; (atr&aacute;s) para continuar");?>
<form class="form-inline" action='admision_pedidonuevo_do' method="get" onsubmit="return valida_datos()">
<div class="form-group has-warning">
<label class="label-form" for="i_fped">Fecha de Pedido</label>
<input class="form-control" size='8' maxlength='10' name='ifped' id='i_fped' onblur='valida_fecha(this.id)' required>
</div>
<div class="form-group has-warning">
<label class="label-form" for="i_deriv">Organismo Solicitante</label>
<select class='form-control' name='ideriv' id='i_deriv' onblur='valida_derivante()'>
<option value='4'>CDNNYA</option>
<option value='1'>JUZGADO</option>
</select>
</div>
<hr>
<div class="form-group has-warning">
<label class="label-form" for="defensoria">Sector / DZ CDNNYA</label>
<select class="form-control" id='defensoria' name='defensoria' required><option value=""></option><?php echo opc_tabla("CM");?></select>&nbsp;&nbsp;
<label class="label-form" for="equipo">Equipo</label>
<input class="form-control" id='equipo' name='equipo' size='1' maxlength='1' onblur='valida_entero(this.id)'>
</div>
<hr>
<div class="form-group has-warning">
<label class="label-form" for="i_derc">Informaci&oacute;n Adicional s/solicitante</label>
<input class='form-control' size='50' maxlength='45' name='iderc' id='i_derc' onblur='valida_0("i_derc")' placeholder='Nro.Juzgado o persona que firma la solicitud, por ejemplo'>

</div>

<br><br>


<div class="form-group has-warning">

<label class="label-form" for="i_proce">Sit.Socio Habitacional</label>

<select class="form-control" name='iproced' id='i_proce'  onblur='hab_hospital()' required><?php echo $_SESSION['Opc_Hoga_Proc'];?></select>

<input class="form-control" size='40' maxlength='60' name='iprcc' id='i_prcc' onblur='valida_0(this.id)' placeholder ='Si es hospital completar debajo, no aqu&iacute;'>&nbsp;

</div>

<br><br>

<div class="form-group has-warning">

<label class="label-form" for="hospital">Hospital</label>

<select class="form-control" id='hospital' name='hospital' onblur='sale_hospital()'>
<option value=""></option><?php echo $_SESSION['Opc_Hosp_At'];?>
</select>&nbsp;
<label class='label-form' for="i_ahos">Alta Hosp./Fecha</label>

<select class="form-control" name='iahos' id='i_ahos'><option value=''>N/C</option><option value='0'>No</option><option value='1'>Si</option></select>&nbsp;

<input class="form-control" size='10' maxlength='10' name='ifaho' id='i_faho' onblur='valida_fecha("i_faho","1")' >

</div>

<br><br>

<div class="form-group has-warning">

<label class='label-form' for="i_moting">Motivo Ingreso</label>

<select class="form-control" name='imoting' id='i_moting' required><?php echo $_SESSION['Opc_Hoga_Ming'];?></select>&nbsp;&nbsp;

<label class='label-form' for='i_categ'>Categor&iacute;a</label>

<select class='form-control' name='icateg' id='i_categ' required><?php echo $_SESSION['Opc_Hoga_Cate'];?></select>&nbsp;&nbsp;

<label class='label-form' for='i_fact'>Cat.Liquidaci&oacute;n</label>

<input class='form-control' size='3' maxlength='3' name='ifact' id='i_fact' onblur='valida_0(this.id)'>&nbsp;&nbsp;

<label class='label-form' for='i_urge'>Urgente</label>

<select class='form-control' name='iurge' id='i_urge'><option value='0'>No</option><option value='1'>Si</option></select>

</div>

<br><br>

<div class="form-group has-warning">

<label class='label-form' for='i_admi'>Admisor</label>

<input class='form-control' size='45' maxlength='45' name='admisor' id='i_admi' onblur='valida_0("i_admi")' value='<?php echo substr($_SESSION['glusua'],0,stripos($_SESSION['glusua'],","))?>'>&nbsp;&nbsp;

<label class='label-form'>Observaciones</label>

<input class='form-control' size='45' maxlength='45' name='iobse' id='i_obse' onblur='valida_0("i_obse")'>

<input type="hidden" name="legajo" value="<?php echo $lega;?>">

<input type="hidden" name="idd" value="<?php echo $idd;?>">

</div>

<br><br>

<button class='form-control btn-primary' type='submit'>Continuar</button>

</form>

</div>



<script type="text/javascript">

enfoca('i_fped');

function hab_hospital(){

situ=document.getElementById('i_proce').value;

if(situ=="10" || situ=="11") {document.getElementById('hospital').style.display="inline";document.getElementById('i_prcc').placeholder="Detallar si el hospital es Otros";} else{document.getElementById('hospital').style.display='none';document.getElementById('i_prcc').placeholder="Si es hospital completar  all&iacute--->";};



return true;

}



function sale_hospital(){

llenah(document.getElementById("hospital"));

}

function llenah(esto){

document.getElementById("i_prcc").value=esto.options[esto.selectedIndex].text;

return true;

};



function valida_datos() {

var sc=<?php echo $_SESSION['glcons'];?>;

if(sc=="1"){alert("Su perfil es de solo consulta"); return false;};

if (!valida_derivante()) {alert("Indique solicitante");return false;};

if (document.getElementById("i_categ").value=="") {alert("Indique categoria");return false;};

if (document.getElementById("i_proce").value.length==0) {alert("Indique sit.socio habitacional");return false;};

if (document.getElementById("i_moting").value.length==0) {alert("Indique motivo de ingreso");return false;};

if (document.getElementById("i_fped").value.length==0) {alert("Indique Fecha de Pedido");return false;};

hoy="<?php echo $_SESSION['DiaHoy']?>";

if (fsql(document.getElementById("i_fped").value)>fsql(hoy)){alert("Nonono, no acepto fechas del futuro");return false;};

indica=document.getElementById("i_proce");

indi=indica.options[indica.selectedIndex].text;

halt=document.getElementById("i_ahos").value;

if (indi.indexOf("Hosp")>-1&&halt=="") {alert("Indique si tiene alta en hospital");return false;};



return valida_derivante() && valida_det("i_prcc","i_proce","*DET*","Sit.S.Hab.")&& valida_det("i_faho","i_ahos","S","Fecha Alta Hospitalaria");

}



function valida_det(objeto,indicador,cadena,tipo) {

indica=document.getElementById(indicador);

indi=indica.options[indica.selectedIndex].text;

obje=document.getElementById(objeto).value;

if (indi.indexOf(cadena)>-1&&obje=="") {alert("Complete detalles "+tipo);return false;};

return true;

}



function valida_derivante(){

deriv=document.getElementById("i_deriv").value;

if(deriv==-1) return false;

if(deriv==4){

  document.getElementById("defensoria").disabled=false;

  document.getElementById("equipo").disabled=false;

  if(document.getElementById("defensoria").value<1) return false; 

} else {

  document.getElementById("defensoria").disabled=true;

  document.getElementById("equipo").disabled=true;

  document.getElementById("defensoria").value="0";

  document.getElementById("equipo").value="";

};

return true;

};

</script>



</body>

</html>