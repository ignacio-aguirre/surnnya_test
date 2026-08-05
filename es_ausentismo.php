<?php
session_start();
include("Funciones.php");
include("encabezado.php");
?>
</div>
<div class="container">
<p class="text-warning">Este es un reporte b&aacute;sico a controlar para luego definir el desarrollo final</p>
<form class="form-inline" method="get" action="es_ausentismo_excel">
<div class="form-group has-warning">
 <label class="label-form">Desde</label>
 <input class="form-control" size="10" maxlength="10" name="desde" id="desde" onblur="valida_fecha(this.id)" value="<?php echo $desde?>" autofocus required>
</div>
<div class="form-group has-warning">
 <label class="label-form">Hasta</label>
 <input class="form-control" size="10" maxlength="10" name="hasta" id="hasta" onblur="valida_fecha(this.id)"  value="<?php echo $hasta?>" required>
</div>
<button class="btn-success" name="excel">Excel</button>
</form>
</div>
</body>
</html>