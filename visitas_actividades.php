<?php
include("Funciones.php");
session_start();
include("encabezado.php");
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
<form class="form-inline" action='visitas_actividades_do' method='GET' onsubmit="return valida_datos();">
 <div class="form-group has-warning">
  <label class="label-form" for="desde">Desde</label>
  <input class="form-control" size='10' maxlength='10' name='desde' id='desde' value="<?php echo $_SESSION['DiaHoy']?>" onblur='valida_fecha(this.id)'>
 </div> 
 <div class="form-group has-warning">
  <label class="label-form" for="hasta">Hasta</label>
  <input class="form-control" size='10' maxlength='10' name='hasta' id='hasta' value="<?php echo $_SESSION['DiaHoy']?>" onblur='valida_fecha(this.id)'>
 </div> 
 <div class="form-group has-warning">
  <label class="label-form" for="tipo">Tipo de Dispositivos</label><select class="form-control" id="tipo" name='tipo'>
  <option value="1">Hogares</opcion>
  <option value="2">Acogimiento Familiar</opcion>
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