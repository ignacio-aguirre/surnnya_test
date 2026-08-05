<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
registre();
?>
<script type="text/javascript">
function valida_datos() {
valida_fecha("i_dde");
valida_fecha("i_hta");
if(document.getElementById("i_dde").value==""){status("Fechas desde y hasta obligatorias");return false;};
if(document.getElementById("i_hta").value==""){status("Fechas desde y hasta obligatorias");return false;};
if(fsql(document.getElementById("i_dde").value)>fsql(document.getElementById("i_hta").value)){status("Fecha desde mayor que hasta");return false;};
status("");
return true;
}
</script>
</div>
<div class="container">
<form class="form-inline" action='sujetos_reporte_do' method='GET' onsubmit="return valida_datos();">
 <div class="form-group has-warning">
  <label class="label-form" for="i_dde">Desde / Hasta</label>
  <input class="form-control" type='text' size='10' maxlength='10' name='desde' id='i_dde' onblur='valida_fecha("i_dde")'>
  <input class="form-control" type='text' size='10' maxlength='10' name='hasta' id='i_hta'  onblur='valida_fecha("i_hta")'>
 </div> 
 <hr>	 
 <input class="btn btn-success" type='submit' name='enviado' value='Excel'>
</form>
</div>
<script type="text/javascript">
enfoca("i_dde");
</script>
</body>
</html>