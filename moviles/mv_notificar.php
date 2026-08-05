<?php 
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Enviar notificaciones pendientes";
include("encabezado.php");
$reg=registros("select case when dispositivo>0 then dispositivos.nombre else sectores.denominacion end as solicitante,movil_notificaciones.id,texto,numero from movil_notificaciones 
	left join dispositivos on dispositivo=dispositivos.id
	left join sectores on sector=sectores.id
	where movil_notificaciones.fecha>=curdate() and usuario=".$_SESSION["usuario"]." and leida=0");

?>
</div>
<br><br>
<div class="container">

<div class="table-responsive col-md-11">

	<table class="table col-md-10">
		<h5>Para enviar, hacer click en el rengl&oacute;n</h5>
		<tr><th class="col-md-3">Solicitante</th><th class="col-md-3">N&uacute;mero</th><th class="col-md-3">Texto</th><th>Id</th></tr>
		<?php
		    $idn=0;
			while($r=mysqli_fetch_assoc($reg)){
				$idn++;
				echo "<tr onclick='noti(".$idn.")'><td>".$r["solicitante"]."</td>
				<td id='n".$idn."'>".$r["numero"]."</td>
				<td id='t".$idn."'>".$r["texto"]."</td>
				<td id='i".$idn."'>".$r["id"]."</td>
				</tr>";
			}
			?>	
    </table>
</div>    
<script>
	function noti(id){
		numero=document.getElementById("n"+id).innerHTML;
		texto=document.getElementById("t"+id).innerHTML;
		id_noti=document.getElementById("i"+id).innerHTML;
		if(id_noti!="notificada"){
		resp=eje("mv_not_marcar?id="+id_noti);
		document.getElementById("i"+id).innerHTML=resp;
		naveganuevo("https://wa.me?phone="+numero+"&text="+texto);
		}
		return true; 
	}

</script>