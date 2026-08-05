<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
?>
</div>
<div class="container">
<form class="form-inline" method="get" action="dgeyc_alojados_edad_excel">
<div class="form-group has-warning">
  <label class="label-form">A&ntilde;o</label>	
  <select class="form-control" id="anio" name="anio" autofocus>
  <option value="2018">2018</option>
  <option value="2019">2019</option>
  <option value="2020">2020</option>
  <option value="2021">2021</option>
  <option value="2022">2022</option>
  <option value="2023">2023</option>
  <option value="2024">2024</option>
  <option value="2024">2025</option>
  <option value="2024">2026</option>
  <option value="2024">2027</option>    
  </select>
</div>
<hr>
<input class="btn-success" type="submit" value="Excel">
</form>
</div>
</body>
</html>