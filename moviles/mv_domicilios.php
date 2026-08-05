<?php
require("funciones.php"); 
session_start();
$_SESSION["prestacion"]="Domicilios del dispositivo/sector";
include("encabezado.php");
$dispositivo=$_SESSION["hogar"];
$ndispo=un_campo("select nombre from dispositivos where id=".nulea($dispositivo));
$tdispo="d";
if(!$dispositivo>"0"){
    $dispositivo=$_SESSION["sector"];
    $ndispo=un_campo("select denominacion from sectores where id=".nulea($dispositivo));
    $tdispo="s";
};

?>
</div>
<div class="container">
	<h4>Domicilios almacenados en <strong><?php echo $ndispo?></strong></h4>
	<button class="btn-sm btn-success" onclick="nuevo()">Nuevo</button>
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr class="bg-success" style="font-size: .85em;"><th>Id</th><th>Direcci&oacute;n</th><th>Localidad</th><th>Barrio</th><th>Comuna</th><th>Partido</th><th>Referencia</th><th>Opciones</th></tr>
			</thead>
			<tbody>
				<?php
					$dom=registros("select movil_domicilios.*, localidad,partido,barrio,comuna,normalizada from movil_domicilios 
						left join domicilios on iddomicilios=domicilios.id 
						
						where ".si($tdispo=="d","dispositivo","sector")."=".$dispositivo." order by domicilio");
					while($d=mysqli_fetch_assoc($dom)){
						
						echo "<tr style='font-size: .85em;'".si($d["normalizada"]=="0"," class='text-danger' ","")."><td>".$d["id"]."</td><td>".$d["domicilio"]."</td><td>".
						$d["localidad"]."</td><td>".$d["barrio"]."</td><td>".
						$d["comuna"]."</td><td>".$d["partido"]."</td><td><input id='".$d["id"]."' value='".
						$d["referencia"]."' onblur='referencia(this.id)'></td><td><button class='btn-sm btn-danger' onclick='baja(".$d["id"].")'>Baja</button></td></tr>";
					};
					
				?>
			</tbody>
		</table>
	</div>
	<hr>
	<button class="btn-md btn-success" onclick="navega('menu')">Men&uacute;</button>
	<script>
		function referencia(idobjeto){
			refe=document.getElementById(idobjeto).value;
			id=idobjeto;
			if(refe!=""){
				resp=eje("validadores/mv_domicilios_referencia?id="+id+"&refe="+refe);
				document.getElementById(idobjeto).value=resp;
			}
		}
		function nuevo(){
			navega("mv_domicilio_dispo_nuevo");
		}
		function baja(id){
			if(confirm("Confirmas la baja del domicilio?")){
			navega("mv_domicilio_dispo_baja?id="+id);};
		}
	</script>	
</div>	