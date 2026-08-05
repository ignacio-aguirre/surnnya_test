<?php 
include("funciones.php");
session_start();
$nnya=$_SESSION["nnnya_actual"];
$hogar=$_SESSION["hogar"];
$_SESSION["prestacion"]="Necesidades de Apoyo por discapacidades";
$nya=un_registro("select * from alojados where idalojados=".$nnya);
include("encabezado.php");
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$trimestral=un_campo("select trimestral from trim_discapacidad where legajo=".$nnya." and hogar=".$hogar." and trimestre=".$trimestre." and anio=".$anio);
if($trimestral>"0"){$tri=un_registro("select * from trim_discapacidad where trimestral=".$trimestral);}
else{$tri=un_registro("select * from trim_discapacidad where legajo=".$nnya." and hogar=".$hogar." order by anio desc, trimestre desc limit 1");};

?>
</div>
<div class="container">
<ul class="list-group">
<li class="list-group-item text-primary">Apellidos:<strong><?php echo $nya["apellidos"]?></strong>&nbsp;-&nbsp;Nombres:<strong><?php echo $nya["nombres"]?></strong>&nbsp;-&nbsp;
<strong><?php echo "Trimestre ".$trimestre." ".$anio?></strong></li>
<li class="list-group-item">Tipo Discapacidad: <select class="form-control" id="tipo_discapacidad" onchange="sale_tipo()" onblur="sale_tipo()" autofocus><?php echo opc_tabla("DIS_TIPO")?></select>
&nbsp;C.U.D.: <select class="form-control" id="certificado_discapacidad" onblur="sale_certificado()"><?php blancosino()?><option value="3">En Tr&aacute;mite</option></select>
&nbsp;Fecha de Vencimiento CUD: <input class="form-control" id="cd_vencimiento" onblur="valida_fecha(this.id,'1')" size="10" maxlength="10"></li>
<li class="list-group-item">Diagn&oacute;stico:<input class="form-control" id="cd_diagnostico" size="80" maxlength="120" placeholder="si hay CUD, lo informado en el mismo, sino diagn&oacute;stico m&eacute;dico"></li>
<li class="list-group-item">Orientaci&oacute;n Prestacional:<input class="form-control" id="cd_prestaciones" size="80" maxlength="120" placeholder="ej.prestaciones de apoyo, de rehabilitaci&oacute;n, otras"></li>

<li class="list-group-item">Pensi&oacute;n: <select class="form-control" id="pension" onblur="sale_pension()"><?php blancosino()?><option value="3">En Tr&aacute;mite</option></select>
&nbsp;Estado del Tr&aacute;mite (*): <select class="form-control" id="pension_estado_tramite" onblur="sale_estado()"><?php echo opc_tabla("DIS_PET")?></select>
&nbsp;Afiliaci&oacute;n a P.F.Incluir Salud: <select class="form-control" id="incluir_salud"><?php blancosino()?></select></li>

</ul>

<p class='text-warning'>(*) Completar s&oacute;lo si la Pensi&oacute;n se encontrara en tr&aacute;mite</p>

<button class="btn-primary" id="aceptar" onclick="guardar()">Guardar Cambios</button>

</div>

<script>
seleccionar("certificado_discapacidad","<?php echo $tri['certificado_discapacidad']?>");
document.getElementById("cd_vencimiento").value="<?php echo ffec($tri['cd_vencimiento'])?>";
document.getElementById("cd_diagnostico").value="<?php echo comillas($tri['cd_diagnostico'])?>";
document.getElementById("cd_prestaciones").value="<?php echo comillas($tri['cd_prestaciones'])?>";
seleccionar("tipo_discapacidad","<?php echo $tri['tipo_discapacidad']?>");
seleccionar("pension","<?php echo $tri['pension']?>");
seleccionar("pension_estado_tramite","<?php echo $tri['pension_estado_tramite']?>");
seleccionar("incluir_salud","<?php echo $tri['incluir_salud']?>");









function sale_certificado(){

certificado_discapacidad=document.getElementById("certificado_discapacidad").value;

if(certificado_discapacidad=="1"){

  document.getElementById("cd_vencimiento").disabled=false;

  enfoca("cd_vencimiento");

}

else{

  document.getElementById("cd_vencimiento").value="";

  document.getElementById("cd_vencimiento").disabled=true;

};

return true;

}

function sale_tipo(){

tipo_discapacidad=document.getElementById("tipo_discapacidad").value;

if(tipo_discapacidad=="0"){

 

  document.getElementById("certificado_discapacidad").value="0";
  document.getElementById("certificado_discapacidad").disabled=true;


  document.getElementById("cd_vencimiento").value="";
  document.getElementById("cd_vencimiento").disabled=true;
  document.getElementById("cd_diagnostico").value="";
  document.getElementById("cd_diagnostico").disabled=true;
  document.getElementById("cd_prestaciones").value="";
  document.getElementById("cd_prestaciones").disabled=true;


  document.getElementById("pension").value="0";
  document.getElementById("pension").disabled=true;

  document.getElementById("pension_estado_tramite").value="0";
  document.getElementById("pension_estado_tramite").disabled=true;
  document.getElementById("incluir_salud").value="0";
  document.getElementById("incluir_salud").disabled=true;

    document.getElementById("aceptar").focus();

}

else{


  document.getElementById("certificado_discapacidad").disabled=false;
  document.getElementById("cd_vencimiento").disabled=false;
  document.getElementById("cd_diagnostico").disabled=false;
  document.getElementById("cd_prestaciones").disabled=false;

  document.getElementById("pension").disabled=false;

  document.getElementById("pension_estado_tramite").disabled=false;

  document.getElementById("incluir_salud").disabled=false;

  enfoca("certificado_discapacidad");

};

return true;

}

function sale_estado(){

 if(document.getElementById("pension_estado_tramite").value=="0" && document.getElementById("pension").value=="3") {status("completar estado");return false;};

  return true;

}



function sale_pension(){

pension=document.getElementById("pension").value;

if(pension=="3"){

 document.getElementById("pension_estado_tramite").disabled=false;

 enfoca("pension_estado_tramite");

}

else{

 document.getElementById("pension_estado_tramite").value="0";

 document.getElementById("pension_estado_tramite").disabled=true;

 enfoca("incluir_salud");

};

return true;

}



function validar(){


sale_certificado();

sale_pension();


sale_estado();
if(document.getElementById("tipo_discapacidad").value>"0" && document.getElementById("certificado_discapacidad").value=="0"){status("certificado obligatorio si tiene discapacidad");return false;};
if(document.getElementById("cd_vencimiento").value=="" && document.getElementById("certificado_discapacidad").value=="1"){status("vencimiento CUD obligatorio si tiene CUD");return false;};
if(document.getElementById("pension_estado_tramite").value=="0" && document.getElementById("pension").value=="3"){status("estado del trámite de la pensión");return false;};

status("");
return true;
}



function guardar(){

if(!validar()) return false;

certificado_discapacidad=document.getElementById("certificado_discapacidad").value;

cd_vencimiento=document.getElementById("cd_vencimiento").value;
cd_diagnostico=document.getElementById("cd_diagnostico").value;
cd_prestaciones=document.getElementById("cd_prestaciones").value;


tipo_discapacidad=document.getElementById("tipo_discapacidad").value;

pension=document.getElementById("pension").value;

pension_estado_tramite=document.getElementById("pension_estado_tramite").value;

incluir_salud=document.getElementById("incluir_salud").value;

if(confirm("Cancela para hacer modificaciones o revisar. Acepta para Guardar los datos.")){

navega("discapacidad_do?certificado_discapacidad="+certificado_discapacidad+"&cd_vencimiento="+cd_vencimiento+"&tipo_discapacidad="+tipo_discapacidad+
"&cd_diagnostico="+cd_diagnostico+"&cd_prestaciones="+cd_prestaciones+
"&pension="+pension+"&pension_estado_tramite="+pension_estado_tramite+"&incluir_salud="+incluir_salud);
};
return true;
}

</script>



</body>