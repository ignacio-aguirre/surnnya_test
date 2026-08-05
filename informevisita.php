<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Informe Visita";
include("encabezado-test.php");
registre();
$sql="select super_visita.*, dispositivos.*, hogares_ong.nombre as nong from super_visita left join dispositivos on dispositivos.id=super_hogar ";
$sql=$sql."left join hogares_ong on ong=hogares_ong.id ";
$sql=$sql."  where idsuper_visita=".$_GET["id"];
$r=un_registro($sql);
$hoga=$r['nombre'];
$razo=$r['nong'];
$fech=ffec($r['super_fecha']);
$domi=$r['domicilio'];
$tele=$r['Hogares_Telefonos'];
$pobl=$r['poblacion'];
$moda=$r['Hogares_Especialidad'];
$loca=$r['localidad'];
$obse=$r['super_obse'];
$nyal=$r['super_chicos'];
?>

<p align="center" style='font-family: Arial, Helvetica, sans-serif; font-size: 12pt;font-weight: bold;'><img src="imagenes/logoGCBA.gif"><br>Gobierno de la Ciudad Aut&oacute;noma de Buenos Aires<br>
Consejo de los Derechos de Ni&ntilde;as, Ni&ntilde;os y Adolescentes<br>
Direcci&oacute;n General de Servicios de Atenci&oacute;n Permanente<br>

<hr>
</p>

<?php



echo "<p align='center' ><table border='2'><td style='font-family: Arial, Helvetica, sans-serif; font-size: 12pt;font-weight: bold;'>Informe Institucional</td></table></p>";

$parrafo1="<strong>Dipositivo de Cuidado:</strong> ".$hoga."<br>".$razo."<br>";

$parrafo1=$parrafo1."<strong>FECHA:</strong> ".$fech."<br><strong>EQUIPO SUPERVISI&Oacute;N:</strong>".$r["super_super"]."<br><br>";

$parrafo1=$parrafo1."<strong>INFORMACI&Oacute;N GENERAL</strong> <br>";

$parrafo1=$parrafo1."DIRECCI&Oacute;N: ".$domi.", ".$loca."<br>";

$parrafo1=$parrafo1."TEL&Eacute;FONO: ".$tele."<br>";

$parrafo1=$parrafo1."POBLACI&Oacute;N: ".$pobl."<br>";

$parrafo1=$parrafo1."MODALIDAD: ".$moda."<br>";

$parrafo1=$parrafo1."CANTIDAD NNYA ALOJADOS: ".$nyal."<br>";



echo "<hr><p align='left' style='font-family: Arial, Helvetica, sans-serif; font-size: 10pt; line-height: 1.5;text-align:justify;text-justify:inter-word;'>".$parrafo1."</p>";

echo "<STRONG>COMPOSICI&Oacute;N DEL EQUIPO PROFESIONAL DEL DISPOSITIVO</strong><br><table>";

$ca=registros("select * from super_visita_cargos where super_visita=".$_GET["id"]);

$conta=1;

while ($car = mysqli_fetch_assoc($ca)) {

 $conta=$conta+1;

 echo "<tr><td>".$car['super_cargo'].":</td>";

 echo "<td>".$car['super_nombres']."</td>";

 echo "</tr>";

};

echo "</table><br>";

$parrafo2="<STRONG>ASPECTOS ORGANIZACIONALES</STRONG> ".$obse;

echo "<p align='left' style='font-family: Arial, Helvetica, sans-serif; font-size: 10pt; line-height: 1.5;text-align:justify;text-justify:inter-word;'>".$parrafo2."</p>";
if($r["inte_reuniones"]+$r["inte_talleres"]+$r["inte_mesas"]+$r["inte_capacitaciones"]+$r["inte_asambleas"]+$r["inte_otros"]+
$r["exte_capacitaciones"]+$r["exte_jornadas"]+$r["exte_supervision"]+$r["exte_otros"]>0){
  echo "<br><strong>ESPACIOS DE FORMACI&Oacute;N Y REFLEXI&Oacute;N DE LOS EQUIPOS</strong><br>";
  if($r["inte_reuniones"]+$r["inte_talleres"]+$r["inte_mesas"]+$r["inte_capacitaciones"]+$r["inte_asambleas"]+$r["inte_otros"]>0){
     echo "<strong>Internos</strong><br>";
     if($r["inte_reuniones"]=="1") echo "Reuniones de Equipo<br>";
     if($r["inte_talleres"]=="1") echo "Talleres<br>";
     if($r["inte_mesas"]=="1") echo "Mesas de Trabajo<br>";
     if($r["inte_capacitaciones"]=="1") echo "Capacitaciones<br>";
     if($r["inte_asambleas"]=="1") echo "Asambleas<br>";
     if($r["inte_otros"]=="1") echo "Otros<br>";

  };
  if($r["exte_capacitaciones"]+$r["exte_jornadas"]+$r["exte_supervision"]+$r["exte_otros"]>0){
     echo "<strong>Externos</strong><br>";
     if($r["exte_capacitaciones"]=="1") echo "Capacitaciones<br>";
     if($r["exte_jornadas"]=="1") echo "Jornadas / Conferencias / Congresos<br>";
     if($r["exte_supervision"]=="1") echo "Supervisiones T&eacute;cnicas Externas<br>";
     if($r["exte_otros"]=="1") echo "Otros<br>";
  };
};
if($r["fore_detalle"]!="")  {
echo "<strong>Detalle espacios de formaci&oacute;n y reflexi&oacute;n</strong><br>";echo $r["fore_detalle"]."<br>";};
  
if($r["espa_consejos"]+$r["espa_proyectos"]+$r["espa_escucha"]+$r["espa_otros"]+$r["part_deportivas"]+$r["part_recreativas"]+$r["part_culturales"]+$r["part_barriales"]+
  $r["part_otras"]+$r["expe_talleres"]+$r["expe_salidas"]+$r["expe_programas"]+$r["expe_otras"]>0) {
	echo "<br><strong>ESPACIOS DE PARTICIPACI&Oacute;N DE NNYA</strong><br>";
  if($r["espa_consejos"]+$r["espa_proyectos"]+$r["espa_escucha"]+$r["espa_otros"]>0){
     echo "<strong>Participaci&oacute;n en el ejercicio de la ciudadan&iacute;a.</strong><br>";
     if($r["espa_consejos"]=="1") echo "Consejos<br>";
     if($r["espa_proyectos"]=="1") echo "Proyectos<br>";
     if($r["espa_escucha"]=="1") echo "Espacios de Escucha<br>";
     if($r["espa_otros"]=="1") echo "Otros<br>";
  };
  if($r["part_deportivas"]+$r["part_recreativas"]+$r["part_culturales"]+$r["part_barriales"]+
  $r["part_otras"]>0){
    echo "<strong>Participaci&oacute;n comunitaria.</strong><br>";
    if($r["part_deportivas"]=="1") echo "Actividades Deportivas<br>";
    if($r["part_recreativas"]=="1") echo "Actividades Recreativas<br>";
    if($r["part_culturales"]=="1") echo "Actividades Culturales<br>";
    if($r["part_barriales"]=="1") echo "Actividades Barriales<br>";
    if($r["part_otras"]=="1") echo "Otras Actividades<br>";
  };
  if($r["expe_talleres"]+$r["expe_salidas"]+$r["expe_programas"]+$r["expe_otras"]>0){
   echo "<strong>Experiencias de participaci&oacute;n.</strong><br>";
   if($r["expe_talleres"]=="1") echo "Talleres<br>";
   if($r["expe_salidas"]=="1") echo "Salidas recreativas o campamentos o viajes<br>";
   if($r["expe_programas"]=="1") echo "Dispositivos y/o programas destinados a las ni&ntilde;eces y adolescencias<br>";
   if($r["expe_otras"]=="1") echo "Otras<br>";
  };
};
if($r["part_detalle"]!="") {
echo "<strong>Detalle espacios de participaci&oacute;n</strong><br>";echo $r["part_detalle"]."<br>";};

echo "<br><strong>DURANTE LA VISITA SE REALIZARON</strong><br>";
if($r["acti_entrevista"]=="1") echo "Entrevistas a NNYA<br>";
if($r["acti_obs_dinamicas"]=="1") echo "Observaci&oacute;n de din&aacute;micas convivenciales<br>";
if($r["acti_talleres"]=="1") echo "Talleres con NNYA<br>";
if($r["acti_ludicas"]=="1") echo "Propuestas l&uacute;dicas<br>";
if($r["acti_participacion"]=="1") echo "Participaci&oacute;n en actividades<br>";
if($r["acti_otros"]=="1") echo "Otros<br>";
if($r["acti_detalle"]!="") echo $r["acti_detalle"]."<br>";

echo "<br><STRONG>Aspectos destacables por NNYA:</STRONG> ";
echo "<table>";

$le=registros("select *,edadcalc(f_nacimiento,sujetosedad,null,sujetosactedad,curdate()) as edadhoy from super_visita_legajo left join sujetos on super_legajo=sujetos.legajo where super_visita=".$_GET["id"]);

$conta=1;

while ($chicos = mysqli_fetch_assoc($le)) {

 $conta=$conta+1;

 if($conta % 2==0) {echo "<tr bgcolor='white'>";} else {echo "<tr bgcolor='#E6E6E6'>";};

 echo "<td>".$chicos['Apellidos'].", ".$chicos['Nombres'].":</td>";

 echo "<td>".$chicos['edadhoy']." a&ntilde;os</td>";

 echo "<td>".$chicos['super_obse']."</td>";

 echo "</tr>";

};

echo "</table>";
?>

</body>

</html>