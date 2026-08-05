<?php
require("funciones.php"); 
session_start();
$_SESSION["prestacion"]="Gestiones de m&oacute;viles";
include("encabezado.php");
ejecute("update movil_gestiones left join movil_viajes on viaje=movil_viajes.id set movil_gestiones.estado='VEN' where 
   movil_gestiones.estado='SOL' and 
   (movil_viajes.fecha<curdate() or (movil_viajes.fecha=curdate() and movil_viajes.hora<curtime()))");
$cond=" movil_gestiones.estado='SOL' and movil_viajes.bandeja in(6,7,80)";
$ges=registros("select movil_gestiones.*, case when movil_gestiones.dispositivo>0 then nombre else denominacion end as solicit, movil_viajes.fecha, movil_viajes.hora, movil_viajes.destino_1, movil_viajes.partida  
   from movil_gestiones left join dispositivos   on movil_gestiones.dispositivo=dispositivos.id
   left join sectores   on sector=sectores.id
   left join movil_viajes on viaje=movil_viajes.id where ".$cond." order by nombre,fechahora desc");

?>
</div>
<div class="container">
<div class="row">
        <h4 class="col-md-6" >Gestiones</h4>
        <div class="col-md-6">
	</div>
</div>
	<div class="table-responsive pre-scrollable">
	<table class="table">
	<thead>
	 <tr><th>Id</th><th>Solicitante</th><th>Usuario</th><th>Tipo y texto</th><th>Fecha <br> y hora partida</th><th>Estado</th><th>Acciones</th></tr>
        </thead>
        <tbody>
           <?php
	while($g=mysqli_fetch_assoc($ges)){
	       echo "<tr><td>".$g["id"]."</td><td>".$g["solicit"]."</td><td>".$g["usuario"]."</td><td>".$g["tipo_gestion"]."<br>".$g["texto"]."</td><td>".ffec($g["fecha"])."<br>".substr($g["hora"],0,5).
          "</td><td>".$g["estado"]."</td><td>";
          echo "<button class='btn-sm btn-info' onclick='ver(".$g["viaje"].")'>Viaje</button> "  ;
          if($g["estado"]=="SOL"){
            echo "<button class='btn-sm btn-success' onclick='";
            if($g["tipo_gestion"]=="Cancelar"){
               echo "apr_cancelar(".$g["id"].")'>Cancelar</button>&nbsp;";
            }
            if($g["tipo_gestion"]=="Agregar"||$g["tipo_gestion"]=="Agregar CMR"){
               echo "apr_agregar(".$g["id"].")'>Agregar</button>&nbsp;";
            }
            echo "<button class='btn-sm btn-danger' onclick='rec(".
            $g["id"].")'>Rechazar</button>&nbsp;";
            if($g["tipo_gestion"]=="Agregar"||$g["tipo_gestion"]=="Agregar CMR"){
            echo "<button class='btn-sm btn-info' onclick='editar(".
            $g["viaje"].")'>Editar </button>";};
            
          };
   echo "</td></tr>";
	}
	?>
        </tbody>
        </table>
        </div>
      <br><br>
				
</div>
<script>

function apr_agregar(id){
   if(confirm("Agregas viaje?")){
   navega("mv_viaje_agregar?idges="+id);
}
}
function apr_cancelar(id){
   navega("mv_viaje_cancelar_aut?idges="+id);
}

function editar(id){
   naveganuevo("mv_viaje_edit?id="+id)
}
function rec(id){
   navega("mv_gestion_rechazar?idges="+id);
}
function ver(id){
   navega("mv_viaje_ver?id="+id);
}
</script>
</body>