<?php
include("Funciones.php"); 
session_start();
$_SESSION["prestacion"]="Historial de Etapas de Inclusi&oacute;n en PAE";
include("encabezado.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
registre();
$id=$_GET["id"];
$r=un_registro("select pae_nomina.*,concat(apellidos,', ',nombres) as apyn from pae_nomina left join sujetos on pae_nomina.legajo=sujetos.legajo where pae_nomina.id=".$id);
?>
</div>
<div class="container">

<h4>Inclusi&oacute;n en PAE de <?php echo $r["apyn"];?></h4>
<div class="table-responsive">
<table class="table">
<tr class="bg-primary"><th>Fecha</th><th>Usuario</th><th>Etapa</th><th>Comentarios</th></tr>
<?php $reg=registros("select fecha,usuario,etapa,comentarios from pae_nomina_estados where inclusion=".$id." order by fecha desc, idpae_nomina_estados desc");
while($r=mysqli_fetch_assoc($reg)){
 echo "<tr><td>".ffec($r["fecha"])."</td><td>".$r["usuario"]."</td><td>";
 if($r["etapa"]==1) {echo "Etapa 1";};
 if($r["etapa"]==2) {echo "Etapa 2";};
 echo "</td><td>".$r["comentarios"]."</td></tr>";
};
?>
</table>
</div>


</div>



</body>
</html>