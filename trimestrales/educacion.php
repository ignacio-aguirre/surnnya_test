<?php 
include("funciones.php");
session_start();
$nnya=$_SESSION["nnnya_actual"];
$hogar=$_SESSION["hogar"];
$_SESSION["prestacion"]="Educaci&oacute;n";
$nya=un_registro("select * from alojados where idalojados=".$nnya);
include("encabezado.php");
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$trimestral=un_campo("select trimestral from trim_educacion where legajo=".$nnya." and hogar=".$hogar." and trimestre=".$trimestre." and anio=".$anio);
if($trimestral>"0"){$tri=un_registro("select * from trim_educacion where trimestral=".$trimestral);}
else{$tri=un_registro("select * from trim_educacion where legajo=".$nnya." and hogar=".$hogar." order by anio desc, trimestre desc limit 1");};
?>
</div>
<div class="container">
<form class="form" action="educacion_do" method="post" onsubmit="return guardar()">
<ul class="list-group">
<li class="list-group-item text-primary">Apellidos:<strong><?php echo $nya["apellidos"]?></strong>&nbsp;-&nbsp;Nombres:<strong><?php echo $nya["nombres"]?></strong>&nbsp;-&nbsp;
<strong><?php echo "Trimestre ".$trimestre." ".$anio?></strong></li>
<li class="list-group-item">Asiste a Establecimiento Educativo <select class="form-control" id="edu_asiste" name="edu_asiste" onblur="sale_esta()" required><?php sino()?></select></li>
<li class="list-group-item">Establecimiento Educativo: <input class="form-control" id="edu_establecimiento" name="edu_establecimiento" size="50" maxlength="80"></li>
<li class="list-group-item">Distrito Escolar (CABA): <select class="form-control" id="edu_distrito_caba" name="edu_distrito_caba"><?php echo opc_numeros(0,21);?></select>&nbsp;
Municipio (PBA): <select class="form-control" id="edu_municipio_pba" name="edu_municipio_pba"><?php echo opc_tabla("EMUNI")?></select>&nbsp;
Gesti&oacute;n: <select class="form-control" id="edu_gestion" name="edu_gestion"><option value="0">(vac&iacute;o)</option><option value="1">Estatal</option><option value="2">Privada</option><option value="3">Mixta</option></select></li>
<li class="list-group-item">Tipo de Establecimiento: <select class="form-control" id="edu_tipo_establecimiento" name="edu_tipo_establecimiento"><?php echo opc_tabla("ETIPO")?></select></li>
<li class="list-group-item">Nivel Educativo: <select class="form-control" id="edu_nivel" name="edu_nivel"><?php echo opc_tabla("ENIVE")?></select></li>
<li class="list-group-item">As.Regular: <select class="form-control" id="edu_regular" name="edu_regular"><?php blancosino()?></select>&nbsp;
Sala/A&ntilde;o/Grado: <select class="form-control" id="edu_grado" name="edu_grado"><?php echo opc_tabla("EGRAD")?></select>&nbsp;
Turno: <select class="form-control" id="edu_turno" name="edu_turno"><?php echo opc_tabla("ETURN")?></select></li>
<li class="list-group-item">Recibe Apoyo Escolar: <select class="form-control" id="edu_apoyo" name="edu_apoyo"><?php blancosino();?></select>&nbsp;
Efector <input class="form-control" id="edu_apoyo_efector" name="edu_apoyo_efector" size="45" maxlength="50"></li>
<li class="list-group-item">&Uacute;lt. Sala/A&ntilde;o/Grado Aprobado: <select class="form-control" id="edu_ultimo_grado" name="edu_ultimo_grado"><?php echo opc_tabla("EGRAD")?></select>&nbsp;
En qu&eacute; A&ntilde;o: <input class="form-control" id="edu_ultimo_anio" name="edu_ultimo_anio" size="4" maxlength="4" onblur="valida_entero(this.id)"></li> 
<li class="list-group-item">Otras Ofertas Educativas: <select class="form-control" id="edu_otras_ofertas" name="edu_otras_ofertas"><?php echo opc_tabla("EOOFE")?></select></li>


<li class="list-group-item">Observaciones (*)<textarea class="form-control" id="edu_observaciones" name="edu_observaciones" rows="15" cols="90"><?php echo $tri["edu_observaciones"]?></textarea></li>

</ul>

<p class='text-warning'>(*) En caso de realizarse reuniones con docentes o directivos consignar motivo, fecha y acuerdos logrados o no. 
En el caso de que se cuente con informes por parte de los docentes remitir al contenido de los mismos a fin de dar cuenta de cu&aacute;l es el proceso que el ni&ntilde;o / ni&ntilde;a / adolescente tiene en ese espacio. 
En el caso de que se encuentre realizando apoyo escolar, consignar frecuencia, de qu&eacute; asignatura lo realiza.</p>

<button class="btn-primary" id="aceptar">Guardar Cambios</button>
</form>
</div>

<script>

document.getElementById("edu_establecimiento").value='<?php echo comillas($tri['edu_establecimiento'])?>';

document.getElementById("edu_distrito_caba").value="<?php echo $tri['edu_distrito_caba']?>";

document.getElementById("edu_municipio_pba").value="<?php echo $tri['edu_municipio_pba']?>";

document.getElementById("edu_gestion").value="<?php echo $tri['edu_gestion']?>";

document.getElementById("edu_tipo_establecimiento").value="<?php echo $tri['edu_tipo_establecimiento']?>";

document.getElementById("edu_nivel").value="<?php echo $tri['edu_nivel']?>";

document.getElementById("edu_asiste").value="<?php echo $tri['edu_asiste']?>";

document.getElementById("edu_regular").value="<?php echo $tri['edu_regular']?>";

document.getElementById("edu_grado").value="<?php echo $tri['edu_grado']?>";

document.getElementById("edu_turno").value="<?php echo $tri['edu_turno']?>";

document.getElementById("edu_ultimo_grado").value="<?php echo $tri['edu_ultimo_grado']?>";

document.getElementById("edu_ultimo_anio").value="<?php echo $tri['edu_ultimo_anio']?>";

document.getElementById("edu_apoyo").value="<?php echo $tri['edu_apoyo']?>";
document.getElementById("edu_apoyo_efector").value="<?php echo comillas($tri['edu_apoyo_efector'])?>";

document.getElementById("edu_otras_ofertas").value="<?php echo comillas($tri['edu_otras_ofertas'])?>";


function sale_esta(){

if(document.getElementById("edu_asiste").value!="1"){

 document.getElementById("edu_establecimiento").value="";
 document.getElementById("edu_establecimiento").disabled=true;

 document.getElementById("edu_distrito_caba").value="0";
 document.getElementById("edu_distrito_caba").disabled=true;
 document.getElementById("edu_municipio_pba").value="0";
 document.getElementById("edu_municipio_pba").disabled=true;
 document.getElementById("edu_gestion").value="0";
 document.getElementById("edu_gestion").disabled=true;
 document.getElementById("edu_tipo_establecimiento").value="0";
 document.getElementById("edu_tipo_establecimiento").disabled=true;

 document.getElementById("edu_nivel").value="0";

 document.getElementById("edu_regular").value="0";
 document.getElementById("edu_regular").disabled=true;

 document.getElementById("edu_grado").value="0";
 document.getElementById("edu_grado").disabled=true;

 document.getElementById("edu_turno").value="0";
 document.getElementById("edu_turno").disabled=true;

 document.getElementById("edu_ultimo_grado").disabled=false;

 document.getElementById("edu_ultimo_anio").disabled=false;

 enfoca("edu_nivel");

} else{ 

 document.getElementById("edu_ultimo_grado").disabled=true;
 document.getElementById("edu_ultimo_anio").disabled=true;
 document.getElementById("edu_ultimo_grado").value="0";
 document.getElementById("edu_ultimo_anio").value="";
 document.getElementById("edu_establecimiento").disabled=false;
 document.getElementById("edu_distrito_caba").disabled=false;
 document.getElementById("edu_municipio_pba").disabled=false;
 document.getElementById("edu_gestion").disabled=false;
 document.getElementById("edu_tipo_establecimiento").disabled=false;
 document.getElementById("edu_regular").disabled=false;
 document.getElementById("edu_grado").disabled=false;
 document.getElementById("edu_turno").disabled=false;

};


return true;

}



function valida(){

edu_establecimiento=document.getElementById("edu_establecimiento").value;
if(document.getElementById("edu_asiste").value=="0"){status("asiste a Est.Educ. Obligatorio");return false;};
if(document.getElementById("edu_asiste").value=="1" && edu_establecimiento==""){status("establecimiento obligatorio"); return false;}; 

if(edu_establecimiento!=""){

if(document.getElementById("edu_distrito_caba").value<="0" && document.getElementById("edu_municipio_pba").value<="0"){status("indicar distrito o municipio"); return false;};
if(document.getElementById("edu_grado").value<="0"){status("grado/año/sala obligatorio, aunque sea categoría sin grado definido");return false;};

};
if(document.getElementById("edu_nivel").value<="0"){status("nivel obligatorio, aunque sea sin nivel");return false;};



if(document.getElementById("edu_apoyo").value=="1" && document.getElementById("edu_apoyo_efector").value==""){
  status("indicar efector de apoyo escolar"); return false;};

status("");

return true;  



}

function guardar(){
if(!valida()) {return false;
};
return true;

}

enfoca("edu_asiste");
</script>



</body>