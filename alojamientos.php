<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
?>
<script type="text/javascript">
function valida_datos() {
valida_fecha("desde");
valida_fecha("hasta");
if(document.getElementById("desde").value==""){status("Fechas desde y hasta obligatorias");return false;};
if(document.getElementById("hasta").value==""){status("Fechas desde y hasta obligatorias");return false;};
if(fsql(document.getElementById("desde").value)>fsql(document.getElementById("hasta").value)){status("Fecha desde mayor que hasta");return false;};
status("");
return true;
}
</script>
<?php 
if (!isset($_SESSION['gldispo'])) Redirect("salir");
?>
</div>
<div class="container">
<form class="form" action='alojamientos_do' method='GET' onsubmit="return valida_datos();">
 <div class="form-group row has-warning">
  <div class="col-md-2">
   <label class="label-form" for="desde">Desde</label>
   <input class="form-control" size="10" maxlength="10" name="desde" id="desde" onblur="valida_fecha(this.id)" autofocus>
  </div>
  <div class="col-md-2">
   <label class="label-form" for="hasta">Hasta</label>
   <input class="form-control" size="10" maxlength="10" name="hasta" id="hasta" onblur="valida_fecha(this.id)">
  </div>
 </div>
 <div class="form-group row has-warning">
  <div class="col-md-4">
  <label class="label-form" for="direccion_operativa">Direcci&oacute;n Operativa</label>
   <select class="form-control" id="direccion_operativa" name='direccion_operativa'>
    <option value="0">Todas</option>
    <?php echo opc_tabla("DIOP");?>
   </select>
 </div>
<script>seleccionar("direccion_operativa","<?php echo $diop?>");</script>
 <div class="col-md-2">
  <label class="label-form" for="circuito">Circuito</label><select class="form-control" id="circuito" name='circuito'>
  <option value="0">Red de Hogares</option>
  <option value="1">Preingreso</option>
  <option value="2">Resid.DGSAP</option>
  </select>
 </div>
<script>seleccionar("circuito","<?php echo $circ?>");</script>
 <div class="col-md-2">
   <label class="label-form">Descargar</label>  	
   <button class="btn btn-success form-control">Excel</button>
 </div>
</div>
</form>
</div>
</body>
</html>