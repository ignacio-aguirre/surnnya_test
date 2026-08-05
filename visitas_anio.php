<?php
include("Funciones.php");
session_start();
include("encabezado.php");
?>
<script type="text/javascript">
function valida_datos() {
if(document.getElementById("anio").value<"2013"){status("Año incorrecto");return false;};
status("");
return true;
}
</script>
<?php 
registre();
?>
</div>
<div class="container">
<form class="form-inline" action='visitas_anio_do' method='GET' onsubmit="return valida_datos();">
 <div class="form-group has-warning">
  <label class="label-form" for="anio">A&ntilde;o</label>
  <input class="form-control" type='text' size='4' maxlength='4' name='anio' id='anio' value="<?php echo substr($_SESSION['DiaHoy'],-4)?>" onblur='valida_entero("anio")'>
 </div> 
 <div class="form-group has-warning">
  <label class="label-form" for="isoco">Tipo de Dispositivos</label><select class="form-control" id="tipo" name='tipo'>
  <option value="1">Hogares</opcion>
  <option value="2">Acogimiento Familiar</opcion>
  </select>
 </div>
 <hr>	 
 <input class="btn btn-success" type='submit' name='enviado' value='Excel'>
</form>
</div>
<script type="text/javascript">
enfoca("anio");
</script>
</body>
</html>