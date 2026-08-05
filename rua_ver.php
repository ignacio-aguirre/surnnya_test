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
<h6>Baja</h6>
<div class="row">
	<div class="col-md-3">
		<label class="label-form">Fecha de baja</label>
		<input class="form-control" id="f_baja" name="f_baja" value="<?php echo ffec($r["f_baja"])?>" onblur="bl_baj(this.id)">
	</div>	
	<div class="col-md-4">
		<label class="label-form">Motivo</label>
		<select class="form-control" id="m_baja" name="m_baja" onblur="bl_mba(this.id)">
			<option value="0"></option>
			<?php echo opc_tabla("BRUA")?>
		</select>
		<script>seleccionar("m_baja","<?php echo $r["motivo_baja"]?>")</script>	
	</div>	
</div>
<br>
<h6>Comentarios</h6>
<div class="row">
	<div class="col-md-12">
		<label class="label-form">Comentarios</label>
		<input class="form-control" id="comentarios" name="comentarios" value="<?php echo $r["comentarios"]?>" maxlength="250" onblur="bl_com(this.id)">
	</div>	
<div>
	<button class="btn btn-success" onclick="navega('rua_nomina')">Volver</button>
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
	function bl_baj(id){
		registro="<?php echo $id?>";
		valida_fecha(id,1);
		baj=document.getElementById("f_baja").value;
		ejec_sq("sq_rua_baj?registro="+registro+"&baj="+baj);
	}
	function bl_mba(id){
		registro="<?php echo $id?>";
		mba=document.getElementById("m_baja").value;
		ejec_sq("sq_rua_mba?registro="+registro+"&mba="+mba);
	}
	function bl_com(id){
		registro="<?php echo $id?>";
		com=document.getElementById("comentarios").value;
		ejec_sq("sq_rua_com?registro="+registro+"&com="+com);
	}
</script>