<?php
include("Funciones.php");
session_start();
$familia=$_GET["familia"];
$legajo=$_GET["legajo"];
$r=un_registro("select fecha_alta, fecha_baja from fv_familias_miembros where familia=".$familia." and legajo=".$legajo);
$_SESSION["prestacion"]="Baja de NNYA de una Familia ";
include("encabezado-test.php");
?>
</div>
<div class="container">
<h4>Familia:  <?php echo un_campo("select descripcion from fv_familias where idfv_familias=".$familia)?></h4>
<h4>NNYA:  <?php echo un_campo("select concat(apellidos,' , ',nombres) from sujetos where legajo=".$legajo)?></h4>
<form class="form-inline" method="get" action="fv_nnya_baja_do" onsubmit="return valida()">
<div class="form-group has-warning">
 <label class="label-form" for="fecha_baja">Fecha Baja</label>
 <input class="form-control" name="fecha_baja" id="fecha_baja" size="10" maxlength="10" onblur="vbaja()"  value="<?php echo ffec($r["fecha_baja"])?>">
</div><br><br>
<input name="familia" value="<?php echo $familia?>" hidden>
<input name="legajo" value="<?php echo $legajo?>" hidden>
<input class="btn-primary" type="submit" name="baja" value="Registrar Fecha de Baja">
<hr>
<p class="text-warning">Si, en cambio, quiere eliminar completamente este/a NNYA del grupo familiar, por tratarse de un error, utilice el bot&oacute;n de abajo</p>
<input class="btn-danger" type="submit" name="eliminar" value="Eliminar completamente">

</form>

</div>
<script>
function vbaja(){
valida_fecha("fecha_baja",1);
if(fsql(document.getElementById("fecha_baja").value)>fsql("<?php echo $_SESSION['DiaHoy']?>")) {document.getElementById("fecha_baja").value="";};
if(fsql(document.getElementById("fecha_baja").value)<fsql("<?php echo ffec($r['fecha_alta'])?>")) {document.getElementById("fecha_baja").value="";};
}
function valida(){
  vbaja();
  return true;
}

</script>
</body>
</html>


