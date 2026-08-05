<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
registre();
?>
<div class="container">
<form class="form-inline" method="get" action="pae_cantidades_excel" onsubmit="return valida()">
 <div class="form-group has-warning">
  <label class="label-form">Desde</label>
  <input class="form-control" name="desde" id="desde" size="10" maxlength="10" autofocus onblur="valida_fecha(this.id)">
 </div>&nbsp;
 <div class="form-group has-warning">
  <label class="label-form">Hasta</label>
  <input class="form-control" name="hasta" id="hasta" size="10" maxlength="10" onblur="valida_fecha(this.id)">
 </div>
 <br><br>
 &nbsp;<button class="btn-success" type="submit">Excel</button>
</form>
</div>
<script>
function valida(){
valida_fecha("desde");
if(document.getElementById("desde").value==""){alert("completar fecha desde");return false;};
valida_fecha("hasta");
if(document.getElementById("hasta").value==""){alert("completar fecha hasta");return false;};
if(fsql(document.getElementById("desde").value)>fsql(document.getElementById("hasta").value)){alert("desde debe ser menor o igual que hasta");return false;};
return true;
}
</script>
</body>
</html>