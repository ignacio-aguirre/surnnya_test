<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Menues";
if ($_SESSION['gl_usuarios']!="1") redirect('error_noautorizado');
include("encabezado-test.php");
$id= nget("id");
$sql="select * from menues where idmenues=".$id;
$reg=registros($sql);;
$cant=mysqli_num_rows($reg);
$descripcion="";
$nombre="";
if ($cant>0) {
  $r = mysqli_fetch_assoc($reg);
  $descripcion=$r["descripcion"];
  $nombre=$r["nombre"];
};
?>
</div>
<div class="container">
<form class="form" method='post' action='menuactualiza'>
<div class="form-group has-warning">
<label class="label-form" for="nombre">Nombre del Men&uacute;</label>
<input class='form-control' name='nombre' id='nombre' value='<?php echo $nombre;?>' required autofocus>
</div>
<div class="form-group has-warning">
<label class="label-form" for="descripcion">URL</label>
<input class="form-control" name="descripcion" id="descripcion"  value='<?php echo $descripcion;?>' required>
</div>
<input type='hidden' name='id' value='<?php echo $id;?>'><br>
<input class="bg-primary" type='submit' value='Aceptar'>
</form>
</div>
</body>
</html>