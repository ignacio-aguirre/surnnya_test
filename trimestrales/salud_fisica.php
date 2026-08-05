<?php 
include("funciones.php");
session_start();
$nnya=$_SESSION["nnnya_actual"];
$hogar=$_SESSION["hogar"];
$_SESSION["prestacion"]="Salud F&iacute;sica";
$nya=un_registro("select * from alojados where idalojados=".$nnya);
include("encabezado.php");
$esac=opc_tabla('ESAC');
$esab=opc_tabla('ESAB');
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$trimestral=un_campo("select trimestral from trim_salud_fisica where legajo=".$nnya." and hogar=".$hogar." and trimestre=".$trimestre." and anio=".$anio);
if($trimestral>"0"){$tri=un_registro("select * from trim_salud_fisica where trimestral=".$trimestral);}
else{$tri=un_registro("select * from trim_salud_fisica where legajo=".$nnya." and hogar=".$hogar." order by anio desc, trimestre desc limit 1");};
?>
</div>
<div class="container">
<form class="form" action="salud_fisica_do" method="post" onsubmit="return guardar()">
<ul class="list-group">
<li class="list-group-item text-primary">Apellidos:<strong><?php echo $nya["apellidos"]?></strong>&nbsp;-&nbsp;Nombres:<strong><?php echo $nya["nombres"]?></strong>&nbsp;-&nbsp;
<strong><?php echo "Trimestre ".$trimestre." ".$anio?></strong></li>
<li class="list-group-item">Afiliado a Obra Social<select class="form-control" id="obra_social" name="obra_social"><?php blancosino();?></select></li>
<li class="list-group-item">Tuvo consultas m&eacute;dicas durante el trimestre (exceptuando las de salud mental): <select class="form-control" id="en_tratamiento" name="en_tratamiento" onblur="sale_entto()" autofocus><?php echo nosi()?></select></li>
<li class="list-group-item">Efectores de Salud<br> 1: Jurisdicci&oacute;n: <select class="form-control" id="juris_ef1" name="juris_ef1" onchange="efectores(this.id)"><option value="0">(VACIO)</option><option value="1">CABA</option><option value="2">PBA</option></select>&nbsp;
Nombre:<select class="form-control" id="ef_1" name="ef_1"></select></li>
<li class="list-group-item"> 2: Jurisdicci&oacute;n: <select class="form-control" id="juris_ef2" name="juris_ef2" onchange="efectores(this.id)"><option value="0">(VACIO)</option><option value="1">CABA</option><option value="2">PBA</option></select>&nbsp;
Nombre:<select class="form-control" id="ef_2" name="ef_2"></select></li>
<li class="list-group-item"> 3: Jurisdicci&oacute;n: <select class="form-control" id="juris_ef3" name="juris_ef3" onchange="efectores(this.id)"><option value="0">(VACIO)</option><option value="1">CABA</option><option value="2">PBA</option></select>&nbsp;
Nombre:<select class="form-control" id="ef_3" name="ef_3"></select></li>
<li class="list-group-item">Especialidades<br> 1:<select class="form-control" id="especialidad_1" name="especialidad_1"><?php echo opc_tabla("ESPEC")?></select>&nbsp; 
2:<select class="form-control" id="especialidad_2" name="especialidad_2"><?php echo opc_tabla("ESPEC")?></select></li>
<li class="list-group-item">3:<select class="form-control" id="especialidad_3" name="especialidad_3"><?php echo opc_tabla("ESPEC")?></select>&nbsp;
4:<select class="form-control" id="especialidad_4" name="especialidad_4"><?php echo opc_tabla("ESPEC")?></select></li>
<li class="list-group-item">Calendario Vacunaci&oacute;n Actualizado: <select class="form-control" id="calendario_vacunacion" name="calendario_vacunacion"><?php blancosino();?></select>&nbsp;
Internaci&oacute;n: <select class="form-control" id="internacion" name="internacion"><option value="2">No</option><option value="1">S&iacute;</option></select></li>
<li class="list-group-item">Tiene Plan de Medicaci&oacute;n: <select class="form-control" id="plan_medicacion" name="plan_medicacion"  onblur="sale_plan()"><?php blancosino();?></select></li>
<li class="list-group-item">&Uacute;ltimo Plan (medicamentos, dosis diarias)<textarea id="plan_detalle" name="plan_detalle" rows="4" cols="60" class="form-control"><?php echo $tri["plan_detalle"]?></textarea></li>
<li class="list-group-item">Odontolog&iacute;a Jurisdicci&oacute;n:<select class="form-control" id="juris_odonto" name="juris_odonto" onchange="efec_odonto()"><option value="0">(VACIO)</option><option value="1">CABA</option><option value="2">PBA</option></select>&nbsp;
Efector:<select class="form-control" id="ef_odonto" name="ef_odonto"></select></br>
Tratamiento:<input class="form-control" id="obse_odonto" name="obse_odonto" size="50" maxlength="50" onblur="valida_0(this.id)"></li>
<li class="list-group-item">Descripci&oacute;n de la situaci&oacute;n de salud durante el per&iacute;odo  (*)
<textarea class="form-control" id="sf_observaciones" name="sf_observaciones" rows="15" cols="90" class="form-control"><?php echo $tri["sf_observaciones"]?></textarea></li>
</ul>
<p class='text-warning'>(*) Motivo de consulta m&aacute;s frecuente y/o aspectos relevantes en el per&iacute;odo. </p>
<button class="btn-primary" id="aceptar">Guardar Cambios</button>
</form>
<script>
function efectores(id){
idcampo="ef_"+id.substr(-1);
if(document.getElementById(id).value=="0") {document.getElementById(idcampo).innerHTML="";};
if(document.getElementById(id).value=="1") {document.getElementById(idcampo).innerHTML="<?php echo $esac?>";document.getElementById(idcampo).focus();};
if(document.getElementById(id).value=="2") {document.getElementById(idcampo).innerHTML="<?php echo $esab?>";document.getElementById(idcampo).focus();};
return true;
}
function efec_odonto(){
if(document.getElementById("juris_odonto").value=="0") {document.getElementById("ef_odonto").innerHTML="";};
if(document.getElementById("juris_odonto").value=="1") {document.getElementById("ef_odonto").innerHTML="<?php echo $esac?>";document.getElementById(idcampo).focus();};
if(document.getElementById("juris_odonto").value=="2") {document.getElementById("ef_odonto").innerHTML="<?php echo $esab?>";document.getElementById(idcampo).focus();};
return true;
}

seleccionar("obra_social","<?php echo $tri['obra_social'];?>");
seleccionar("en_tratamiento","<?php echo $tri["en_tratamiento"]?>");
seleccionar("juris_ef1","<?php echo $tri['juris_ef1'];?>");
seleccionar("juris_ef2","<?php echo $tri['juris_ef2'];?>");
seleccionar("juris_ef3","<?php echo $tri['juris_ef3'];?>");
seleccionar("juris_odonto","<?php echo $tri['juris_odonto'];?>");
efectores("juris_ef1");
efectores("juris_ef2");
efectores("juris_ef3");
efec_odonto();
seleccionar("ef_1","<?php echo $tri['ef_1'];?>");
seleccionar("ef_2","<?php echo $tri['ef_2'];?>");
seleccionar("ef_3","<?php echo $tri['ef_3'];?>");
seleccionar("ef_odonto","<?php echo $tri['ef_odonto'];?>");
document.getElementById("obse_odonto").value="<?php echo comillas($tri["obse_odonto"])?>";
seleccionar("especialidad_1","<?php echo $tri['especialidad_1'];?>");
seleccionar("especialidad_2","<?php echo $tri['especialidad_2'];?>");
seleccionar("especialidad_3","<?php echo $tri['especialidad_3'];?>");
seleccionar("especialidad_4","<?php echo $tri['especialidad_4'];?>");
seleccionar("calendario_vacunacion","<?php echo $tri['calendario_vacunacion'];?>");
seleccionar("internacion","<?php echo $tri['internacion'];?>");
seleccionar("plan_medicacion","<?php echo $tri["plan_medicacion"]?>");
document.getElementById("obra_social").focus();

function guardar(){
en_tratamiento=document.getElementById("en_tratamiento").value;
obra_social=document.getElementById("obra_social").value;
juris_ef1=document.getElementById("juris_ef1").value;
juris_ef2=document.getElementById("juris_ef2").value;
juris_ef3=document.getElementById("juris_ef3").value;
juris_odonto=document.getElementById("juris_odonto").value;

ef_1=document.getElementById("ef_1").value;
ef_2=document.getElementById("ef_2").value;
ef_3=document.getElementById("ef_3").value;
ef_odonto=document.getElementById("ef_odonto").value;
obse_odonto=document.getElementById("obse_odonto").value;
especialidad_1=document.getElementById("especialidad_1").value;
especialidad_2=document.getElementById("especialidad_2").value;
especialidad_3=document.getElementById("especialidad_3").value;
especialidad_4=document.getElementById("especialidad_4").value;
calendario_vacunacion=document.getElementById("calendario_vacunacion").value;
internacion=document.getElementById("internacion").value;
plan_medicacion=document.getElementById("plan_medicacion").value;
plan_detalle=document.getElementById("plan_detalle").value;
sf_observaciones=document.getElementById("sf_observaciones").value;
if(sf_observaciones==""){status("Campo Obligatorio");return false;};
if(confirm("Cancela para hacer modificaciones o revisar. Acepta para guardar datos en pantalla")){
 return true;
};
return false;

}
</script>
</div>
</body>