<?php
include("Funciones.php");
session_start();
if(!isset($_GET["id"])) Redirect("ongs");
if($_SESSION['gl_tablaongs']!="1") header("Location: error_noautorizado");

$id=nget("id");
$ong="0";
if(isset($_GET["ong"])){$ong=nget("ong");};
$_SESSION["prestacion"]="Datos Dispositivo";
$r=un_registro("select * from dispositivos where dispositivos.id=".$id);
include("encabezado.php");?>
</div>
<div class="container">
<form class="form-inline" method="get" onsubmit="return valida()" action="un_dispositivo_do">
        <div class="form-group has-warning">
		<label class="label-form" for="nombre">Nombre</label>
		<input class="form-control" id="nombre" name="nombre" size="80" maxlength="200" required autofocus value="<?php echo $r['nombre']?>" onblur="valida_0(this.id)">
	</div>
	<br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="conveniado">Conveniado con GCABA</label>
		<input class="form-control" type="checkbox" id="conveniado" name="conveniado" <?php echo si($r['conveniado']==1," checked","");?>>
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="area_gubernamental">&Aacute;rea Gubernamental</label>
		<select class='form-control' name='area_gubernamental' id='area_gubernamental'><?php echo opc_tabla("AGUB")?></select>
	</div>
	<br><br>

	<div class="form-group has-warning">
		<label class="label-form" for="ong">Ong</label>
		<select class='form-control' name='ong' id='ong'><?php echo tbla("hogares_ong")?></select>
	</div>
	<br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="tipo_dispositivo">Tipo de Dispositivo</label>
		<select class='form-control' name='tipo_dispositivo' id='tipo_dispositivo'>
		<?php echo opc_tabla("DITIP");?>

		</select>
	</div>
	
        <h4>Domicilio</h4>
	<div class="form-group has-warning">
		<label class="label-form" for="domicilio">Calle y Altura</label>
		<input class="form-control" id="domicilio" name="domicilio" size="50" maxlength="200" onblur="normaliza_calle()" value="<?php echo $r['domicilio']?>">
        </div>
	<div class="form-group has-warning">
                <var class="text-warning" id='resultado'></var>
	</div>
      	&nbsp;&nbsp;
	<div class="form-group has-warning">
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

        <br><br>
      
	<div class="form-group has-warning">
		<label class="label-form" for="barrio">Barrio (s&oacute;lo para CABA)</label>
		<input class="form-control" id="barrio" name="barrio" size="30" maxlength="50" value="<?php echo $r['barrio']?>">
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="comuna">Comuna (s&oacute;lo para CABA)</label>
		<input class="form-control" id="comuna" name="comuna" type="number" min="1" max="15" value="<?php echo $r['comuna']?>">
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
		<label class="label-form" for="referente">Referente</label>
		<input class="form-control" id="referente" name="referente" size="50" maxlength="100"  value="<?php echo $r['referente']?>" onblur="valida_0(this.id)">
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="celular_referente">Celular</label>
		<input class="form-control" id="celular_referente" name="celular_referente" size="40" maxlength="50" value="<?php echo $r['celular_referente']?>" onblur="valida_0(this.id)">
		<img src="imagenes/wapp.png" height="20" width="20" onclick="whatsapea()">
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="dni_referente">DNI</label>
		<input class="form-control" id="dni_referente" name="dni_referente" size="8" maxlength="9" value="<?php echo $r['dni_referente']?>" onblur="valida_entero(this.id)">
        </div> 
	<br><br>
            
        <h4>Poblaci&oacute;n Objetivo</h4>
	<div class="form-group has-warning">
		<label class="label-form" for="genero">G&eacute;nero</label>
		<select class="form-control" id="genero" name="genero">
		<option value="1">Femenino</option>
		<option value="2">Masculino</option>
		<option value="3">Ambos</option>
		</select>
	</div>

	<div class="form-group has-warning">
		<label class="label-form" for="etaria_desde">Franja Etaria: Desde</label>
		<input class="form-control" type="number" min="0" max="99" id="etaria_desde" name="etaria_desde" value="<?php echo $r['etaria_desde']?>">
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="etaria_hasta">Hasta</label>
		<input class="form-control" type="number" min="0" max="99" id="etaria_hasta" name="etaria_hasta" value="<?php echo $r['etaria_hasta']?>">
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="poblacion">Especificaci&oacute;n</label>
		<input class="form-control" id="poblacion" name="poblacion" size="50" maxlength="100" value="<?php echo $r['poblacion']?>" onblur="valida_0(this.id)">
	</div>
	<br><br>
  <h4>Caracter&iacute;sticas del Dispositivo</h4>
	<div class="form-group has-warning">
		<label class="label-form" for="modalidad">Modalidad de Atenci&oacute;n</label>
		<select class='form-control' name='modalidad' id='modalidad'>
<?php
$mod=registros("select * from tablas where baja is null and tipo='HOMOD' order by deno");
while($m=mysqli_fetch_assoc($mod)){
 echo "<option value='".$m["valo"]."'>".$m["deno"]."</option>";
};
?>
	</select>
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="plazas">Plazas</label>
		<input class="form-control" id="plazas" name="plazas" type="number" min="0" max="500" required value="<?php echo $r['plazas']?>">
	</div>
	&nbsp;<div class="form-group has-warning">
		<label class="label-form" for="frecuencia">Frecuencia Monitoreo</label>
		<select class="form-control" id="frecuencia" name="frecuencia">
		<option value="3">Trimestral</option>
		<option value="4">Cuatrimestral</option>
		<option value="6">Semestral</option>
		<option value="12">Anual</option>
		</select>
	</div>
	&nbsp;<div class="form-group has-warning">
		<label class="label-form" for="ultimo_monitoreo">&Uacute;ltimo Monitoreo</label>
		<input class="form-control" id="ultimo_monitoreo" name="ultimo_monitoreo" size="10" maxlength="10" value="<?php echo ffec($r['ultimo_monitoreo'])?>" onblur="valida_fecha(this.id,1)">
	</div>
	<hr>
	<div class="form-group has-warning">
		<label class="label-form" for="usuario_monitoreo">Responsable Monitoreo</label>
		<select class="form-control" id="usuario_monitoreo" name="usuario_monitoreo">
			<?php echo tbla('UMO')?>
		</select>
	</div>&nbsp;&nbsp
	<div class="form-group has-warning">
        <p class="text-warning">Tildar para todos los dispositivos propios o supervisados por CDNNYA</p>
		<label class="label-form" for="baja">En n&oacute;mina CDNNYA</label>
		<input class="form-control" type="checkbox" id="nomina_hogares" name="nomina_hogares">
	</div>
	&nbsp;&nbsp;&nbsp;
	<div class="form-group has-warning">
		<label class="label-form" for="baja">Fecha Baja</label>
		<input class="form-control" id="baja" name="baja" size="10" maxlength="10" value="<?php echo ffec($r['baja'])?>" onblur="valida_fecha(this.id,1)">
	</div>
	<hr>
	<div class="form-group has-warning">
		<label class="label-form" for="tramite_eximicion">Tr&aacute;mite Eximici&oacute;n de Habilitaci&oacute;n</label>
		<input class="form-control" name="tramite_eximicion" id="tramite_eximicion" size="40" maxlength="50" value="<?php echo $r["tramite_eximicion"]?>" onblur="valida_0(this.id)">
	</div>
	<hr>
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
seleccionar("ong","<?php echo si($ong>0,$ong,$r['ong'])?>");
seleccionar("area_gubernamental","<?php echo $r['area_gubernamental']?>");
seleccionar("tipo_dispositivo","<?php echo $r['tipo_dispositivo']?>");
seleccionar("modalidad","<?php echo $r['modalidad']?>");
seleccionar("frecuencia","<?php echo $r['frecuencia']?>");
seleccionar("genero","<?php echo $r['genero_poblacion']?>");
seleccionar("usuario_monitoreo","<?php echo $r['usuario_monitoreo']?>");
document.getElementById("conveniado").checked=(document.getElementById("ong").value>0);
document.getElementById("nomina_hogares").checked=("<?php echo $r['nomina_hogares']?>"=="1");
function valida(){
valida_0("nombre");
valida_0("referente");
valida_0("domicilio");
valida_0("telefonos");
valida_fecha("baja",1);
valida_mail("email");
document.getElementById("cod_calle").disabled=false;
document.getElementById("altura").disabled=false;
document.getElementById("geo_x").disabled=false;
document.getElementById("geo_y").disabled=false;
status("");
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
 calle=document.getElementById("domicilio").value;
 if(calle!=""){
 calle=calle.replace("Ñ","N").replace("ñ","n");
 
  var xhttp = new XMLHttpRequest();
 xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
 	document.getElementById("resultado").innerHTML="";
        resp = xhttp.responseText;
        var objeto = JSON.parse(resp);
        if(typeof objeto.errorMessage!="undefined"){bus_error(objeto.errorMessage);};
        document.getElementById("sugerencias").options.length=0;
        if(objeto.direccionesNormalizadas.length==1){
	document.getElementById("resultado").innerHTML="OK";

         document.getElementById("domicilio").value=objeto.direccionesNormalizadas[0].nombre_calle+" "+objeto.direccionesNormalizadas[0].altura;
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
	  c.text = objeto.direccionesNormalizadas[i].nombre_calle+","+objeto.direccionesNormalizadas[i].nombre_localidad+"|"+objeto.direccionesNormalizadas[i].altura+"#"+
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
  if(sele.options.length>0){
  valor=sele.options[sele.selectedIndex].value;
  sele.options.length=0;
  posi_localidad=valor.indexOf(",");
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
  document.getElementById("domicilio").value=call+" "+altu;
  document.getElementById("cod_calle").value=codc;
  document.getElementById("altura").value=altu;
  document.getElementById("localidad").value=loca;
  document.getElementById("geo_x").value=geox;
  document.getElementById("geo_y").value=geoy;
  completa_mas(loca);	
  } else {sele.disabled=true;};
  document.getElementById("piso_departamento").focus();
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
 } else {
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
