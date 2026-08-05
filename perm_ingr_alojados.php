<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
if (!isset($_SESSION['gldispo'])) Redirect("salir");
$sino="<option value=1>Si</option><option value=0>No</option>";
?>
</div>
<div class="container">
<form class="form-inline" action='perm_ingr_alojados_do' method='GET'>
 <div class="form-group has-warning">
  <label class="label-form" for="i_dde">Alojados al </label>
  <input class="form-control" type='text' size='10' maxlength='10' name='fecha' id='fecha' value="<?php echo $_SESSION['DiaHoy']?>" onblur='valida_fecha("fecha")' autofocus>
 </div> 
 <hr>	 
 <button class="btn btn-success">Excel</button>
</form>
</div>
</body>
</html>