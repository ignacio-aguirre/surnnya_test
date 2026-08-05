<?php
session_start();
include("Funciones.php");
$provincia=nget("provincia");
$grupo=tget("grupo");
echo "<option value='0'></option>";
$loc=registros("select idlocalidades,descripcion from localidades where provincia=".$provincia." and grupo=".$grupo." order by descripcion");
while($lo=mysqli_fetch_assoc($loc)){
  echo "<option value='".$lo["idlocalidades"]."'>".$lo["descripcion"]."</option>";
};
exit
?>