<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Registrar ausentismo a acci&oacute;n programada";
include("encabezado.php");
$id=nget("id");
$r=un_registro("select es_acciones.*, concat(apellidos,', ',nombres) as apyn, dispositivos.nombre from es_acciones 
   left join sujetos on es_acciones.legajo=sujetos.legajo 
   left join dispositivos on es_acciones.dispositivo=dispositivos.id 
   where es_acciones.id=".$id);
?>
</div>
<div class="container">
 <div class="row">
   <div class="col-md-4">
	Fecha acci&oacute;n <strong> <?php echo ffec($r["fecha"])?></strong>
   </div>
   <div class="col-md-4">
	NNYA <strong> <?php echo $r["apyn"]?></strong>
   </div>
   <div class="col-md-4">
	Dispositivo <strong> <?php echo $r["nombre"]?></strong>
   </div>

 </div>
 

 <form class="form-inline" method="get" action="es_aus_nuevo_do" onsubmit="return true">
  <div class="form-group has-warning">
	<label class="label-form">Tipo de ausentismo</label>
        <select class='form-control' name='estado' id='estado'  required>
        <option value=""></option>  
        <?php $estas=registros("select valo, deno from tablas where tipo='ESEA' and info='AUS' order by valo");
          while($e=mysqli_fetch_assoc($estas)){
            echo "<option value=".$e["valo"].">".$e["deno"]."</option>";
          }
        ?>

        </select>
  </div>

        <input hidden name='id' value="<?php echo $id?>"><br><br>

 

  <button class='btn-danger'>Registrar ausentismo</button>

 
  </form>
</div>

</body>
</html>
