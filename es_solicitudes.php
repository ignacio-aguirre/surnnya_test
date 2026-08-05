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
<hr>



<strong>Solicitudes Ingresadas</strong>

<div class='table-responsive'>

<table class='table table-striped table-bordered'>

<tr style="font-size:.9em"><th>Fecha</th><th>Apellido y Nombre, edad</th><th>Solicitante</th><th>Profesi&oacute;n</th><th>Estado</th><th>Opciones</th></tr>

<?php

if (isset($_GET["desde"]))
 
{
  $desd=fget("desde");
  $hast=fget("hasta");

   $sql="select es_participaciones.*, sujetos.*, edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,curdate()) as edadc,
 dispositivos.nombre as solicitante, espe.deno as especialidad   
  from es_participaciones left join sujetos on es_participaciones.legajo=sujetos.legajo 
  left join dispositivos on dispositivos.id=es_participaciones.solicitante
  left join tablas espe on espe.tipo='ESESP' and espe.valo=es_participaciones.especialidad
 where fecha_ingreso between ".$desd." and ".$hast." order by fecha_ingreso desc";
   $reg =registros($sql);
   $conta=0;
   while ($r = mysqli_fetch_assoc($reg)) {
      $conta=$conta+1;
      $lega=$r['legajo'];
      $apyn=si($lega=="0","",$r["Apellidos"].", ".$r["Nombres"]." (".$r["edadc"].")");
      echo "<tr style='font-size:.9em'><td>".ffec($r["fecha_ingreso"])."</td><td>".$apyn."</td><td>".trim($r["solicitante"]." ".$r["solicitante_especificar"]).
  "</td><td>".$r["especialidad"]."</td>";
      echo "<td>";
      if($r["fecha_rechazo"]!="") {echo "No pertinente";$esta="np";}
      else{
      if($r["fecha_fin"]!="") {echo "Cerrada";$esta="cr";}
        else{
         if($r["fecha_inicio"]!="") {echo "En Curso";$esta="ab";}
	 else{
          echo "Pendiente";$esta="pn";
         };
        };
      };
      echo "</td><td>";
      if($esta=="pn"){echo "<btn class='btn-sm btn-info' onclick='nopert(".$r["id"].")'>NoPert</btn>&nbsp;";};
      if($esta=="ab"){echo "<btn class='btn-sm btn-danger' onclick='finalizar(".$r["id"].")'>Fin</btn>&nbsp;";};
      echo "<btn class='btn-sm btn-warning' onclick='informe(".$r["id"].")'>Informe</btn>&nbsp;";	

      echo "</td></tr>";

   };   

  }


?>

</table>
<?php echo $conta." solicitudes"?>
</div>

<script>
function accion(id){
 navega("es_accion_nueva?solicitud="+id);
}
function nopert(id){
 navega("es_estado?solicitud="+id+"&estado=np");
}
function finalizar(id){
 navega("es_estado?solicitud="+id+"&estado=cr");
}

function editar(id){
 navega("una_solicitud_es?id="+id);
}

function informe(id){
 navega("informe_solicitud_es?id="+id);
}
function aexcel(){
desde=document.getElementById("desde").value;
hasta=document.getElementById("hasta").value;
navega("es_solicitudes_excel?desde="+desde+"&hasta="+hasta);
}
</script>
</body>

</html>