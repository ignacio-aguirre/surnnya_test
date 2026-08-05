<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Informes Trimestrales del NNYA";
include("encabezado.php");
$lega= $_GET["legajo"];
$_SESSION["posicion"]="7";
include("mnu_superior.php");
?>
<div class="container">
<h3>Informes Trimestrales</h3>
<?php $reg=registros("select distinct trimestrales.id,trimestrales.anio,trimestrales.trimestre,dispositivos.nombre from trimestrales left join trim_firmas on trimestrales.id=trim_firmas.trimestral left join dispositivos on trimestrales.hogar=dispositivos.id where trim_firmas.id is not null and legajo_surnnya=".$lega." order by trimestrales.anio desc, trimestrales.trimestre desc");
	if(mysqli_num_rows($reg)>0){
?>
<div class="table-responsive">
<table class="table">
<tr class="bg-primary"><th>A&ntilde;o</th><th>Trimestre</th><th>Dispositivo</th><th></th></tr>
 <?php 
      
	while($r=mysqli_fetch_assoc($reg)){
         echo "<tr><td>".$r["anio"]."</td><td>".$r["trimestre"]."</td><td>".$r["nombre"]."</td><td><button class='btn-info' onclick='ver(".$r["id"].")'>Ver</button></td></tr>";
	};
?>
</table>
</div>
<?php }
else{echo "No hay informes trimestrales electr&oacute;nicos";};?>
</div>
<script>
function ver(id){
naveganuevo("../trimestrales/informe?id="+id);
}
</script>
</body>
</html>