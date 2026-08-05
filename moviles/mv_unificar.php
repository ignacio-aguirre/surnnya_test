<?php 
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Unificar dos viajes";
include("encabezado.php");
$id1=nget("id1");
$id2=nget("id2");
$v1=un_registro("select movil_viajes.*,dispositivos.nombre
 from movil_viajes
 left join dispositivos on dispositivo=dispositivos.id 
  where movil_viajes.id=".$id1);
$v2=un_registro("select movil_viajes.*,dispositivos.nombre
 from movil_viajes
 left join dispositivos on dispositivo=dispositivos.id 
  where movil_viajes.id=".$id2);
$mensaje="";
if($v1["dispositivo"]=="0"){
    die("Solo para viajes de dispositivos");
};
if($v2["dispositivo"]=="0"){
    die("Solo para viajes de dispositivos");
};
if($v1["dispositivo"]!=$v2["dispositivo"]){
  die("Por el momento, solo para viajes del mismo dispositivo");
};
if($v1["destino_2"]!="" || $v2["destino_2"]!="" ){  
    die("Por el momento, solo para viajes con un solo destino");
};
if($v1["partida"]!=$v2["partida"]){
  die("Por el momento, solo para viajes con mismo punto de partida");
};
?>
<div class="container">
    <h7><?php echo $v1["nombre"]?></h7>
    <div class="row col-md-12">
    <h7 class="col-md-12">Desde <?php echo $v1["partida"]?></h7>
    </div>
    <div class="row col-md-12">
    <h8 class="col-md-12">Viaje 1</h8>
    </div>
    <div class="row col-md-12">
        <p class="col-md-6">Fecha y hora partida<?php echo ffec($v1["fecha"])." ".substr($v1["hora"],0,5)?></p>
        <p class="col-md-6">Destino <?php echo $v1["destino_1"]?></p>
    </div>    
    <div class="row col-md-12">
        <h8 class="col-md-12">Viaje 2</h8>
    </div>
     <div class="row col-md-12">   
        <p class="col-md-6">Fecha y hora partida<?php echo ffec($v2["fecha"])." ".substr($v2["hora"],0,5)?></p>
        <p class="col-md-6">Destino <?php echo $v2["destino_1"]?></p>
    </div>
    <form class="form" method="get" action="mv_unificar_do">
        <input name="id1" value="<?php echo $id1?>" hidden>
        <input name="id2" value="<?php echo $id2?>" hidden>    
        <div class="form-group has-warning">
            <label class="label-form" for="primero">Primer destino igual al destino de</label>
            <select class="form-control" id="primero" name="primero">
                <option value=1>Viaje 1</option>
                <option value=2>Viaje 2</option>
            </select>
        </div>    
        <div class="form-group has-warning">
            <button class="btn-sm btn-success">Unificar</button>
        <div>
    </form>    
    <div class="row">
        <p class="text-info">
            El nuevo viaje unificado reemplazar&aacute; al viaje del cual se elija como primer destino, el destino propio, y quedará en estado "PRO", mientras que el otro viaje quedará en estado "REC"
        </p>
    </div>    
</div>

</body>