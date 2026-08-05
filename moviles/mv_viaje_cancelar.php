<?php 
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Cancelar viaje";
include("encabezado.php");

$id=nget("id");
$v=un_registro("select fecha,hora, case when fecha>curdate() then 'normal' else 
  case when timediff(hora,curtime())>='02:00' then  'normal' else 'requiere autorizar' end 
  end as situacion from movil_viajes where id=".$id);

?>

</div>
<br><br>
<div class="container">
  <h4>Viaje a Cancelar</h4>
  <form class="form" method="get" action="mv_viaje_cancelar_do">
    <input hidden name="id" value="<?php echo $id?>">
  <div class="row">
    <div class="col-md-4">
      <label class="label-form">Fecha viaje</label>
      <p class="text-primary"><?php echo ffec($v["fecha"])?></p>
    </div>
    <div class="col-md-4">
      <label class="label-form">Hora viaje</label>
      <p class="text-primary"><?php echo substr($v["hora"],0,5)?></p>
    </div>
    <div class="col-md-4">
      <label class="label-form">Situaci&oacute;n</label>
      <p class="text-primary" id="situacion"><?php echo $v["situacion"]?></p>
    </div>  
</div> 
<div class="row">
    <div class="col-md-4">
      <label class="label-form">Motivo</label>
      <input class="form-control" name="texto" id="texto" size="30" maxlength="70" required>
    </div>
    <div class="col-md-4">  
      <br>
      <button class="btn-sm btn-primary">Cancelar</button>
    </div>  

</div>
</form>
</div>
