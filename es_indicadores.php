<?php
session_start();
include("Funciones.php");
include("encabezado.php");
$desde="";
$hasta="";
if(isset($_GET["desde"])){
$desde=$_GET["desde"];
$hasta=$_GET["hasta"];
};
?>
</div>
<script>
function aexcel(){
desde=document.getElementById("desde").value;
hasta=document.getElementById("hasta").value;
navega("es_indicadores_excel?desde="+desde+"&hasta="+hasta);
}
</script>

<div class="container">
<form class="form-inline" onsubmit="return false">
<div class="form-group has-warning">
 <label class="label-form">Desde</label>
 <input class="form-control" size="10" maxlength="10" name="desde" id="desde" onblur="valida_fecha(this.id)" value="<?php echo $desde?>" autofocus required>
</div>
<div class="form-group has-warning">
 <label class="label-form">Hasta</label>
 <input class="form-control" size="10" maxlength="10" name="hasta" id="hasta" onblur="valida_fecha(this.id)"  value="<?php echo $hasta?>" required>
</div>
&nbsp;&nbsp;&nbsp;
<button class="btn-success" name="excel" onclick="aexcel()">Excel</button>

</form>
</div>
</body>
</html>