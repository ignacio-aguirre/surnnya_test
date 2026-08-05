<?php
include("Funciones.php"); 
session_start();
noconsulta();
$_SESSION["prestacion"]="Edici&oacute;n Pedido de Recurso";
include("encabezado.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
$id=$_GET["iid"];
$ped=un_registro("select * from hogares_admision where idhogares_admision=".$id);
$lega=$ped["admi_legajo"];
$fped=ffec($ped['admi_fped']);
$nnya=un_registro("select concat(apellidos,' , ',nombres) as apyn, rib_anio,rib_numero,rib_reparticion from sujetos where sujetos.legajo=".$lega);
$apyn=$nnya["apyn"];
$rib=rib2($nnya);
$defe=opc_tabla("CM");
?>
</div>
<div class="container">
<h4><?php echo $apyn." ";
if($nnya["rib_anio"]>"2010"){echo $rib;} else {echo "<p class='text-danger'>ATENCI&Oacute;N! no tiene RIB. Proximamente ser&aacute; obligatorio</p>";};?></h4>
<form class="form-inline" action='admiedita_do' method="get" onsubmit="return valida_datos()">
<div class="form-group has-warning">
<label class="label-form" for="i_fped">Fecha de Pedido</label>
<input class="form-control" size='8' maxlength='10' name='fped' id='fped' value="<?php echo $fped?>" onblur='valida_fecha(this.id)'>
</div>
<div class="form-group has-warning">
<label class="label-form" for="deriv">Organismo Solicitante</label>
<select class='form-control' name='deriv' id='deriv' onblur='valida_derivante()'>
<option value='4'>CDNNYA</option>
<option value='1'>JUZGADO</option>
</select>
<script>
seleccionar("deriv",'<?php echo $ped["admi_deriv"]?>');

function valida_derivante(){
deriv=document.getElementById("deriv").value;
if(deriv==-1) return false;
if(deriv!=4){
  document.getElementById("defensoria").disabled=true;
  document.getElementById("equipo").disabled=true;
  document.getElementById("defensoria").value="0";
  document.getElementById("equipo").value="";
};
return true;
};
</script>
</div>
<hr>
<div class="form-group has-warning">
<label class="label-form" for="defensoria">Sector / DZ CDNNYA</label>
<select class="form-control" id='defensoria' name='defensoria' required>
<option value=""></option><?php echo $defe?></select>&nbsp;&nbsp;
<script>seleccionar('defensoria','<?php echo $ped["admi_deriv_sector"]?>');</script>
<label class="label-form" for="equipo">Equipo</label>
<input class="form-control" id='equipo' name='equipo' size='1' maxlength='1' onblur='valida_entero(this.id)'>
</div>
<hr>
<div class="form-group has-warning">
<label class="label-form" for="i_derc">Informaci&oacute;n Adicional s/solicitante</label>
<input class='form-control' size='50' maxlength='45' name='deriv_cual' id='deriv_cual' onblur='valida_0(this.id)' 
placeholder='Nro.Juzgado o persona que firma la solicitud, por ejemplo' value='<?php echo $ped["admi_deriv_cual"]?>'>
</div>
<br><br>
<div class="form-group has-warning">
<label class="label-form" for="i_proce">Sit.Socio Habitacional</label>
<select class="form-control" name='proc' id='proc'  onblur='hab_hospital()'><?php echo $_SESSION['Opc_Hoga_Proc'];?></select>
<script>seleccionar('proc','<?php echo $ped["admi_proc"]?>')</script>
<input class="form-control" size='40' maxlength='60' name='proc_cual' id='proc_cual' onblur='valida_0(this.id)' placeholder ='Si es hospital completar debajo, no aqu&iacute;'
 value='<?php echo $ped["admi_proc_cual"]?>'>&nbsp;
</div>
<br><br>
<div class="form-group has-warning">
<label class="label-form" for="hospital">Hospital</label>
<select class="form-control" id='hospital' name='hospital' onblur='sale_hospital()'>
<option value=""></option>
<?php echo $_SESSION['Opc_Hosp_At'];?></select>&nbsp;
<label class='label-form' for="halt">Alta Hosp./Fecha</label>
<select class="form-control" name='halt' id='halt'><option value=''>N/C</option><option value='0'>No</option><option value='1'>Si</option></select>&nbsp;
<script>
seleccionar("halt",'<?php echo $ped["admi_halt"]?>');
seleccionar("hospital",'<?php echo $ped["hospital"]?>');
</script>

<input class="form-control" size='10' maxlength='10' name='falt' id='falt' value='<?php echo ffec($ped["admi_falt"])?>' onblur='valida_fecha("falt","1")' >
</div>
<br><br>
<div class="form-group has-warning">
<label class='label-form' for="moti">Motivo Ingreso</label>
<select class="form-control" name='moti' id='moti' required><?php echo $_SESSION['Opc_Hoga_Ming'];?></select>&nbsp;&nbsp;
<script>
seleccionar("moti",'<?php echo $ped["admi_moti"]?>');
</script>
<label class='label-form' for='cate'>Categor&iacute;a</label>
<select class='form-control' name='cate' id='cate' required><?php echo $_SESSION['Opc_Hoga_Cate'];?></select>&nbsp;&nbsp;
<script>
seleccionar("cate",'<?php echo $ped["admi_cate"]?>');
</script>
</div>
<input type="hidden" name="legajo" value="<?php echo $lega;?>">
<input type="hidden" name="idd" value="<?php echo $id;?>">
<br><br>
<button class='form-control btn-primary' type='submit'>Continuar</button>
</form>
</div>

<script type="text/javascript">
enfoca('fped');
function hab_hospital(){
situ=document.getElementById('proc').value;
if(situ=="10" || situ=="11") {document.getElementById('hospital').style.display="inline";document.getElementById('proc_cual').placeholder="Detallar si el hospital es Otros";} else{document.getElementById('hospital').style.display='none';document.getElementById('proc_cual').placeholder="Si es hospital completar  all&iacute--->";};
return true;
}

function sale_hospital(){
llenah(document.getElementById("hospital"));
}

function llenah(esto){
document.getElementById("proc_cual").value=esto.options[esto.selectedIndex].text;
return true;
};


function valida_datos() {
var sc=<?php echo $_SESSION['glcons'];?>;
if(sc=="1"){alert("Su perfil es de solo consulta"); return false;};
if (!valida_derivante()) {alert("Indique solicitante");return false;};
if (document.getElementById("cate").value=="") {alert("Indique categoria");return false;};
if (document.getElementById("proc").value.length==0) {alert("Indique sit.socio habitacional");return false;};
if (document.getElementById("moti").value.length==0) {alert("Indique motivo de ingreso");return false;};
if (document.getElementById("fped").value.length==0) {alert("Indique Fecha de Pedido");return false;};
hoy="<?php echo $_SESSION['DiaHoy']?>";
if (fsql(document.getElementById("fped").value)>fsql(hoy)){alert("Nonono, no acepto fechas del futuro");return false;};
indica=document.getElementById("proc");
indi=indica.options[indica.selectedIndex].text;
halt=document.getElementById("halt").value;
if (indi.indexOf("Hosp")>-1&&halt=="") {alert("Indique si tiene alta en hospital");return false;};
return valida_derivante() && valida_det("proc_cual","proc","*DET*","Sit.S.Hab.")&& valida_det("falt","halt","S","Fecha Alta Hospitalaria");
}

function valida_det(objeto,indicador,cadena,tipo) {
indica=document.getElementById(indicador);
indi=indica.options[indica.selectedIndex].text;
obje=document.getElementById(objeto).value;
if (indi.indexOf(cadena)>-1&&obje=="") {alert("Complete detalles "+tipo);return false;};
return true;
}
</script>
</body>
</html>