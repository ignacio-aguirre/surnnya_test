<?php 
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Men&uacute; administrador viajes DGSAP";
include("encabezado.php");

$bandeja=$_SESSION["bandeja"];
$proc=un_registro("select * from movil_procesos where id=".$_SESSION['idproceso']);
$desde=fsql(ffec($proc["desde_ab"]));
$hasta=$proc["hasta"];
$desdev=$proc["desde_ab"];
$hastas=fsql(ffec($hasta));
if($proc["b1_".$bandeja]=="1"){$desdep=ffec($proc["desde_db"]);}
else{$desdep=ffec($desdev);};
$labo=$proc["proceso"];
ejecute("update movil_gestiones left join movil_viajes on viaje=movil_viajes.id set movil_gestiones.estado='VEN' where 
	movil_gestiones.estado='SOL' and 
	(movil_viajes.fecha<curdate() or (movil_viajes.fecha=curdate() and movil_viajes.hora<curtime()))");
?>

<div class="container">
<div class="row">	
<h8 class="col-md-12">Fecha proceso <strong> <?php echo $_SESSION['hoy_v']." ".$labo?></strong>
&nbsp;&nbsp;Fechas viajes <strong><?php echo ffec($desdev)."->".ffec($hasta)?>
	
</strong>
&nbsp;&nbsp;Bloqueo <strong>1 
<?php if($proc["b1_6"]=="1"){echo "Hecho";} 	else{echo "No hecho";};?>
</strong>&nbsp;&nbsp;Bloqueo  <strong>2 
<?php if($proc["b2_6"]=="1"){echo "Hecho";} 	else{echo "No hecho";};?>
</strong></h8>
</div>
<br>

<div class="table-responsive col-md-9">
			<h7> Viajes en bandejas</h7>	
	<table class="table col-md-6 table-condensed">
		<tr><th class="col-md-3">Bandeja</th><th class="col-md-3">Cantidad</th><th class="col-md-3">Acci&oacute;n</th></tr>
		<?php
			$cntb1=0;
			$cntb6=0;
			$viajes=registros("select bandeja, nombre, count(*) as cant from movil_viajes  left join movil_bandejas on bandeja=movil_bandejas.id where 
				(bandeja in (1,6) and fecha between ".	$desde." and ".$hastas.")
				or ( bandeja=7 and f_solicitud=".fsql(ffec($proc["fecha_hoy"])).")
				or (bandeja=80 and estado='PRO' and (select estado from movil_gestiones where movil_gestiones.viaje=movil_viajes.id)='SOL') group by bandeja,nombre");
			while($v=mysqli_fetch_assoc($viajes)){
				echo "<tr class='col-md-3'><td>".$v["nombre"]."</td><td>".$v["cant"]."</td><td>";
				if($v["bandeja"]=="1"){echo "<button onclick='vv()' class='btn-sm	btn-primary'>Viajes</button>";}
				if($v["bandeja"]=="6"){echo "<button onclick='mvrp()' class='btn-sm	btn-info'>Revisar</button>";};
				if($v["bandeja"]=="7"){echo "<button onclick='excel()' class='btn-sm	btn-success'>Excel</button>";};
				
				if($v["bandeja"]=="80"){echo "<button onclick='gest()' class='btn-sm	btn-danger'>Gestiones</button>";};
				echo "</td></tr>";
				if($v["bandeja"]=="1"){$cntb1=$cntb1+intval($v["cant"]);}
				if($v["bandeja"]=="6"){$cntb6=$cntb6+intval($v["cant"]);}
			};
          		
			?>	
    </table>
 </div>
 

    		
<ul class="list-group-item">

	
<?php 
  	if($proc["b1_6"]==0){
  		echo '<li class="list-item" style="margin-top:2px margin-bottom:2px;" onclick="mvb1()">Bloqueo 1</li>';
  	};
  	if($proc["b1_6"]=="1" && $proc["b2_6"]==0){
  		echo '<li class="list-item text-danger"  style="margin-top:2px margin-bottom:2px;" onclick="reabrir()">Revertir Bloqueo 1</li>';
  	};	
	
 if($proc["b1_6"]>"0" && $proc["b2_6"]=="0"){
       echo '<li class="list-item"  style="margin-top:2px margin-bottom:2px; "onclick="mvb2()">Bloqueo 2</li>';
       
  };

  if($proc["b2_6"]>"0"){
     echo '<li class="list-item">Bloqueo 2 Realizado</li>';
	  echo '<li class="list_item" style="margin-top:2px margin-bottom:2px;" onclick="navega('."'mv_viajes_bloq_adm'".')"> Viajes Bloqueados </li>';
  }
  ?>
<li class="list-item"  style="margin-top:2px margin-bottom:2px;" onclick="navega('mv_gen_exc_fecha')"> Reimprimir Documento s/fecha proceso</li>
<li class="list-item" style="margin-top:2px margin-bottom:2px;" onclick="navega('mv_v_empresa')"> Imprimir Documentos por empresa</li>


<li class="list-item" style="margin-top:2px margin-bottom:2px;" onclick="navega('mv_est_exc_dispo')"> Viajes por solicitante entre fechas</li>
<li class="list-item" style="margin-top:2px margin-bottom:2px;" onclick="navega('menu_tbl')">Men&uacute; tablas</li>
<!--li class="list-item" onclick="navega('menu_conciliar')">Men&uacute Conciliaci&oacute;n</li-->
<li class="list-item" style="margin-top:2px margin-bottom:2px;" onclick="navega('mv_ante_programar')">Programar viaje</li>

</ul>
<script>
	function vv(){
		navega("mv_viajes_ver");
	}
	function mvrp(){
		navega("mv_revision_propia");
	}
	function gest(){
		navega("mv_gestiones");
	}
	function mvb1(){
		navega("mv_bloqueo1");
	}
	function mvb2(){
		navega("mv_bloqueo2");
	}
	function reabrir()
	{
		navega("mv_bloqueo1_reabrir");
	}
	function excel()
	{
		navega("mv_viajes_proceso");
	}

	

	
</script>