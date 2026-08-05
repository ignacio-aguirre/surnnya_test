<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Seleccionar Trimestre Activo";
include("encabezado.php"); 
$par=un_registro("select * from parametros limit 1");
      $_SESSION["trimestre"]=$par["trimestre"];
      $_SESSION["anio"]=$par["trimestre_anio"];
?>
</div>
<div class="container">
<form class="form-inline" method="get" action="trim_trimestre_do">
<div class="form-group has-warning">
<div class="form-group has-warning">
<label class="label-form">A&ntilde;o</label>
<select class="form-control" name="anio" id="anio">
<option value="2022">2022</option>
<option value="2023">2023</option>
<option value="2024">2024</option>
<option value="2025">2025</option>
<option value="2026">2026</option>
<option value="2027">2027</option>
<option value="2028">2028</option>
</select>
</div>
<div class="form-group has-warning">

<label class="label-form">Trimestre</label>
<select class="form-control" name="trimestre" id="trimestre">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
</select>
</div>
<div class="form-group has-warning">
 <label class="label-form" for="carga_desde">Per&iacute;odo carga desde</label>
 <input class="form-control" id="carga_desde" name="carga_desde" value="<?php echo ffec($par['carga_desde'])?>" size="10" maxlength="10" onblur="valida_fecha(this.id)">
</div> 
<div class="form-group has-warning">
 <label class="label-form" for="carga_hasta">hasta</label>
 <input class="form-control" id="carga_hasta" name="carga_hasta" value="<?php echo ffec($par['carga_hasta'])?>" size="10" maxlength="10" onblur="valida_fecha(this.id)">
</div> 
<hr>
<button class="btn-primary">Continuar</button>
</form>
</div>
<script>
seleccionar("anio",'<?php echo $_SESSION["anio"]?>');
seleccionar("trimestre",'<?php echo $_SESSION["trimestre"]?>');
</script>
</body>
</html>
