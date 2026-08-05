<?php
include("Funciones.php");
session_start();
if(!isset($_GET["id"])) Redirect("ongs");
if($_SESSION['gl_tablaongs']!="1"){Redirect("error_noautorizado");};
$id=nget("id");
$_SESSION["prestacion"]="Datos ONG";
$r=un_registro("select * from hogares_ong where id=".$id);
include("encabezado-test.php");?>
</div>
<div class="container">
<form class="form-inline" method="get" onsubmit="return valida()" action="una_ong_do">
	<div class="form-group has-warning">
		<label class="label-form" for="legajo">Legajo</label>
		<input class="form-control" id="legajo" name="legajo" maxlength="6" type="number" min="0" max="999999" required autofocus value="<?php echo $r['legajo']?>">
	</div>

        <div class="form-group has-warning">
		<label class="label-form" for="nombre">Raz&oacute;n Social</label>
		<input class="form-control" id="nombre" name="nombre" size="80" maxlength="200" required value="<?php echo $r['nombre']?>" onblur="valida_0(this.id)">
	</div>
        <br><br>
	
	<div class="form-group has-warning">
		<label class="label-form" for="igj">Nro.Personer&iacute;a Jur&iacute;dica</label>
		<input class="form-control" id="igj" name="igj" maxlength="6" type="number" min="1" max="20000000" value="<?php echo $r['igj']?>">
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="cuit">CUIT</label>
		<input class="form-control" id="cuit" name="cuit" size="11" maxlength="11" value="<?php echo $r['cuit']?>" onblur="validac()">
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="tipo_entidad">Forma Jur&iacute;dica</label>
		<select class="form-control" id="tipo_entidad" name="tipo_entidad">
		<?php echo opc_tabla("TENT")?>
                </select>
	</div>
	<br><br>
        <h4>Domicilio Legal</h4>
	<div class="form-group has-warning">
		<label class="label-form" for="domicilio_legal">Calle y Altura</label>
		<input class="form-control" id="domicilio_legal" name="domicilio_legal" size="50" maxlength="200" onblur="normaliza_calle()" value="<?php echo $r['domicilio_legal']?>">
        </div>
        <br>
	<div class="form-group has-warning">
                <var class="text-warning" id='resultado'></var>
	</div>
      	&nbsp;&nbsp;<div class="form-group has-warning">
		<select class="form-control" id='sugerencias' disabled onblur='copiadom()'></select>
        </div>
	
       <br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="piso_departamento">Piso, Departamento, otros</label>
		<input class="form-control" id="piso_departamento" name="piso_departamento" size="20" maxlength="50" onblur="valida_0(this.id)" value="<?php echo $r['piso_departamento']?>">
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="localidad">Localidad</label>
		<input class="form-control" id="localidad" name="localidad" size="20" maxlength="50" value="<?php echo $r['localidad']?>" onblur="valida_0(this.id)">
	</div>

	<div class="form-group has-warning">
		<label class="label-form" for="codigo_postal">C&oacute;digo Postal</label>
		<input class="form-control" id="codigo_postal" name="codigo_postal" size="15"  value="<?php echo $r['codigo_postal']?>" onblur="valida_0(this.id)">
	</div>
        <br><br>
      
	<div class="form-group has-warning">
		<label class="label-form" for="barrio">Barrio (s&oacute;lo para CABA)</label>
		<input class="form-control" id="barrio" name="barrio" size="30" maxlength="50" value="<?php echo $r['barrio']?>" >
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="comuna">Comuna (s&oacute;lo para CABA)</label>
		<input class="form-control" id="comuna" name="comuna" type="number" min="0" max="15" value="<?php echo $r['comuna']?>">
	</div>
        
        <br><br>
	  <h4>Contacto</h4>
	<div class="form-group has-warning">
		<label class="label-form" for="telefonos">Tel&eacute;fonos</label>
		<input class="form-control" id="telefonos" name="telefonos" size="40"maxlength="50" value="<?php echo $r['telefonos']?>" onblur="valida_0(this.id)">
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="email">Email</label>
		<input class="form-control" id="email" name="email" size="60" maxlength="100" value="<?php echo $r['email']?>" onblur="valida_mail(this.id)">
	</div>
	<br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="referente">Referente Institucional</label>
		<input class="form-control" id="referente" name="referente" size="50" maxlength="100" value="<?php echo $r['referente']?>" onblur="valida_0(this.id)">
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="celular_referente">Celular</label>
		<input class="form-control" id="celular_referente" name="celular_referente" size="40" maxlength="50" value="<?php echo $r['celular_referente']?>" onblur="valida_0(this.id)">
		<img src="imagenes/wapp.png" height="20" width="20" onclick="whatsapea()">
	</div>
	<br><br>
       <h4>&Aacute;reas</h4>
	<div class="form-group has-warning">
		<label class="label-form" for="atencion_directa">Atenci&oacute;n directa</label>
		<input class="form-control" type="checkbox" id="atencion_directa" name="atencion_directa"> - 
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="necesidades_especiales">Necesidades Especiales</label>
		<input class="form-control" type="checkbox" id="necesidades_especiales" name="necesidades_especiales"> - 
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="promocion">Promoci&oacute;n</label>
		<input class="form-control" type="checkbox" id="promocion" name="promocion"> - 
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="academicas_investigacion">Acad&eacute;micas / Investigaci&oacute;n</label>
		<input class="form-control" type="checkbox" id="academicas_investigacion" name="academicas_investigacion"> - 
	</div>

	<div class="form-group has-warning">
		<label class="label-form" for="genero">G&eacute;nero</label>
		<input class="form-control" type="checkbox" id="genero" name="genero"> - 
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="area_plenario">&Aacute;rea Plenario</label>
		<select class="form-control" id="area_plenario" name="area_plenario">
		<?php echo opc_tabla("AONG")?>
		</select>
	</div>

        <br><br>
       <h4>Situaci&oacute;n Actual</h4>

	<div class="form-group has-warning">
		<label class="label-form" for="conveniada">Conveniada con GCABA</label>
		<input class="form-control" type="checkbox" id="conveniada" name="conveniada">
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="reparticion_convenio">Reparticiones con Convenio</label>
		<input class="form-control" id="reparticion_convenio" name="reparticion_convenio" size="60" maxlength="100" value="<?php echo $r['reparticion_convenio']?>" onblur="valida_0(this.id)">
	</div>
	<br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="estado">Estado</label>
		<select class="form-control" id="estado" name="estado" required>
		<?php echo opc_tabla("EONG")?>
                </select>
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="estado">Departamento RONG</label>
		<select class="form-control" id="departamento" name="departamento" required>
		<option value="1">Monitoreo</option>
		<option value="2">Fiscalizaci&oacute;n</option>
                </select>
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="frecuencia_fiscalizacion">Frecuencia Fiscalizaci&oacute;n</label>
		<select class="form-control" id="frecuencia_fiscalizacion" name="frecuencia_fiscalizacion">
		<option value="0">No se fiscaliza</option>
		<option value="6">Semestral</option>
		<option value="12">Anual</option>
		<option value="24">Bianual</option>
		</select>
	</div>

	<br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="sade_alta">Nro.SADE Resoluci&oacute;n Alta</label>
		<input class="form-control" id="sade_alta" name="sade_alta" size="35" maxlength="100" value="<?php echo $r['sade_alta']?>" onblur="valida_0(this.id)">
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="fecha_alta">Fecha Alta</label>
		<input class="form-control" id="fecha_alta" name="fecha_alta" size="10" maxlength="10" value="<?php echo ffec($r['fecha_alta'])?>" onblur="valida_fecha(this.id,1)">
	</div>
	<br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="sade_baja">Nro.SADE Resoluci&oacute;n Baja</label>
		<input class="form-control" id="sade_baja" name="sade_baja" size="35" maxlength="100" value="<?php echo $r['sade_baja']?>" onblur="valida_0(this.id)">
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="baja">Fecha Baja</label>
		<input class="form-control" id="baja" name="baja" size="10" maxlength="10" value="<?php echo ffec($r['baja'])?>" onblur="valida_fecha(this.id,1)">
	</div>
        <br><br>
        <h4>Geolocalizaci&oacute;n</h4>
	<div class="form-group has-warning">
		<label class="label-form" for="geo_x">X</label>
		<input class="form-control" name="geo_x" id="geo_x" value="<?php echo $r['geo_x']?>" disabled>
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="geo_y">Y</label>
		<input class="form-control" name="geo_y" id="geo_y" value="<?php echo $r['geo_y']?>" disabled>
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="codigo_calle">C&oacute;digo de Calle</label>
		<input class="form-control" id="cod_calle" name="cod_calle" size="10" maxlength="10" value="<?php echo $r['cod_calle']?>" disabled required>
	</div>
      	<div class="form-group has-warning">
		<label class="label-form" for="altura">Altura</label>
		<input class="form-control" id="altura" name="altura" size="5" maxlength="10"  value="<?php echo $r['altura']?>" disabled required>
	</div>
	<br><br>
	<input hidden name="id" value="<?php echo $id?>">
	<input class="btn-primary" type="submit" value="Guardar">
</form>
</div>
<script>
seleccionar("tipo_entidad","<?php echo $r['tipo_entidad']?>");

seleccionar("area_plenario","<?php echo $r['area_plenario']?>");
seleccionar("estado","<?php echo $r['estado']?>");
seleccionar("departamento","<?php echo $r['departamento']?>");
seleccionar("frecuencia_fiscalizacion","<?php echo $r['frecuencia_fiscalizacion']?>");

<?php
if($r["atencion_directa"]=="1"){echo "document.getElementById('atencion_directa').checked=true;";};
if($r["necesidades_especiales"]=="1"){echo "document.getElementById('necesidades_especiales').checked=true;";};
if($r["promocion"]=="1"){echo "document.getElementById('promocion').checked=true;";};
if($r["academicas_investigacion"]=="1"){echo "document.getElementById('academicas_investigacion').checked=true;";};
if($r["genero"]=="1"){echo "document.getElementById('genero').checked=true;";};
if($r["conveniada"]=="1"){echo "document.getElementById('conveniada').checked=true;";};
?>
function valida(){
valida_0("nombre");
valida_0("referente");
valida_0("domicilio_legal");
valida_0("telefonos");
valida_0("sade_baja");
valida_fecha("fecha_alta",1);
valida_fecha("baja",1);
validac();
valida_0("codigo_postal");
valida_mail("email");
if(document.getElementById("departamento").value=="2" && document.getElementById("frecuencia_fiscalizacion").value=="0"){
status("Debe indicarse la frecuencia de fiscalizacion");
return false;
};
if(document.getElementById("departamento").value=="1" && document.getElementById("frecuencia_fiscalizacion").value!="0"){
status("Debe indicarse como frecuencia de fiscalizacion, NO SE FISCALIZA");
return false;
};

document.getElementById("cod_calle").disabled=false;
document.getElementById("altura").disabled=false;
document.getElementById("geo_x").disabled=false;
document.getElementById("geo_y").disabled=false;
status("");
return true;
}
function validac(){
status("");
valor=document.getElementById('cuit').value;
if(!validaCuit(valor)){status("CUIT "+valor+" INCORRECTO");document.getElementById('cuit').value=""; return false;};
return true;
}

function whatsapea(){
 numero="549"+document.getElementById("celular_referente").value;
 if(numero!="549"){
   naveganuevo("https://api.whatsapp.com/send?phone="+numero);
 };
}

function normaliza_calle(){
 document.getElementById("resultado").innerHTML="Buscando...";
 calle=document.getElementById("domicilio_legal").value;
 if(calle!=""){
 calle=calle.replace("Ñ","N").replace("ñ","n");
 
  var xhttp = new XMLHttpRequest();
 xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
	document.getElementById("resultado").innerHTML="Buscando...";
        resp = xhttp.responseText;
        var objeto = JSON.parse(resp);
        if(typeof objeto.errorMessage!="undefined"){bus_error(objeto.errorMessage);};
        document.getElementById("sugerencias").options.length=0;
        if(objeto.direccionesNormalizadas.length==1){
         document.getElementById("resultado").innerHTML="OK";
         document.getElementById("domicilio_legal").value=objeto.direccionesNormalizadas[0].nombre_calle+" "+objeto.direccionesNormalizadas[0].altura;
         document.getElementById("sugerencias").disabled=true;
         document.getElementById("sugerencias").options=[];
         document.getElementById("cod_calle").value=objeto.direccionesNormalizadas[0].cod_calle;
         document.getElementById("altura").value=objeto.direccionesNormalizadas[0].altura;
         document.getElementById("localidad").value=objeto.direccionesNormalizadas[0].nombre_localidad;
	 document.getElementById("geo_x").value=objeto.direccionesNormalizadas[0].coordenadas.x;
    	 document.getElementById("geo_y").value=objeto.direccionesNormalizadas[0].coordenadas.y;
	 completa_mas(document.getElementById("localidad").value);	
        };
        if(objeto.direccionesNormalizadas.length>1){
  	document.getElementById("resultado").innerHTML="Seleccionar";
        document.getElementById("cod_calle").value="";
         document.getElementById("altura").value="";
         document.getElementById("barrio").value="";
         document.getElementById("localidad").value="";
         document.getElementById("comuna").value="";
  	 document.getElementById("geo_x").value="";
	 document.getElementById("geo_y").value="";

         document.getElementById("sugerencias").disabled=false;
         for(i=0;i<objeto.direccionesNormalizadas.length;i++){
	  var c = document.createElement("option");
	  c.text = objeto.direccionesNormalizadas[i].nombre_calle+";"+objeto.direccionesNormalizadas[i].nombre_localidad+"|"+objeto.direccionesNormalizadas[i].altura+"#"+
		objeto.direccionesNormalizadas[i].cod_calle+"|";
          if(objeto.direccionesNormalizadas[i].nombre_localidad=="CABA"){
           c.text=c.text+objeto.direccionesNormalizadas[i].coordenadas.x+"|"+objeto.direccionesNormalizadas[i].coordenadas.y;
	 }else{c.text=c.text+"0|0";};
          document.getElementById("sugerencias").options.add(c,i);
         };
         document.getElementById("sugerencias").focus();

        };
       };
    };
  xhttp.open("GET", "https://servicios.usig.buenosaires.gob.ar/normalizar/?direccion="+calle+"&maxOptions=25&geocodificar=true", true);
  xhttp.send();
 };  
return true; 
}

function copiadom(){
  document.getElementById("resultado").innerHTML="";
  sele=document.getElementById("sugerencias");
  valor=sele.options[sele.selectedIndex].value;
  sele.options.length=0;
  posi_localidad=valor.indexOf(";");
  call=valor.substr(0,posi_localidad);
  valor=valor.substr(posi_localidad+1);
  posi_altura=valor.indexOf("|");
  loca=valor.substr(0,posi_altura);
  valor=valor.substr(posi_altura+1);
  posi_codcalle=valor.indexOf("#");	
  altu=valor.substr(0,posi_codcalle);
  valor=valor.substr(posi_codcalle+1);
  posi_geox=valor.indexOf("|");
  codc=valor.substr(0,posi_geox);
  valor=valor.substr(posi_geox+1);
  posi_geoy=valor.indexOf("|");
  geox=valor.substr(0,posi_geoy);
  geoy=valor.substr(posi_geoy+1);
  document.getElementById("domicilio_legal").value=call+" "+altu;
  document.getElementById("cod_calle").value=codc;
  document.getElementById("altura").value=altu;
  document.getElementById("localidad").value=loca;
  document.getElementById("geo_x").value=geox;
  document.getElementById("geo_y").value=geoy;
  completa_mas(loca);	
};
 
function completa_mas(l){
  if(l=="CABA"){
  x=document.getElementById("geo_x").value;
  y=document.getElementById("geo_y").value;
   var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
   if (this.readyState == 4 && this.status == 200) {
        resp = xhttp.response;
        var obje = JSON.parse(resp);
	document.getElementById("barrio").value=obje.barrio;
	document.getElementById("comuna").value=parseInt(obje.comuna.substr(-2));
   };
 };
  xhttp.open("GET", "https://ws.usig.buenosaires.gob.ar/datos_utiles?x="+x+"&y="+y, true);
  xhttp.send();
  } else{
	document.getElementById("barrio").value="";
	document.getElementById("comuna").value="";
  };	
}
function bus_error(mensaje){
  document.getElementById("resultado").innerHTML="La normalizaci&oacute;n ha devuelto el error "+mensaje+
  ".<br>Se puede continuar completando manualmente los campos. Se recomienda refinar la b&uacute;squeda";
}
</script>
</body>
