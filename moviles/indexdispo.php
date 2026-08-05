<?php

session_start();
session_destroy();
session_start();
include("funciones.php");
$_SESSION['prestacion']="Ingreso a Móviles";
$_SESSION["ul"]="1";
include("encabezado.php");
?>
</div>
<br>
<div class="container">
<form class="form" action="validadispo" autocomplete="off" method="post">
	<div class="form-group has-primary col-md-8" align="center">
	 <label form='label-form'>Usuario m&oacute;viles</label>
     <input class="form-control"  id="usua"  name="usua" size="30" maxlength="50" required value="" autocomplete="off" autofocus>  
   </div>
  <div class="form-group has-primary col-md-8" align="center">
	<label class="label-form">Contrase&ntilde;a</label>
	<input class="form-control" id="pass" name="pass" type ="password" size="30" maxlength="50" required autocomplete="off" > 
</div>
<div class="form-group has-success col-md-8"  align="center">
			<button class="btn-sm btn-success">Ingresar</button>
</div>

</form>

<?php include("footer.php");?>
</div>
