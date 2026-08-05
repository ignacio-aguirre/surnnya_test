<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Asignar Profesional a Solicitud Equipo de Salud";
include("encabezado.php");
$id=nget("id");
$retorno=$_GET["retorno"];
$r=un_registro("select * from es_participaciones where id=".$id);
$ult_dispositivo=un_campo("select dispositivo from es_acciones where solicitud=".$id." order by fecha desc, id desc limit 1");
$ult_tipo=un_campo("select tipo from es_acciones where alcance=1 and solicitud=".$id." order by fecha desc, id desc limit 1");
if($ult_dispositivo==""){$ult_dispositivo=$r["solicitante"];};
?>
</div>
<div class="container">
 <div class="row">
   <div class="col-md-4">
	Fecha Solicitud <strong> <?php echo ffec($r["fecha_ingreso"])?></strong>
   </div>
   <div class="col-md-4">
	Tipo de Acci&oacute;n Solicitada <strong> <?php echo si($r["alcance"]=="1","Intervenci&oacute;n","Institucional")?></strong>
   </div>
   <div class="col-md-4">
	Dispositivo Solicitante <strong> <?php echo si($r["solicitante"]=="-1",$r["solicitante_especificar"],un_campo("select nombre from dispositivos where dispositivos.id=".$r["solicitante"]))?></strong>
   </div>

 </div>
 <div class="row">
   <div class="col-md-4">
	Profesi&oacute;n <strong> <?php echo un_campo("select deno from tablas where tipo='ESESP' and valo=".$r["especialidad"]);?></strong>
   </div>
   <div class="col-md-8"><strong>
     <?php
      if($r["legajo"]>0){
        echo "NNYA ".un_campo("select concat(apellidos,', ',nombres) from sujetos where legajo=".$r["legajo"]);
      }else{
      echo "No asociada a un NNYA";};
      ?></strong>
   </div>

 </div>
 <h4>Asignaci&oacute;n del Profesional</h4>
 <form class="form-inline" method="get" action="es_solicitud_profesional_do">
  <div class="form-group has-warning">
	<label class="label-form">Nuevo Profesional Asignado</label>
        <select class="form-control" name="profesional" id="profesional" autofocus required>
	<?php
        $pro=registros("select * from es_profesionales where baja is null and profesion=".$r["especialidad"]." order by apellido, nombre");
        while($p=mysqli_fetch_assoc($pro)){
          echo "<option value='".$p["id"]."'>".$p["apellido"].", ".$p["nombre"]."</option>";
        }
        ?>
        </select>
  </div>
  <input hidden name="id" value="<?php echo $id?>">	
  <input hidden name="retorno" value="<?php echo $retorno?>">	
  <button class='btn-primary'>Registrar</button>
  </form>
</div>
</body>
</html>
