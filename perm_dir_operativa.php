<?php
include("Funciones.php");
session_start();
include("encabezado.php");
if (!isset($_SESSION['gldispo'])) Redirect("salir");
?>
</div>
<div class="container">
<form class="form-inline" action='perm_dir_operativa_excel' method='GET' onsubmit="return valida()">
 <div class="form-group has-warning">
  <label class="label-form" for="direccion_operativa">Dirección Operativa</label>
  <select class="form-control" name="direccion_operativa" id="direccion_operativa" autofocus>
    <option value="1">Adolescencias</option>
    <option value="2">Infancias</option>
  </select>
  </div>  
  <div class="form-group has-warning">
  <label class="label-form" for="desde">Desde</label>
  <input class="form-control" type='date' name="desde" id="desde" required>
 </div> 
 <div class="form-group has-warning">
  <label class="label-form" for="desde">Hasta</label>
  <input class="form-control" type='date' name="hasta" id="hasta" required>
 </div> 
 <hr>	 
 <button class="btn btn-success">Excel</button>
</form>
</div>
<script>
    function valida(){
        desde=document.getElementById("desde").value;
        hasta=document.getElementById("hasta").value;
        if(desde>hasta){
        status("Fecha desde debe ser menor o igual que fecha hasta");
        return false;
        };
        return true;
    }
</script>
</body>
</html>