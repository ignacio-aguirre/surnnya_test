<?php
require("Funciones.php");
session_start();
$_SESSION["prestacion"]="Registro de Familias en Seguimiento";
registre();
include("encabezado.php");
$id="";
if(isset($_GET["id"])) {
 $id=$_GET["id"];
};

$r=un_registro("select *,edc(fecha_nacimiento,null,null,null,null) as eda from af_familias left join personas on persona=idpersonas where idaf_familias=".$id);
if($r==null){die("null");};
$hoga=$r["hogar"];
if(isset($_GET['hogar'])) $hoga=$_GET['hogar'];
?>

<div class="container">
<strong>DATOS DE LA FAMILIA DE ACOGIMIENTO</strong>
<div class="table-responsive">
<table class="table">
<tr><td>Dispositivo:</td><td><select id='hogar' name='hogar'><?php echo $_SESSION['Opc_Hoga_AF'];?></select></td>
<script>
valor="<?php echo $hoga;?>";
seleccionar("hogar",valor);
</script>
</tr>
<input type="hidden" id="identificador"  size="6" maxlength="7" onblur='valida_identificador()' value='<?php echo $id;?>'>
<tr><td>Denominaci&oacute;n</td><td><input type="text" id="denominacion" size="30" maxlength="45" onblur='valida_0(this.id)' value='<?php echo $r["denominacion"];?>'></td>
<td>Registro</td><td><input type="text" id="registro"  size="6" maxlength="7" value='<?php echo $r["registro_unico"];?>'></td>
<td>Disposici&oacute;n</td><td><input type="text" id="disposicion"  size="25" maxlength="45" onblur='valida_0(this.id)' value='<?php echo $r["disposicion"];?>'></td></tr>
</table>
</div>
<button class="btn-info" onclick="navega('af_familias_grupos?id=<?php echo $id?>')">Ir a Grupo Familiar</button><br><br>

<hr>
<strong>DATOS DEL REFERENTE DE ACOGIMIENTO</strong>
<div class="table-responsive">
<table class="table">
<tr><td>Apellidos</td><td><input type="text" id="apellidos" name="apellidos" size="30" maxlength="45"  onblur='valida_0(this.id)' value='<?php echo $r["apellidos"];?>'></td>
<td>Nombres</td><td><input type="text" id="nombres" name="nombres" size="30" maxlength="45" onblur='valida_0(this.id)' value='<?php echo $r["nombres"];?>'></td></tr>
<tr><td>Tipo de Documento</td><td><select id="tipodoc" name="tipodoc"><?php echo tbla("tipodoc");?></select></td>
<td>Nro. de Documento</td><td><input type="text" id="nrodoc" name="nrodoc" size="6" maxlength="10" onfocus='solosino("tipodoc",0,"fecha_nacimiento")' onblur='sale_nrodoc()'  value='<?php echo $r["nrodoc"];?>'></td></tr>
<tr><td>Fecha de Nacimiento</td><td><input type="text" id="fecha_nacimiento" name="fecha_nacimiento" size="6" maxlength="10" onblur='valida_fecha(this.id,"1")'  value='<?php echo ffec($r["fecha_nacimiento"]);?>'></td>
<td>Edad</td><td><input type="text" id="edad" name="edad" size="15"  onfocus='solosi("fecha_nacimiento","","nacionalidad")' onblur='ob_numero(this.id,"1")' value='<?php echo $r["eda"];?>'></td></tr>
<tr><td>Nacionalidad</td><td><select id="nacionalidad" name="nacionalidad"><?php echo tbla("nacionalidad");?></select></td>
<td>G&eacute;nero</td><td><select id="genero" name="genero"><option value='F'>Femenino</option><option value='M'>Masculino</option></select></td>
<td>Estado Civil</td><td><select id="estadocivil" name="estadocivil"><?php echo tbla("estadocivil");?></select></td></tr>
<tr><td>Domicilio Caba/GBA/Otros</td><td><select id="caba" name="caba"><?php echo tbla("caba");?></select></td>
<tr><td>Caba:Barrio</td><td><input type="text" id="barrio" name="barrio" size="30" maxlength="45" onfocus='solosi("caba",1,"localidad")' onblur='valida_0(this.id)' value='<?php echo $r["barrio"];?>'></td>
<td>Caba:Comuna</td><td><select id="comuna" name="comuna"><?php echo tbla("comuna");?></select></td></tr>
<tr><td>Localidad</td><td><input type="text" id="localidad" name="localidad" size="30" maxlength="45" onfocus='solosino("caba",1,"calle")' onblur='valida_0(this.id)' value='<?php echo $r["localidad"];?>'></td>
<td>PBA:Partido</td><td><input type="text" id="partido" name="partido" size="30" maxlength="45" onfocus='solosino("caba",1,"calle")' onblur='valida_0(this.id)'></td></tr>
<tr><td>Domicilio Calle y Nro.</td><td><input type="text" id="calle" name="calle" size="30" maxlength="60" onfocus="control_nor('calle')" onblur='valida_0(this.id)' value='<?php echo $r["callenro"];?>'></td>
<td colspan="2">Piso, depto, casa, manzana, etc.</td><td><input type="text" id="otras" name="otras" size="30" maxlength="45" onblur='valida_0(this.id)' value='<?php echo $r["otros_domicilio"];?>'></td></tr>
<tr><td>Email</td><td><input type="text" id="email" name="email" size="30" maxlength="45" onblur='valida_0(this.id)' value='<?php echo $r["email"];?>'></td>
<td>Tel&eacute;fonos</td><td><input type="text" id="telefonos" name="telefonos" size="30" maxlength="45" onblur='valida_0(this.id)' value='<?php echo $r["telefonos"];?>'></td></tr>
<tr><td>Ocupaci&oacute;n</td><td><input type="text" id="ocupacion" name="ocupacion" size="30" maxlength="45" onblur='valida_0(this.id)' value='<?php echo $r["ocupacion"];?>'></td>
<td>Fecha de Actualizaci&oacute;n</td><td><input type="text" id="fecha_actualizacion" name="fecha_actualizacion" size="6" maxlength="10" onblur='valida_fecha(this.id)' value='<?php echo ffec($r["fecha_actualizacion"]);?>'></td></tr>
</table>
</div>
<?php if ($id!=0) {
  echo "<h3>REQUISITOS PARA EL REGISTRO</h3>";
  echo "<h4>Encuesta  "; 
  $da=un_registro("select * from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos where archivos_vinculos.tipo='F' and identificador=".$id." and as_tipo=103 and as_baja is null");
  if($da!=null && $da['as_path']!="") {echo " <a href='descarga_nuevo?id=".$da['idarchivos_subidos']."'>Descargar</a>&nbsp;<a href='archdesvincular?id=".$da["idarchivos_subidos"]."&tipo=F&identificador=".$id."'>Desvincular</a></h4>";} else echo "FALTANTE -  <a href='subir_archivos?familia=".$id."&tipo=103'>Subir</a></h4>";
  echo "<h4>Informe Socioambiental "; 
  $da=un_registro("select * from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos where archivos_vinculos.tipo='F' and identificador=".$id." and as_tipo=101 and as_baja is null");
  if($da!=null && $da['as_path']!="") {echo " <a href='descarga_nuevo?id=".$da['idarchivos_subidos']."'>Descargar</a>&nbsp;<a href='archdesvincular?id=".$da["idarchivos_subidos"]."&tipo=F&identificador=".$id."'>Desvincular</a></h4>";} else echo "FALTANTE -  <a href='subir_archivos?familia=".$id."&tipo=101'>Subir</a></h4>";
  echo "<h4>Informe Psicol&oacute;gico  ";
  $da=un_registro("select * from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos where archivos_vinculos.tipo='F' and identificador=".$id." and as_tipo=102 and as_baja is null");
  if($da!=null && $da['as_path']!="") {echo " <a href='descarga_nuevo?id=".$da['idarchivos_subidos']."'>Descargar</a>&nbsp;<a href='archdesvincular?id=".$da["idarchivos_subidos"]."&tipo=F&identificador=".$id."'>Desvincular</a></h4>";} else echo "FALTANTE -  <a href='subir_archivos?familia=".$id."&tipo=102'>Subir</a></h4>";
    echo "<h4>Inscripci&oacute;n al registro  ";
  $da=un_registro("select * from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos where archivos_vinculos.tipo='F' and identificador=".$id." and as_tipo=104 and as_baja is null");
  if($da!=null && $da['as_path']!="") {echo " <a href='descarga_nuevo?id=".$da['idarchivos_subidos']."'>Descargar</a>&nbsp;<a href='archdesvincular?id=".$da["idarchivos_subidos"]."&tipo=F&identificador=".$id."'>Desvincular</a></h4>";} else echo "FALTANTE -  <a href='subir_archivos?familia=".$id."&tipo=104'>Subir</a></h4>";
  echo "<h4>Consentimiento de Inicio de Proceso de Selecci&oacute;n  ";
  $da=un_registro("select * from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos where archivos_vinculos.tipo='F' and identificador=".$id." and as_tipo=112 and as_baja is null");
  if($da!=null && $da['as_path']!="") {echo " <a href='descarga_nuevo?id=".$da['idarchivos_subidos']."'>Descargar</a>&nbsp;<a href='archdesvincular?id=".$da["idarchivos_subidos"]."&tipo=F&identificador=".$id."'>Desvincular</a></h4>";} else echo "FALTANTE -  <a href='subir_archivos?familia=".$id."&tipo=112'>Subir</a></h4>";
};
?>
<h3>HISTORIAL DE ALOJAMIENTO</h3>
<div class="table-responsive">
<table class="table">
<th>Apellido y Nombre</th><th>Desde</th><th>Hasta</th>
<?php
 if ($id!=0) {
 $reg=registros("select apellidos, nombres, admi_alta, admi_baja from hogares_admision left join sujetos on admi_legajo=legajo where admi_fami=".$id);
 while ($re = mysqli_fetch_assoc($reg)) {
   echo colorfila()."<td>".$re["apellidos"].", ".$re["nombres"]."</td><td>".ffec($re["admi_alta"])."</td><td>".ffec($re["admi_baja"])."</td></tr>";
 };
 };
?>
</table>
</div>
<h3>HISTORIAL DE APOYO</h3>
<div class="table-responsive">
<table class="table">
<th>Apellido y Nombre</th><th>Desde</th><th>Hasta</th>
<?php
 if ($id!=0) {
 $apy=registros("select apellidos, nombres, f_desde, f_hasta from af_apoyos 
 left join hogares_admision on alojamiento=idhogares_admision left join sujetos on admi_legajo=legajo where familia=".$id);
 while ($ap = mysqli_fetch_assoc($apy)) {
   echo colorfila()."<td>".$ap["apellidos"].", ".$ap["nombres"]."</td><td>".ffec($ap["f_desde"])."</td><td>".ffec($ap["f_hasta"])."</td></tr>";
 };
 };
?>
</table>
</div>

<hr>
<div>
<?php if ($id!=0) {
  echo "<h4>DOCUMENTACION OBLIGATORIA</h4>";
  echo "<h4>DNI's <a href='subir_archivos?familia=".$id."&tipo=105'>Subir</a></h4>";
  echo muestrarchivos(105,$id);
  echo "<h4>Antecedentes Penales <a href='subir_archivos?familia=".$id."&tipo=106'>Subir</a></h4>";
  echo muestrarchivos(106,$id);
  echo "<h4>Deudores Alimentarios <a href='subir_archivos?familia=".$id."&tipo=107'>Subir</a></h4>";
  echo muestrarchivos(107,$id);
  echo "<h4>No Inscripci&oacute;n Ruaga <a href='subir_archivos?familia=".$id."&tipo=108'>Subir</a></h4>";
  echo muestrarchivos(108,$id);
  echo "<h4>No Inscripci&oacute;n DNRUA <a href='subir_archivos?familia=".$id."&tipo=110'>Subir</a></h4>";
  echo muestrarchivos(110,$id);
  echo "<h4>Capacitaciones <a href='subir_archivos?familia=".$id."&tipo=109'>Subir</a></h4>";
  echo muestrarchivos(109,$id);
  echo "<h4>Otros Archivos <a href='subir_archivos?familia=".$id."&tipo=111'>Subir</a></h4>";
  echo muestrarchivos(111,$id);
  echo "<h3>Capacitaciones</h3>";
  echo "<div class='table-responsive'><table class='table'>";
  echo "<tr><th>Capacitaci&oacute;n</th><th>Realizada</th><th>Fecha</th></tr>";
  echo "<tr><td>RCP</td><td><select id='cp_rcp'><option value='0'>No</option><option value='1'>S&iacute;</option></select></td><td><input id='cp_rcp_fecha' size='10' maxlength='10'  value='".ffec($r["cp_rcp_fecha"])."'></td></tr>";
  echo "<tr><td>Rol</td><td><select id='cp_rol'><option value='0'>No</option><option value='1'>S&iacute;</option></select></td><td><input id='cp_rol_fecha' size='10' maxlength='10'  value='".ffec($r["cp_rol_fecha"])."'></td></tr>";
  echo "<tr><td>Marco Legal</td><td><select id='cp_marcolegal'><option value='0'>No</option><option value='1'>S&iacute;</option></select></td><td><input id='cp_marcolegal_fecha' size='10' maxlength='10'  value='".ffec($r["cp_marcolegal_fecha"])."'></td></tr>";
  echo "</table></div>";

  echo "<h3>Intervenciones <a href='ninthogar?hogar=".$hoga."&familia=".$id."'>Nueva</a></h3>";

  echo "<div class='table-responsive'><table class='table'>

  <tr><td>Acc</td><td>Fecha</td><td>Tipo</td><td>Supervisores</td><td>Descripci&oacute;n</td><td>Usuario</td></tr>";

  $da = registros("select idhogares_intervenciones as id, fecha, deno, supervisores, texto, usuario from hogares_intervenciones left join tablas on tablas.tipo='TINTH' and valo=hogares_intervenciones.tipo where hogar=".$hoga." and familia=".$id." and hogares_intervenciones.baja is null order by fecha desc");

  

  while ( $dt = mysqli_fetch_assoc($da)){

   echo colorfila()."<td>";

   if($dt["usuario"]==$_SESSION["glusua"]) echo "<a href='hogares_intborrar?id=".$dt["id"]."'><img src='imagenes/eliminar.png' height='25' width='25' ></a>";

   echo "</a></td><td>".ffec($dt["fecha"])."</td><td>".$dt["deno"]."</td><td>".$dt["supervisores"]."</td><td>".$dt["texto"]."</td><td>".$dt["usuario"]."</td></tr>";

   };
  echo "</table></div>";
};

function muestrarchivos($tipo,$id){
$reg=registros("select *,concat(denominacion,'-',as_usuario) as efector from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos left join sectores on as_dispositivo=id where archivos_vinculos.tipo='F' and identificador=".$id." and as_tipo=".$tipo." and as_baja is null order by as_fecha desc");
$texto="";
while ($da=mysqli_fetch_assoc($reg)){
if($texto=="") $texto="<table><th>Descripci&oacute;n</th><th>Efector - Usuario</th><th>Fecha Subida</th><th>Acciones</th>";
$texto=$texto.colorfila()."<td>".$da['as_descripcion']."</td><td>".$da['efector']."</td><td>".ffec($da['as_fecha'])."</td><td><a href='descarga_nuevo?id=".$da['idarchivos_subidos']."'>Descargar</a>";
if($da['as_dispositivo']==$_SESSION['gldispo']&&$da['as_usuario']==$_SESSION['glusua']) $texto=$texto."  <a href='archdesvincular?id=".$da['idarchivos_subidos']."&tipo=F&identificador=".$id."'> Desvincular</a>";
$texto=$texto."</td></tr>";
};
if($texto!="") $texto=$texto."</table></div>";
return $texto;
}
?>
</div>

<script type="text/javascript">
seleccionar("tipodoc",'<?php echo $r["tipodoc"];?>');
seleccionar("nacionalidad",'<?php echo $r["nacionalidad"];?>');
seleccionar("estadocivil",'<?php echo $r["estadocivil"];?>');
seleccionar("caba",'<?php echo $r["caba"];?>');
seleccionar("comuna",'<?php echo $r["comuna"];?>');
seleccionar("cp_rcp","<?php echo $r["cp_rcp"]?>");
seleccionar("cp_rol","<?php echo $r["cp_rol"]?>");
seleccionar("cp_marcolegal","<?php echo $r["cp_marcolegal"]?>");


function valida_datos(){
 if(document.getElementById("denominacion").value=="") return false;
 if(document.getElementById("hogar").value=="") return false;
 return true;
}
enfoca("denominacion");
</script>
</body>
</html>