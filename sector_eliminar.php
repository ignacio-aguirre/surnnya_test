<?php
session_start();
include("Funciones.php");
$_SESSION["prestacion"]="Eliminar Sector";
include("encabezado.php");
$id=nget("id");
$r=un_registro("select * from sectores where id=".$id);
?>
</div>
<div class="container">
<form class="form-inline" method="get" action="sector_eliminar_do">
<div class="form-group has-warning">
 <label class="label-form">Nombre del sector a eliminar</label>
 <input class="form-control" readonly value="<?php echo $r["denominacion"]?>">
</div><br><br>
<p class="text-warning">Al presionar Eliminar da conformidad para eliminar el sector del sistema</p>
<br><br>
<input hidden name="id" value="<?php echo $id?>">
<button class="btn-danger">Eliminar</button>
</form>
</div>
</body>
</html>