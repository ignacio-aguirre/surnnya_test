<?php
session_start();
include("Funciones.php");
$provincia=nget("provincia");
echo "<option value='0'></option>";
$par=registros("select distinct grupo from localidades where provincia=".$provincia." order by grupo");
while($pa=mysqli_fetch_assoc($par)){
  echo "<option value='".$pa["grupo"]."'>".$pa["grupo"]."</option>";
};
exit
?>