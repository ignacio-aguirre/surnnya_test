<?php 
include("funciones.php");
session_start();
tranca(3);
$status="";
$anio=un_campo("select year(curdate()) from dual");
if(isset($_GET['status'])) $status=$_GET['status'];
if(isset($_GET['anio'])) $anio=$_GET['anio'];
$_SESSION["prestacion"]="Consulta de Entregas Mensuales Global";
include("encabezado.php");echo $status;?>
</div>
<div class="container">
 <form class="form-inline" method="get" action="excel_global">
  <div class="form-group has-warning">
    <label class="label-form" for="anio">A&ntilde;o</label>
    <input class="form-control" id="anio" name="anio" size='4' maxlength='4' value="<?php echo $anio?>" autofocus required onblur="valida_entero(this.id)">
  </div>
  <div class="form-group has-warning">
    <label class="label-form" for="mes">Mes</label>
    <select class="form-control" name="mes" id="mes">
	<option value=1>Enero</option>
	<option value=2>Febrero</option>
	<option value=3>Marzo</option>
	<option value=4>Abril</option>
	<option value=5>Mayo</option>
	<option value=6>Junio</option>
	<option value=7>Julio</option>
	<option value=8>Agosto</option>
	<option value=9>Septiembre</option>
	<option value=10>Octubre</option>
	<option value=11>Noviembre</option>
	<option value=12>Diciembre</option>
    </select>
  <button class="btn-success">Enviar a Excel</button>
  </form>

</div>

</div>

</div> 
<script src='js/particulares.js'></script>
</div>
</div>
</body>