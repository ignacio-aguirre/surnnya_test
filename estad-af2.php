<?php
include("Funciones.php");
session_start();
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
registre();
$desd=$_SESSION["DiaHoy"];
$hast=$_SESSION["DiaHoy"];
include("encabezado.php");
?>
<div class="container">
<form class="form-inline" method="get" action="excel-af2">
	<div class="form-group has-warning">
		<label class="label-form" for="desde">Desde</label>
        	<input class="form-control" name="desde" id="desde" size="8" maxlenght="10" onblur="valida_fecha(this.id)" value="<?php echo $desd;?>">
	</div>
	<div class="form-group has-warning">
		<label class="label-form" for="hasta">Hasta</label>
		<input class="form-control" name="hasta" id="hasta" size="8" maxlenght="10" onblur="valida_fecha(this.id)" value="<?php echo $hast;?>">
	</div>
	<input class="btn-success" type="submit" value="Excel">
</form>
<script type="text/javascript">enfoca("desde");</script> 
</div>
</body>
</html>