<?php
include("Funciones.php"); 
session_start();
if(isset($_GET["id"])){
	$id=$_GET["id"];
}else {
	Redirect("rua_nomina");
};
$r=un_registro("select * from rua_nomina where id=".$id);
$l=un_registro("select * from sujetos where legajo=".$r["legajo"]);
$p=un_registro("select * from sujetos_pae where legajo=".$r["legajo"]);
$_SESSION["prestacion"]="Consulta al registro RUA";
include("encabezado-test.php");
function edadaprox($fn){
	$dias=un_campo("select datediff(curdate(),".$fn.")");
	return intval(intval($dias)/365.25);
}
?>
<div class="container">
<div class="row">
	<div class="col-md-4">
		Registro <strong><?php echo $r["registro"]?></strong>
	</div>
	<div class="col-md-4">
		Apellidos y nombres <strong><?php echo $l["Apellidos"].", ".$l["Nombres"]?></strong>
	</div>	
	<div class="col-md-2">
		DNI / CUIL <strong><?php echo $l["SujetosDNI"]." ".$l["cuil"]?></strong> 
	</div>	
	<div class="col-md-2">
		F.Nacimiento / edad <strong><?php echo ffec($l["f_nacimiento"])." ".edadaprox(fsql(ffec($l["f_nacimiento"])))." hoy"?></strong>
	</div>	
</div>
<div class="row">
	<div class="col-md-6">
		Domicilio <strong><?php echo $p["callenro_domicilio"]." ".$p["otros_domicilio"]." ".$p["localidad_domicilio"]." ".$p["provincia_dommicilio"]?></strong>
	</div>	
	<div class="col-md-6">
		Tel&eacute;fono / email <strong><?php echo $l["telefonos"]." ".$l["email"]?></strong>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		Fecha de ingreso al registro <strong><?php echo ffec($r["f_ingreso"])?></strong>
	</div>	
</div>	
<div class="row">
	<div class="col-md-6">
		Intereses <strong><?php echo $p["intereses"]?></strong>
	</div>	
	<div class="col-md-6">
		Competencias <strong><?php echo $p["competencias"]?></strong>
	</div>
</div>
<br>
<h6>Ingreso al puesto laboral</h6>
<div class="row">
	<div class="col-md-3">
		<label class="label-form">Fecha ingreso al puesto laboral</label>
		<input class="form-control" id="f_alta_laboral" name="f_alta_laboral" value="<?php echo ffec($r["f_alta_laboral"])?>" onblur="bl_fal(this.id)">
	</div>	
	<div class="col-md-4">
		<label class="label-form">Poder</label>
		<select class="form-control" id="poder" name="poder" onblur="bl_pod(this.id)">
			<option value="0"></option>
			<?php echo opc_tabla("PRUA")?>
		</select>
		<script>seleccionar("poder","<?php echo $r["poder"]?>")</script>	
	</div>	
	<div class="col-md-5">
		<label class="label-form">Organismo</label>
		<input class="form-control" id="organismo" name="organismo" value="<?php echo $r["organismo"]?>" maxlength="70" onblur="bl_org(this.id)">
	</div>
</div>
<br>
<h6>Documentaci&oacute;n</h6>
<div class="row">
	<div class="col-md-4">
		CV actualizado
		<?php 
		$da=un_registro("select * from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos where archivos_vinculos.tipo='S' and identificador=".$r["legajo"]." and as_tipo=202 and as_baja is null");
  		if($da!=null && $da['as_path']!="") {echo " <a href='descarga_nuevo?id=".$da['idarchivos_subidos']."'>Descargar</a>&nbsp;<a href='archdesvincular?id=".$da["idarchivos_subidos"]."&tipo=S&identificador=".$r["legajo"]."'>Desvincular</a></h4>";} else echo "FALTANTE -  <a href='subir_archivos?legajo=".$r["legajo"]."&tipo=202'>Subir</a></h4>";
  		?>
	</div>
	<div class="col-md-4">
		Consentimiento informado
		<?php 
		$da=un_registro("select * from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos where archivos_vinculos.tipo='S' and identificador=".$r["legajo"]." and as_tipo=203 and as_baja is null");
  		if($da!=null && $da['as_path']!="") {echo " <a href='descarga_nuevo?id=".$da['idarchivos_subidos']."'>Descargar</a>&nbsp;<a href='archdesvincular?id=".$da["idarchivos_subidos"]."&tipo=S&identificador=".$r["legajo"]."'>Desvincular</a></h4>";} else echo "FALTANTE -  <a href='subir_archivos?legajo=".$r["legajo"]."&tipo=203'>Subir</a></h4>";
  		?>
	</div>
	<div class="col-md-4">
		<a href="suje_cons_archivos?legajo=<?php echo $r['legajo']?>">Otros</a>
	</div>
</div>
<h6>Estado</h6>
<div class="row">
	<div class="col-md-12">
		<?php
			$estado=un_campo("select deno from tablas where tipo='ERUA' and valo=".$r["estado"]);
			$fecha_estado=ffec(un_campo("select fecha from rua_estados where registro=".$id." order by fecha desc,id desc limit 1"));
			$comentarios=un_campo("select comentarios from rua_estados where registro=".$id." order by fecha desc,id desc limit 1");
		?>
		Estado <strong><?php echo $estado." - ".$comentarios?></strong>&nbsp;
		<?php if(ffec($r["f_baja"])==""){?>
		<a href="rua_cambio_estado?id=<?php echo $id?>">Cambiar</a>
	<?php }?>

	</div>
</div>
<br>
<h6>Historial de cambios</h6>
<div class="table-responsive pre-scrollable">
	<table class="table">
		<tr class="bg-primary text-white"><th>Fecha</th><th>Estado</th><th>Comentarios</th><th>Usuario</th></tr>
		<?php
			$est=registros("select rua_estados.*, deno from rua_estados left join tablas on tipo='ERUA' and valo=estado where registro=".$id." order by fecha desc, id desc");
			while($e=mysqli_fetch_assoc($est)){
				echo "<tr><td>".ffec($e["fecha"])."</td><td>".
				$e["deno"]."</td><td>".$e["comentarios"]."</td><td>".$e["usuario"]."</td><tr>";
			}
		?>
	</table>	
</div>				
</div>
<script>
	function bl_fal(id){
		registro="<?php echo $id?>";
		valida_fecha(id,1);
		fal=document.getElementById("f_alta_laboral").value;
		ejec_sq("sq_rua_fal?registro="+registro+"&fal="+fal);
	}
	function bl_pod(id){
		registro="<?php echo $id?>";
		pod=document.getElementById("poder").value;
		ejec_sq("sq_rua_pod?registro="+registro+"&pod="+pod);
	}
	function bl_org(id){
		registro="<?php echo $id?>";
		valida_0(id);
		org=document.getElementById("organismo").value;
		ejec_sq("sq_rua_org?registro="+registro+"&org="+org);
	}
</script>