<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Pasar de estado programadas a realizadas";
include("encabezado-test.php");
$fini=un_campo("select min(fecha) from es_acciones where estado=1 and year(fecha)>=2025");
$ffin=un_campo("select max(fecha) from es_acciones where estado=1 and fecha<=curdate()");


?>
</div>
<div class="container">
 <h4>Registro de la Acci&oacute;n</h4>
 <form class="form-inline" method="get" action="es_acciones_realizar_do">
  <div class="form-group has-warning">
	  <label class="label-form">Fecha desde</label>
	  <input type="date" min="<?php echo $fini?>" id="fini" name="fini" class="form-control" value="<?php echo $fini?>" autofocus required>
 </div><br><br>
  <div class="form-group has-warning">
	  <label class="label-form">Fecha hasta</label>
	  <input type="date" min="<?php echo $fini?>" max="<?php echo $ffin?>" id="ffin" name="ffin" class="form-control" value="<?php echo $ffin?>"required>

 </div><br><br>

  <br><br>
  <button class='btn-primary'>Actualizar</button>
  </form>
</div>

</body>
</html>
