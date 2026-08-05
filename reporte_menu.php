<?php
include("Funciones.php");
session_start();
$id=nget("id");
if($id=="0") {Redirect("reportes");};
$_SESSION["prestacion"]="Agregar a Otro Men&uacute; Reporte Id=".$id;
include("encabezado-test.php");
?>
</div>
<div class="container">
<form class="form-inline" method="GET" action="reporte_menu_do" onsubmit="return valida()">
<div class="form-group has-warning">
<label class="label-form" for="menu">Men&uacute;</label>
<select class="form-control" id="menu" name="menu" autofocus onblur="llena_superiores()">
<?php
$reg=registros("select idmenues, nombre from menues order by nombre");
while($r=mysqli_fetch_assoc($reg)){
 echo "<option value='".$r["idmenues"]."'>".$r["nombre"]."</option>";
};
?>
</select>
</div>
<div class="form-group has-warning">
<label class="label-form" for="posicion">Opci&oacute;n Men&uacute; Superior</label>
<select class="form-control" id="posicion" name="posicion"></select>
</div>

<input hidden name="id" value="<?php echo $id?>">
<button class="btn-primary" type="submit">Agregar</button>
</form>
</div>
<script>
function valida(){
 return true;
};
function llena_superiores(){
  opciones=ejec("ej","SUPERIORES","&menu="+document.getElementById("menu").value);
  
  document.getElementById("posicion").innerHTML=opciones;
};
</script>
</body>
</html>
