<?php
include("Funciones.php");
session_start();
include("encabezado.php");

?>
</div>
<div class="container">
<form class="form-inline" action="alojados_cumples_excel" method="GET">
<div class="form-group has-warning">
 <label class="label-form">Mes</label>
 <select class="form-control" name="mes" id="mes">
   <option value="01">Enero</option>
   <option value="02">Febrero</option>
   <option value="03">Marzo</option>
   <option value="04">Abril</option>
   <option value="05">Mayo</option>
   <option value="06">Junio</option>
   <option value="07">Julio</option>
   <option value="08">Agosto</option>
   <option value="09">Septiembre</option>
   <option value="10">Octubre</option>
   <option value="11">Noviembre</option>
   <option value="12">Diciembre</option>
 </select>
 <script>
	hoy="<?php echo substr($_SESSION['DiaHoy'],3,2)?>";
        if(hoy=="12"){hoy="01";} else {nhoy=(parseInt(hoy)+1);hoy=nhoy.toString();if(nhoy<10){hoy="0"+hoy;};};
	seleccionar("mes",hoy);
 </script>	
</div>
<div class="form-group has-warning">
 <label class="label-form">A&ntilde;o</label>
 <input class="form-control" name="anio" type="number" min="<?php echo substr($_SESSION['DiaHoy'],-4)?>" max="2030" value="<?php echo substr($_SESSION['DiaHoy'],-4)?>" required>
</div>
<input class="btn-success" type="submit" value="Excel">
</form>
</div>
</body>
</html>