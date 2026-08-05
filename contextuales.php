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
</div>
<div class="container">
<form class="form-inline" action='contextuales_do' method='GET' onsubmit="return valida_datos();">
 <div class="form-group has-warning">
  <label class="label-form" for="desde">Desde</label>
  <input class="form-control" size='10' maxlength='10' name='desde' id='desde' value="<?php echo $_SESSION['DiaHoy']?>" onblur='valida_fecha(this.id)'>
 </div> 
 <div class="form-group has-warning">
  <label class="label-form" for="hasta">Hasta</label>
  <input class="form-control" size='10' maxlength='10' name='hasta' id='hasta' value="<?php echo $_SESSION['DiaHoy']?>" onblur='valida_fecha(this.id)'>
 </div> 
<div class="form-group has-warning">
  <label class="label-form" for="direccion_operativa">Direcci&oacute;n Operativa</label><select class="form-control" id="direccion_operativa" name='direccion_operativa'>
  <option value="0">Todas</option>
  <?php echo opc_tabla("DIOP");?>
  </select>
 </div>
 <div class="form-group has-warning">
  <label class="label-form" for="circuito">Circuito</label><select class="form-control" id="circuito" name='circuito'>
  <option value="0">Todos</option>
  <option value="1">Preingreso</option>
  <option value="2">Red de Hogares</option>
  </select>
 </div>

 <hr>	 
 <input class="btn btn-success" type='submit' value='Excel'>
</form>
</div>
<script type="text/javascript">
enfoca("desde");
</script>
</body>
</html>