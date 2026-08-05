<?php 
include("funciones.php");
session_start();
localidades();
$nnya=$_SESSION["nnnya_actual"];
$hogar=$_SESSION["hogar"];
$_SESSION["prestacion"]="Salud Mental";
$nya=un_registro("select * from alojados where idalojados=".$nnya);
include("encabezado.php");
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$trimestral=un_campo("select trimestral from trim_salud_mental where legajo=".$nnya." and hogar=".$hogar." and trimestre=".$trimestre." and anio=".$anio);
if($trimestral>"0"){$tri=un_registro("select * from trim_salud_mental where trimestral=".$trimestral);}
else{$tri=un_registro("select * from trim_salud_mental where legajo=".$nnya." and hogar=".$hogar." order by anio desc, trimestre desc limit 1");};

$esmen=opc_tabla("ESMEN");
$esab=opc_tabla("ESAB");
?>
</div>
<div class="container">
<form class="form" action="salud_mental_do" method="post" onsubmit="return guardar()">
<ul class="list-group">
<li class="list-group-item text-primary">Apellidos:<strong><?php echo $nya["apellidos"]?></strong>&nbsp;-&nbsp;Nombres:<strong><?php echo $nya["nombres"]?></strong>&nbsp;-&nbsp;
<strong><?php echo "Trimestre ".$trimestre." ".$anio?></strong></li>
<li class="list-group-item">Realiz&oacute; Tratamiento durante el Trimestre: <select class="form-control" id="en_tratamiento" name="en_tratamiento" onblur="sale_entto()" autofocus><?php echo nosi()?></select></li>
<li class="list-group-item text-warning">Indic&aacute; los efectores y profesionales tratantes.</li>
<li class="list-group-item"> 1: Jurisdicci&oacute;n: <select class="form-control" id="juris_em1" name="juris_em1" onchange="efectores(this.id)"><option value="0">(vac&iacute;o)</option><option value="1">CABA</option><option value="2">PBA</option></select>&nbsp;
<select class="form-control" id="em_1" name="em_1"></select>&nbsp;
Profesional:<input class="form-control" id="pm_1" name="pm_1" size="30" maxlength="45" onblur="valida_0(this.id)"></li>
<li class="list-group-item"> 2: Jurisdicci&oacute;n: <select class="form-control" id="juris_em2" name="juris_em2" onchange="efectores(this.id)"><option value="0">(vac&iacute;o)</option><option value="1">CABA</option><option value="2">PBA</option></select>&nbsp;
<select class="form-control" id="em_2" name="em_2"></select>&nbsp;
Profesional:<input class="form-control" id="pm_2" name="pm_2" size="30" maxlength="45" onblur="valida_0(this.id)">&nbsp;</li>
<li class="list-group-item"> 3: Jurisdicci&oacute;n: <select class="form-control" id="juris_em3" name="juris_em3" onchange="efectores(this.id)"><option value="0">(vac&iacute;o)</option><option value="1">CABA</option><option value="2">PBA</option></select>&nbsp;
<select class="form-control" id="em_3" name="em_3"></select>&nbsp;
Profesional:<input class="form-control" id="pm_3" name="pm_3" size="30" maxlength="45" onblur="valida_0(this.id)">&nbsp;</li>
<li class="list-group-item"> 4: Jurisdicci&oacute;n: <select class="form-control" id="juris_em4" name="juris_em4" onchange="efectores(this.id)"><option value="0">(vac&iacute;o)</option><option value="1">CABA</option><option value="2">PBA</option></select>&nbsp;
<select class="form-control" id="em_4" name="em_4"></select>&nbsp;
Profesional:<input class="form-control" id="pm_4" name="pm_4"size="30" maxlength="45" onblur="valida_0(this.id)">&nbsp;</li>

<li class="list-group-item">Especialidades 1 :<select class="form-control" id="espec_sm1" name="espec_sm1"><?php echo opc_tabla("ESPSM")?></select>&nbsp;

2 :<select class="form-control" id="espec_sm2" name="espec_sm2"><?php echo opc_tabla("ESPSM")?></select>&nbsp;3 :<select class="form-control" id="espec_sm3" name="espec_sm3"><?php echo opc_tabla("ESPSM")?></select>&nbsp;

4 :<select class="form-control" id="espec_sm4" name="espec_sm4"><?php echo opc_tabla("ESPSM")?></select></li>
<li class="list-group-item">Internaci&oacute;n: <select class="form-control" id="sm_internacion" name="sm_internacion"><?php blancosino();?></select></li>

<li class="list-group-item">Tiene Plan de Medicaci&oacute;n: <select class="form-control" id="plan_medicacion" name="plan_medicacion" onblur="sale_plan()"><?php blancosino();?></select></li>

<li class="list-group-item">&Uacute;ltimo Plan (medicamentos, dosis diarias)<textarea id="plan_detalle" name="plan_detalle" rows="4" cols="60" class="form-control">
<?php echo $tri["plan_detalle"]?></textarea></li>

<li class="list-group-item">M&eacute;dico Control Psicofarmacol&oacute;gico: <select class="form-control" id="plan_efector" name="plan_efector" onfocus="arma_efectores()"></select></li>

<li class="list-group-item">Descripci&oacute;n de la situaci&oacute;n de salud mental durante el per&iacute;odo<textarea class="form-control" id="sm_observaciones" name="sm_observaciones" rows="15" cols="90" class="form-control">
<?php echo $tri["sm_observaciones"]?></textarea></li>

<li class="list-group-item">Tuvo Acompa&ntilde;amiento terap&eacute;utico durante el trimestre: <select class="form-control" id="at_tuvo" name="at_tuvo" onblur="sale_at()" required><?php blancosino();?></select></li>
<li class="list-group-item">Prestador: <select class="form-control" id="at_prestador" name="at_prestador"><?php echo opc_tabla("ATPSM");?></select></li>
<li class="list-group-item">Esquema de d&iacute;as y horarios<textarea class="form-control" id="at_esquema" name="at_esquema" rows="15" cols="90" class="form-control">
<?php echo $tri["at_esquema"]?></textarea></li>

</ul>

<button class="btn-primary" id="aceptar" >Guardar Cambios</button>
</form>

</div>

<script>
function efectores(id){
idcampo="em_"+id.substr(-1);
if(document.getElementById(id).value=="0") {document.getElementById(idcampo).innerHTML="";};
if(document.getElementById(id).value=="1") {document.getElementById(idcampo).innerHTML="<?php echo $esmen?>";document.getElementById(idcampo).focus();};
if(document.getElementById(id).value=="2") {document.getElementById(idcampo).innerHTML="<?php echo $esab?>";document.getElementById(idcampo).focus();};
return true;
}

seleccionar("en_tratamiento","<?php echo $tri["en_tratamiento"]?>");
seleccionar("juris_em1","<?php echo $tri['juris_em1'];?>");
seleccionar("juris_em2","<?php echo $tri['juris_em2'];?>");
seleccionar("juris_em3","<?php echo $tri['juris_em3'];?>");
seleccionar("juris_em4","<?php echo $tri['juris_em4'];?>");
efectores("juris_em1");
efectores("juris_em2");
efectores("juris_em3");
efectores("juris_em4");

seleccionar("em_1","<?php echo $tri["em_1"]?>");
document.getElementById("pm_1").value="<?php echo comillas($tri["pm_1"])?>";
seleccionar("em_2","<?php echo $tri["em_2"]?>");
document.getElementById("pm_2").value="<?php echo comillas($tri["pm_2"])?>";
seleccionar("em_3","<?php echo $tri["em_3"]?>");
document.getElementById("pm_3").value="<?php echo comillas($tri["pm_3"])?>";
seleccionar("em_4","<?php echo $tri["em_4"]?>");
document.getElementById("pm_4").value="<?php echo comillas($tri["pm_4"])?>";
seleccionar("espec_sm1","<?php echo $tri["espec_sm1"]?>");
seleccionar("espec_sm2","<?php echo $tri["espec_sm2"]?>");
seleccionar("espec_sm3","<?php echo $tri["espec_sm3"]?>");
seleccionar("espec_sm4","<?php echo $tri["espec_sm4"]?>");
seleccionar("sm_internacion","<?php echo $tri["sm_internacion"]?>");
seleccionar("plan_medicacion","<?php echo $tri["plan_medicacion"]?>");
seleccionar("at_tuvo","<?php echo $tri["at_tuvo"]?>");
seleccionar("at_prestador","<?php echo $tri["at_prestador"]?>");

arma_efectores();
document.getElementById("plan_efector").value="<?php echo comillas($tri["plan_efector"])?>";

function sale_plan(){
  if(plan_medicacion.value!=1){
    plan_detalle.value="";
    plan_detalle.disabled=true;
    plan_efector.value="";
    plan_efector.disabled=true;
  }
  else{
    plan_detalle.disabled=false;
    plan_efector.disabled=false;

  };
 return true;
}
function sale_at(){
 if(at_tuvo.value!=1){
    seleccionar("at_prestador","");
    at_prestador.disabled=true;
    at_esquema.value="";
    at_esquema.disabled=true;
  }
  else{
	at_prestador.disabled=false;
    at_esquema.disabled=false;

  };
 return true;

}

function sale_entto(){

en_tratamiento=document.getElementById("en_tratamiento").value;

if(en_tratamiento!=1){

  document.getElementById("juris_em1").value="0";
  document.getElementById("em_1").value="";
  document.getElementById("pm_1").value="";
  document.getElementById("juris_em2").value="0";
  document.getElementById("em_2").value="";
  document.getElementById("pm_2").value="";
  document.getElementById("juris_em3").value="0";
  document.getElementById("em_3").value="";
  document.getElementById("pm_3").value="";
  document.getElementById("juris_em4").value="0";
  document.getElementById("em_4").value="";
  document.getElementById("pm_4").value="";


  document.getElementById("espec_sm1").value=0;

  document.getElementById("espec_sm2").value=0;

  document.getElementById("espec_sm3").value=0;

  document.getElementById("espec_sm4").value=0;

  document.getElementById("sm_internacion").value=0;

  document.getElementById("plan_medicacion").value=0;

  document.getElementById("plan_detalle").value="";

  document.getElementById("plan_efector").value=0;


  document.getElementById("juris_em1").disabled=true;
  document.getElementById("juris_em2").disabled=true;
  document.getElementById("juris_em3").disabled=true;
  document.getElementById("juris_em4").disabled=true;
  document.getElementById("em_1").disabled=true;
  document.getElementById("pm_1").disabled=true;
  document.getElementById("em_2").disabled=true;
  document.getElementById("pm_2").disabled=true;
  document.getElementById("em_3").disabled=true;
  document.getElementById("pm_3").disabled=true;
  document.getElementById("em_4").disabled=true;
  document.getElementById("pm_4").disabled=true;

  document.getElementById("espec_sm1").disabled=true;

  document.getElementById("espec_sm2").disabled=true;

  document.getElementById("espec_sm3").disabled=true;

  document.getElementById("espec_sm4").disabled=true;
  document.getElementById("sm_internacion").disabled=true;

  document.getElementById("plan_medicacion").disabled=true;

  document.getElementById("plan_detalle").disabled=true;

  document.getElementById("plan_efector").disabled=true;





} else



{

  document.getElementById("juris_em1").disabled=false;
  document.getElementById("juris_em2").disabled=false;
  document.getElementById("juris_em3").disabled=false;
  document.getElementById("juris_em4").disabled=false;
  document.getElementById("em_1").disabled=false;
  document.getElementById("pm_1").disabled=false;
  document.getElementById("em_2").disabled=false;
  document.getElementById("pm_2").disabled=false;
  document.getElementById("em_3").disabled=false;
  document.getElementById("pm_3").disabled=false;
  document.getElementById("em_4").disabled=false;
  document.getElementById("pm_4").disabled=false;


  document.getElementById("espec_sm1").disabled=false;

  document.getElementById("espec_sm2").disabled=false;

  document.getElementById("espec_sm3").disabled=false;

  document.getElementById("espec_sm4").disabled=false;

  document.getElementById("sm_internacion").disabled=false;
  document.getElementById("plan_medicacion").disabled=false;

  document.getElementById("plan_detalle").disabled=false;

  document.getElementById("plan_efector").disabled=false;


};



}


function arma_efectores(){
obj=document.getElementById("plan_efector");
valor=obj.value;
obj.options.length=0;
if(document.getElementById("pm_1").value!="") {
	var opcion = document.createElement("option");
	opcion.text=document.getElementById("pm_1").value+" "+em_1.options[em_1.selectedIndex].text;
        opcion.value="1";
	obj.options.add(opcion);
};
if(document.getElementById("pm_2").value!="") {
	var opcion = document.createElement("option");
	opcion.text=document.getElementById("pm_2").value+" "+em_2.options[em_2.selectedIndex].text;
        opcion.value="2";
	obj.options.add(opcion);
};
if(document.getElementById("pm_3").value!="") {
	var opcion = document.createElement("option");
	opcion.text=document.getElementById("pm_3").value+" "+em_3.options[em_3.selectedIndex].text;
        opcion.value="3";
	obj.options.add(opcion);
};
if(document.getElementById("pm_4").value!="") {
	var opcion = document.createElement("option");
	opcion.text=document.getElementById("pm_4").value+" "+em_4.options[em_4.selectedIndex].text;
        opcion.value="4";
	obj.options.add(opcion);
};
seleccionar("plan_efector",valor);

}

function guardar(){

sale_entto();

en_tratamiento=document.getElementById("en_tratamiento").value;
if(en_tratamiento!="1" && en_tratamiento!="2"){status("En tratamiento es obligatorio");return false;};
juris_em1=document.getElementById("juris_em1").value;
em_1=document.getElementById("em_1").value;
if(!em_1>"0" && en_tratamiento=="1"){status("campo efector es obligatorio");return false;};

pm_1=document.getElementById("pm_1").value;
juris_em2=document.getElementById("juris_em2").value;
em_2=document.getElementById("em_2").value;
pm_2=document.getElementById("pm_2").value;
juris_em3=document.getElementById("juris_em3").value;
em_3=document.getElementById("em_3").value;
pm_3=document.getElementById("pm_3").value;
juris_em4=document.getElementById("juris_em4").value;
em_4=document.getElementById("em_4").value;
pm_4=document.getElementById("pm_4").value;
espec_sm1=document.getElementById("espec_sm1").value;
if(espec_sm1=="0" && en_tratamiento=="1"){status("campo especialidad es obligatorio");return false;};

espec_sm2=document.getElementById("espec_sm2").value;
espec_sm3=document.getElementById("espec_sm3").value;
espec_sm4=document.getElementById("espec_sm4").value;
sm_internacion=document.getElementById("sm_internacion").value;
plan_medicacion=document.getElementById("plan_medicacion").value;
if(plan_medicacion=="0" && en_tratamiento=="1"){status("campo plan medicacion es obligatorio");return false;};

plan_detalle=document.getElementById("plan_detalle").value;
plan_efector=document.getElementById("plan_efector").value;
sm_observaciones=document.getElementById("sm_observaciones").value;
if(sm_observaciones==""){status("campo descripcion es obligatorio");return false;};
status("");
if(confirm("Cancela para hacer modificaciones o revisar. Acepta para guardar datos en pantalla")){
return true;
};
return false;

}
</script>
</body>