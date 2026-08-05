<?php 
include("funciones.php");
session_start();
$ids=$_GET["ids"];
if($_SESSION["usuario"]>0){
 if(un_campo("select firma from usuarios_hogares where baja is null and id=".$_SESSION["usuario"])!="1"){
 die("Usuario no habilitado para firmar");};
};
$v=explode("f",$ids);
for($i=1;$i<count($v);$i++){
  if($_SESSION["usuario"]==0){
   $trimestral=$v[$i];
   $tri=un_registro("select * from trimestrales where id=".$trimestral);
   $nnya=$tri["legajo"];
   $trimestre=$tri["trimestre"];
   $anio=$tri["anio"];
   $hogar=$tri["hogar"];
   inserte("insert into trim_firmas(anio,trimestre,hogar,legajo,usuario,fecha,trimestral) values(".$anio.",".$trimestre.",".$hogar.",".$nnya.",0,curdate(),".$trimestral.")");
  };
  //  si es usuario es mayor que cero
  if($_SESSION["usuario"]>0){
    $trimestral=$v[$i];
    $tri=un_registro("select * from trimestrales where id=".$trimestral);
    $nnya=$tri["legajo"];
    $trimestre=$tri["trimestre"];
    $anio=$tri["anio"];
    $hogar=$tri["hogar"];
    $ida=un_campo("select id from trim_identidad where trimestral=".$trimestral);
    if(!$ida>0){muere("Identidad",$trimestral);};
    $ida=un_campo("select id from trim_juridicos where trimestral=".$trimestral);
    if(!$ida>0){muere("Sit.Adm/Legal",$trimestral);};
    $ida=un_campo("select id from trim_ingreso where trimestral=".$trimestral);
    if(!$ida>0){muere("Sit. al Ingreso",$trimestral);};
    $ida=un_campo("select id from trim_convivencial where trimestral=".$trimestral);
    if(!$ida>0){muere("Sit. Convivencial",$trimestral);};
    $ida=un_campo("select id from trim_salud_fisica where trimestral=".$trimestral);
    if(!$ida>0){muere("Salud F&iacute;sica",$trimestral);};
    $ida=un_campo("select id from trim_salud_mental where trimestral=".$trimestral);
    if(!$ida>0){muere("Salud Mental",$trimestral);};
    $ida=un_campo("select id from trim_educacion where trimestral=".$trimestral);
    if(!$ida>0){muere("Escolaridad",$trimestral);};
   $ida=un_campo("select id from trim_vinculaciones where trimestral=".$trimestral);
   if(!$ida>0){muere("Vinculaciones",$trimestral);};
   $ida=un_campo("select id from trim_egreso where trimestral=".$trimestral);
   if(!$ida>0){muere("Egreso",$trimestral);};
   $ida=un_campo("select id from trim_estrategias where trimestral=".$trimestral);
   if(!$ida>0){muere("Estrategias",$trimestral);};
   $ida=un_campo("select id from trim_profesional where trimestral=".$trimestral);
   inserte("insert into trim_firmas(anio,trimestre,hogar,legajo,usuario,fecha,trimestral) values(".$anio.",".$trimestre.",".$hogar.",".$nnya.",".$_SESSION["usuario"].",curdate(),".$trimestral.")");

};
};
Redirect("informes");

function muere($conjunto,$trimestral){
    $tri=un_registro("select * from trimestrales where id=".$trimestral);
    $nnya=$tri["legajo"];
    die("Sin datos cargados para el conjunto ".$conjunto." en trimestral de ".un_campo("select concat(apellidos,', ',nombres) from alojados where idsurnnya=".$nnya));
}
?>
