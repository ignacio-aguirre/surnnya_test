<?php
session_start();
include("Funciones.php");
$tipo=$_GET["tipo"];
echo "<option value=''>Completar</option>";
if($tipo=="Provincias"){
  $prov=registros("select id,descripcion from provincias where baja is null order by descripcion");
  while($p=mysqli_fetch_assoc($prov)){
  	echo "<option value='".$p["descripcion"]."'>".$p["descripcion"]."</option>";
  };
};
if($tipo=="Partidos"){
  $part=registros("select nombre from partidos order by nombre");
  while($p=mysqli_fetch_assoc($part)){
    echo "<option value='".$p["nombre"]."'>".$p["nombre"]."</option>";
  };
};
if($tipo=="Localidades"){
$condicion=" true ";
if(isset($_GET["provincia"])) {$condicion=$condicion." and provincia=".tget("provincia");};
if(isset($_GET["partido"])) {$condicion=$condicion." and partido=".tget("partido");};
$loca=registros("select nombre,partido from localidades_nueva where ".$condicion." and nombre<>'' order by nombre");
   while($l=mysqli_fetch_assoc($loca)){
    echo "<option value='".$l["nombre"]."/".$l["partido"]."'>".$l["nombre"]."/".$l["partido"]."</option>";
  };


};
?>