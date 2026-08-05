<?php
include("Funciones.php");
session_start();
include("encabezado.php");
?>
</div>
<div class="container">
<form class="form-inline" method="get" action="trim_vuelco_excel">
<div class="form-group has-warning">
  <label class="label-form">A&ntilde;o</label>	
  <select class="form-control" id="anio" name="anio" autofocus>
  <option value="2026">2026</option>
  <option value="2027">2027</option>
  <option value="2028">2028</option>
  <option value="2025">2025</option>
  <option value="2024">2024</option>
  <option value="2023">2023</option>
  <option value="2022">2022</option>
  </select>
</div>
<div class="form-group has-warning">
  <label class="label-form">Trimestre</label>
  <select class="form-control" id="trimestre" name="trimestre">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option> 
  </select>	
</div>
<div class="form-group has-warning">
  <label class="label-form">UT</label>
  <?php echo select_tabla("ut","SUPUT",1,0)?>
</div>
<hr>
<input class="btn-success" type="submit" value="Excel">
</form>
</div>
</body>
</html>