<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
?>
</div>
<div class="container">
<form class="form-inline" method="get" action="dgeyc_familias_alojamiento_excel" onsubmit="return valida()">
<div class="form-group has-warning">
  <label class="label-form">Desde</label>	
  <input class="form-control" id="desde" name="desde" size="10" maxlength="10" onblur="valida_fecha(this.id)" autofocus>
</div>
<div class="form-group has-warning">
  <label class="label-form">Hasta</label>	
  <input class="form-control" id="hasta" name="hasta" size="10" maxlength="10" onblur="valida_fecha(this.id)">
</div>
<hr>
<input class="btn-success" type="submit" value="Excel">
</form>
</div>
<script>
function valida(){
 valida_fecha("desde");
 valida_fecha("hasta");
 if(document.getElementById("desde").value==""){alert("Fechas desde y hasta son obligatorias");return false;};
 if(document.getElementById("hasta").value==""){alert("Fechas desde y hasta son obligatorias");return false;};
 if(fsql(document.getElementById("hasta").value)<fsql(document.getElementById("desde").value)){alert("Fecha desde debe ser menor o igual que hasta");return false;};
 return true;
}
</script>
</body>
</html>