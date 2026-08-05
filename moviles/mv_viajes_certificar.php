<?php
session_start();
require("funciones.php"); 
$_SESSION["prestacion"]="Certificar viajes";
include("encabezado.php");
if($_SESSION["hogar"]>"0"){$dispo=$_SESSION["hogar"];
$tdispo="d";} else{$dispo=$_SESSION["sector"];$tdispo="s";}
if($tdispo=="d"){
    $via=registros("select * from movil_viajes where dispositivo=".$dispo." and bandeja=7 and estado='APR' and fecha<curdate() and cumplido=0 order by fecha, hora");
}else{
    $via=registros("select * from movil_viajes where sector=".$dispo." and bandeja=7 and estado='APR' and fecha<curdate() and cumplido=0 order by fecha, hora");
}
?>
</div>
<br>
<div class="container">
    <div class="table-responsive pre-scrollable">
        <table class="table">
            <thead>
                <tr><th>id</th><th>fecha y hora</th><th>destino</th><th>Certificar</th></tr>
            </thead>
            <?php
             while($v=mysqli_fetch_assoc($via)){
                echo "<tr><td>".$v["id"]."</td><td>".ffec($v["fecha"])." ".substr($v["hora"],0,5).
                "</td><td>".$v["destino_1"]."</td><td>".
                "<button class='btn-sm btn-primary' onclick='cert(".$v["id"].")'>Certificar</btn>".
                "</td></tr>";
             }?>
        </table>
    </div>    
  
</div>
<script>
    function cert(id){
        navega("mv_viaje_certificar?id="+id);
    }
</script>



</body>