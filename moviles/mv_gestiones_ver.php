<?php
require("funciones.php"); 
session_start();
$_SESSION["prestacion"]="Gestiones de m&oacute;viles";
include("encabezado.php");
$dispositivo=$_SESSION["hogar"];
$d=un_registro("select * from dispositivos where id=".$dispositivo);
ejecute("update movil_gestiones left join movil_viajes on viaje=movil_viajes.id set movil_gestiones.estado='VEN' where 
   movil_gestiones.estado='SOL' and 
   (movil_viajes.fecha<curdate() or (movil_viajes.fecha=curdate() and movil_viajes.hora<curtime()))");
$ges=registros("select movil_gestiones.*,  movil_viajes.fecha, movil_viajes.hora, movil_viajes.destino_1,movil_viajes.destino_2,movil_viajes.destino_3,movil_viajes.destino_4, movil_viajes.partida 
   from movil_gestiones 
   left join movil_viajes on viaje=movil_viajes.id 
   where movil_gestiones.dispositivo=".$dispositivo."  order by fechahora desc");

function destages($e){
   $desc=$e;
   if($e=="0") $desc="No iniciada";
   if($e=="1") $desc="Documento enviado";
   if($e=="2") $desc="Finalizada";
   return $desc;
}
?>
</div>
<div class="container">
   <h4>Dispositivo: <strong><?php echo $d["nombre"]?></strong></h4>
<div class="row">
        <h4 class="col-md-6" >Gestiones</h4>
        <div class="col-md-6">
	</div>
</div>
	<div class="table-responsive pre-scrollable">
	<table class="table">
	<thead>
	 <tr class="bg-primary"><th>Id</th><th>Tipo y texto</th><th>Fecha <br> y hora partida</th><th>Destino</th><th>Pax alojados</th><th>Estado</th><th>Comentarios</th></tr>
        </thead>
        <tbody>
           <?php
	while($g=mysqli_fetch_assoc($ges)){
	       echo "<tr><td>".$g["id"]."</td><td>".$g["tipo_gestion"]."<br>".$g["texto"]."</td><td>".ffec($g["fecha"])."<br>".substr($g["hora"],0,5)."</td><td>";
          echo substr($g["destino_1"],0,20).
si(strlen($g["destino_1"])>20 || $g["destino_2"]!="","...","")."</td><td>";
          $pas=registros("select pas_nombre from movil_pasajeros where tipo_pasajero=1 and viaje=".$g["viaje"]);
          $px="";
          while($p=mysqli_fetch_assoc($pas)){
            $px=$px.$p["pas_nombre"]." ";
          };
          echo $px."</td><td>".destages($g["estado"])."</td><td>";
          
   echo "</td></tr>";
	}
	?>
        </tbody>
        </table>
        </div>
      <br><br>
				
</div>
<script>

</script>
</body>