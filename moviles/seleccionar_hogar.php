<?php 
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Seleccionar dispositivo";
include("encabezado.php"); 
$opc="";
if($_SESSION["perfil_moviles"]=="1" ){
$reg=registros("select nombre, hogar from usuarios_hogares_roles left join dispositivos on hogar=dispositivos.id where usuario=".$_SESSION["usuario"].
	" order by dispositivos.nombre");

while($r=mysqli_fetch_assoc($reg)){
 $opc=$opc."<option value=".$r["hogar"].">".$r["nombre"]."</option>";
};
$_SESSION['bandeja']="";} else{die("error");};
?>

<div class="container">
<form class="form-inline" method="get" action="seleccionar_hogar_do">
<div class="form-group has-warning">
<label class="label-form">Dispositivo</label>
<select name="hogar" id="hogar" class="form-control" autofocus>
<?php echo $opc?>
</select>
</div>
<hr>
<button class="btn-primary">Continuar</button>
</form>
</div>
</body>
</html>
