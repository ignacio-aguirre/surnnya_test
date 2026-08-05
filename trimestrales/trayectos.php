<?php 
include("funciones.php");
session_start();
$nnya=$_SESSION["nnnya_actual"];
$hogar=$_SESSION["hogar"];
$_SESSION["prestacion"]="Espacios Socioformativos y Laborales";
$nya=un_registro("select * from alojados where idalojados=".$nnya);
include("encabezado.php");
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$trimestral=un_campo("select trimestral from trim_trayectos where legajo=".$nnya." and hogar=".$hogar." and trimestre=".$trimestre." and anio=".$anio);
if($trimestral>"0"){$tri=un_registro("select * from trim_trayectos where trimestral=".$trimestral);}
else{$tri=un_registro("select * from trim_trayectos where legajo=".$nnya." and hogar=".$hogar." order by anio desc, trimestre desc limit 1");};
?>

</div>
<div class="container">
<p class="text-warning">Completar los siguientes campos si realiz&oacute; una actividad durante el trimestre</p>
<ul class="list-group">
<li class="list-group-item text-primary">Apellidos:<strong><?php echo $nya["apellidos"]?></strong>&nbsp;-&nbsp;Nombres:<strong><?php echo $nya["nombres"]?></strong>&nbsp;-&nbsp;
<strong><?php echo "Trimestre ".$trimestre." ".$anio?></strong></li>
<li class="list-group-item">Instituci&oacute;n / Programa:<input class="form-control" id="tra_institucion" size="60" maxlength="90" onblur="valida_0(this.id)"></li>
<li class="list-group-item">Tipo:<select class="form-control" id="tra_tipo"><option value=''></option>
<?php $tac=registros("select * from tablas_semestrales where tipo='TAFL' order by valor");
  foreach($tac as $ta){
    echo "<option value='".$ta["valor"]."'>".$ta["descripcion"]."</option>";
  };
?>
</select> 
</li>
<li class="list-group-item">Detallar: <input class="form-control" id="tra_actividad" size="60" maxlength="90" onblur="valida_0(this.id)"></li>
<li class="list-group-item">Frecuencia:<select class="form-control" id="tra_frecuencia"><option value=''></option>
<?php $tfr=registros("select * from tablas_semestrales where tipo='AFRE' order by valor");
  foreach($tfr as $fr){
    echo "<option value='".$fr["valor"]."'>".$fr["descripcion"]."</option>";
  };
?>
</select> 
</li>
<li class="list-group-item"><p class="text-warning">Completar los siguientes campos si realiz&oacute; una segunda actividad en el trimestre</p></li>
<li class="list-group-item">Instituci&oacute;n / Programa:<input class="form-control" id="tra_institucion2" size="60" maxlength="90" onblur="valida_0(this.id)"></li>
<li class="list-group-item">Tipo:<select class="form-control" id="tra_tipo2"><option value=''></option>
<?php $tac=registros("select * from tablas_semestrales where tipo='TAFL' order by valor");
  foreach($tac as $ta){
    echo "<option value='".$ta["valor"]."'>".$ta["descripcion"]."</option>";
  };
?>
</select> 
</li>
<li class="list-group-item">Detallar: <input class="form-control" id="tra_actividad2" size="60" maxlength="90" onblur="valida_0(this.id)"></li>
<li class="list-group-item">Frecuencia:<select class="form-control" id="tra_frecuencia2"><option value=''></option>
<?php $tfr=registros("select * from tablas_semestrales where tipo='AFRE' order by valor");
  foreach($tfr as $fr){
    echo "<option value='".$fr["valor"]."'>".$fr["descripcion"]."</option>";
  };
?>
</select> 
</li>
<li class="list-group-item">Particip&oacute; del programa acompa&ntilde;amiento para el egreso (PAE) durante el trimestre?
<select class="form-control" id="pae" onblur="sale_pae()"><option value=0></option><option value=1>Si</option><option value=-1>No</option></select></li>
<li class="list-group-item">Etapa al final del trimestre<select class="form-control" id="pae_etapa"><option value=0></option><option value=1>Etapa 1</option><option value=2>Etapa 2</option></select></li>
<li class="list-group-item">Nombre del referente<input class="form-control" id="pae_referente" value="<?php echo $tri['pae_referente']?>" maxlength="70"></li>
<li class="list-group-item">Descripci&oacute;n del modo de vivenciar cada propuesta<textarea class="form-control" id="tra_observaciones" rows="15" cols="90">
<?php echo comillas($tri['tra_observaciones'])?></textarea></li>

</ul>

<button class="btn-primary" id="aceptar" onclick="guardar()">Guardar Cambios</button>


</div>

<script>
document.getElementById("tra_institucion").value="<?php echo comillas($tri['tra_institucion'])?>";
document.getElementById("tra_actividad").value="<?php echo comillas($tri['tra_actividad'])?>";
document.getElementById("tra_institucion2").value="<?php echo comillas($tri['tra_institucion2'])?>";
document.getElementById("tra_actividad2").value="<?php echo comillas($tri['tra_actividad2'])?>";
seleccionar("tra_tipo","<?php echo comillas($tri['tipo_actividad'])?>");
seleccionar("tra_tipo2","<?php echo comillas($tri['tipo_actividad2'])?>");
seleccionar("tra_frecuencia","<?php echo comillas($tri['frecuencia'])?>");
seleccionar("tra_frecuencia2","<?php echo comillas($tri['frecuencia2'])?>");
seleccionar("pae","<?php echo $tri['pae']?>");
seleccionar("pae_etapa","<?php echo $tri['pae_etapa']?>");



function todoonada(a,b,c,d){
return (a=="" && b=="" && c=="" && d=="") || (a!="" && b!="" && c!="" && d!="")
}



function valida(){
tra_institucion=document.getElementById("tra_institucion").value;
tra_actividad=document.getElementById("tra_actividad").value;
tra_tipo=document.getElementById("tra_tipo").value;
tra_frecuencia=document.getElementById("tra_frecuencia").value;
if (!todoonada(tra_institucion,tra_tipo,tra_actividad,tra_frecuencia)) {status("completar todos los campos de la actividad");return false;};
tra_institucion2=document.getElementById("tra_institucion2").value;
tra_actividad2=document.getElementById("tra_actividad2").value;
tra_tipo2=document.getElementById("tra_tipo2").value;
tra_frecuencia2=document.getElementById("tra_frecuencia2").value;
if (!todoonada(tra_institucion2,tra_tipo2,tra_actividad2,tra_frecuencia2)) {status("completar todos los campos de la segunda actividad");return false;};
pae=document.getElementById("pae").value;
sale_pae();
if(pae==1){
  if(document.getElementById("pae_etapa")==0){status("etapa PAE es obligatoria");return false;};
  if(document.getElementById("pae_referent")==""){status("referente PAE es obligatorio");return false;};

};
status("");
return true;  

}
function sale_pae(){
  pae=document.getElementById("pae").value;
  if(pae==1){
    document.getElementById("pae_referente").disabled=false;
    document.getElementById("pae_etapa").disabled=false;

  }
  else{
    seleccionar("pae_etapa",0);
    document.getElementById("pae_referente").value="";
    document.getElementById("pae_referente").disabled=true;
    document.getElementById("pae_etapa").disabled=true;
  };	
}
function guardar(){
if(!valida()) return false;
tra_institucion=document.getElementById("tra_institucion").value;
tra_actividad=document.getElementById("tra_actividad").value;
tra_tipo=document.getElementById("tra_tipo").value;
tra_frecuencia=document.getElementById("tra_frecuencia").value;
tra_institucion2=document.getElementById("tra_institucion2").value;
tra_actividad2=document.getElementById("tra_actividad2").value;
tra_tipo2=document.getElementById("tra_tipo2").value;
tra_frecuencia2=document.getElementById("tra_frecuencia2").value;

if(confirm("Cancela para hacer modificaciones o revisar. Acepta para guardar datos en pantalla")){
navega("trayectos_do?tra_institucion="+tra_institucion+
"&tra_actividad="+tra_actividad+
"&tra_tipo_actividad="+tra_tipo+
"&tra_frecuencia="+tra_frecuencia+
"&tra_institucion2="+document.getElementById("tra_institucion2").value+
"&tra_tipo_actividad2="+tra_tipo2+
"&tra_actividad2="+document.getElementById("tra_actividad2").value+
"&tra_frecuencia2="+document.getElementById("tra_frecuencia2").value+
"&tra_observaciones="+document.getElementById("tra_observaciones").value+
"&pae="+document.getElementById("pae").value+
"&pae_etapa="+document.getElementById("pae_etapa").value+
"&pae_referente="+document.getElementById("pae_referente").value
);
};
return true;
}
</script>
</body>