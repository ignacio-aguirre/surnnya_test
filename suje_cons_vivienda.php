<?php
include("Funciones.php");
session_start();
$_SESSION['prestacion']="Informaci&oacute;n sobre Vivienda y Datos de Contacto";
include('encabezado.php');
if (!isset($_SESSION['gldispo'])|!isset($_GET['legajo'])) header ("Location: .");
registre();
$lega= $_GET["legajo"];
$rc=un_registro("select provincia_domicilio, partido_domicilio, localidad_domicilio, callenro_domicilio,condicion_domicilio, otros_domicilio ,telefonos, email from sujetos where legajo=".$lega);
$rv=un_registro("select * from sujetos_vivienda where legajo=".$lega." order by fecha desc limit 1");
$hogar=un_campo("select admi_hogar from hogares_admision where admi_alta is not null and admi_baja is null and admi_legajo=".$lega);
$tipo="";
if ($lega=="" ) Redirect("Location: consultasujetos");
if (isset($_GET["tipo"])) $tipo=$_GET["tipo"] ;
$_SESSION["posicion"]="9";
include("mnu_superior.php");
?>
</div>
<script>
function valida_contacto(){
valida_0("domicilio");
valida_0("telefonos");
valida_mail("email");
if(document.getElementById("domicilio").value=="" && document.getElementById("telefonos").value=="" && document.getElementById("email").value==""){
  status("No hay datos");
  return false;
};
return true;
}
</script>
<div class="container">
<form class="form-inline" method="post" action="actualizacontacto" onsubmit="return valida_contacto()">
  <h4>Domicilio</h4>
   <br><br>
   <div class="form-group has-warning">
	<label class="label-form">Domicilio Provincia</label>
        <select class="form-control" name="provincia_domicilio" id="provincia_domicilio">
	</select>
  </div>
  <div class="form-group has-warning">
	<label class="label-form">Partido</label>
	<select class="form-control" name="partido_domicilio" id="partido_domicilio" onblur="bpart()">
	</select>
  </div>
<div class="form-group has-warning">
	<label class="label-form">Localidad</label>
	<select class="form-control" name="localidad_domicilio" id="localidad_domicilio" onfocus="floca()" onblur="bloca()">
	</select>
</div>
<br><br>
<div class="form-group has-warning">
 <label class="label-form">Condici&oacute;n domiciliaria</label>
 <select class="form-control" name="condicion_domicilio" id="condicion_domicilio">
	<option>Completar</option>
	<option value="Calle cemento">Calle cemento</option>
	<option value="Barrio social / Villa">Barrio social / Villa</option>
 </select>
</div>
<br><br>
<div class="form-group has-warning">
 <label class="label-form">Calle y Altura</label>
 <input class="form-control" name="calle_altura" id="calle_altura" value="<?php echo $rc['callenro_domicilio']?>" onblur="normaliza_calle()">
</div>
<div class="form-group has-warning">
<label class="label-form">Opciones</label>
<select class="form-control" name="opciones" id="opciones" onblur="copiadom()"></select>
</div>
<br><br>
<div class="form-group has-warning">
<label class="label-form">Informaci&oacute;n complementaria (manzana,casa, piso, departamento,etc)</label>
<input class="form-control" name="otros_domicilio" id="otros_domicilio" value="<?php echo $rc['otros_domicilio']?>"></input>
</div>
<br><br>

  <h4>Contacto</h4>
  <div class="form-group has-warning">
	<label class="label-form" for="telefono">Tel&eacute;fonos</label>
	<input class="form-control" name="telefonos" id="telefonos" size="40" maxlength="45" onblur="valida_0(this.id)" value="<?php echo $rc["telefonos"]?>">
  </div>
  <br><br>
  <div class="form-group has-warning">
	<label class="label-form" for="email">Email</label>
	<input class="form-control" name="email" id="email" size="60" onblur="valida_mail(this.id)"  maxlength="70" value="<?php echo $rc["email"]?>">
  </div>
  <br><br>
  <input name="legajo" hidden value="<?php echo $lega?>">
  <?php if($_SESSION['gl_editar_sujeto']=="1"){?>
  <button class="btn btn-primary">Actualizar Contacto</button>
  <?php }?>
</form>
<h3>Vivienda</h3>
<br>
<script>
function valida_vivienda(){
  tipovivienda=document.getElementById("tipovivienda").value;
  if(tipovivienda=="103" && document.getElementById("especificar").value==""){
    status("debe especificarse el tipo de vivienda");
    return false;
  };
  if(tipovivienda!="103"){document.getElementById("especificar").value="";};
  return true;
}
</script>
<?php if(!$hogar>"0"){?>
<form class="form-inline" method="post" action="actualizavivienda" onsubmit="return valida_vivienda()">
  <div class="form-group has-warning">
	<label class="label-form" for="tipovivienda">Tipo Vivienda</label>
        <select class="form-control" id="tipovivienda" name="tipovivienda" required><option></option>
	<?php echo opc_tabla("MEPRE");?>
	</select>
	<script>
	seleccionar("tipovivienda","<?php echo $rv['tipovivienda']?>");
        </script>
  </div>
  <br><br>
  <div class="form-group has-warning">
	<label class="label-form" for="especificar">Especificar (si otros)</label>
	<input class="form-control" name="especificar" id="especificar" size="40" maxlength="45" onblur="valida_0(this.id)" value="<?php echo $rv["especificar"]?>">
  </div>
  <br><br>	
  <input name="legajo" hidden value="<?php echo $lega?>">
  <?php if($_SESSION['gl_editar_sujeto']=="1"){?>
  <button class="btn btn-primary">Actualizar Vivienda</button>
  <?php }?>
</form>
<?php }?>
<h3>Historial de Situaciones de Vivienda</h3>
<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed">
<thead><tr class="bg-primary"><td>Tipo Vivienda</td><td>Dispositivo/Lugar</td><td>Desde</td><td>Hasta</td></tr></thead>
<?php
$dt=un_registro("select * from sujetos where legajo=".$lega);
$conn=registros("select case when tipo_dispositivo=12 then 'Dispositivo Pre egreso' else 'Dispositivo Cuidados Alternativos' end as tipoviv, nombre as hogar, admi_alta, admi_baja
from hogares_admision left join dispositivos on dispositivos.id=admi_hogar 
where admi_alta is not null and admi_legajo=".$lega.
" union select deno as tipoviv, especificar as hogar, fecha as admi_alta, null as admi_baja from sujetos_vivienda 
left join tablas on tipo='MEPRE' and valo=tipovivienda where legajo=".$lega." order by admi_alta desc");
while ( $da = mysqli_fetch_assoc($conn)) {
  echo colorfila()."<td>".$da["tipoviv"]."</td><td>".$da["hogar"]."</td><td>".ffec($da['admi_alta'])."</td><td>".ffec($da['admi_baja'])."</td></tr>";
 };
?>
</table>
<script>
contprov=ejec_sq("sq_loc?tipo=Provincias");
document.getElementById("provincia_domicilio").innerHTML=contprov;
contpart=ejec_sq("sq_loc?tipo=Partidos");
document.getElementById("partido_domicilio").innerHTML=contpart;
contloca=ejec_sq("sq_loc?tipo=Localidades");
document.getElementById("localidad_domicilio").innerHTML=contloca;
seleccionar("provincia_domicilio","<?php echo $rc["provincia_domicilio"]?>");
seleccionar("partido_domicilio","<?php echo $rc["partido_domicilio"]?>");
seleccionar("localidad_domicilio","<?php echo $rc["localidad_domicilio"]?>");
seleccionar("condicion_domicilio","<?php echo $rc["condicion_domicilio"]?>");
function floca(){
	pr_d=document.getElementById("provincia_domicilio").value;
        pa_d=document.getElementById("partido_domicilio").value;
	if(pr_d==""){
	   document.getElementById("localidad_domicilio").innerHTML=contloca;
        } else 
        if(pa_d==""){
	  document.getElementById("localidad_domicilio").innerHTML=ejec_sq("sq_loc?tipo=Localidades&provincia="+pr_d);
        }
        else{
	  document.getElementById("localidad_domicilio").innerHTML=ejec_sq("sq_loc?tipo=Localidades&provincia="+pr_d+"&partido="+pa_d);
        };
}
function bloca(){
  loca=document.getElementById("localidad_domicilio").value;
  if(loca!=""){
     if(loca.indexOf("/")>0 && document.getElementById("partido_domicilio").value==""){
	part=loca.substr(loca.indexOf("/")+1);
      
	seleccionar("partido_domicilio",part);
     }
  };

}
function bpart(){
	pr_d=document.getElementById("provincia_domicilio").value;
        pa_d=document.getElementById("partido_domicilio").value;
	if(pr_d=="" && pa_d!="") seleccionar("provincia_domicilio","Buenos Aires");
}

function normaliza_calle(){
 valida_0("calle_altura");
 valida_0("localidad_domicilio");
 calle=document.getElementById("calle_altura").value;
 prov=document.getElementById("provincia_domicilio").value;
 if(calle!=""&&(prov=="CABA"||prov=="Buenos Aires")){
 calle=calle.replace("Ñ","N").replace("ñ","n");
 loca=document.getElementById("localidad_domicilio").value;
 pos=loca.indexOf("/");
 loca=loca.substr(0,pos-1);
  var xhttp = new XMLHttpRequest();
 xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        resp = xhttp.responseText;
        var objeto = JSON.parse(resp);
        if(typeof objeto.errorMessage!="undefined"){
		alert(objeto.errorMessage);
		document.getElementById("calle_altura").value="";
		seleccionar("localidad_domicilio","");

		};
        document.getElementById("opciones").options.length=0;
        if(objeto.direccionesNormalizadas.length>=1){
         document.getElementById("opciones").disabled=false;
         for(i=0;i<objeto.direccionesNormalizadas.length;i++){
	  var c = document.createElement("option");
	  c.text = objeto.direccionesNormalizadas[i].direccion;
          document.getElementById("opciones").options.add(c,i);
         };
        };
       };
    };
  xhttp.open("GET", "https://servicios.usig.buenosaires.gob.ar/normalizar/?direccion="+calle+","+loca, true);
  xhttp.send();
 };  
return true;  
}

function copiadom(){
  sele=document.getElementById("opciones");
  valor=sele.options[sele.selectedIndex].value;
  sele.options.length=0;
  posi=valor.lastIndexOf(",");
  part=trim(valor.substr(posi+1));
  call=valor.substr(0,posi+1);
  

  document.getElementById("calle_altura").value=call;
	
  if(part=="CABA"){
	seleccionar("provincia_domicilio","CABA");
	seleccionar("partido_domicilio","");
	selenuevo("localidad_domicilio","CABA");
  }else{
     selenuevo("partido_domicilio",part);
     seleccionar("provincia_domicilio","Buenos Aires");

  };	

};

function selenuevo(id,valor){
valor=trim(valor.toUpperCase());
seleccionar(id,valor);
if (document.getElementById(id).value!=valor){
  var c = document.createElement("option");
  c.text=valor;
  c.value=valor;
  document.getElementById(id).options.add(c);
  seleccionar(id,valor);
}
}
</script>
</div>
</body>
</html>