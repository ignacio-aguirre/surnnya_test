<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Viajes incumplidos";
include("encabezado.php");
$fini=un_campo("select date_add(curdate(), interval -32 day) from dual");
$ffin=sqlf2(fsql($_SESSION["hoy"]));

?>
</div>
<div class="container">
  <form class="form-inline" method="get" action="mv_viajes_incumplidos_do">
	<div class="form-group has-warning">
		<label class="label-form">Desde el</label>
		<input class="form-control" id="fini" name="fini" required autofocus type="date" value="<?php echo $fini?>">
	</div>&nbsp;&nbsp;
	<div class="form-group has-warning">
		<label class="label-form">Hasta el</label>
		<input class="form-control" type="date" id="ffin" name="ffin" required value="<?php echo $ffin?>">
	</div>&nbsp;&nbsp;
  <button class="btn-success">Excel</button>&nbsp;
  
  </form>
</div>
