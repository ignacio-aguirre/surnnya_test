<?php 
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Men&uacute;";
include("encabezado.php");
$bandeja=$_SESSION["bandeja"];
$proc=un_registro("select *, b1_6 as bl from movil_procesos where id=".$_SESSION['idproceso']);
$desdes=fsql(ffec($proc["desde_ab"]));
$hastas=fsql(ffec($proc["hasta"]));
$desde=ffec($proc["desde_ab"]);
$hasta=sqlf($hastas);
$labo=$proc["proceso"];

if($proc["bl"]==1 && $_SESSION['perfil_moviles']=="1"){$desdep=ffec($proc["desde_db"]);}
else{$desdep=$desde;}

if($_SESSION["hogar"]>"0"){
	$dispositivo=$_SESSION["hogar"];
	$_SESSION["sector"]="0";}
else{
	$dispositivo=$_SESSION["sector"];
	$_SESSION["hogar"]="0";
};
$via=registros("select id,hora,partida from movil_viajes where fecha=curdate() and estado='APR' and bandeja>5 and case when dispositivo>0 then dispositivo else sector end =".$dispositivo." order by hora");
$via_pro=registros("select estado, count(*) as cantidad from movil_viajes where fecha between ".$desdes." and ".$hastas." and case when dispositivo>0 then dispositivo else sector end =".$dispositivo." group by estado");
?>	
<br><br>
<div class="row">
	<h5 class="col-md-12">Programar,editar,eliminar desde el <?php echo $desdep?></h5>
</div>
<div class="table-responsive col-md-6">
	<?php
	if($labo=="Laborable"){
		echo "<h5>Viajes en proceso diario ". $desde." -> ".$hasta."</h5>";	
		echo "<table class='table col-md-6'>
	<tr><th>Estado</th><th>Cantidad</th></tr>";
	while($vp=mysqli_fetch_assoc($via_pro)){
			echo "<tr><td>".$vp["estado"]."</td><td>".$vp["cantidad"]."</td></tr>";
		}
	echo "</table></div>";}
	else{ echo "</div><div class='row'><h5 class='col-md-12'>".$_SESSION["hoy_v"]." ".$labo." GCABA</h5></div><br><br>";}
	?>

<div class="table-responsive col-md-6">
<h4>Opciones disponibles</h4>
<table class="table col-md-6">
<tr class="info" onclick=location.href="mv_vdispo_ver"><td align="center">Ver viajes entre fechas</td></tr>
<tr class="info" onclick=location.href="mv_programar"><td align="center">Programar viajes</td></tr>
<tr class='info' onclick=location.href='menu_gestiones'><td align='center'>Gestiones</td></tr>
<tr class="warning" onclick=location.href="mv_adultos"><td align="center">Tabla de adultos</td></tr>
<tr class="warning" onclick=location.href="mv_domicilios"><td align="center">Tabla de domicilios</td></tr>
<?php 
  	if($_SESSION["hogar"]>"0"){
  		$ong=un_campo("select ong from dispositivos where id=".$_SESSION["hogar"]);
  		if($ong>"0"){
  			$cntdispo=un_campo("select count(*) from dispositivos where baja is null and direccion_operativa in(1,2) and ong=".$ong);
  			if($cntdispo>"1"){?>
  				<tr class="text-danger" onclick=location.href="mv_cambiar_dispositivo"><td align="center">Cambiar a otro dispositivo</td></tr>
  			<?php }
  		}
	}
?>



</table>
</div>

<br><br>
<div class="row">
	
	<div class="table-responsive col-md-6">
		<h4>Viajes de hoy</h4>		
		<table class="table">
			<thead>
				<tr class="bg-success" style="font-size: .9em;"><th>Hora</th><th>Pasajero(s)</th><th>Partida</th></tr>
			</thead>
			<tbody>
			<?php
			
				while($v=mysqli_fetch_assoc($via)){
					echo "<tr style='font-size:.9em'><td>".substr($v["hora"],0,5)."</td><td>";
					$pasalo=registros("select  pas_nombre from movil_pasajeros where tipo_pasajero=1 and viaje=".$v["id"]);
					$pax="";
					while($p=mysqli_fetch_assoc($pasalo)){
						$pax=si($pax=="","",$pax . "/").$p["pas_nombre"];
					}
					echo $pax."</td><td>".$v["partida"]."</td></tr>";
					

				}
			?>
			</tbody>
		</table>	
	</div>	
</div>
</div>

</div>
</body>