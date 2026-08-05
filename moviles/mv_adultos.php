<?php
require("funciones.php"); 
session_start();
$_SESSION["prestacion"]="Adultos dispositivo ";
include("encabezado.php");
$dispositivo=$_SESSION["hogar"];
$ndispo=un_campo("select nombre from dispositivos where id=".nulea($dispositivo));
$tdispo="d";
if(!$dispositivo>"0"){
    $dispositivo=$_SESSION["sector"];
    $ndispo=un_campo("select denominacion from sectores where id=".nulea($dispositivo));
    $tdispo="s";
};

$adu=registros("select * from movil_adultos where ".si($tdispo=="d","dispositivo","sector")."=".$dispositivo." and baja is null order by apellido,nombre");
?>
</div>
<div class="container">
 <div class="row">
    <h4 class="col-md-12">Adultos <strong><?php echo $ndispo?></strong></h4>
 </div>
 <div class="row">
   <div class="col-md-6">
   <button class="btn-sm btn-success" onclick="nuevo()">Nuevo</button>
</div>
 </div>
	<div class="table-responsive pre-scrollable">
	<table class="table">
	<thead>
	 <tr class="bg-success" style="font-size:.8em"><th>Id</th><th>Apellido</th><th>Nombre</th><th>Celular</th><th>Opciones</th></tr>
        </thead>
        <tbody>
           <?php
	while($a=mysqli_fetch_assoc($adu)){
	        echo "<tr><td>".$a["id"]."</td><td>".$a["apellido"]."</td><td>".$a["nombre"]."</td><td>".$a["celular"]."</td><td><button class='btn-sm btn-primary' onclick='editar(".$a["id"].")'>Editar</button>";
          echo "&nbsp;<button class='btn-sm btn-danger' onclick='baja(".$a["id"].")')>Baja</button></td></tr>";
	}
	?>
        </tbody>
        </table>
        </div>
      <br><br>
				
</div>
<script>
function nuevo(id){
   navega("mv_adulto_nuevo");
}
function editar(id){
   navega("mv_adulto_editar?id="+id);
}
function baja(id){
      if(confirm("confirmas baja adulto?")){
   navega("mv_adulto_baja?id="+id);
 };
 return true;
}
</script>
</body>