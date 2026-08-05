<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Replicar Pedido en miembros del grupo";
include("encabezado-test.php");
$id=nget("id");
$lega=nget("legajo");
$grup=un_campo("select grupo from grupos_legajos where grupo_legajo=".$lega);
if(!$grup>"0") {Redirect($_SESSION["menu"]);};
?>
</div>
<div class="container">
<div class="table-responsive">
<table class="table">
<?php
$reg=registros("select * from grupos_legajos left join sujetos on grupo_legajo=legajo where grupo=".$grup);
$c=0;
while($r=mysqli_fetch_assoc($reg)){
 $c=$c+1;
  if($r["grupo_legajo"]!=$lega) echo "<tr><td>".$r["Apellidos"]."</td><td>".$r["Nombres"]."</td><td><input id='".$r["grupo_legajo"]."' type='checkbox' onclick=replica(".$r["grupo_legajo"].")></td></tr>";
  };
?>

</table>

</div>

</div>

<script>

function replica(lega){

 ejec_sq("admision_replica?id=<?php echo $id?>&legajo="+lega)

 document.getElementById(lega).disabled=true;

}

</script>

</body>