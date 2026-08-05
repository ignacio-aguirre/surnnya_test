<?php
session_start();
require("funciones.php"); 
$_SESSION["prestacion"]="Revisi&oacute;n";
include("encabezado.php");
$proc=un_registro("select * from movil_procesos where id=".$_SESSION["idproceso"]);
$desde=fsql(ffec($proc["desde_ab"]));
$hasta=fsql(ffec($proc["hasta"]));
$estado="0";
$dispositivo="0";
$sector="0";
if(isset($_GET["estado"])){$estado=$_GET['estado'];};
if(isset($_GET["dispositivo"])){$dispositivo=$_GET["dispositivo"];};
if(isset($_GET["sector"])){$sector=$_GET["sector"];};
$_SESSION["ret_menu"]="mv_revision_propia";
$sql="select movil_viajes.*, movil_renglones.nombre_info as tipo, case when dispositivo>0 then dispositivos.nombre else  sectores.denominacion end as solicitante,dispositivos.celular_moviles from movil_viajes 
left join dispositivos on dispositivo=dispositivos.id  
left join sectores on sector=sectores.id  
left join movil_renglones on movil_renglones.id=tipo_movil where  movil_viajes.bandeja=6 and bloqueo=1 ";
if($dispositivo>"0"){$sql=$sql." and dispositivo=".$dispositivo;};
if($sector>"0"){$sql=$sql." and sector=".$sector;};
if($estado>"0"){$sql=$sql." and estado=".tsql($estado);};

$sql=$sql." order by solicitante,fecha,hora";

$via=registros($sql);
function maymin($t){
  return strtoupper(substr($t,0,1)).strtolower(substr($t,1));
}
?>
</div>
<br><br>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Opciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
  </div>
</div>

<div class="container">
<div class="row" style="font-size:.9em;">
  <form class="form-inline">
    <div class="form-group col-md-6">
      <label class="label-form">Dispositivo</label>
      <select class="form-control-sm" name="dispositivo" id="dispositivo">
        
        <?php 
          $dispos=registros("select id, nombre from dispositivos where bandeja>0 and baja is null order by nombre");
          $opc_dispo="<option value='0'>Todos</option>";
          while($d=mysqli_fetch_assoc($dispos)){
            $opc_dispo=$opc_dispo."<option value='".$d["id"]."'>".$d["nombre"]."</option>";
          };
          echo $opc_dispo;
         
        ?>
      </select>  
    </div>
    <script>seleccionar("dispositivo","<?php echo $dispositivo?>")</script>
    <div class="form-group col-md-6">
      <label class="label-form">Sector</label>
      <select class="form-control-sm" name="sector" id="sector">
        
        <?php 
         $sectos=registros("select id, denominacion from sectores where bandeja>0 and baja is null order by denominacion");
          $opc_secto="<option value='0'>Todos</option>";
          while($d=mysqli_fetch_assoc($sectos)){
            $opc_secto=$opc_secto."<option value='".$d["id"]."'>".$d["denominacion"]."</option>";
          };
         
          echo $opc_secto;
         
        ?>
      </select>  
    </div>
    <script>seleccionar("sector","<?php echo $sector?>")</script>
    <br><br>    

    <div class="form-group col-md-3">
        <label class="label-form">Estado</label>
        <select class="form-control-sm" id="estado" name="estado">
          <option value=''>Todos</option>
    <option value='APR'>Aprobados</option>
    <option value='REC'>Rechazados</option>
    <option value='OBS'>Observados</option>
    <option value='PRO'>Programados</option>
        </select>
    </div>
    <script>seleccionar("estado","<?php echo $estado?>")</script>
        <div class="form-group col-md-2">
      <button class="btn-sm btn-success">Filtrar</button>
    </div>
  </form>
</div> 
 
 <div class="row" style="font-size:.9em;">
  
  <div class="col-md-2">
      <button class="btn-sm btn-info" onclick="revaut()">Rev. autom&aacute;tica</button>
  </div>
  <div class="col-md-2">
      <button class="btn-sm btn-success" onclick="excel()">Excel aprobados</button>
  </div>  
  
  <div class="col-md-2">
      <button class="btn-sm btn-success" onclick="marcar()">Marcar todos</button>
  </div>
    <div class="col-md-2">
      <button class="btn-sm btn-danger" onclick="desmarcar()">Desmarcar todos</button>
  </div>

</div> 
<div class="row">  &nbsp; </div>
<div class="row">
  <div class="table-responsive">
  <table id="tabla" class="table">
  <thead> 
   <tr class="bg-dark text-white" style="font-size:.8em"><th>Id</th><th>Dispositivo/Sector</th><th>Fecha y Hora</th><th>Rengl&oacute;n</th>
  <th>Observaciones</th><th>Estado</th><th>Opciones</th><th>Marcar</th></tr>
  </thead>
  <tbody>

 <?php
  while($v=mysqli_fetch_assoc($via)){
    $cels="";
    $cel=registros("select distinct celular from movil_pasajeros  where celular is not null and viaje=".$v["id"]);
    while($c=mysqli_fetch_assoc($cel)){
      $cels=$cels.$c["celular"]." ";
    };
    echo "<tr style='font-size:.8em'><td style='font-size:.7em'>".$v["id"].
    "</td><td>".maymin($v["solicitante"])."</td><td>".
    substr(ffec($v["fecha"]),0,5)."&nbsp;".substr($v["hora"],0,5)."</td><td>".maymin($v["tipo"])."</td><td id='o".$v["id"]."'>".substr(maymin($v["observaciones"]),0,20);
    if(strlen($v["observaciones"])>20) echo "...";
    echo '<button type="button" class="btn-xs btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="'.
      maymin($v["observaciones"]).'->'.
      $v["usuario"].' '.$v["fechahora"].'"'.'>+</button>';
    echo "</td><td id='e".$v["id"]."'>".maymin($v["estado"]);
    echo "</td><td><button class='btn-xs btn-primary' title='Ver' onclick='ver(".$v["id"].")'>V</button>&nbsp;";
    if($v["estado"]!="UNI")    echo "<button class='btn-xs btn-secondary' title='editar' onclick='editar(".$v["id"].")'>E</button>&nbsp;";
    if($v["estado"]!="APR" && $v["estado"]!="UNI" ){ 
        echo "<button class='btn-xs btn-success' title='aprobar' onclick='aprobar(".$v["id"].")'>A</button>&nbsp;";
      };
     
    if($v["estado"]!="REC"  && $v["estado"]!="UNI" ){ 
         echo "<button class='btn-xs btn-danger' title='rechazar' onclick='rechazar(".$v["id"].")'>R</button>&nbsp;";

     };
        
       
      if($v["estado"]!="PRO" && $v["estado"]!="UNI" ){  
       echo "<button class='btn-xs btn-info' title='pasa a programado' onclick='programar(".$v["id"].")'>P</button>&nbsp;"; 
      };
      
      
  

      
    echo "<td>";
    if($v["estado"]!="UNI") echo "<input id='".$v["id"]."' class='form-control mk' type='checkbox'>";
    
    echo "</td>";
    
    
  };
  ?>    
  </tbody>
  </table>
  </div>
  
</div>
<div class="row" style="font-size:.9em;">
  <div class="text-dark col-md-4">Para todos los viajes marcados</div>
  <div class="text-warning col-md-4">
    <select class="form-control-sm" id="nuevoestado">
      <option value="AUT">Revisión Aut.</option>
      <option value="REC">Estado->Rechazado</option>  
      <option value="APR">Estado->Aprobado</option>
      <option value="UNI">Unificar 2 viajes</option>
    </select> 
  </div> 
  <div class="text-dark col-md-3">
    <button class='btn-xs btn-success' title='estados' onclick='cambia_estado()'>Realizar</button>
  </div>  
  <br><br>
</div>  



</div>
<script>
  $('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('Observaciones y registro');
  modal.find('.modal-body').text(recipient);
})
 const cck=document.getElementsByClassName('mk');
 function marcar(){
  for(i=0;i<cck.length;i++){
    cck[i].checked=true;
  }
 } 
 function desmarcar(){
  for(i=0;i<cck.length;i++){
    cck[i].checked=false;
  }
 } 

function cambia_estado(){

    nuevo=document.getElementById("nuevoestado").value;
    if(nuevo=="AUT") return revaut_sele();
    if(nuevo=="UNI") return unificar();
    for(i=0;i<cck.length;i++){
      id=cck[i].id;
      if(cck[i].checked){
        document.getElementById("e"+id).innerHTML=eje('vl_estado?id='+id+'&estado='+nuevo)
        if(document.getElementById("e"+id).innerHTML=="REC"){
               
        }else{
          
                  if(document.getElementById("e"+id).innerHTML!="REC" && document.getElementById("e"+id).innerHTML!="OBS"){
                    document.getElementById("o"+id).innerHTML="";
                  }  
        }

      };
  } 
}


function rechazar(id){
   document.getElementById("e"+id).innerHTML=eje('vl_estado?id='+id+'&estado=REC');
   
}
function programar(id){
 document.getElementById("e"+id).innerHTML=eje('vl_estado?id='+id+'&estado=PRO');
 
}


function aprobar(id){
document.getElementById("e"+id).innerHTML=eje('vl_estado?id='+id+'&estado=APR');
document.getElementById("o"+id).innerHTML="";
}




function excel(){
  naveganuevo("mv_generar_envio_do");
      }


function revaut(){
  
  tabla=document.getElementById("tabla");
  for(i=1;i<tabla.rows.length;i++){
    id=tabla.rows[i].cells[0].innerHTML;
    estado=tabla.rows[i].cells[5].innerHTML;
    if(estado!="Rec" && estado!="Apr" && estado!="Uni"){
      revi=eje("val_revisar?id="+id);
      if(revi=="ok"){
      tabla.rows[i].cells[4].innerHTML="";  
      tabla.rows[i].cells[5].innerHTML="AUTOK";}
      else{
        tabla.rows[i].cells[5].innerHTML="OBS";}
      
      
    }
  }
}

function revaut_sele(){
   for(i=0;i<cck.length;i++){
      id=cck[i].id;
      if(cck[i].checked){
        revi=eje("val_revisar?id="+id);
        
        if(revi=="ok"){
        tabla.rows[i+1].cells[5].innerHTML="AUTOK";
          tabla.rows[i+1].cells[4].innerHTML="";
      }
        else{
        tabla.rows[i+1].cells[5].innerHTML="OBS";}
        
     }
   }
  return true;
  }
           
function unificar() {
  cnt=0;
  id1=0;
  id2=0;
   for(i=0;i<cck.length;i++){
      id=cck[i].id;
      if(cck[i].checked){
        cnt++
        if(cnt==1){id1=id;};
        if(cnt==2){
          id2=id;
          navega("mv_unificar?id1="+id1+"&id2="+id2);
        };
      }
    }
} 
function editar(id){
   navega("mv_viaje_edit?id="+id);
}
function ver(id){
   navega("mv_viaje_ver?id="+id);
}

</script>
</body>