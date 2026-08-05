<?php
require("Funciones.php");
session_start();
$_SESSION["prestacion"]="Nueva Familia";
registre();
include("encabezado.php");

if(isset($_GET["id"])) { $id=$_GET["id"];};
$hoga="";
if(isset($_GET['hogar'])) $hoga=$_GET['hogar'];
if($hoga=="") {Redirect("consultafamilias");};
?>
</div>
<div class="container">
<form class="form-inline" method="GET" action="af_familias_nueva_do" onsubmit="return valida()">
  <div class="form-group has-warning">
    <label class="label-form" for="hogar">Dispositivo</label>
    <select class="form-control" id='hogar' name='hogar'><?php echo $_SESSION['Opc_Hoga_AF'];?></select>
  </div>
  <script>
  seleccionar("hogar","<?php echo $hoga;?>");
  </script>
  <div class="form-group has-warning">
    <label class="label-form" for="denominacion">Denominaci&oacute;n (apellido/s)</label>
    <input class="form-control" id="denominacion" name="denominacion" size="30" maxlength="45" onblur='valida_0(this.id)'>
  </div>
  <div class="form-group has-warning">
    <label class="label-form" for="estado1">Estado 1</label>
    <select class="form-control" id='estado1' name='estado1'>
      <option value="1">Admitidas</option>
      <option value="2">En evaluaci&oacute;n</option>
    </select>
  </div>
  <script>
    if(document.getElementById("hogar").value=="170"){seleccionar("estado1","2");} else{seleccionar("estado1","1");};
  </script>  
  <h3>Solo para familias Admitidas</h3>
  <div class="form-group has-warning">
    <label class="label-form" for="fecha_disposicion">Fecha de Alta</label>
    <input class="form-control" id="fecha_disposicion" name="fecha_disposicion" maxlength="10" size="8" onblur="valida_fecha(this.id,1)">
  </div> 
  <div class="form-group has-warning">
    <label class="label-form" for="registro_unico">N&uacute;mero Legajo SAF / A&ntilde;o</label>
    <input class="form-control" name="registro_unico" id="registro_unico" type="number" min="0" max="999999">
    <input class="form-control" name="anio" id="anio" type="number" min="2022" max="2027">
  </div>	
  <h3>Datos de la persona referente</h3>
  <div class="table-responsive">
  <table class="table">
  <tr><td>Apellidos</td><td><input class="form-control" id="apellidos" name="apellidos" size="30" maxlength="45"  onblur='valida_0(this.id)'></td>
      <td>Nombres</td><td><input class="form-control" id="nombres" name="nombres" size="30" maxlength="45" onblur='valida_0(this.id)'></td></tr>
  <tr><td>Tipo de Documento</td><td><select class="form-control" id="tipodoc" name="tipodoc"><?php echo tbla("tipodoc");?></select></td>
      <td>Nro. de Documento</td><td><input class="form-control" id="nrodoc" name="nrodoc" size="6" maxlength="10" onfocus='solosino("tipodoc",0,"fecha_nacimiento")' onblur='sale_nrodoc()'></td></tr>
  <tr><td>Fecha de Nacimiento</td><td><input class="form_control" id="fecha_nacimiento" name="fecha_nacimiento" size="6" maxlength="10" onblur='valida_fecha(this.id,"1")'></td>
   <td>Edad</td><td><input class="form-control" id="edad" name="edad" size="15"  onfocus='solosi("fecha_nacimiento","","nacionalidad")' onblur='ob_numero(this.id,"1")'></td></tr>
  <tr><td>Nacionalidad</td><td><select class="form-control" id="nacionalidad" name="nacionalidad"><?php echo tbla("nacionalidad");?></select></td>
   <td>G&eacute;nero</td><td><select class="form-control" id="genero" name="genero"><option value='F'>Femenino</option><option value='M'>Masculino</option></select></td>
   <td>Estado Civil <select class="form-control" id="estadocivil" name="estadocivil"><?php echo tbla("estadocivil");?></select></td></tr>
  <tr><td>Domicilio Caba/GBA/Otros</td><td><select class="form-control" id="caba" name="caba"><?php echo tbla("caba");?></select></td>
  <tr><td>Caba:Barrio</td><td><input class="form-control" id="barrio" name="barrio" size="30" maxlength="45" onfocus='solosi("caba",1,"localidad")' onblur='valida_0(this.id)'></td>
    <td>Caba:Comuna</td><td><select class="form-control" id="comuna" name="comuna"><option value=""></option><?php for($i=1;$i<=15;$i++){echo "<option value='".$i."'>".$i."</option>";};?></select></td></tr>
  <tr><td>Localidad</td><td><input class="form-control" id="localidad" name="localidad" size="30" maxlength="45" onfocus='solosino("caba",1,"calle")' onblur='valida_0(this.id)'></td>
     <td>PBA:Partido</td><td><input class="form-control" id="partido" name="partido" size="30" maxlength="45" onfocus='solosino("caba",1,"calle")' onblur='valida_0(this.id)'></td></tr>
  <tr><td>Domicilio Calle y Nro.</td><td><input class="form-control" id="calle" name="calle" size="30" maxlength="60" onblur='valida_0(this.id)'></td>
    <td colspan="2">Piso, depto, casa, manzana, etc.</td><td><input class="form-control" id="otras" name="otras" size="30" maxlength="45" onblur='valida_0(this.id)'></td></tr>
 <tr><td>Email</td><td><input class="form-control" id="email" name="email" size="30" maxlength="45" onblur='valida_0(this.id)'></td>
   <td>Tel&eacute;fonos</td><td><input class="form-control" id="telefonos" name="telefonos" size="30" maxlength="45" onblur='valida_0(this.id)'></td></tr>
 <tr><td>Ocupaci&oacute;n</td><td><input class="form-control" id="ocupacion" name="ocupacion" size="30" maxlength="45" onblur='valida_0(this.id)'></td>
  <td>Fecha de Actualizaci&oacute;n</td><td><input class="form-control" id="fecha_actualizacion" name="fecha_actualizacion" size="6" maxlength="10" onblur='valida_fecha(this.id)'></td></tr>
</table>
</div>

  <button class="btn-primary">Agregar Familia</button>
</form>
</div>
<script>
function valida(){
 valida_0("denominacion");
 if(document.getElementById("denominacion").value==""){alert("Completa la denominacion");return false;};
 valida_fecha("fecha_disposicion",1);
 if(document.getElementById("fecha_disposicion").value=="" && document.getElementById("estado1").value=="1"){alert("Completa la fecha de ingreso");return false;};
  return true;
}
enfoca("denominacion");
</script>
</body>
</html>