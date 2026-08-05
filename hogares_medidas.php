<?php
include("Funciones.php");
session_start();
include("encabezado.php");
?>
</div>
<div class="container">
<div class="table-responsive">
<table class="table">

<th>Apellido y Nombre</th><th>DNI</th><th>Hogar</th><th>F.Ingreso</th><th>Vencimiento</th><th>Defensor&iacute;a Zonal</th><th>No Innovar</th>

<?php 

$sql="select apellidos, nombres, sujetosdni, nombre, sujetos_medidas.fecha, case when sujetos_medidas.fecha is null then null  else date_add(sujetos_medidas.fecha, interval dias DAY) end as ds,deno, no_innovar,admi_alta from hogares_admision 
  left join sujetos on admi_legajo=legajo
  left join sujetos_medidas on sujetos_medidas.legajo=sujetos.legajo and fecha=(select max(fecha) from sujetos_medidas where sujetos_medidas.legajo=sujetos.legajo)
  left join tablas on tipo='CM' and valo=defensoria_zonal left join dispositivos on admi_hogar=dispositivos.id
  where admi_alta is not null and admi_baja is null 
  order by apellidos, nombres, ds desc";

$reg=registros($sql);
while($r=mysqli_fetch_assoc($reg)){
echo colorfila()."<td>".$r["apellidos"]." , ".$r["nombres"]."</td><td>".$r["sujetosdni"]."</td><td>".$r["nombre"]."</td><td>".ffec($r["admi_alta"])."</td><td>".si($r["ds"]=="0","",ffec($r["ds"]))."</td><td>".$r["deno"]."</td><td>".si($r["no_innovar"]==1,"No Innovar","")."</td></tr>";
};
?>
<table>
</div>
</div>
</body>
</html>