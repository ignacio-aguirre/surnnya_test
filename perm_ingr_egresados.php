<?php
include("Funciones.php");
session_start();
include("encabezado.php");
if (!isset($_SESSION['gldispo'])) Redirect("salir");
$sino="<option value=1>Si</option><option value=0>No</option>";
?>
</div>
<div class="container">
<form class="form-inline" action='perm_ingr_egresados_do' method='GET' onsubmit="return valida()">
 <div class="form-group has-warning">
  <label class="label-form">Per&iacute;odo de Egresos a Considerar</label><br><br>
  <label class="label-form" for="desde">desde</label>
  <input class="form-control" type='text' size='10' maxlength='10' name='desde' id='desde' value="<?php echo $_SESSION['DiaHoy']?>" onblur='valida_fecha("desde")' autofocus>
 </div> 
 <div class="form-group has-warning">
  <br><br>
  <label class="label-form" for="hasta">hasta</label>
  <input class="form-control" type='text' size='10' maxlength='10' name='hasta' id='hasta' value="<?php echo $_SESSION['DiaHoy']?>" onblur='valida_fecha("hasta")'>
 </div> 
 <hr>	 
 <button class="btn btn-success">Excel</button>
</form>
<script>
function valida(){
  valida_fecha("desde");
  valida_fecha("hasta");
  if(fsql(document.getElementById("desde").value)>fsql(document.getElementById("hasta").value))	{
     status("fecha desde debe ser menor o igual que fecha hasta");
     return false;
  };
  return true;
};
</script>
</div>
</body>
</html>