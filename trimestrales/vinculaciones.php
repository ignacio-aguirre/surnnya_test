<?php 
include("funciones.php");
session_start();
$nnya=$_SESSION["nnnya_actual"];
$hogar=$_SESSION["hogar"];
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$_SESSION["prestacion"]="Vinculaciones Familiares y Comunitarias";
include("encabezado.php");
$nya=un_registro("select * from alojados where idalojados=".$nnya);
$trimestral=un_campo("select trimestral from trim_vinculaciones where legajo=".$nnya." and hogar=".$hogar." and trimestre=".$trimestre." and anio=".$anio);
if($trimestral>"0"){$tri=un_registro("select * from trim_vinculaciones where trimestral=".$trimestral);}
else{$tri=un_registro("select * from trim_vinculaciones where legajo=".$nnya." and hogar=".$hogar." order by anio desc, trimestre desc limit 1");};
?>


</div>
<div class="container">
<form method="POST" action="vinculaciones_do" onsubmit="return guardar()">
<ul class="list-group">
<li class="list-group-item text-primary">Apellidos:<strong><?php echo $nya["apellidos"]?></strong>&nbsp;-&nbsp;Nombres:<strong><?php echo $nya["nombres"]?></strong>&nbsp;-&nbsp;
<strong><?php echo "Trimestre ".$trimestre." ".$anio?></strong></li>
<li class="list-group-item">Tuvo Vinculaciones en el Trimestre<select class="form-control" id="vin_tuvo" name="vin_tuvo" onblur="sale_tuvo()" autofocus><?php sino();?></select></li>
<li class="list-group-item">1: Con qui&eacute;n/es: <select class="form-control" id="vin_quien" name="vin_quien"><?php echo opc_tabla("VQUI")?></select>&nbsp;
Frecuencia: <select class="form-control" id="vin_frecuencia" name="vin_frecuencia"><?php echo opc_tabla("VFRE")?></select>&nbsp;
Lugar: <select class="form-control" id="vin_lugar" name="vin_lugar"><?php echo opc_tabla("VLUG")?></select></li>
<li class="list-group-item">2: Con qui&eacute;n/es: <select class="form-control" id="vin_quien2" name="vin_quien2" onblur="bautom(this.id)"><?php echo opc_tabla("VQUI")?></select>&nbsp;Frecuencia: <select class="form-control" id="vin_frecuencia2" name="vin_frecuencia2"><?php echo opc_tabla("VFRE")?></select>&nbsp;
Lugar: <select class="form-control" id="vin_lugar2" name="vin_lugar2"><?php echo opc_tabla("VLUG")?></select></li>
<li class="list-group-item">3: Con qui&eacute;n/es: <select class="form-control" id="vin_quien3" name="vin_quien3" onblur="bautom(this.id)"><?php echo opc_tabla("VQUI")?></select>&nbsp;
Frecuencia: <select class="form-control" id="vin_frecuencia3" name="vin_frecuencia3"><?php echo opc_tabla("VFRE")?></select>&nbsp;
Lugar: <select class="form-control" id="vin_lugar3" name="vin_lugar3"><?php echo opc_tabla("VLUG")?></select></li>
<li class="list-group-item">4: Con qui&eacute;n/es: <select class="form-control" id="vin_quien4" name="vin_quien4" onblur="bautom(this.id)"><?php echo opc_tabla("VQUI")?></select>&nbsp;
Frecuencia: <select class="form-control" id="vin_frecuencia4" name="vin_frecuencia4"><?php echo opc_tabla("VFRE")?></select>&nbsp;
Lugar: <select class="form-control" id="vin_lugar4" name="vin_lugar4"><?php echo opc_tabla("VLUG")?></select></li>
<li class="list-group-item">Con Referentes Programa Abrazar CDNNYA: <select class="form-control" id="vin_abrazar" name="vin_abrazar"><?php blancosino();?></select></li>
<li class="list-group-item">Observaciones (*)<textarea id="vin_observaciones" name="vin_observaciones" rows="15" cols="90" class="form-control">
<?php echo $tri["vin_observaciones"]?></textarea></li>
</ul>
<p class='text-warning'>(*)Indicar cu&aacute;les son los acuerdos establecidos con los familiares o referentes, estrategias que se llevan a cabo para propiciar y acompa&ntilde;ar las vinculaciones.</p>
<button class="btn-primary" id="aceptar" type="submit">Guardar Cambios</button>
</form>
</div>
<script>
seleccionar("vin_tuvo","<?php echo $tri["vin_tuvo"]?>");
seleccionar("vin_quien","<?php echo $tri["vin_quien"]?>");
seleccionar("vin_frecuencia","<?php echo $tri["vin_frecuencia"]?>");
seleccionar("vin_lugar","<?php echo $tri["vin_lugar"]?>");
seleccionar("vin_quien2","<?php echo $tri["vin_quien2"]?>");
seleccionar("vin_frecuencia2","<?php echo $tri["vin_frecuencia2"]?>");
seleccionar("vin_lugar2","<?php echo $tri["vin_lugar2"]?>");
seleccionar("vin_quien3","<?php echo $tri["vin_quien3"]?>");
seleccionar("vin_frecuencia3","<?php echo $tri["vin_frecuencia3"]?>");
seleccionar("vin_lugar3","<?php echo $tri["vin_lugar3"]?>");
seleccionar("vin_quien4","<?php echo $tri["vin_quien4"]?>");
seleccionar("vin_frecuencia4","<?php echo $tri["vin_frecuencia4"]?>");
seleccionar("vin_lugar4","<?php echo $tri["vin_lugar4"]?>");
seleccionar("vin_abrazar","<?php echo $tri["vin_abrazar"]?>");


function sale_tuvo(){
  if(vin_tuvo.value!=1){
    vin_quien.value="0";
    vin_quien.disabled=true;
    vin_frecuencia.value="0";
    vin_frecuencia.disabled=true;
    vin_lugar.value="0";
    vin_lugar.disabled=true;
    vin_quien2.value="0";
    vin_quien2.disabled=true;
    vin_frecuencia2.value="0";
    vin_frecuencia2.disabled=true;
    vin_lugar2.value="0";
    vin_lugar2.disabled=true;
    vin_quien3.value="0";
    vin_quien3.disabled=true;
    vin_frecuencia3.value="0";
    vin_frecuencia3.disabled=true;
    vin_lugar3.value="0";
    vin_lugar3.disabled=true;
    vin_quien4.value="0";
    vin_quien4.disabled=true;
    vin_frecuencia4.value="0";
    vin_frecuencia4.disabled=true;
    vin_lugar4.value="0";
    vin_lugar4.disabled=true;
    
    
 }
  else{
    vin_quien.disabled=false;
    vin_frecuencia.disabled=false;
    vin_lugar.disabled=false;
    vin_quien2.disabled=false;
    vin_frecuencia2.disabled=false;
    vin_lugar2.disabled=false;
    vin_quien3.disabled=false;
    vin_frecuencia3.disabled=false;
    vin_lugar3.disabled=false;
    vin_quien4.disabled=false;
    vin_frecuencia4.disabled=false;
    vin_lugar4.disabled=false;
    vin_quien.focus();
  };
 return true;
}

function bautom(id){
   if(document.getElementById(id).value==0){
     if(id=="vin_quien2"){
	seleccionar("vin_quien3","0");
	seleccionar("vin_quien4","0");
	seleccionar("vin_frecuencia2","0");
	seleccionar("vin_frecuencia3","0");
	seleccionar("vin_frecuencia4","0");
	seleccionar("vin_lugar2","0");
	seleccionar("vin_lugar3","0");
	seleccionar("vin_lugar4","0");
     };
     if(id=="vin_quien3"){
	seleccionar("vin_quien4","0");
	seleccionar("vin_frecuencia3","0");
	seleccionar("vin_frecuencia4","0");
	seleccionar("vin_lugar3","0");
	seleccionar("vin_lugar4","0");
     };
     if(id=="vin_quien4"){
	seleccionar("vin_frecuencia4","0");
	seleccionar("vin_lugar4","0");
     };
	
  };
}
function guardar(){
if(vin_observaciones.value==""){status("Observaciones es un campo obligatorio");return false;};
sale_tuvo();

if(vin_tuvo.value=="1"){
  if(vin_quien.value=="0"||vin_frecuencia.value=="0"||vin_lugar.value=="0"){
    status("Faltan Datos"); return false;
  };
};

if(confirm("Cancela para hacer modificaciones o revisar. Acepta para guardar datos en pantalla")){
return true;
}else{return false;};
}

</script>



</body>