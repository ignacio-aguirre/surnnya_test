<?php
include("Funciones.php"); 
session_start();
include("encabezado.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
registre();
$perf_original=un_campo("select perfil from usuarios where id=".$_SESSION["glidusua"]);
?>
</div>
<div class="container">
<button class="btn-success" onclick="navega('cjoven_nomina_excel')">Excel</button>
<h4>Altas</h4>
<?php if($perf_original!="41"){?>
<button class="btn btn-warning" onclick="navega('consultasujetos?cj=1')">Nueva Alta</button>
<?php }?>
<div class="table-responsive">
<table class="table">
<tr class="bg-primary"><th>Apellido y Nombre</th><th>DNI</th><th>Fecha Nac.</th><th>Alta</th><th>Acciones</th></tr>
<?php

$reg=registros("select * from cjoven_nomina left join sujetos on cjoven_nomina.legajo=sujetos.legajo  where baja is null order by apellidos,nombres");
while($r=mysqli_fetch_assoc($reg)){
 echo "<tr><td>".$r["Apellidos"]." , ".$r["Nombres"]."</td><td>".$r["SujetosDNI"]."</td><td>".ffec($r["f_nacimiento"])."</td><td>".ffec($r["alta"])."</td><td>";
 if($perf_original!="41"){echo "<button class='btn btn-danger' onclick='baja(".$r["idcjoven_nomina"].")'>Baja</button>&nbsp;";};
echo "</td></tr>";
};
?>
</table>
</div>
<h4>Bajas</h4>
<div class="table-responsive">
<table class="table">
<tr class="bg-primary"><th>Apellido y Nombre</th><th>DNI</th><th>Fecha Nac.</th><th>Alta</th><th>Baja</th></tr>
<?php $reg=registros("select * from cjoven_nomina left join sujetos on cjoven_nomina.legajo=sujetos.legajo where baja is not null order by apellidos,nombres");
while($r=mysqli_fetch_assoc($reg)){
 echo "<tr><td>".$r["Apellidos"]." , ".$r["Nombres"]."</td><td>".$r["SujetosDNI"]."</td><td>".ffec($r["f_nacimiento"])."</td><td>".ffec($r["alta"])."</td><td>".ffec($r["baja"])."</td><td>";
echo "</td><td></td></tr>";
};
?>
</table>
</div>

<script>
function baja(id){
 navega("cjoven_baja?id="+id);
}
</script>

</div>
</body>
</html>