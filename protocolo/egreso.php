<?php 
include("funciones.php");
session_start();
$_SESSION["titulo"]="Egreso";
tranca();
include("encabezado-test.php");
$id=$_GET["id"];
$a=un_registro("select * from alojamientos where id=".$id);
$nya=un_campo("select concat(apellidos,', ',nombres) from casos where idcasos=".$a["caso"]);
$dispo=$a["dispositivo"];
$_SESSION['Hoy']=un_campo("select curdate() as hoy");
?>

<div class="container" align="center">
	<h4>Registrar egreso de <?php echo $nya?> de <?php echo $dispo?></h4>
</div>		
<div class="container">
<section class="col-md-12">
<form class="form" action="egreso_do" onsubmit="return valida_formulario()" method="POST">
		<input hidden name="id" value="<?php echo $id?>">
		<input hidden id="f_ingreso" value="<?php echo ffec($a['f_ingreso'])?>">
<div class="form-group has-warning col-md-2">
<label for="f_egreso">Fecha del egreso:</label>
<input class="form-control" id="f_egreso" name="f_egreso"  type="date" autofocus required min="<?php echo $a['f_ingreso']?>" max="<?php echo $_SESSION['Hoy'] ?>" value="<?php echo $_SESSION['Hoy'] ?>">
</div>
<div class="form-group has-warning col-md-6">
<label class="label-form" for="b_paradero">C/b&uacute;squeda paradero</label>
<input  type ="checkbox" name="b_paradero" id="b_paradero">
</div>
<button class="btn-sm btn-primary">Registrar Egreso</button>
</div>
</form>
</section>
<script>
function valida_formulario(){
if(chequea_estado()){

valida_fecha("f_egreso");
if(fsql(document.getElementById("f_egreso").value)<fsql(document.getElementById("f_ingreso").value){
	status("Fecha egreso anterior a ingreso");return false;
}
return true;
}
</script>