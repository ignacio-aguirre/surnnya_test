<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Editar Estado Registro de Acci&oacute;n Equipo de Salud";
include("encabezado-test.php");
$id=nget("id");
$r=un_registro("select * from es_acciones left join tablas on tablas.tipo='ESEA' and valo=estado where id=".$id);
$s=un_registro("select * from es_participaciones where id=".nulea($r["solicitud"]));
?>
</div>
<div class="container">
 <div class="row">
   <div class="col-md-4">
	Estado Actual <strong> <?php echo $r["deno"]?></strong>
   </div>
 </div>
 <div class="row">
   <div class="col-md-4">
	Profesi&oacute;n <strong> <?php echo un_campo("select deno from tablas where tipo='ESESP' and valo=".$s["especialidad"]);?></strong>
   </div>
   <div class="col-md-8"><strong>
     <?php
      if($s["legajo"]>0){
        echo "NNYA ".un_campo("select concat(apellidos,', ',nombres) from sujetos where legajo=".$s["legajo"]);
      }else{
      echo "No asociada a un NNYA";};
      ?></strong>
   </div>

 </div>
 <h4>Registro de la Acci&oacute;n</h4>
 <form class="form-inline" method="get" action="es_accion_cesta_do">
  <input hidden name="id" value="<?php echo $r['id']?>">
  <div class="form-group has-warning">
	  <label class="label-form">Nuevo estado</label>
	  <select id="estado" name="estado" class="form-control" required>
	  <option value="">(completar)</option>
          <?php echo opc_tabla("ESEA")?>
          </select>
 </div><br><br>
  <p class="text-warning">Aviso: el estado BAJA no es reversible por el usuario</p>
  <br><br>
  <button class='btn-primary'>Actualizar</button>
  </form>
</div>

</body>
</html>
