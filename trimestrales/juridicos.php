<?php 
include("funciones.php");
session_start();
$nnya=$_SESSION["nnnya_actual"];
$hogar=$_SESSION["hogar"];
$_SESSION["prestacion"]="Situaci&oacute;n Administrativa / Legal";
$nya=un_registro("select * from alojados where idalojados=".$nnya);
include("encabezado.php");
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$trimestral=un_campo("select trimestral from trim_juridicos where legajo=".$nnya." and hogar=".$hogar." and trimestre=".$trimestre." and anio=".$anio);
if($trimestral>"0"){$tri=un_registro("select * from trim_juridicos where trimestral=".$trimestral);}
else{$tri=un_registro("select * from trim_juridicos where legajo=".$nnya." and hogar=".$hogar." order by anio desc, trimestre desc limit 1");};
?>
</div>
<div class="container">
<ul class="list-group">
<li class="list-group-item text-primary">Apellidos:<strong><?php echo $nya["apellidos"]?></strong>&nbsp;-&nbsp;Nombres:<strong><?php echo $nya["nombres"]?></strong>&nbsp;-&nbsp;
 <strong><?php echo "Trimestre ".$trimestre." ".$anio?></strong></li>
<li class="list-group-item">Defensor&iacute;a CDNNYA: <select class="form-control" id="defensoria_zonal" autofocus><?php echo opc_tabla_surnnya('CM');?></select></li>
<li class="list-group-item">Zonal/Local PBA:<select class="form-control" id="zonal_provincial"><?php echo opc_tabla("ZP");?></select>&nbsp;&nbsp;
Detallar: <input class="form-control" id="zp_detalle" size="60" maxlength="100" onblur="valida_0(this.id)"></li>
<li class="list-group-item">Juzgado Civil: <select class="form-control" id="juzgado_civil"><?php echo str_replace('0>0','0>(VACIO)',opc_numeros(0,110));?></select>&nbsp;
Otro Juzgado: <select class="form-control" id="juzgado_otro"><?php echo opc_tabla("TJ");?></select>&nbsp;Detallar: <input class="form-control" id="juzgado_otro_q" size="40" maxlength="45" onblur="valida_0(this.id)"></li>
<li class="list-group-item">Defensor&iacute;a Nacional: <select class="form-control" id="defensoria_nacional"><?php echo str_replace('0>0','0>(VACIO)',opc_numeros(0,7));?></select>&nbsp;
Defensor: <input class="form-control" id="defensor" size="50" maxlength="60" onblur="valida_0(this.id)"></li>
<li class="list-group-item">Tutor&iacute;a: <select class="form-control" id="tutoria"><?php echo str_replace('0>0','0>(VACIO)',opc_numeros(0,2));?></select>
Tutor: <input id="tutor" class="form-control" size="50" maxlength="60" onblur="valida_0(this.id)"></li>
<li class="list-group-item">Abogado del Ni&ntilde;o: <select class="form-control" id="abogado_ninio"><?php blancosino();?></select>
Abogado: <input class="form-control" id="abogado" size="50" maxlength="60" onblur="valida_0(this.id)">
Pertenencia: <select  class="form-control" id="pertenencia"><?php echo opc_tabla("ANP")?></select></li>
<li class="list-group-item">Adoptabilidad Decretada<select class="form-control" id="ad_decretada"><?php blancosino();?></select></li>
<li class="list-group-item">Tuvo Vinculaciones para Guardas Preadoptivas Fallidas: <select class="form-control" id="guardas_fallidas"><?php blancosino();?></select>
Fecha &Uacute;ltima Vinculaci&oacute;n para Guarda Preadoptiva Fallida: <input class="form-control" id="guardas_fult_vinculacion"  size="10" maxlength="10" onblur="valida_fecha(this.id,1)"></li>
<li class="list-group-item">Medida Excepcional Vigente en Dispositivo: <select class="form-control" id="medida_excepcional"><?php sino();?></select></li>
<li class="list-group-item">Medida Cautelar de Alojamiento en Dispositivo: <select class="form-control" id="medida_cautelar"><?php nosi();?></select></li>
</ul>

<button class="btn-primary" id="aceptar" onclick="guardar()">Guardar Cambios</button>
</div>

<script>

seleccionar("defensoria_zonal","<?php echo si($tri['defensoria_zonal']!="",$tri['defensoria_zonal'],$nya['defensoria_zonal'])?>");
seleccionar("zonal_provincial","<?php echo si($tri['zonal_provincial']!="",$tri['zonal_provincial'],$nya['zonal_provincial'])?>");
document.getElementById("zp_detalle").value="<?php echo comillas(si($tri['zp_detalle']!="",$tri['zp_detalle'],""))?>";
seleccionar("juzgado_civil","<?php echo si($tri['juzgado_civil']!="",$tri['juzgado_civil'],$nya['juzgado_civil'])?>");
seleccionar("juzgado_otro","<?php echo si($tri['juzgado_otro']!="",$tri['juzgado_otro'],$nya['juzgado_otro'])?>");
document.getElementById("juzgado_otro_q").value="<?php echo comillas(si($tri['juzgado_otro_q']!="",$tri['juzgado_otro_q'],si($nya['juzgado_otro_q']>"0",$nya['juzgado_otro_q'],"")))?>";
seleccionar("defensoria_nacional","<?php echo si($tri['defensoria_nacional']>="0",$tri['defensoria_nacional'],$nya['defensoria_nacional'])?>");
document.getElementById("defensor").value="<?php echo comillas(si($tri['defensor']!="",$tri['defensor'],$nya['defensor']))?>";
seleccionar("tutoria","<?php echo si($tri['tutoria']!="",$tri['tutoria'],$nya['tutoria'])?>");
document.getElementById("tutor").value="<?php echo comillas(si($tri['tutor']!="",$tri['tutor'],$nya['tutor']))?>";
seleccionar("abogado_ninio","<?php echo si($tri['abogado_ninio']>"0",$tri['abogado_ninio'],$nya['abogado_ninio'])?>");
document.getElementById("abogado").value="<?php echo comillas(si($tri['abogado']!="",$tri['abogado'],$nya['abogado']))?>";
seleccionar("pertenencia","<?php echo si($tri['pertenencia']!="",$tri['pertenencia'],$nya['ab_procedencia'])?>");
document.getElementById("ad_decretada").value="<?php echo $tri['ad_decretada']?>";
seleccionar("guardas_fallidas","<?php echo $tri['guardas_fallidas']?>");
document.getElementById("guardas_fult_vinculacion").value="<?php echo ffec($tri['guardas_fult_vinculacion'])?>";
seleccionar("medida_excepcional","<?php echo $tri['medida_excepcional']?>");
seleccionar("medida_cautelar","<?php echo $tri['medida_cautelar']?>");

function guardar(){
defensoria_zonal=document.getElementById("defensoria_zonal").value;
zonal_provincial=document.getElementById("zonal_provincial").value;
zp_detalle=document.getElementById("zp_detalle").value;
juzgado_civil=document.getElementById("juzgado_civil").value;
juzgado_otro=document.getElementById("juzgado_otro").value;
juzgado_otro_q=document.getElementById("juzgado_otro_q").value;
if(juzgado_otro!="0"&&juzgado_otro_q==""){status("indique el juzgado_otro");return false;};
defensoria_nacional=document.getElementById("defensoria_nacional").value;
defensor=document.getElementById("defensor").value;
tutoria=document.getElementById("tutoria").value;
tutor=document.getElementById("tutor").value;
abogado_ninio=document.getElementById("abogado_ninio").value;
abogado=document.getElementById("abogado").value;
if(abogado!="") {abogado_ninio="1";document.getElementById("abogado_ninio").value="1";};
pertenencia=document.getElementById("pertenencia").value;
ad_decretada=document.getElementById("ad_decretada").value;
guardas_fallidas=document.getElementById("guardas_fallidas").value;
guardas_fult_vinculacion=document.getElementById("guardas_fult_vinculacion").value;
medida_excepcional=document.getElementById("medida_excepcional").value;
medida_cautelar=document.getElementById("medida_cautelar").value;

if(confirm("Cancela para hacer modificaciones o revisar. Acepta para Guardar los datos.")){
navega("juridicos_do?defensoria_zonal="+defensoria_zonal+"&zonal_provincial="+zonal_provincial+"&zp_detalle="+zp_detalle+"&juzgado_civil="+juzgado_civil+
"&juzgado_otro="+juzgado_otro+"&juzgado_otro_q="+juzgado_otro_q+"&defensoria_nacional="+defensoria_nacional+"&defensor="+defensor+
"&tutoria="+tutoria+"&tutor="+tutor+"&abogado_ninio="+abogado_ninio+"&abogado="+abogado+"&pertenencia="+pertenencia+
"&ad_decretada="+ad_decretada+"&guardas_fallidas="+guardas_fallidas+"&guardas_fult_vinculacion="+guardas_fult_vinculacion+
"&medida_excepcional="+medida_excepcional+"&medida_cautelar="+medida_cautelar);
};
return true;
}
</script>
</body>