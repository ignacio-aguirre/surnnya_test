<?php 
include("Funciones.php");
session_start();
$tipo=$_GET["tipo"]; 
if(isset($_GET["cdgo"])) $cdgo=$_GET["cdgo"];
if(isset($_GET["lega"])) $lega=$_GET["lega"];
if(isset($_GET["hoga"])) $hoga=$_GET["hoga"];
if(isset($_GET["anio"])) $anio=$_GET["anio"];
if(isset($_GET["trim"])) $trim=$_GET["trim"];

/* referente (personas)  */
if($tipo=="RF") $sql="select apellidos, nombres, ocupacion from personas where idpersonas=".$cdgo;
/* legajo */
if($tipo=="LG") $sql="select concat(apellidos,', ',nombres) from sujetos where legajo=".$cdgo;
/* informe trimestral */
if($tipo=="EXIN") $sql="select idinformes from informes where legajo=".nulea($lega)." and hogar=".nulea($hoga)." and anio=".nulea($anio)." and trimestre=".nulea($trim);
$desc=un_registro_array($sql);
echo "<?xml version='1.0' encoding='ISO-8859-1' ?>";
echo "<descripcion>";
for ($i = 0; isset($desc[$i]); $i++) {echo "<campo".$i.">";
                                 echo $desc[$i];
                                 echo " </campo".$i.">";}
echo "</descripcion>";
?>
