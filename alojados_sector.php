<?php
include("Funciones.php");
session_start();
include("encabezado.php");
?>
</div>
<div class="container">
<form class="form-inline" action="alojados_sector_excel" method="GET">
<div class="form-group has-warning">
 <label class="label-form">DZ o Sector Participante</label>
 <select class="form-control" name="sector"><?php echo opc_tabla("CM")?></select>	
</div>
<input class="btn-success" type="submit" value="Excel">
</form>
</div>
</body>
</html>