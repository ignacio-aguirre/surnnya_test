<?php 
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Cupos diarios por efector";
include("encabezado.php");
?>
</div>
<br><br>
<div class="container">
	<div class="table-responsive pre-scrollable">
		<table class="table">
			<tr><th class='col-md-11'>Dispositivo</th><th class="col-md-1">Cupo</th></tr>
			<?php $reg=registros("select nombre, cupo_diario,dispositivos.id as iddispo from dispositivos left join movil_cupos on dispositivos.id=dispositivo where direccion_operativa in(1,2) and baja is null and bandeja>0 order by direccion_operativa,ong,nombre");
				while($r=mysqli_fetch_assoc($reg)){
					echo "<tr><td>".$r["nombre"]."</td><td><input class='form-control cupo' id='c".$r["iddispo"]."' size='4' value='".$r["cupo_diario"]."'></td></tr>";
					if(un_campo("select id from movil_cupos where dispositivo=".$r["iddispo"])==""){
						inserte("insert into movil_cupos(dispositivo) values(".$r["iddispo"].")");
					}
				}
			?>
				
		</table>
	</div>
	<button class="btn-success" onclick="actualizar()">Guardar</button>
</div>
<script>
	function actualizar(){
		const colcup=document.getElementsByClassName("cupo");
    	for(i=0;i<colcup.length;i++){
    		id=colcup[i].id;
    		dispo=id.substr(1,100);
    		cupo=colcup[i].value;
    		eje("val_act_cupo?dispo="+dispo+"&cupo="+cupo);
		}
			navega("menu_tbl");
	}

</script>
