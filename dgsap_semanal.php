<?php
include("Funciones.php");
session_start();
include("encabezado.php");
?>
<script type="text/javascript">
function valida_datos() {
valida_fecha("desde");
valida_fecha("hasta");
if(fsql(document.getElementById("desde").value)>fsql(document.getElementById("hasta").value)){status("Fecha desde mayor que hasta");return false;};
status("");
return true;
}
</script>
</div>
<div class="container">
<form class="form-inline" action='dgsap_semanal_do' method='GET' onsubmit="return valida_datos();">
 <div class="form-group has-warning">
  <label class="label-form" for="desde">Desde / Hasta</label>
  <input class="form-control" type='text' size='10' maxlength='10' name='desde' id='desde' value="<?php echo $_SESSION['DiaHoy']?>" onblur='valida_fecha("desde")' required autofocus>
  <input class="form-control" type='text' size='10' maxlength='10' name='hasta' id='hasta' value="<?php echo $_SESSION['DiaHoy']?>" onblur='valida_fecha("hasta")' required>
 </div> 
 <hr>	 
 <button class="btn btn-success">Excel</button>
</form>
</div>
</body>
</html>