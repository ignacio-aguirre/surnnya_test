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
?>
</div>
<br><br>
<div class="container">
<h6 class="col-md-11">Proceso Activo - Fecha <?php echo $_SESSION['hoy_v']." ".$labo?></h6>
<h6 class="col-md-11">Fechas de viajes  a procesar <?php echo ffec($desdev)."->".ffec($hasta)?></h6>


<ul class="list-group-item">Opciones disponibles
<?php if($proc["b2_6"]==0){?>
		<li class="list-item" onclick="navega('mv_ante_programar')"> Agregar viaje a bandeja de trabajo</li>	  		
<?php } else{?>
		<li class="list-item" onclick="navega('')"> Editar viaje ya informado</li>	  		
<?php }?>
  		

</ul>
</div>