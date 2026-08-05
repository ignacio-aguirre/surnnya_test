<?php
include("Funciones.php");
session_start();
noconsulta();
$_SESSION["prestacion"]="Baja de Casa Joven";
include("encabezado.php");
$id=$_GET["id"];
$legajo=un_campo("select legajo from cjoven_nomina where idcjoven_nomina=".$id);
?>
</div>
<div class="container">
<h4><?php echo un_campo("select concat(apellidos,', ',nombres) from sujetos where legajo=".$legajo)?></h4>
<form class="form-inline" method="GET" action="cjoven_baja_do" onsubmit="return valida()">
<div class="form-group has-warning">
<label class="label-form" for="fecha">Fecha de Baja</label>
<input class="form-control" id="fecha" name="fecha" size="10" maxlength="10" onblur="valida_fecha(this.id,1)">
<input name="id" hidden value="<?php echo $id?>">
<button class="btn btn-primary" type="submit">Registrar</button>
</div>
</form>
</div>
<script>
enfoca("fecha");
function valida(){
valida_fecha("fecha",1);
if(document.getElementById("fecha").value==""){status("completar fecha de baja");return false;};
status("");
return true;
}
</script>
</body>