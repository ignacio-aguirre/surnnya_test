<?php 
include("funciones.php");
session_start();
if(!$_SESSION["hogar"]>"0"){Redirect(".");};
localidades();
$nnya=$_SESSION["nnnya_actual"];
$hogar=$_SESSION["hogar"];
$_SESSION["prestacion"]="Identidad y Datos Generales";
$nya=un_registro("select * from alojados where idalojados=".$nnya);
include("encabezado.php");
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$trimestral=un_campo("select trimestral from trim_identidad where legajo=".$nnya." and hogar=".$hogar." and trimestre=".$trimestre." and anio=".$anio);
if($trimestral>"0"){$tri=un_registro("select * from trim_identidad where trimestral=".$trimestral);}
else{$tri=un_registro("select * from trim_identidad where legajo=".$nnya." and hogar=".$hogar." order by anio desc, trimestre desc limit 1");};
?>
</div>
<div class="container">
<form class="form" action="identidad_do" method="post" onsubmit="return guardar()">
<ul class="list-group">
<li class="list-group-item text-primary">Apellidos:<strong><?php echo $nya["apellidos"]?></strong>&nbsp;-&nbsp;Nombres:<strong><?php echo $nya["nombres"]?></strong>&nbsp;-&nbsp;
 <strong><?php echo "Trimestre ".$trimestre." ".$anio?></strong></li>
<li class="list-group-item">Otros Nombres a los que Responde:<input class="form-control" name="otros_nombres" id="otros_nombres" size="40" maxlength="45" onblur="valida_0(this.id)" autofocus></li>
<li class="list-group-item">Nacimiento Pa&iacute;s: <select class="form-control" id="pais_nacimiento"  name="pais_nacimiento" onblur="sale_switch(this.id,'provincia_nacimiento')"><?php echo opciones("paises");?></select>&nbsp;
Provincia:<select class="form-control" id="provincia_nacimiento" name="provincia_nacimiento"><?php echo opciones("provincias");?></select></li>

<li class="list-group-item">&Uacute;lt. Residencia Familiar Pa&iacute;s:<select class="form-control" id="pais_ultresfam" name="pais_ultresfam"  onblur="sale_paurf()">
<?php echo opciones("paises");?></select>&nbsp;
Provincia:<select class="form-control" id="provincia_ultresfam" name="provincia_ultresfam" onblur="sale_prurf()">
<?php echo opcionest("provincias");?></select>&nbsp;
Partido:<select class="form-control" id="partido_ultresfam" name="partido_ultresfam" onblur="sale_parurf()">
<?php echo opcionest("partidos")?></select>
Localidad:<select onblur="sale_lourf()" onfocus="reclurf()"class="form-control" id="localidad_ultresfam" name="localidad_ultresfam"><?php echo localidades()?></select>
Barrio:<select class="form-control" id="barrio_ultresfam" name="barrio_ultresfam"><?php echo barrios();?></select>
</li>


<li class="list-group-item">Origen Familiar Pa&iacute;s:<select class="form-control" id="pais_origenfam"  name="pais_origenfam" onblur="sale_switch(this.id,'provincia_origenfam')"><?php echo opciones("paises");?></select>&nbsp;
Provincia:<select class="form-control" id="provincia_origenfam" name="provincia_origenfam"><?php echo opciones("provincias");?></select></li>
</li>
<li class="list-group-item">Identidad de G&eacute;nero<select class="form-control" id="identidad_genero" name="identidad_genero"><?php echo opc_tabla("GENERO");?></select></li>
<li class="list-group-item">Tiene Partida de Nacimiento:<select class="form-control" id="partida"  name="partida" onblur="sale_partida"><?php sino();?></select>&nbsp;
Partida de Nacimiento en el Hogar:<select class="form-control" id="partida_ubicacion" name="partida_ubicacion"><?php blancosino();?></select>&nbsp;
Posee Documento de Identidad:<select class="form-control" id="documento_posee" name="documento_posee" onblur="sale_posee()"><?php blancosino();?></select></li>
<li class="list-group-item">Tipo de Documento:<select class="form-control" id="documento_tipo" name="documento_tipo"><?php echo opc_tabla("TD");?></select>&nbsp;
N&uacute;mero de Documento sin puntos:<input class="form-control" id="documento_numero" name="documento_numero"  size="15" maxlength="20">&nbsp;
Ubicaci&oacute;n F&iacute;sica:<select class="form-control" id="documento_ubicacion" name="documento_ubicacion"><?php echo opc_tabla("UBICACION");?></select></li>
<li class="list-group-item">Informaci&oacute;n de familiares y/o referentes comunitarios: </li>
<textarea class="form-control" id="informacion_familiar" name="informacion_familiar" cols="90" rows="8"> <?php echo $tri["informacion_familiar"]?></textarea></li>
</ul>

<button class="btn-primary" id="aceptar">Guardar Cambios</button>
</form>
</div>

<script>
var relocurf=false;

otros_nombres.value="<?php echo comillas($tri["otros_nombres"]);?>";
seleccionar("pais_nacimiento","<?php echo $tri["pais_nacimiento"]?>");
if(pais_nacimiento.value=="9"){
provincia_nacimiento.disabled=false;
seleccionar("provincia_nacimiento","<?php echo $tri['provincia_nacimiento']?>");
}
else{
provincia_nacimiento.disabled=true;
provincia_nacimiento.value="";
};
seleccionar("pais_ultresfam","<?php echo $tri['pais_ultresfam']?>");
seleccionar("localidad_ultresfam","<?php echo $tri['localidad_ultresfam']?>");
if(pais_ultresfam.value=="9"){
document.getElementById("provincia_ultresfam").disabled=false;
seleccionar("provincia_ultresfam","<?php echo $tri['provincia_ultresfam']?>");
document.getElementById("partido_ultresfam").disabled=false;
seleccionar("partido_ultresfam","<?php echo $tri['partido_ultresfam']?>");
document.getElementById("barrio_ultresfam").disabled=false;
seleccionar("barrio_ultresfam","<?php echo $tri['barrio_ultresfam']?>");
}
else{
document.getElementById("provincia_ultresfam").disabled=true;
seleccionar("provincia_ultresfam","");
document.getElementById("partido_ultresfam").disabled=true;
seleccionar("partido_ultresfam","");
document.getElementById("barrio_ultresfam").disabled=false;
seleccionar("barrio_ultresfam","");
};
seleccionar("pais_origenfam","<?php echo $tri['pais_origenfam']?>");
if(pais_origenfam.value=="9"){
provincia_origenfam.disabled=false;
seleccionar("provincia_origenfam","<?php echo $tri['provincia_origenfam']?>");
}
else{
provincia_origenfam.disabled=true;
provincia_origenfam.value="";
};
seleccionar("identidad_genero","<?php $tri['identidad_genero']?>");
seleccionar("partida","<?php echo $tri['partida']?>");
seleccionar("partida_ubicacion","<?php echo $tri['partida_ubicacion']?>");
if("<?php echo $nya['dni'];?>">0) {seleccionar("documento_posee","1");
                   seleccionar("documento_tipo","1");
                   document.getElementById("documento_numero").value="<?php echo $nya['dni'];?>";
		   document.getElementById("documento_ubicacion").value="<?php echo comillas($tri['documento_ubicacion']);?>";
		   document.getElementById("documento_numero").disabled=false;
	           document.getElementById("documento_posee").disabled=true;
tiene_doc=true;		
}
else {tiene_doc=false;};

function sale_posee(){
if(document.getElementById("documento_posee").value!="1"){
		   document.getElementById("documento_numero").disabled=true;
	           document.getElementById("documento_tipo").disabled=true;
		   document.getElementById("documento_ubicacion").disabled=true;
}
else{
		   document.getElementById("documento_numero").disabled=tiene_doc;
	           document.getElementById("documento_tipo").disabled=false;
		   document.getElementById("documento_ubicacion").disabled=false;
};
return true;
}

function sale_partida(){
if(document.getElementById("partida").value!="1"){
		   document.getElementById("partida_ubicacion").disabled=true;
		   seleccionar("partida_ubicacion","0");
}

else{
		   document.getElementById("partida_ubicacion").disabled=false;
};
return true;
}

function sale_switch(control_salida,control_destino){
if(control_destino=="partido_ultresfam"){
  valor="2";
}else{valor="9";};
if(document.getElementById(control_salida).value==valor){
document.getElementById(control_destino).disabled=false;
document.getElementById(control_destino).focus();
}
else{
document.getElementById(control_destino).disabled=true;
document.getElementById(control_destino).value="";
};
return true;	
}

function sale_paurf(){
pais=document.getElementById("pais_ultresfam").value;
if(pais==9){
	document.getElementById("provincia_ultresfam").disabled=false;
	document.getElementById("partido_ultresfam").disabled=false;
	document.getElementById("barrio_ultresfam").disabled=false;
}else{
        seleccionar("provincia_ultresfam","");
        seleccionar("barrio_ultresfam","");
        seleccionar("partido_ultresfam","");
	document.getElementById("partido_ultresfam").disabled=true;
	document.getElementById("barrio_ultresfam").disabled=true;
        document.getElementById("provincia_ultresfam").disabled=true;
	
}
}
function sale_parurf(){
part=document.getElementById("partido_ultresfam").value;
if(part==""){
   document.getElementById("localidad_ultresfam").innerHTML=eje("sq_loc?prov=Buenos Aires");
}
else{
   document.getElementById("localidad_ultresfam").innerHTML=eje("sq_loc?part="+part);
};
  document.getElementById("localidad_ultresfam").focus;		

}
function sale_prurf(){
 prov=document.getElementById("provincia_ultresfam").value;
 document.getElementById("partido_ultresfam").disabled=false;
 document.getElementById("localidad_ultresfam").disabled=false;
 document.getElementById("localidad_ultresfam").innerHTML=eje("sq_loc?prov=");


 if(prov=="CABA"){

	seleccionar("localidad_ultresfam","CABA");
	document.getElementById("localidad_ultresfam").disabled=true;
	seleccionar("partido_ultresfam","");
	document.getElementById("partido_ultresfam").disabled=true;
	document.getElementById("barrio_ultresfam").disabled=false;
 }
 else{
	document.getElementById("localidad_ultresfam").innerHTML=eje("sq_loc?prov="+prov);
	if(prov!="Buenos Aires") {
        	seleccionar("partido_ultresfam","");
		document.getElementById("partido_ultresfam").disabled=true;
	};
	seleccionar("barrio_ultresfam","");
	document.getElementById("barrio_ultresfam").disabled=true;
}
}
function reclurf(){
 if(relocurf){
   sale_prurf();
   relocurf=false;
 };
}
function sale_lourf(){
  pais=document.getElementById("pais_ultresfam").value;
  prov=document.getElementById("provincia_ultresfam").value;
  part=document.getElementById("partido_ultresfam").value;
  loca=document.getElementById("localidad_ultresfam").value;
  if(loca=="999"){seleccionar("localidad_ultresfam","");
    document.getElementById("localidad_ultresfam").value;
    relocurf=true;
    naveganuevo("nlocalidad?pais="+pais+"&provincia="+prov+"&partido="+part);};

  if(pais=="9"){
     if(prov=="Buenos Aires" && loca!=""){
	partido=eje("sq_partido?loca="+loca);	

	seleccionar("partido_ultresfam",partido);
     };	
  } else{
  };
 
}
function guardar(){
valida_0("otros_nombres");
otros_nombres=document.getElementById("otros_nombres").value;
pais_nacimiento=document.getElementById("pais_nacimiento").value;
if(pais_nacimiento==0){status("Pa&iacute;s de Nacimiento es un dato obligatorio");return false;};
provincia_nacimiento=document.getElementById("provincia_nacimiento").value;
pais_ultresfam=document.getElementById("pais_ultresfam").value;
if(pais_ultresfam==0) {
 document.getElementById("localidad_ultresfam").value="";
 seleccionar("provincia_ultresfam","");
 seleccionar("partido_ultresfam","");
 seleccionar("barrio_ultresfam","");
};
if(document.getElementById("provincia_ultresfam").value=="CABA"){
 seleccionar("localidad_ultresfam","CABA");}
else if(document.getElementById("localidad_ultresfam").value=="CABA" && document.getElementById("provincia_ultresfam").value==""){
  seleccionar("provincia_ultresfam","CABA");}
else if(document.getElementById("localidad_ultresfam").value=="CABA" && document.getElementById("provincia_ultresfam").value!="CABA"){
   seleccionar("localidad_ultresfam","");
};
if(document.getElementById("localidad_ultresfam").value=="999"){status("completar localidad URF");return false;};
identidad_genero=document.getElementById("identidad_genero").value;
if(!(identidad_genero>"0")){status("Identidad de g&eacute;nero es un dato obligatorio");return false;};
pais_origenfam=document.getElementById("pais_origenfam").value;
provincia_origenfam=document.getElementById("provincia_origenfam").value;
partida=document.getElementById("partida").value;

/* si es NN invalida todo el resto */

sale_partida();

partida_ubicacion=document.getElementById("partida_ubicacion").value;

if(partida=="1" && partida_ubicacion=="0"){status("Partida en hogar Obligatorio");return false;};

documento_posee=document.getElementById("documento_posee").value;

/* si no posee documento invalida todo el resto */

if(documento_posee!="1") {

 		documento_tipo="0";

 		document.getElementById("documento_numero").value="";

 		documento_numero="";

 		documento_ubicacion="0";

   } 

  else{

		documento_tipo=document.getElementById("documento_tipo").value;

		documento_numero=document.getElementById("documento_numero").value;

		/* si el tipo de documento es 1 DNI valida el número como número y en cierto rango */

		if(documento_tipo=="1"){

			valida_entero("documento_numero");

			documento_numero=document.getElementById("documento_numero").value;

			if(documento_numero<"10000000") {status("DNI incorrecto");return false;};

		};

		documento_ubicacion=document.getElementById("documento_ubicacion").value;
		informacion_familiar=document.getElementById("informacion_familiar").value;

};



identidad_genero=document.getElementById("identidad_genero").value;
document.getElementById("pais_nacimiento").focus();
status("");
if(confirm("Cancela para hacer modificaciones o revisar. Acepta para Guardar los datos.")){
return true;
};
return false;
}
</script>
</body>