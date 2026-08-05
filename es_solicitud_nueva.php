<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Nueva Solicitud a Equipo de Salud";
include("encabezado-test.php");
?>
</div>
<div class="container">
<form class="form-inline" method="get" action="es_solicitud_nueva_do" onsubmit="return valida()">
 <div class="form-group has-warning">
	  <label class="label-form">Fecha Solicitud</label>
	  <input class="form-control" id="fecha_ingreso" size="10" maxlength="10" name="fecha_ingreso" value="<?php echo ffec($r["fecha_ingreso"])?>" required  autofocus onblur="valta(this.id)">
 </div>
 <div class="form-group has-warning">
	  <label class="label-form">Alcance de la Acci&oacute;n Solicitada</label>
	  <select id="alcance" name="alcance" class="form-control" required onblur="bloquea()">
          <option value=""></option>
	  <option value="1">Intervenci&oacute;n con NNYA</option>
	  <option value="2">Acciones Institucionales</option>
          </select>
	  
 </div><br><br>
 <div class="form-group has-warning">
	  <label class="label-form">Dispositivo Solicitante</label>
	  <select id="solicitante" name="solicitante" class="form-control" required>
          <option value=""></option>
		<?php echo $_SESSION['Opc_Hoga']?>
          <option value="-1">--Otros</option>

          </select>
 </div><br><br>
 <div class="form-group has-warning">
   	  <label class="label-form">Especificar Solicitante en caso de Otros</label>
	  <input class="form-control" id="solicitante_especificar" name="solicitante_especificar" size="50" maxlength="60" value="<?php echo $r['derivante_especificar']?>"> 	
	</div><br><br>
<div class="form-group has-warning">
    <label class="label-form">Profesi&oacute;n Requerida</label>
	  <select id="especialidad" name="especialidad" class="form-control" required>
          <option value=""></option>
          <?php echo opc_tabla("ESESP");?>
          </select>
 </div>

<h4>Para intervenciones exclusivamente</h4>
 <div class="form-group has-warning">
    <label class="label-form">B&uacute;squeda de NNYA</label>
	  <input id="busqueda" name="busqueda" class="form-control" onblur="completa_apynom()">
 </div>
 <div class="form-group has-warning">
    <label class="label-form">Apellido y Nombre</label>
   <var class="form-control" id="apynom" name="apynom"></var>
 </div>

<select class="form-control" id="legajos" onblur="pone_apynom()"></select>
 <br><br>

<input hidden name="legajo" id="legajo">
 
<button class="btn-success">Procesar Solicitud</button>
</form>
<script>
function valta(id){
  valida_fecha(id);
  if(document.getElementById(id).value==""){return false;};
  if(fsql(document.getElementById(id).value)>fsql("<?php echo $_SESSION['DiaHoy']?>")){document.getElementById(id).value="";return false;};
  return true;
}

function valida(){
 if(!valta("fecha_ingreso")){return false;};
 alca=document.getElementById("alcance").value;
 if(alca==1){
  if(document.getElementById("apynom").innerHTML==""){alert("especificar NNYA");return false;};
  document.getElementById("legajo").value=document.getElementById("apynom").innerHTML.substr(-7);	
  document.getElementById("legajo").value=  document.getElementById("legajo").value.substr(0,6);
 };
 return true;
}
function completa_apynom(){
 if(document.getElementById("busqueda").value.length>3){
 resp=ejec_sq("sq_apynom?frase="+document.getElementById("busqueda").value);
 if(resp.substr(0,1)=="*"){
   document.getElementById("legajos").innerHTML=resp;
   document.getElementById("apynom").innerHTML="";
  }
 else{
   for(i=0;i<document.getElementById("legajos").options.length;i=0){
    document.getElementById("legajos").options.remove(0);
   };
  document.getElementById("apynom").innerHTML=resp;
  document.getElementById("busqueda").value="";

 }
}
}
function pone_apynom(){
 if(document.getElementById("legajos").options.length>0 ){
	x=document.getElementById("legajos").selectedIndex;
	texto=document.getElementById("legajos").options[x].text+" ("+document.getElementById("legajos").options[x].value+")";
   for(i=0;i<document.getElementById("legajos").options.length;i=0){
    document.getElementById("legajos").options.remove(0);
   };
	document.getElementById("apynom").innerHTML=texto;
	document.getElementById("busqueda").value="";

 };
}

function bloquea(){
 alca=document.getElementById("alcance").value;
 if(alca==1){
  document.getElementById("busqueda").disabled=false;
  document.getElementById("apynom").disabled=false;
  document.getElementById("legajos").disabled=false;
  document.getElementById("tipo").disabled=false;
 };
 if(alca==2){
  document.getElementById("busqueda").disabled=true;
  document.getElementById("apynom").disabled=true;
  document.getElementById("busqueda").value="";
  document.getElementById("apynom").disabled=true;
  document.getElementById("apynom").value="";
  document.getElementById("legajos").disabled=true;
  document.getElementById("tipo").disabled=true;
  seleccionar("tipo","5");
 };
}
</script>

</body>
</html>
