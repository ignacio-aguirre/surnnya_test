<?php
include("Funciones.php");
session_start();
include("encabezado.php");?>
</div>
<div class="container">
<button class="btn-success" onclick='navega("hogares_lista")'>Excel</button><br><br>
<div class="table-responsive">
<table class="table striped-table condensed-table">
<tr class="bg-primary" style='font-size:.9em'>
<th>Unidad T&eacute;cnica</th><th>Nombre</th><th>Modalidad</th><th>ONG</th><th>Domicilio</th><th>Tel&eacute;fono</th><th>Mail Not. Electr&oacute;nicas</th><th>Opciones</th></tr>
<?php
$sql="select dispositivos.* , hogares_ong.nombre as dong, hmod.deno as dmodalidad,utec.deno  as ut 
from dispositivos 
left join hogares_ong on ong=hogares_ong.id
left join tablas hmod on hmod.tipo='HOMOD' and modalidad=hmod.valo  
left join tablas utec on utec.tipo='SUPUT' and utec.valo=unidad_tecnica
 where dispositivos.baja_sistema is null and tipo_dispositivo in (1,2,11,12) and nomina_hogares=1 order by ut,nombre"; 
$conn = registros($sql);
$conta=1; 
while ($da = mysqli_fetch_assoc($conn)) {
   $conta=$conta+1;
   echo "<tr style='font-size:.9em'>";
   echo "<td>".$da['ut']."</td>";
   echo "<td>".$da['nombre']."</td>";
   echo "<td>".$da['dmodalidad']."</td>";
   echo "<td style='font-size:.7em'>".$da['dong']."</td>";
   echo "<td>".$da['domicilio']."-".$da['localidad']."</td>";
   echo "<td>".$da['telefonos']."</td>";
   echo "<td>".$da['Hogares_Mail']."</td><td>";
   if($_SESSION['gl_tablahogares']==1) {
     echo "<button class='btn-secondary btn-sm' onclick='consulta(".$da["id"].")'>Acciones</button>";
     echo "<button class='btn-warning btn-sm' onclick='ver(".$da["id"].")'>Ver</button>";
     echo "<button class='btn-primary btn-sm' onclick='edita(".$da["id"].")'>Editar</button>";
     echo "<button class='btn-info btn-sm' onclick='archivos(".$da["id"].")'>Documentaci&oacute;n</button>";

   };
   if($_SESSION['glperfil']=='DIPP'){
    echo "<button class='btn-warning btn-sm' onclick='ver(".$da["id"].")'>Ver</button>";
    echo "<button class='btn-info btn-sm' onclick='archivos(".$da["id"].")'>Documentaci&oacute;n</button>";
   };
   echo "</td></tr>";
  };
?>
</table>
</div>
</div>
<script>
function edita(id){
navega("un_hogar?id="+id);
}
function consulta(id){
navega("consultahogar?id="+id);
}
function ver(id){
naveganuevo("dispositivos_ver?id="+id);
}
function archivos(id){
navega("dispositivos_archivos?id="+id);
}

</script>
</body>
</html>
