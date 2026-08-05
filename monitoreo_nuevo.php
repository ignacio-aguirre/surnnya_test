<?php
include("Funciones.php");
session_start();
if($_SESSION['gl_tablaongs']!="1") {header("Location: error_noautorizado");};
$frase="";
if(isset($_GET["frase"])) {$frase=$_GET["frase"];};
$_SESSION["prestacion"]="Datos del Monitoreo (en desarrollo)";
include("encabezado-test.php");?>
</div>
<div class="container">
<form class="form-inline" method="get">
<div class="form-group has-warning">
<label class="label-form">Par&aacute;metro de B&uacute;squeda (todo o parte del Nombre / n&uacute;mero de legajo) </label>
<input class="form-control has-warning" name="frase" id="frase" size="30" maxlength="50" autofocus value="<?php echo $frase?>">
</div>
<input class="btn-warning" type="submit" value="Buscar">
</form>

<form class="form-inline" method="get" action="monitoreo_nuevo_do">
        <div class="form-group has-warning">
		<label class="label-form" for="dispositivo">Dispositivo</label>
		<select class="form-control" id="dispositivo" name="dispositivo">
		<?php
		if($frase=="") {
		 $sql="select dispositivos.*,hogares_ong.legajo,deno from dispositivos left join tablas on tablas.tipo='DITIP' and valo=tipo_dispositivo left join hogares_ong on hogares_ong.id=ong  where dispositivos.baja is null order by nombre";}
		else{
 		 if(intval($frase)!=0) {
   			$sql="select dispositivos.*,hogares_ong.legajo from dispositivos left join hogares_ong on hogares_ong.id=ong where legajo=".intval($frase)." and dispositivos.baja is null  order by nombre";}
 		 else{  $sql="select dispositivos.*,hogares_ong.legajo from dispositivos left join hogares_ong on hogares_ong.id=ong where dispositivos.nombre like '%".$frase."%' and dispositivos.baja is null order by nombre";}
	        };
		$reg = registros($sql);
		while($r=mysqli_fetch_assoc($reg)){
		  echo "<option value=".$r["id"].">".$r["nombre"]."</option>";
		};
		?>
		</select>
	</div>
        <div class="form-group has-warning">
		<label class="label-form" for="fecha">Fecha</label>
		<input class="form-control" id="fecha" name="fecha" type="date" required autofocus>
	</div>
	<br><br>
	<div class="form-group has-warning">
		<label class="label-form" for="agentes">Agentes</label>
		<input class="form-control"  id="agentes" name="agentes" size="50" maxlength="60" required onblur="valida_0(this.id)">
	</div>
	<br><br>
	<input class="btn-primary" type="submit" value="Registrar">
</form>
</div>
<script>

function valida(){
valida_0("nombre");
valida_0("referente");
valida_0("domicilio");
valida_0("telefonos");
valida_fecha("baja",1);
valida_mail("email");
document.getElementById("cod_calle").disabled=false;
document.getElementById("altura").disabled=false;
document.getElementById("geo_x").disabled=false;
document.getElementById("geo_y").disabled=false;
status("");
return true;
}

</script>
</body>
