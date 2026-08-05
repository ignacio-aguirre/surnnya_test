<?php
require("funciones.php"); 
session_start();
$_SESSION["prestacion"]="Eliminar viaje";
include("encabezado.php");
$id=nget("id");
$retorno=nget("rtn");


$v=un_registro("select * from movil_viajes where id=".$id);
$dispositivo=$v["dispositivo"];
if($_SESSION["perfil_moviles"]=="1"){$dispositivo=$_SESSION["hogar"];
  if($dispositivo!=$v["dispositivo"]) {$SESSION["msg"]="2";Redirect("salir");};
};

$d=un_registro("select * from dispositivos where id=".$dispositivo);

?>
</div>
<div class="container">

 <form class="form-inline" method="get" action="mv_viaje_eliminar_do">
   <input name="id" value="<?php echo $id?>" hidden>
     <input name="rtn" value="<?php echo $retorno?>" hidden>

    <div class="row">     
    <div class="form-group has-warning col-md-2">
        <label class="label-form">Fecha del viaje</label>
        <input disabled id="fecha" class="form-control" type="date" size="10"  value="<?php echo $v['fecha']?>">
        </div>
    <div class="form-group has-warning col-md-2">
        <label class="label-form">Hora de salida</label>
        <input type="time" class="form-control" size="5"   id="hora" name="hora" readonly value="<?php echo $v['hora']?>">
    </div>&nbsp;&nbsp;

    <div class="form-group has-warning col-md-3">
        <label class="label-form">Tipo de m&oacute;vil</label>
        <select class="form-control" id="tipo">
              
        <?php 
            $opc=registros("select id,nombre_info from movil_renglones  order by id");
                    while($o=mysqli_fetch_assoc($opc)){
                echo "<option value='".$o["id"]."'>".$o["nombre_info"]."</option>";}
        ?>
        </select>
        <script>seleccionar("tipo","<?php echo $v['tipo_movil']?>");
                 document.getElementById("tipo").disabled=true;
            </script>
    </div>
    <div class="form-group has-warning col-md-5">
        <label class="label-form">Sale desde</label>
        <input class="form-control" size="40" maxlength="70" id="partida" name="partida"  value="<?php echo $v['partida']?>"  readonly>
        
    </div>
    <div class="row">
    <br><br><br>
    </div>
    <div class="row">
    <div class="form-group has-warning col-md-9">
        <label class="label-form">Destino 1</label>
        <input class="form-control" id="destino_1"  name="destino_1" size="40" maxlength= "70" value="<?php echo $v['destino_1']?>" readonly>
        
        
    </div>
    <?php if($v["destino_2"]!=""){?>
    <div class="form-group has-warning col-md-9">
        <label class="label-form">Destino 2</label>
        <input class="form-control" id="destino_2"  name="destino_2" size="40" maxlength= "70"  value="<?php echo $v['destino_2']?>" readonly>
        
    </div>
    <?php ;} if($v["destino_3"]!=""){?>
    <div class="form-group has-warning col-md-9">
        <label class="label-form">Destino 3</label>
        <input class="form-control" id="destino_3"  name="destino_3" size="40" maxlength= "70" value="<?php echo $v['destino_3']?>" readonly>
        
    </div>
    <?php ;} if($v["destino_4"]!=""){?>
    <div class="form-group has-warning  col-md-9">
        <label class="label-form">Destino 4</label>
        <input class="form-control" id="destino_4"  name="destino_4" size="40" maxlength= "70"  value="<?php echo $v['destino_4']?>" readonly>
        
    </div>
    <?php ;}?>
    </div>
    

        </div>


      <div class="row">
      <hr>
      <?php if($ar>"0"){?>
      <div class="input-group">
        <label class="form-check-label">Eliminas tambi&eacute;n viajes futuros asociados?</label>
        <input class="form-control" type="checkbox" name="asociados">
    
    
    </div>
      <?php }?>
      <br><br>

      <button class="form-control btn-danger">Eliminar</button>                 
  </form>   
</div>


</body>