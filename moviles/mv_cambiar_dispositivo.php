<?php 
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Seleccionar dispositivo";
include("encabezado.php"); 
$opc="";
if($_SESSION["perfil_moviles"]=="1" && $_SESSION["hogar"]>"0"){
	$ong=un_campo("select ong from dispositivos where id=".$_SESSION["hogar"]);
	$reg=registros("select id, nombre from dispositivos where ong=".$ong.
	" and baja is null and direccion_operativa in (1,2) order by nombre");

while($r=mysqli_fetch_assoc($reg)){
 $opc=$opc."<option value=".$r["id"].">".$r["nombre"]."</option>";
};
}
?>
</div><br>
<div class="container">
<form class="form" method="get" action="mv_cambiar_dispositivo_do">
<div class="form-group has-warning">
<label class="label-form">Dispositivo</label>
<select name="hogar" id="hogar" class="form-control" autofocus>
<?php echo $opc?>
</select>
</div>

<button class="btn-primary">Continuar</button>
</form>
</div>
</body>
</html>
