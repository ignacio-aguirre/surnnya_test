<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
registre();
$refe="";
$etapa="";
$accion="ALTA";
if(isset($_GET["refe"])) $refe=$_GET["refe"];
if(isset($_GET["etapa"])) $etapa=$_GET["etapa"];
if(isset($_GET["accion"])) $accion=$_GET["accion"];

?>
<div class="container">
<form class="form-inline" method="get">
   <div class="form-group has-warning">
	<label class="label-form">Referente </label>
	<input class="form-control" name="refe" id="refe" size="40" placeholder="completar parte del nombre o apellido" value="<?php echo $refe?>">
   </div>
   &nbsp;&nbsp;
   <div class="form-group has-warning">
	<label class="label-form">Etapa </label>
	<select class="form-control" name="etapa" id="etapa">
	<option value="">Ambas</option>
	<option value="1">Etapa 1</option>
	<option value="2">Etapa 2</option>
	</select>
   </div>
   &nbsp;&nbsp;
   <div class="form-group has-warning">
	<label class="label-form">AMB </label>
	<select class="form-control" name="accion" id="accion">
	<option value="ALTA">ALTA</option>
	<option value="">Ambas</option>
	<option value="BAJA">BAJA</option>
	</select>
   </div>
   &nbsp;&nbsp;

   <script>
	seleccionar("accion","<?php echo $accion?>");
	seleccionar("etapa","<?php echo $etapa?>");

    </script>	
   <button class="btn-primary">Filtrar</button>
</form>
<div class='table-responsive pre-scrollable'>
<table class='table table-striped table-bordered'>
<tr style="font-size:.80em">
<th>Id</th><th>AMB</th><th>Apellido y Nombre</th><th>Edad</th><th>Etapa</th><th>Hogar</th><th>Egreso Fecha</th><th>Referente</th></tr>
<?php
  $cond=" pae_nomina.legajo>0 ";
  if($accion!="") $cond=$cond." and accion_amb=".tsql($accion)." ";
  if($refe!="") $cond=$cond." and concat(apellido,', ',nombre) like '%".$refe."%'";
  if(isset($_GET["etapa"])) {
    if($_GET["etapa"]>"")    $cond=$cond." and etapa=".$_GET["etapa"];
  };

  $sql="select pae_nomina.*, sujetos.legajo , sujetos.apellidos as apel, sujetos.nombres, edadcalc(f_nacimiento,sujetosEdad,SujetosMeses,SujetosActEdad,curdate()) as edad_calc,  
 case when apellido is null then case when referente_1=-1 then 'GRUPAL' else '' end else concat(apellido,', ',nombre) end as refe from pae_nomina
   left join sujetos on pae_nomina.legajo=sujetos.legajo 
   left join sujetos_pae on sujetos_pae.legajo=sujetos.legajo 
   left join usuarios on referente_1=usuarios.id
   where ".$cond."  order by apel, Nombres";
   $conn = registros($sql);
   $conta=0;
   $perf_original=un_campo("select perfil from usuarios where id=".$_SESSION["glidusua"]);
   while ($da = mysqli_fetch_assoc($conn)) {
      $conta=$conta+1;
      $lega=$da['legajo'];
      $apel=$da["apel"];
      $nomb= $da["nombres"];
      $hoga=un_registro("SELECT nombre,admi_baja,admi_mote,tipo_dispositivo FROM `hogares_admision` 
     left join dispositivos on dispositivos.id=admi_hogar WHERE admi_alta is not null and  admi_baja is null and admi_legajo=".$lega." order by admi_alta desc limit 1");	
     $tviv=un_registro("select deno,fecha from sujetos_vivienda left join tablas on tipo='MEPRE' and valo=tipovivienda where legajo=".$lega." order by fecha desc limit 1");
      $baja="";
      if(isset($hoga["admi_baja"])) $baja=ffec($hoga["admi_baja"]);
      $hogar="";
      if(isset($hoga["nombre"]))      $hogar=$hoga["nombre"];
      $refe="";
      if(isset($da["refe"]))      $refe=$da["refe"];

      echo "<tr style='font-size:.80em' onclick='ver(".$da["id"].")'><td>".$da["id"]."</td><td>".$da["accion_amb"]."</td><td>".$apel.", ".$nomb."</td><td>".$da["edad_calc"].
"</td><td>".$da["etapa"]."<br>".ffec($da["f_cambio_etapa"]).
"</td><td>".$hogar."</td><td>".$baja."</td><td>".$refe."</td></tr>";
	    };   
?>

</table>

</div>

<?php if(isset($conta)){ echo 'Total ';echo $conta;echo ' registros ';};?><br>


</body>
<script>
function ver(id){
	navega("pae_ver?id="+id);
}
</script>
</html>