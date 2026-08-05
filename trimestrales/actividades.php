<?php 
include("funciones.php");
session_start();
$nnya=$_SESSION["nnnya_actual"];
$hogar=$_SESSION["hogar"];
$_SESSION["prestacion"]="Actividades Deportivas, Recreativas y Culturales";
$nya=un_registro("select * from alojados where idalojados=".$nnya);
include("encabezado.php");
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$trimestral=un_campo("select trimestral from trim_actividades where legajo=".$nnya." and hogar=".$hogar." and trimestre=".$trimestre." and anio=".$anio);
if($trimestral>"0"){$tri=un_registro("select * from trim_actividades where trimestral=".$trimestral);}
else{$tri=un_registro("select * from trim_actividades where legajo=".$nnya." and hogar=".$hogar." order by anio desc, trimestre desc limit 1");};

?>
</div>
<div class="container">
<p class="text-warning">Completar los siguientes campos si realiz&oacute; una actividad durante el trimestre</p>
<ul class="list-group">
<li class="list-group-item text-primary">Apellidos:<strong><?php echo $nya["apellidos"]?></strong>&nbsp;-&nbsp;Nombres:<strong><?php echo $nya["nombres"]?></strong>&nbsp;-&nbsp;
<strong><?php echo "Trimestre ".$trimestre." ".$anio?></strong></li>
<li class="list-group-item">Instituci&oacute;n / Programa:<input class="form-control" id="tra_institucion" size="60" maxlength="200" onblur="valida_0(this.id)"></li>
<li class="list-group-item">Tipo:<select class="form-control" id="tra_tipo"><option value=''></option>
<?php $tac=registros("select * from tablas_semestrales where tipo='TADRC' order by valor");
  foreach($tac as $ta){
    echo "<option value='".$ta["valor"]."'>".$ta["descripcion"]."</option>";
  };
?>
</select> 
</li>
<li class="list-group-item">Detallar: <input class="form-control" id="tra_actividad" size="60" maxlength="200" onblur="valida_0(this.id)"></li>
<li class="list-group-item">Frecuencia:<select class="form-control" id="tra_frecuencia"><option value=''></option>
<?php $tfr=registros("select * from tablas_semestrales where tipo='AFRE' order by valor");
  foreach($tfr as $fr){
    echo "<option value='".$fr["valor"]."'>".$fr["descripcion"]."</option>";
  };
?>
</select> 
</li>
<li class="list-group-item"><p class="text-warning">Completar los siguientes campos si realiz&oacute; una segunda actividad en el trimestre
</p></li>
<li class="list-group-item">Instituci&oacute;n / Programa:<input class="form-control" id="tra_institucion2" size="60" maxlength="200" onblur="valida_0(this.id)"></li>
<li class="list-group-item">Tipo:<select class="form-control" id="tra_tipo2" ><option value=''></option>
<?php $tac=registros("select * from tablas_semestrales where tipo='TADRC' order by valor");
  foreach($tac as $ta){
    echo "<option value='".$ta["valor"]."'>".$ta["descripcion"]."</option>";
  };
?>
</select> 
</li>
<li class="list-group-item">Detallar: <input class="form-control" id="tra_actividad2" size="60" maxlength="200" onblur="valida_0(this.id)"></li>
<li class="list-group-item">Frecuencia:<select class="form-control" id="tra_frecuencia2"><option value=''></option>
<?php $tfr=registros("select * from tablas_semestrales where tipo='AFRE' order by valor");
  foreach($tfr as $fr){
    echo "<option value='".$fr["valor"]."'>".$fr["descripcion"]."</option>";
  };
?>
</select> 
</li>
<li class="list-group-item">Descripci&oacute;n del modo de vivenciar cada propuesta<textarea class="form-control" id="tra_observaciones" rows="15" cols="90"></textarea></li>
</ul>

<button class="btn-primary" id="aceptar" onclick="guardar()">Guardar Cambios</button>


</div>

<script>
document.getElementById("tra_institucion").value="<?php echo comillas($tri['institucion'])?>";
document.getElementById("tra_actividad").value="<?php echo comillas($tri['actividad'])?>";
document.getElementById("tra_institucion2").value="<?php echo comillas($tri['institucion2'])?>";
document.getElementById("tra_actividad2").value="<?php echo comillas($tri['actividad2'])?>";
document.getElementById("tra_observaciones").value="<?php echo comillas($tri['observaciones'])?>";
seleccionar("tra_tipo","<?php echo comillas($tri['tipo_actividad'])?>");
seleccionar("tra_tipo2","<?php echo comillas($tri['tipo_actividad2'])?>");
seleccionar("tra_frecuencia","<?php echo comillas($tri['frecuencia'])?>");
seleccionar("tra_frecuencia2","<?php echo comillas($tri['frecuencia2'])?>");

function todoonada(a,b,c,d){

return (a=="" && b=="" && c=="" && d=="") || (a!="" && b!="" && c!="" && d!="")

}



function valida(){
tra_institucion=document.getElementById("tra_institucion").value;
tra_tipo=document.getElementById("tra_tipo").value;
tra_frecuencia=document.getElementById("tra_frecuencia").value;
tra_actividad=document.getElementById("tra_actividad").value;
if (!todoonada(tra_tipo,tra_institucion,tra_actividad,tra_frecuencia)) {status("completar todos los campos de la actividad");return false;};

tra_institucion2=document.getElementById("tra_institucion2").value;
tra_tipo2=document.getElementById("tra_tipo2").value;
tra_frecuencia2=document.getElementById("tra_frecuencia2").value;
tra_actividad2=document.getElementById("tra_actividad2").value;

if (!todoonada(tra_tipo2,tra_institucion2,tra_actividad2,tra_frecuencia2)) {status("completar todos los campos de la segunda actividad");return false;};

status("");

return true;  

}





function guardar(){

if(!valida()) return false;
tra_institucion=document.getElementById("tra_institucion").value;
tra_actividad=document.getElementById("tra_actividad").value;
tra_frecuencia=document.getElementById("tra_frecuencia").value;
tra_institucion2=document.getElementById("tra_institucion2").value;
tra_actividad2=document.getElementById("tra_actividad2").value;
tra_frecuencia2=document.getElementById("tra_frecuencia2").value;
tra_observaciones=document.getElementById("tra_observaciones").value;
tra_tipo=document.getElementById("tra_tipo").value;
tra_tipo2=document.getElementById("tra_tipo2").value;

if(confirm("Cancela para hacer modificaciones o revisar. Acepta para guardar datos en pantalla")){
navega("actividades_do?tra_institucion="+tra_institucion+
"&tra_tipo_actividad="+tra_tipo+
"&tra_actividad="+tra_actividad+
"&tra_frecuencia="+tra_frecuencia+
"&tra_institucion2="+tra_institucion2+
"&tra_tipo_actividad2="+tra_tipo2+
"&tra_actividad2="+tra_actividad2+
"&tra_frecuencia2="+tra_frecuencia2+
"&tra_observaciones="+tra_observaciones);
};
return true;
}
</script>
</body>