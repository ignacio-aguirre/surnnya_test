<?php
include('func.php');
session_start();
$arti=nget('arti');
$reg=registros("select id,ficha_estante from unidades where articulo=".$arti." and f_egreso is null order by f_ingreso");
$opci="";
while($r=mysqli_fetch_assoc($reg)){
   $opci=$opci."<option value='".$r["id"]."'>".$r["ficha_estante"]."</option>";
};
echo $opci;
exit;
?>
