<?php
include("funciones.php"); 
session_start();
$tp=nget("tp");
$opc=registros("select * from movil_renglones where tipo=".$tp." order by id");
while($o=mysqli_fetch_assoc($opc)){
          echo "<option value='".$o["id"]."'>".$o["nombre_info"]."</option>";
      };
exit();
?>