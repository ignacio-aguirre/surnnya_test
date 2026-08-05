<?php
session_start();
include("Funciones.php");
$_SESSION["prestacion"]="Editar datos de Profesional";
$id=nget("id");
$r=un_registro("select * from es_profesionales where id=".$id);
include("encabezado-test.php");
?>
</div>
<div class="container">
<form class="form-inline" method="get" action="es_profesional_do" onsubmit="return valida()">
	<div class="form-group has-warning">
	  <label class="label-form">Apellidos</label>
	  <input class="form-control" name="apellido" id="apellido" size="50" maxlength="50" onblur="valida_0(this.id)" value="<?php echo $r['apellido']?>" required autofocus>
	</div>
	<div class="form-group has-warning">
	  <label class="label-form">Nombres</label>
	  <input class="form-control" name="nombre" id="nombre" size="50" maxlength="50" onblur="valida_0(this.id)" value="<?php echo $r['nombre']?>" required>
	</div><br><br>
	<div class="form-group has-warning">
	  <label class="label-form">Profesi&oacute;n</label>
          <?php echo select_tabla("profesion","ESESP",true,true)?> 
          <script>
	   seleccionar("profesion","<?php echo $r['profesion']?>");
          </script>
	</div>
	<div class="form-group has-warning">
	  <label class="label-form">Matr&iacute;culas</label>
	  <input class="form-control" name="matricula" id="matricula" size="30" maxlength="50"  value="<?php echo $r['matricula']?>"  onblur="valida_0(this.id)">
	</div>
	<div class="form-group has-warning">
	  <label class="label-form">Fecha de Alta</label>
	  <input class="form-control" name="alta" id="alta" size="10" maxlength="10"  value="<?php echo ffec($r['alta'])?>"  onblur="valida_fecha(this.id)" required>
	</div>
	<div class="form-group has-warning">
	  <label class="label-form">Fecha de Baja</label>
	  <input class="form-control" name="baja" id="baja" size="10" maxlength="10"  value="<?php echo ffec($r['baja'])?>"  onblur="valida_fecha(this.id,1)">
	</div><br><br>
	<div class="form-group has-warning">
	  <label class="label-form">Usuario</label>
	  <select class="form-control" name="usuario" id="usuario">
           <option value="">(Ninguno)</option>
           <?php
            $opc=registros("select concat(apellido,', ',nombre) as apynom, id from usuarios where perfil=56 order by apellido, nombre");
            while($o=mysqli_fetch_assoc($opc)){
              echo "<option value='".$o["id"]."'>".$o["apynom"]."</option>";
            };
           ?>
          </select>
	  <script>
	   seleccionar("usuario","<?php echo $r['usuario']?>");
          </script>

        </div><br><br>	


	<input hidden name="id" value="<?php echo $id?>">
        <button class="btn-primary">Guardar</button> 
</form>
<script>
function valida(){
valida_fecha("alta");
valida_fecha("baja",1);
return (document.getElementById("alta").value!="");
}
</script>
</div>
</body>
</html>
