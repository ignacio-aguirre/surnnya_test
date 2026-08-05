<?php
include("Funciones.php");
session_start();
$id=$_GET["id"];
$_SESSION["temp_ffv"]=$id;
$_SESSION["prestacion"]="Miembros de la Familia ".un_campo("select descripcion from fv_familias where idfv_familias=".$id);
include("encabezado-test.php");
?>
</div>
<div class="container">
<div class="row">
<div class="col-sm-4"><p class="text-warning"><strong>NNYA</strong></p></div>
<div class="col-sm-4"><button class="btn btn-warning" onclick='navega("consultasujetos?ffv=1")'>Agregar NNYA</button></div>
</div>
<div class="table-responsive">
<table class="table">
<tr class="bg-primary"><td>RIB</td><td>Apellido y Nombre</td><td>Edad</td><td>Tipo y Nro.Documento</td><td>Fecha Alta</td><td>Fecha Baja</td><td>Opciones</td></tr>
<?php
$reg=registros("select sujetos.legajo,apellidos,nombres,deno,sujetosdni,rib_anio,rib_numero,rib_reparticion, edadcalc(f_nacimiento,sujetosedad,0,sujetosactedad,curdate()) as edadc,fecha_alta, fecha_baja  
 from fv_familias_miembros left join sujetos on fv_familias_miembros.legajo=sujetos.legajo 
 left join tablas on tablas.tipo='TD' and tablas.valo=sujetos.tipodni 
 where fv_familias_miembros.legajo>0 and familia=".$id." order by apellidos,nombres");
$contador=0;
while($r=mysqli_fetch_assoc($reg)){
   $contador=$contador+1;	
   echo "<tr><td onclick='navega(".'"suje_cons_duros?legajo='.$r["legajo"].'")'."'>".rib($r["rib_anio"],$r["rib_numero"],$r["rib_reparticion"]).
"</td><td>".$r["apellidos"].", ".$r["nombres"]."</td><td>".$r["edadc"]."</td><td>".$r["deno"]." ".$r["sujetosdni"]."</td><td>".ffec($r["fecha_alta"]).
"</td><td>".ffec($r["fecha_baja"])."</td><td><button class='btn-sm btn-info' onclick='vernnya(".$r["legajo"].")'>Legajo NNYA</button>&nbsp;".
si($_SESSION["glcons"]==0,"<a class='btn btn-danger btn-sm' href='javascript:editalegajo(".$r["legajo"].")'>Baja</a>","")."</td></tr>";
}; 
?>
</table>
</div>

<script>
function vernnya(l){
 naveganuevo("suje_cons_duros?legajo="+l);
}
function editalegajo(lega){
navega("fv_nnya_baja?legajo="+lega+"&familia=<?php echo $id?>");
return true;
}

</script>
</div>
</body>
</html>