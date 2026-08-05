<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Efector Nuevo";
include("encabezado.php"); 
?>
<div class="container">
<form class="form" method="get" action="efectores_do" onsubmit="return valida()">
  <div class="form-group has-warning">
  <label class="label-form" for="dispositivo">Dispositivo</label>
  <select class="form-control"name="dispositivo" id="dispositivo" onblur="importa(this.value)">
    <option value="0">(Seleccionar, si es dispositivo DGSAP)</option>
    <?php
     $dis=registros("select id,nombre from surnnya.dispositivos where baja is null and direccion_operativa in(1,2) order by nombre");
     while($d=mysqli_fetch_assoc($dis)){
        echo "<option value='".$d["id"]."'>".$d["nombre"]."</option>";
     };
    ?>
    <option value="0">(Ninguno de los anteriores)</option>
  </select>
  </div>
  <div class="form-group has-warning">
	<label class="label-form" for="descripcion">Descripci&oacute;n</label>
	<input class="form-control" id="descripcion" name="descripcion" size="50" maxlength="100" onblur='valida_0(this.id)' autofocus required>
  </div>
  
  <div class="form-group has-warning">
	<label class="label-form" for="domicilio">Domicilio</label>
        <input class="form-control" id='domicilio' name='domicilio' size='40' maxlength='45' onblur='valida_0(this.id)' required>&nbsp;
  </div>
  <div class="form-group has-warning">
      <label class="label-form" for="localidad">Localidad</label>
      <input class="form-control" id='localidad' name='localidad' size='20' maxlength='45' onblur='valida_0(this.id)' required value='CABA' readonly>
  </div>
  
  <div class="form-group has-warning">
     <label class="label-form" for="barrio">Barrio</label>
     <input  class="form-control" id='barrio' name='barrio' size='40' maxlength='45' onblur='valida_0(this.id)' required>&nbsp;
  </div>
  <div class="form-group has-warning">
    <label class="label-form" for="comuna">Comuna</label>
    <input class="form-control" id='comuna' name='comuna' type='number' min='1' max='15' required>
  </div>
  
  <div class="form-group has-warning">
	<label class="label-form" for="telefonos">Tel&eacutefonos</label>
	<input  class="form-control" id='telefonos' name='telefonos' size='40' maxlength='45' onblur='valida_0(this.id)' required>
  </div>
  
  <div class="form-group has-warning">
   <input name="id" value="0" hidden>
   <button class="btn btn-primary">Guardar</button>	
  </div>
</form>
<script>
function valida(){
  desc=document.getElementById("descripcion").value;
  if(desc!=""){
  id=ejec_sq("ej_tablas?tipo=EFECTOR_CONS&descripcion="+desc);
  if(id>0){status("Efector Existente");return false;};
  };
 return true;
}
function importa(id){
  if(id>0){
   var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        resp = xhttp.responseText;
        var objeto = JSON.parse(resp);
        
        if(typeof objeto.errorMessage!="undefined"){alert(objeto.errorMessage);return false;};
        document.getElementById("descripcion").value=objeto.nombre;
        document.getElementById("domicilio").value=objeto.domicilio;
        document.getElementById("localidad").value=objeto.localidad;
        document.getElementById("barrio").value=objeto.barrio;
        document.getElementById("comuna").value=objeto.comuna;
        document.getElementById("telefonos").value=objeto.telefonos;
       };
    };
    xhttp.open("GET", "ej?tipo=DISPOSITIVO&id="+id, false);
    xhttp.send();

    }
}
</script>  
</div>
