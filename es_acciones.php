<?php
include("Funciones.php");
session_start();
include("encabezado.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
$hasta=$_SESSION["DiaHoy"];
$desde="01/".substr($hasta,-7);
if(isset($_GET["desde"])){$desde=$_GET["desde"];$hasta=$_GET["hasta"];

};
?>
</div>
<div class="container">
<form class="form-inline" method="get">
 <div class='form-group has-warning'>
  <label class='label-form' for='desde'>Desde</label>
  <input class='form-control' name="desde" id="desde" size="10" maxlength="10" onblur="valida_fecha(this.id)" value="<?php echo $desde?>" required autofocus>
 </div>&nbsp;&nbsp;&nbsp;

 <div class='form-group has-warning'>
  <label class='label-form' for='hasta'>Hasta</label>
  <input class='form-control' name="hasta" id="hasta" size="10" maxlength="10" onblur="valida_fecha(this.id)" value="<?php echo $hasta?>" required>
 </div>&nbsp;&nbsp;&nbsp;
 

<input name="submit" type="submit" value="Consultar" />

</form>
<button class="btn btn-success" onclick="aexcel()">Excel</button>
<button class="btn btn-info btn-sm" onclick="realizar()">Pasar de programadas a realizadas</button>

<hr>



<strong>Acciones Realizadas</strong>

<div class='table-responsive'>
<table class='table table-striped table-bordered'>
<tr style="font-size:.8em;"><th>Fecha</th><th>F.Solic.</th><th>Apellido y Nombre, edad</th><th>Dispositivo</th><th>Tipo Acci&oacute;n</th><th>Profesi&oacute;n</th><th>Estado</th><th>Observaciones</th><th>Opciones</th></tr>

<?php

if (isset($_GET["desde"]))
 
{
  $desd=fget("desde");
  $hast=fget("hasta");

   $sql="select es_acciones.*, es_participaciones.fecha_ingreso, sujetos.*, edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,curdate()) as edadc,
 dispositivos.nombre as dispositivo, espe.deno as especialidad, tias.deno as tipoaccion,tiea.deno as esta    
  from es_acciones left join es_participaciones on solicitud=es_participaciones.id
  left join sujetos on es_acciones.legajo=sujetos.legajo 
  left join dispositivos on dispositivos.id=es_acciones.dispositivo
  left join tablas espe on espe.tipo='ESESP' and espe.valo=es_acciones.especialidad
  left join tablas tias on tias.tipo='ESTIA' and tias.valo=es_acciones.tipo
  left join tablas tiea on tiea.tipo='ESEA' and tiea.valo=es_acciones.estado

 where estado<>7 and fecha between ".$desd." and ".$hast." order by fecha desc";
   $reg =registros($sql);
   $conta=0;
   while ($r = mysqli_fetch_assoc($reg)) {
      $conta=$conta+1;
      $lega=$r['legajo'];
      $apyn=si($lega=="0","",$r["Apellidos"].", ".$r["Nombres"]." (".$r["edadc"].")");
      echo "<tr style='font-size:.8em;'><td>".ffec($r["fecha"])."</td><td>".ffec($r["fecha_ingreso"])."</td><td>".$apyn."</td><td>".trim($r["dispositivo"]." ".$r["dispositivo_especificar"]).
  "</td><td>".si($r["alcance"]=="2","Institucional ".$r["accion_especificar"],$r["tipoaccion"])."</td><td>".$r["especialidad"]."</td>";
      echo "<td>".$r["esta"].si($_SESSION['glidperfil']=='58'," <btn class='btn-sm btn-info' onclick='cesta(".$r["id"].")'>Cambiar</btn>","")."</td><td>".$r["observaciones"]."</td><td>";
      if($_SESSION['glidperfil']=='58') echo "<button class='btn-primary btn-sm' onclick='editar(".$r["id"].")'>Editar</button>";
      echo "</td></tr>";

   };   

  }


?>

</table>

</div>

<script>
function editar(id){
 navega("es_accion_editar?id="+id);
}
function cesta(id){
 navega("es_accion_cesta?id="+id);
}
function realizar(){
 navega("es_acciones_realizar");
}

function aexcel(){
 desde=document.getElementById("desde").value;
 hasta=document.getElementById("hasta").value;
 navega("es_acciones_excel?desde="+desde+"&hasta="+hasta);
}
</script>
</body>

</html>