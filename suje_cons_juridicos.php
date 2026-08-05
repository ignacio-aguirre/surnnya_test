<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Consulta Datos Jur&iacute;dicos del Sujeto";
include("encabezado.php");
if (!isset($_SESSION['gldispo'])|!isset($_GET['legajo'])) header ("Location: salir");
registre();
$lega= $_GET["legajo"];
if ($lega=="" ) ("Location: consultasujetos");
$sql="select sujetos.legajo,fecha,  juzgado_modalidad, juzgado_numero, juzgado_expediente, juzgado_caratula,defensoria_zonal,equipo,  zonal_provincial,tipo_medida   from sujetos left join sujetos_juridicos on sujetos_juridicos.legajo=sujetos.legajo where sujetos.legajo=".$lega;
$dj = un_registro($sql);
if ($dj['legajo']!=$lega) ejecute("insert into sujetos_juridicos (legajo) values(".$lega.")");
$sector=un_campo("select concat(deno,' ',info) from tablas where tipo='CM' and valo='".$dj["defensoria_zonal"]."'");
$_SESSION["posicion"]="4";
include("mnu_superior.php");
?>
<div class="container">
<Strong>DATOS JURIDICOS</Strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='sujeactjuridicos?legajo=<?php echo $lega;?>'>Actualizar</a></strong><br>
<strong>Juzgado Interviniente </strong>
<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed">
<thead><tr class="bg-primary"><td>Fuero y Nro.</td><td>Expediente</td><td>Car&aacute;tula</td></tr></thead>
<tr><td><strong><?php echo un_campo("select deno from tablas where tipo='TJ' and valo=".nulea($dj['juzgado_modalidad']))." ".$dj['juzgado_numero'];?></td><td><strong><?php echo $dj['juzgado_expediente'];?></td><td><strong><?php echo $dj['juzgado_caratula'];?></td></tr>
</table>
</div>
<Strong>Organismos de Promoci&oacute;n y Protecci&oacute;n de Derechos</Strong>
<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed">
<thead><tr class="bg-primary"><td>Defensor&iacute;a Zonal</td><td>Equipo</td><td>Tipo Medida</td><td>Zonal Provincial</td></tr></thead>
<tr><td><strong><?php echo $sector."</td><td>".$dj['equipo'];?>
</td><td><strong><?php echo un_campo("select deno from tablas where tipo='TM' and valo=".nulea($dj['tipo_medida']));?>
</td><td><strong><?php echo un_campo("select deno from tablas where tipo='ZP' and valo=".nulea($dj['zonal_provincial']));?></td></tr>
</table>
</div>
<script type="text/javascript">
function valida_campos(){
  if(document.getElementById("fecha").value!="" || document.getElementById("dias").value!="" || document.getElementById("archivo").value!="" ) return true;
  return false;
}

</script>
<strong>Medidas (MEX solamente)</strong>
<form action="uploadmedida" method="post" enctype="multipart/form-data" onsubmit="return valida_campos()">
<div class="table-responsive">
<table style="font-size:.9em" class="table table-striped table-bordered table-condensed">
<thead><tr class="bg-primary"><td>Fecha</td><td>D&iacute;as</td><td>Vencimiento</td><td>Acto adm</td><td>Archivo/F.subida</td><td></td></tr></thead>
<tr><td><input id="fecha" name="fecha" size="8" maxlength="10" onblur=valida_fecha(this.id)></td><td>
<input id="dias" name="dias" size="3" maxlength="3" onblur="valida_entero(this.id)"></td><td></td><td><input name="acto_administrativo"
id="acto_administrativo" size="25" maxlength="40"></td><td><input name="archivo" id="archivo" type="file" size="35" /></td>
 <td><input type='hidden' name='legajo' value='<?php echo $lega;?>'><input type="submit" name="action" value="Subir"></td></tr>
<?php $me=registros("select fecha,dias,case when no_innovar=0 then DATE_ADD(fecha,INTERVAL dias DAY) else null end as vto,archivo,as_path, no_innovar,acto_administrativo,archivos_subidos.as_fecha as subida from sujetos_medidas left join archivos_subidos on archivo=idarchivos_subidos where legajo=".$lega." order by fecha desc");
while ($m = mysqli_fetch_assoc($me)) {
  echo colorfila()."<td>".ffec($m["fecha"])."</td><td>".$m["dias"].si($m["no_innovar"]=="1","No Inn.","")."</td><td>".ffec($m["vto"])."</td>
<td>".$m["acto_administrativo"]."</td><td>".ffec($m["subida"])."</td><td><a href='descarga?link=".sacamas($m['as_path'])."&nombre=".sacamas_limpia(sacapath($m['as_path']))."'>Descargar</a>";
  echo "</td></tr>";
};
?>
</table>
</div>
</form>



<script type="text/javascript">

function valida_campos(){

  if(document.getElementById("fecha").value!="" && document.getElementById("dias").value!="" && document.getElementById("archivo").value!="" ) return true;

  return false;

}

</script>
</div>
</body>
</html>