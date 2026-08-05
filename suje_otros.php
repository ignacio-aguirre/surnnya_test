<?php
include("Funciones.php");
session_start();
$_SESSION['prestacion']="Otros";
include('encabezado.php');
if (!isset($_SESSION['gldispo'])|!isset($_GET['legajo'])) header ("Location: .");
registre();
$lega= $_GET["legajo"];
$r=un_registro("select f_adop_decretada,cud,decreto_5 from sujetos where legajo=".$lega);

$tipo="";
if ($lega=="" ) Redirect("Location: consultasujetos");

$_SESSION["posicion"]="9";
include("mnu_superior.php");
?>
</div>

<div class="container">
<form class="form" method="post" action="sujeactotros">
  <input name="legajo" hidden value="<?php echo $lega?>">
  <div class="form-group has-warning">
    <label class="label-form" for="f_adop_decretada">Fecha adoptabilidad decretada</label>
    <input class="form-control" name="f_adop_decretada" id="f_adop_decretada" value="<?php echo ffec($r['f_adop_decretada'])?>" size="10" maxlength="10" onblur="valida_fecha(this.id,1)">
  </div>
  <div class="form-group has-warning">
    <label class="label-form" for="cud">C.U.D.</label>
    <select class="form-control" name="cud" id="cud">
      <option value="0">No tiene CUD</option>
      <option value="1">CUD en tr&aacute;mite</option>
      <option value="2">Tiene CUD</option>
    </select>
  </div>
  <div class="form-group has-warning">
    <label class="label-form" for="decreto_5">Decreto 5</label>
    <select class="form-control" name="decreto_5" id="decreto_5">
      <option value="0">No</option>
      <option value="1">S&iacute;</option>
    </select>
  </div>
  
  <?php if($_SESSION['gl_editar_sujeto']=="1"){?>
  <button class="btn btn-primary">Actualizar</button>
  <?php }?>
</form>
<script>
seleccionar("cud","<?php echo $r["cud"]?>");
seleccionar("decreto_5","<?php echo $r["decreto_5"]?>");
</script>
</div>
