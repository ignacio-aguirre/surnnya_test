<?php 
include("Funciones.php");
session_start();
$id=$_GET["id"];
$r=un_registro("select * from af_familias where idaf_familias=".$id);
$cantidad=un_campo("select count(*) from hogares_admision where admi_alta is not null and admi_baja is null and admi_hogar=".$r["hogar"]." and admi_fami=".$id);
$_SESSION["prestacion"]="Registrar cambio de estado familia ".$r["denominacion"];
include("encabezado-test.php");
?>
</div>
<div class="container">
	<?php echo "La familia ".si($cantidad=="0","no ","")." est&aacute; acogiendo actualmente";?>
	<div class="table-responsive">
		<table class="table-condensed">
			
			<tr class="bg-primary"><th>Tipo</th><th>Estado</th><th>Desde</th><th>Cambiar</th></tr>
			<tr><td>Estado 1</td><td><?php echo estado1($r["estado1"])?></td><td><?php echo ffec($r["fecha_estado1"])?></td><td>
				<?php if($r["estado1"]=="2"){
				echo "<img src='imagenes/Play.jpg' height='20' width='20' onclick='navega(".'"af_cambiaestado1?id='.$id.'")'."'>";
			}?>
			</td></tr>
			<?php if($r["estado1"]=="1"){?>
			<tr><td>Estado 2</td><td><?php echo estado2($r["tipo_prestacion"])?></td><td><?php echo ffec($r["fecha_estado2"])?></td><td>
				<?php
				echo "<img src='imagenes/Play.jpg' height='20' width='20' onclick='navega(".'"af_cambiaestado2?id='.$id.'")
				'."'>";
			?>
			</td></tr>
			<?php };?>
		</table>		
	</div>
	<button class="btn-primary" onclick="navega('consultafamilias?hogar=<?php echo $r["hogar"]?>&estado1=<?php echo $r["estado1"]?>')">Volver a Familias</button>
	<h4>Historial de cambios de Estado</h4>
	<div class="table-responsive">
		<table class="table-condensed">
			<tr class="bg-primary"><th>Usuario</th><th>Fecha y Hora</th><th>Estado1</th><th>Estado2</th><th>Fecha Estado</th></tr>
			<?php
			  $est=registros("select * from af_familias_estados where familia=".$id." order by fecha desc");
			  while($e=mysqli_fetch_assoc($est)){
			  	echo "<tr><td>".$e["usuario"]."</td><td>".$e["fecha_sistema"]."</td><td>";
			  	if($e["estado1"]!=""){echo estado1($e["estado1"])."</td><td>";}
			  	else{echo "</td><td>";};
			  	if($e["estado2"]!=""){echo estado2($e["estado2"])."</td><td>";}
			  	else{echo "</td><td>";};
			  	
			  	echo ffec($e["fecha"])."</td></tr>";
			  }
			?>
		</table>	
	</div>	
</div>
</body>
</html>