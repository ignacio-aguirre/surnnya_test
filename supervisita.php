<?php
include("Funciones.php");
session_start();
if($_SESSION['gl_super_super']!="1"){Redirect("error_noautorizado");};
$_SESSION["prestacion"]="Visita a Dispositivo de Cuidado";
include("encabezado.php");
registre();
$id=$_GET['id'];
if(isset($_GET['enviar'])){
  $fecha=$_GET['fecha'];
  $super=$_GET['super'];
  $hoga=$_GET['hogar'];
  $super=$_GET['super'];
  $obse=$_GET['obse'];

  $inte_reuniones=si($_GET["inte_reuniones"]=="on","1","0");
  $inte_talleres=si($_GET["inte_talleres"]=="on","1","0");
  $inte_mesas=si($_GET["inte_mesas"]=="on","1","0");
  $inte_capacitaciones=si($_GET["inte_capacitaciones"]=="on","1","0");
  $inte_asambleas=si($_GET["inte_asambleas"]=="on","1","0");
  $inte_otros=si($_GET["inte_otros"]=="on","1","0");

  $exte_capacitaciones=si($_GET["exte_capacitaciones"]=="on","1","0");
  $exte_jornadas=si($_GET["exte_jornadas"]=="on","1","0");
  $exte_supervision=si($_GET["exte_supervision"]=="on","1","0");
  $exte_otros=si($_GET["exte_otros"]=="on","1","0");
  $fore_detalle=$_GET["fore_detalle"];

  $espa_consejos=si($_GET["espa_consejos"]=="on","1","0");
  $espa_proyectos=si($_GET["espa_proyectos"]=="on","1","0");
  $espa_escucha=si($_GET["espa_escucha"]=="on","1","0");
  $espa_otros=si($_GET["espa_otros"]=="on","1","0");

  $part_deportivas=si($_GET["part_deportivas"]=="on","1","0");
  $part_recreativas=si($_GET["part_recreativas"]=="on","1","0");
  $part_culturales=si($_GET["part_culturales"]=="on","1","0");
  $part_barriales=si($_GET["part_barriales"]=="on","1","0");
  $part_otras=si($_GET["part_otras"]=="on","1","0");

  $expe_talleres=si($_GET["expe_talleres"]=="on","1","0");
  $expe_salidas=si($_GET["expe_salidas"]=="on","1","0");
  $expe_programas=si($_GET["expe_programas"]=="on","1","0");
  $expe_otras=si($_GET["expe_otras"]=="on","1","0");
  $part_detalle=$_GET["part_detalle"];


  $acti_entrevista=si($_GET["acti_entrevista"]=="on","1","0");
  $acti_obs_dinamicas=si($_GET["acti_obs_dinamicas"]=="on","1","0");
  $acti_talleres=si($_GET["acti_talleres"]=="on","1","0");
  $acti_ludicas=si($_GET["acti_ludicas"]=="on","1","0");
  $acti_participacion=si($_GET["acti_participacion"]=="on","1","0");
  $acti_otros=si($_GET["acti_otros"]=="on","1","0");
  $acti_detalle=$_GET["acti_detalle"];
  $chic=nulea($_GET['chicos']);
  $maxreg=$_GET['reg'];
  
  if($id==0) {
    $id=un_campo("select idsuper_visita from super_visita where super_hogar=".$hoga." and super_fecha=".fsql($fecha));
    if($id=="") {$id=inserte("insert into super_visita(super_super, super_hogar) values('".$super."',".$hoga.")");};
  };
  ejecute("update super_visita set super_super='".$super."', super_chicos=".$chic.", super_obse='".$obse."', super_usuario='".$_SESSION['glusua']."', super_fecha=".fsql($fecha).
  ",acti_entrevista=".$acti_entrevista.",acti_obs_dinamicas=".$acti_obs_dinamicas.", acti_talleres=".$acti_talleres.
  ",acti_ludicas=".$acti_ludicas.",acti_participacion=".$acti_participacion.", acti_otros=".$acti_otros.
  ", acti_detalle=".tsql($acti_detalle).
  ", inte_reuniones=".$inte_reuniones.", inte_talleres=".$inte_talleres.", inte_mesas=".$inte_mesas.", inte_capacitaciones=".$inte_capacitaciones.
  ", inte_asambleas=".$inte_asambleas.", inte_otros=".$inte_otros.
  ", exte_capacitaciones=".$exte_capacitaciones.", exte_jornadas=".$exte_jornadas.", exte_supervision=".$exte_supervision.", exte_otros=".$exte_otros.
  ", fore_detalle=".tsql($fore_detalle).
  ", espa_consejos=".$espa_consejos.", espa_proyectos=".$espa_proyectos.", espa_escucha=".$espa_escucha.", espa_otros=".$espa_otros.
  ", part_deportivas=".$part_deportivas.", part_recreativas=".$part_recreativas.", part_culturales=".$part_culturales.
  ", part_barriales=".$part_barriales.", part_otras=".$part_otras.
  ", expe_talleres=".$expe_talleres.", expe_salidas=".$expe_salidas.", expe_programas=".$expe_programas.", expe_otras=".$expe_otras.
  ", part_detalle=".tsql($part_detalle)." where idsuper_visita=".$id);
  ejecute("delete from super_visita_cargos where super_visita=".$id);
  $conta=0;
  while($conta<11) {
       $conta=$conta+1;
       $car=$_GET["c".(string)($conta)];
       $nom=$_GET["n".(string)($conta)];
       if($car!=""|$nom!="") ejecute("insert into super_visita_cargos(super_visita,super_cargo,super_nombres) values(".$id.",'".$car."','".$nom."')");
  };
  Redirect("supervisitas");
};

if($id!=0) {
$vi=un_registro("select * from super_visita where idsuper_visita=".$id);
$hoga=$vi['super_hogar'];
$fecha=ffec($vi['super_fecha']);
$super=$vi['super_super'];
$obse=$vi['super_obse'];
$chic=$vi['super_chicos'];
if(isset($_GET['baja'])) {
  ejecute("delete from super_visita where idsuper_visita=".$id);
  ejecute("delete from super_visita_legajo where super_visita=".$id);
  ejecute("delete from visita_archivos where va_visita=".$id);
  ejecute("delete from super_visita_cargos where super_visita=".$id);
  Redirect("supervisitas");
};
}
else {
$hoga=$_GET['hogar'];
$fecha=$_SESSION['DiaHoy'];
$super=substr($_SESSION['glusua'],0,stripos($_SESSION['glusua'],","));
$obse="";
$chic="";
};
?>
</div>
<div class="container">
<?php if($id>0) echo "<a class='btn-small btn-primary' href='informevisita?id=".$id."'>Ver Informe</a><br>";?>
<form class="form-inline" method='get' onsubmit='return valida_campos()'>
<div class="form-group has-warning">
<label class="label-form">Hogar</label>
<select class="form-control" name='hogar' id='hogar'><?php echo $_SESSION['Opc_Hoga'];?></select>
</div>
<div class="form-group has-warning">
<label class="label-form">Fecha Visita</label>
<input class="form-control" type='text' size='10' maxlength='10' name='fecha' id='fecha' value='<?php echo $fecha;?>' onblur="valida_fecha('fecha')">
</div>
<div class="form-group has-warning">
<label class="label-form">Supervisores</label>
<input class="form-control" type='text' size='45' maxlength='100' name='super' id='super' value='<?php echo $super;?>'><br>
</div>
<div class="form-group has-warning">
<label class="label-form">Aspectos Organizacionales: Organizaci&oacute;n de rutinas/ momentos claves (comidas, noche, ba&ntilde;o, tarea). Uso y estado de los espacios/ apropiaci&oacute;n de los mismos. Roles/Din&aacute;mica Interna, Clima institucional, Comunicaci&oacute;n; Formas de vincularse, adultos disponibles, capacidad de escucha/Lugar de la palabra, 
Anticipaci&oacute;n Articulaciones institucionales /comunitarias.</label> 
Max:5100 caracteres, usado:<input type='text' size='2' readonly id='usado'>
<textarea class="form-control" cols="150" rows="10" name="obse" onkeyup="limite('obse','5100','usado')" onblur="valida_0('obse')" onfocus='foca_usado("obse")' id="obse"><?php echo $obse;?></textarea>
</div>
<br><br>
<div class="form-group has-warning">
<label class="label-form">Cantidad NNYA alojadxs: </label>
<input class="form-control" type='text' size='2' name='chicos' id='chicos' onblur='valida_entero("chicos")' value='<?php echo $chic;?>'>
</div>
<h3>Responsables</h3>
<div class="table-responsive">
<table class="table">
<tr class="bg-primary"><th>Cargo</th><th>Apellidos y Nombres</th></tr>
<?php
$idaux=$id;
if($id==0) $idaux=un_campo("select max(idsuper_visita) from super_visita where super_hogar=".$hoga);
if($idaux>0){
$conn=registros("select idsuper_visita_cargos as id, super_cargo, super_nombres from super_visita_cargos where super_visita=".$idaux." order by idsuper_visita_cargos");
$conta=1;
while ($cargos = mysqli_fetch_assoc($conn) or $conta<11) {
 $conta=$conta+1;
 if($conta % 2==0) {echo "<tr bgcolor='white'>";} else {echo "<tr bgcolor='#E6E6E6'>";};
 $ncar="c".(string)($conta-1);
 $nnom="n".(string)($conta-1);
 $vcar=$cargos["super_cargo"];
 $vnom=$cargos["super_nombres"];
 echo "<td><input type='text' size='45' maxlength='45' name='".$ncar."' id='".$ncar."' value='".$vcar."' onblur='valida_0(".'"'.$ncar.'"'.")'></td>";

 echo "<td><input type='text' size='60' maxlength='100' name='".$nnom."' id='".$nnom."' value='".$vnom."' onblur='valida_0(".'"'.$nnom.'"'.")'></td>";

 echo "</tr>";

};

}
else{$conta=1;};
?>
</table>
</div>
<h3>ESPACIOS DE FORMACI&Oacute;N Y REFLEXI&Oacute;N DE LOS EQUIPOS</h3>
<h4>1. Internos</h4>
<div class="form-group has-warning">
<label class="label-form">Reuniones de Equipo</label>
<input class="form-control" id="inte_reuniones" name="inte_reuniones" type="checkbox" <?php echo si($vi["inte_reuniones"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Talleres</label>
<input class="form-control" id="inte_talleres" name="inte_talleres" type="checkbox" <?php echo si($vi["inte_talleres"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Mesas de Trabajo</label>
<input class="form-control" id="inte_mesas" name="inte_mesas" type="checkbox" <?php echo si($vi["inte_mesas"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Capacitaciones</label>
<input class="form-control" id="inte_capacitaciones" name="inte_capacitaciones" type="checkbox" <?php echo si($vi["inte_capacitaciones"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Asambleas</label>
<input class="form-control" id="inte_asambleas" name="inte_asambleas" type="checkbox" <?php echo si($vi["inte_asambleas"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Otros</label>
<input class="form-control" id="inte_otros" name="inte_otros" type="checkbox" <?php echo si($vi["inte_otros"]=="1"," checked","")?>>
</div>
<h4>2. Externos</h4>
<div class="form-group has-warning">
<label class="label-form">Capacitaciones</label>
<input class="form-control" id="exte_capacitaciones" name="exte_capacitaciones" type="checkbox" <?php echo si($vi["exte_capacitaciones"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Jornadas / Conferencias / Congresos</label>
<input class="form-control" id="exte_jornadas" name="exte_jornadas" type="checkbox" <?php echo si($vi["exte_jornadas"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Supervisi&oacute;n T&eacute;cnica Externa</label>
<input class="form-control" id="exte_supervision" name="exte_supervision" type="checkbox" <?php echo si($vi["exte_supervision"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Otros</label>
<input class="form-control" id="exte_otros" name="exte_otros" type="checkbox" <?php echo si($vi["exte_otros"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Descripci&oacute;n de los espacios de formaci&oacute;n y reflexi&oacute;n</label>
<textarea class="form-control" cols="100" rows="3" name="fore_detalle" onblur="valida_0('fore_detalle')" id="fore_detalle"><?php echo $vi["fore_detalle"];?></textarea>
</div>
<br>
<h3>ESPACIOS DE PARTICIPACI&Oacute;N DE NNYA</h3> 
<h4>1. Participaci&oacute;n en el ejercicio de la ciudadan&iacute;a.</h4>
<div class="form-group has-warning">
<label class="label-form">Consejos</label>
<input class="form-control" id="espa_consejos" name="espa_consejos" type="checkbox" <?php echo si($vi["espa_consejos"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Proyectos</label>
<input class="form-control" id="espa_proyectos" name="espa_proyectos" type="checkbox" <?php echo si($vi["espa_proyectos"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Espacios de escucha dentro del dispositivo de cuidado</label>
<input class="form-control" id="espa_escucha" name="espa_escucha" type="checkbox" <?php echo si($vi["espa_escucha"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Otros</label>
<input class="form-control" id="espa_otros" name="espa_otros" type="checkbox" <?php echo si($vi["espa_otros"]=="1"," checked","")?>>
</div>
<br>
<h4>2. Participaci&oacute;n comunitaria.</h4>
<div class="form-group has-warning">
<label class="label-form">Actividades Deportivas</label>
<input class="form-control" id="part_deportivas" name="part_deportivas" type="checkbox" <?php echo si($vi["part_deportivas"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Actividades Recreativas</label>
<input class="form-control" id="part_recreativas" name="part_recreativas" type="checkbox" <?php echo si($vi["part_recreativas"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Actividades Culturales</label>
<input class="form-control" id="part_culturales" name="part_culturales" type="checkbox" <?php echo si($vi["part_culturales"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Actividades Barriales</label>
<input class="form-control" id="part_barriales" name="part_barriales" type="checkbox" <?php echo si($vi["part_barriales"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Otras</label>
<input class="form-control" id="part_otras" name="part_otras" type="checkbox" <?php echo si($vi["part_otras"]=="1"," checked","")?>>
</div>
<h4>3. Experiencias de participaci&oacute;n.</h4>
<div class="form-group has-warning">
<label class="label-form">Talleres</label>
<input class="form-control" id="expe_talleres" name="expe_talleres" type="checkbox" <?php echo si($vi["expe_talleres"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Salidas recreativas o campamentos o viajes</label>
<input class="form-control" id="expe_salidas" name="expe_salidas" type="checkbox" <?php echo si($vi["expe_salidas"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Dispositivos y/o programas destinados a las ni&ntilde;eces y adolescencias</label>
<input class="form-control" id="expe_programas" name="expe_programas" type="checkbox" <?php echo si($vi["expe_programas"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Otras</label>
<input class="form-control" id="expe_otras" name="expe_otras" type="checkbox" <?php echo si($vi["expe_otras"]=="1"," checked","")?>>
</div>
<br>

<div class="form-group has-warning">
<label class="label-form">Descripci&oacute;n de los espacios de participaci&oacute;n</label>
<textarea class="form-control" cols="100" rows="3" name="part_detalle" onblur="valida_0('part_detalle')" id="part_detalle"><?php echo $vi["part_detalle"];?></textarea>
</div>
<br>

<h3>DURANTE LA VISITA SE REALIZARON</h3>
<div class="form-group has-warning">
<label class="label-form">Entrevistas a NNyA</label>
<input class="form-control" id="acti_entrevista" name="acti_entrevista" type="checkbox" <?php echo si($vi["acti_entrevista"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Observaci&oacute;n de din&aacute;micas convivenciales</label>
<input class="form-control" id="acti_obs_dinamicas" name="acti_obs_dinamicas" type="checkbox" <?php echo si($vi["acti_obs_dinamicas"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Talleres con NNYA</label>
<input class="form-control" id="acti_tallers" name="acti_talleres" type="checkbox" <?php echo si($vi["acti_talleres"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Propuestas l&uacute;dicas</label>
<input class="form-control" id="acti_ludicas" name="acti_ludicas" type="checkbox" <?php echo si($vi["acti_ludicas"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Participaci&oacute;n en Actividades</label>
<input class="form-control" id="acti_participacion" name="acti_participacion" type="checkbox" <?php echo si($vi["acti_actividades"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Otros</label>
<input class="form-control" id="acti_otros" name="acti_otros" type="checkbox" <?php echo si($vi["acti_otros"]=="1"," checked","")?>>
</div>
<br>
<div class="form-group has-warning">
<label class="label-form">Descripci&oacute;n de las actividades realizadas</label>
<textarea class="form-control" cols="100" rows="3" name="acti_detalle" onblur="valida_0('acti_detalle')" id="acti_detalle"><?php echo $vi["acti_detalle"];?></textarea>
</div>
<br>

<input type='hidden' name='id' id='ide' value='<?php echo $id;?>'>
<input type='hidden' name='reg' value='<?php echo $conta-1;?>'>
<input class="form-control btn-primary" type='Submit' name='enviar' value='Enviar Datos'>
</form>

<script  type="text/javascript">

seleccionar("hogar","<?php echo $hoga;?>");

</script>

<script type="text/javascript">


function valida_campos() {
valida_fecha("fecha");
valida_0("super");
valida_entero("chicos");
valida_0("obse");
var hoga=document.getElementById("hogar").value;
var fech=document.getElementById("fecha").value;
var supe=document.getElementById("super").value;
var obs=document.getElementById("obse").value;
var chi=document.getElementById("chicos").value;
if(hoga=="") {alert("Complete Hogar");return false;};
if(fech==""||supe==""||obs=="") {alert("Complete los Campos Fecha, Supervisores y Observación Institucional");return false;};
if(chi==""||chi=="NaN") {alert("Complete Cantidad de niñ@s alojad@s");return false;};
return true;
}
function grabannya(id){
 texto=document.getElementById(id).value;
 idx="<?php echo $id?>";
 ejec_sq("supervisita_nnya?id="+idx+"&legajo="+id+"&texto="+texto);
}
function valida(campo) {
return true;
}

function foca_usado(leg){
document.getElementById("usado").value=document.getElementById(leg).value.length;
}
</script>
<h3>Aspectos destacables por NNYA</h3>
<div class='table-responsive'><table class='table'>
<form class="form" method="get" onsubmit="return false" action="">
<tr class="bg-primary"><th>Apellido y Nombre</th><th>Edad</th><th>Observaciones</th></tr>
<?php
if($id>0){
$d=un_registro("select idsuper_visita as id from super_visita where super_hogar=".$hoga." and super_fecha=".fsql($fecha));
$conn=registros("select sujetos.legajo as lega, super_obse as obse, apellidos, nombres, edadcalc(f_nacimiento,sujetosEdad,SujetosMeses,SujetosActedad,".fsql($fecha).") as edad from hogares_admision inner join sujetos on admi_legajo=sujetos.legajo left join super_visita_legajo on super_legajo=sujetos.legajo and super_visita=".$id.
 " where admi_hogar=".$hoga." and admi_alta<=".fsql($fecha)." and (admi_baja is null or datediff(".fsql($fecha).",admi_baja) < 10) order by apellidos, nombres");
$conta=1;
while ($chi = mysqli_fetch_assoc($conn)) {
 $conta=$conta+1;
 if($conta % 2==0) {echo "<tr bgcolor='white'>";} else {echo "<tr bgcolor='#E6E6E6'>";};
 $idl=(string)($chi["lega"]);
 echo "<td>".$chi['apellidos'].", ".$chi['nombres']."</td><td>".$chi['edad']."</td><td>";
 echo "<textarea cols='100' rows='3' id='".$idl."' maxlength='2048' onblur='grabannya(this.id)'>".$chi['obse']."</textarea></td></tr>";
};
echo "</table></div>";
echo "<input type='hidden' name='id' value='".$id."'>
<button class='btn-primary' type='submit'>Guardar Aspectos por NNYA</button>
</form>";
};
?>



<h2>Archivos Vinculados</h2>

<table>

<td>Tipo</td><td>Descripci&oacute;n</td><td>Efector - Usuario</td><td>Fecha Subida</td><td>Acciones</td>

<?php 

 

  $sql="select deno,restringido,as_descripcion, concat(denominacion,'-',as_usuario) as efector, as_fecha as fecha, as_path, as_dispositivo, as_usuario, idarchivos_subidos as id 

  from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos left join sectores on sectores.id=as_dispositivo 

  left join tablas on tablas.tipo='TA' and tablas.valo=as_tipo   where archivos_vinculos.tipo='V' and identificador=".$id." and as_baja is null order by as_fecha desc";

  $conn = registros($sql);

   while ($da = mysqli_fetch_assoc($conn)) {

    if($da["restringido"]==0||$_SESSION["usuario"]=="1") {

     echo colorfila()."<td>".$da['deno']."</td><td>".$da['as_descripcion']."</td><td>".$da['efector']."</td><td>".ffec($da['fecha'])."</td><td><a href='descarga?link=".sacamas($da['as_path'])."&nombre=".sacamas_limpia(sacapath($da['as_path']))."'>Descargar</a>";

     if($da['as_dispositivo']==$_SESSION['gldispo']&&$da['as_usuario']==$_SESSION['glusua']) echo "<a href='archdesvincular?id=".$da['id']."&tipo=V&identificador=".$id."'> Desvincular</a>";

     echo "</td></tr>";

    };

   };

 

?>

</table>

<?php if($id>0){

echo '<form action="uploadarch" method="post" enctype="multipart/form-data" onsubmit="return valida_arch()">';

echo '<fieldset class="C300">';

echo '<legend>Subida de Archivo</legend>';

echo '<label>Seleccione Archivo a Subir:</label><input name="archivo" type="file" size="35" />';

echo '<label>Breve descripci&oacute;n del Contenido del Archivo:</label><input name="descripcion" type="text" size="45" maxlength="45" id="descr"/>';

echo '<input class="btn-primary" name="enviar" type="submit" value="Subir Archivo" />';

echo '<input name="tipoarchivo" type="hidden" value="74" />';

echo '<input type="hidden" name="visita" value="'.$id.'">';

echo '<input name="action" type="hidden" value="upload" />';

echo '</fieldset>';

echo '</form>';};?>

</div>



</body>

</html>