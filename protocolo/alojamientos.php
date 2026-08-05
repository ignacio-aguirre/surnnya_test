<?php 
include("funciones.php");
session_start();
$_SESSION["titulo"]="Alojamientos";
tranca();
include("encabezado-test.php");
$id=$_SESSION["caso"];
$nya=un_campo("select concat(apellidos,', ',nombres) from casos where idcasos=".$id)?>
<div class="container" align="center">
<h4>Historial de alojamientos de <?php echo $nya?></h4>
</div>
<div class="container">

</div>
<div class="container">
<div class="table-responsive pre-scrollable" style="max-height: 420px;">
<table class="table  table-bordered ">
<tr class="table-primary">
<th class="col-md-2">F ingreso</th><th class="col-md-4">Dispositivo</th><th class="col-md-2">F egreso</th><th class="col-md-2">C/b&uacute;sq paradero</th><th>permanencia</th><th>eliminar</th></tr>
<?php
$alo=registros("select alojamientos.*, datediff(case when f_egreso is null then curdate() else f_egreso end,f_ingreso) as perm from alojamientos  where caso=".$id." order by f_ingreso desc, id desc ");
while($a=mysqli_fetch_assoc($alo)){
	$egr=ffec($a["f_egreso"]);
 echo "<tr style='font-size:.9em'><td>".ffec($a["f_ingreso"])."</td><td>".$a["dispositivo"]."</td><td>".si($egr!="",$egr,"<button class='btn-sm btn-danger' onclick='egreso(".$a["id"].")'>Egreso</button>")."</td><td>".si($a["b_paradero"]=="1","S&iacute;","")."</td><td>".$a["perm"]."</td><td>".
 si($a["usuario"]==$_SESSION["usuario"],"<img src='imagenes/eliminar.png' height='15' width='15' onclick='elimina(".$a["id"].")'>","")."</td></tr>"; 
 
};
?>
</table>
</div>
<hr>
<?php $hayabiertos=un_campo("select count(*) from alojamientos where caso=".$id." and f_egreso is null");
   if($_SESSION["escritura"]=="1" && $hayabiertos=="0"){?>


<button class="btn-sm btn-info" onclick='navega("alojamiento_nuevo")'>Nuevo Ingreso</button>
<?php }?>
<button class="btn-sm btn-primary" onclick='navega("uncaso")'>Legajo</button>
<button class="btn-sm btn-success" onclick='navega("acciones")'>Acciones</button>
<script>
function elimina(id){
if(confirm("Confirma que desea eliminar el item?")) {navega("eliminaralojamiento?id="+id);
};	
}
function egreso(id){
navega("egreso?id="+id);

}

</script>
</div>