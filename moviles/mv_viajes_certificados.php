<?php
session_start();
require("funciones.php"); 
$_SESSION["prestacion"]="Viajes certificados y no conciliados";
include("encabezado.php");
if($_SESSION["hogar"]>"0"){$dispo=$_SESSION["hogar"];
$tdispo="d";} else{$dispo=$_SESSION["sector"];$tdispo="s";}
if($tdispo=="d"){
    $via=registros("select * from movil_viajes where dispositivo=".$dispo." and bandeja=7 and estado='APR' and fecha<curdate() and cumplido<>0 and conciliado=0 order by fecha, hora");
}else{
    $via=registros("select * from movil_viajes where sector=".$dispo." and bandeja=7 and estado='APR' and fecha<curdate() and cumplido<>0 and conciliado=0 order by fecha, hora");
}
?>
</div>
<br>
<div class="container">
    <div class="table-responsive pre-scrollable">
        <table class="table">
            <thead>
                <tr><th>id</th><th>fecha y hora</th><th>destino</th><th>Realizado</th></tr>
            </thead>
            <?php
             while($v=mysqli_fetch_assoc($via)){
                echo "<tr><td>".$v["id"]."</td><td>".ffec($v["fecha"])." ".substr($v["hora"],0,5).
                "</td><td>".$v["destino_1"]."</td><td>".si($v["cumplido"]=="1","SI",$v["observaciones"])."</td></tr>";
             }?>
        </table>
    </div>    
  
</div>



</body>