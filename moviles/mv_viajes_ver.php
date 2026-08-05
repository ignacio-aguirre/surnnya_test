<?php 
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Consulta viajes";
include("encabezado.php");
$cosa=revisa_programados();
$_SESSION["ret_menu"]="mv_viajes_ver";
$bandeja=$_SESSION["bandeja"];
$oper=un_registro("select * from movil_procesos where id=".$_SESSION["idproceso"]);
      $b1="b1_".$_SESSION['bandeja'];
      $b2="b2_".$_SESSION['bandeja'];
      $lini=$oper["desde_db"];
$fini=$oper["desde_ab"];
$ffin=$oper["hasta"];


$estado="";
$dispositivo="0";
$sector="0";
if(isset($_GET["estado"])){
  $estado=$_GET["estado"];
};
if(isset($_GET["fini"])){
 $fini=$_GET["fini"];
 $ffin=$_GET["ffin"];
 $f_ini=str_replace("-","",$fini);
 $f_fin=str_replace("-","",$ffin);
}
if(isset($_GET["dispositivo"])){
 $dispositivo=nget("dispositivo");
}
if(isset($_GET["sector"])){
 $sector=nget("sector");
};

?>

</div>
<br><br>
<div class="container">
  <div class="row">
  <form class="form-inline" method="get">
	<div class="form-group has-warning col-md-2" style='font-size:.8em;' >
		<label class="label-form has-warning col-md-2">Desde&nbsp;</label>
		<input class="form-control-sm" id="fini" name="fini" required autofocus type="date" value="<?php echo $fini?>" min="<?php echo $_SESSION["hoy_c"]?>">
	</div>&nbsp;&nbsp;
	<div class="form-group has-warning col-md-2" style='font-size:.8em;'>
		<label class="label-form">Hasta&nbsp;</label>
		<input class="form-control-sm" type="date" id="ffin" name="ffin" required value="<?php echo $ffin?>" min="<?php echo $_SESSION["hoy_c"]?>">
	</div>
  <div class="form-group has-warning col-md-3" style='font-size:.8em;' >
      <label class="label-form">Dispositivo</label>
      <select class="form-control-sm" name="dispositivo" id="dispositivo">
        
        <?php 
          $dispos=registros("select id, nombre from dispositivos where bandeja=1  order by nombre");
          $opc_dispo="<option value='0'>Todos</option>";
          while($d=mysqli_fetch_assoc($dispos)){
            $opc_dispo=$opc_dispo."<option value='".$d["id"]."'>".$d["nombre"]."</option>";
          };
          echo $opc_dispo;
         
        ?>
      </select>  
    </div>
    <script>seleccionar("dispositivo","<?php echo $dispositivo?>")</script>
  </div>
  
    <div class="form-group col-md-12 has-warning" style='font-size:.8em;' >
      <label class="label-form">Sector</label>
      <select class="form-control-sm" name="sector" id="sector">
        
        <?php 
         $sectos=registros("select id, denominacion from sectores where bandeja=1 order by denominacion");
          $opc_secto="<option value='0'>Todos</option>";
          while($d=mysqli_fetch_assoc($sectos)){
            $opc_secto=$opc_secto."<option value='".$d["id"]."'>".$d["denominacion"]."</option>";
          };
         
          echo $opc_secto;
         
        ?>
      </select>  
  
    <script>seleccionar("sector","<?php echo $sector?>")</script>
    

    
  
    <label class="label-form">Estado&nbsp;</label>
    <select id="estado" name="estado" class="form-control-sm">

    <option value=''>Todos</option>
    <option value='PRO'>Programados</option>
    <option value='APR'>Aprobados</option>
    <option value='REC'>Rechazados</option>
    <option value='OBS'>Observados</option>
    <option value='BAJ'>Baja</option>
    
   </select>
  
   <script>
     seleccionar("estado","<?php echo $estado?>");
   </script>
    
	 <button class="btn-sm btn-primary">Consultar</button>&nbsp;
  </div>
  </form>
  <button class="btn-success btn-sm" onclick="javascript:excel()">Excel</button>
   

  

  
	<?php 
	if(isset($_GET["fini"])){?>
    
   <button class="btn-sm btn-info" onclick="revaut()">Revisar todos</button>&nbsp;
    
   
   <div class="table-responsive pre-scrollable">
  <table class="table table-striped table-condensed" id="tabla" style="font-size:.9em;">
  <thead>
<tr class="bg-info text-white" ><th>Id</th><th>Solicitante</th><th>Fecha y hora</th><th>Tipo M&oacute;vil</th><th>Estado</th><th>Bandeja</th><th>Opciones</th></tr>
  </thead>
  <tbody>


      <?php
      
      
      $cond=" movil_viajes.bandeja in (1,6) and movil_viajes.fecha between ".$f_ini." and ".$f_fin;
      
      
      if($estado!="") $cond=$cond." and estado=".tsql($estado);
      if($dispositivo>"0") $cond=$cond." and dispositivo=".$dispositivo;
      if($sector>"0") $cond=$cond." and sector=".$sector;


      $via=registros("select movil_viajes.*,case when dispositivo>0 then dispositivos.nombre else denominacion end as solicit ,movil_renglones.nombre_info as tmov, ds ,dispositivos.nombre, movil_bandejas.nombre as nbandeja from movil_viajes 
        left join movil_renglones on tipo_movil=movil_renglones.id  
        left join dispositivos on dispositivo=dispositivos.id 
        left join sectores on sector=sectores.id
        left join fechas on movil_viajes.fecha=fechas.fecha
        left join movil_bandejas on movil_viajes.bandeja=movil_bandejas.id 
        
         where ".$cond." order by solicit, fecha,hora,id");
      while($v=mysqli_fetch_assoc($via)){
          echo "<tr><td>".$v["id"]."</td><td>".
          $v["solicit"]."</td><td>".$v["ds"]." ".substr(ffec($v["fecha"]),0,5)." ".substr($v["hora"],0,5)."</td><td>";
          
          echo $v["tmov"]."</td><td id='e".$v["id"]."'>".
          $v["estado"]."</td><td>".$v["nbandeja"]."</td><td>";


            echo "<button class='btn-sm btn-success' title='ver' onclick='ver(".$v["id"].")'>Ver</button>&nbsp;";
            if($v["bloqueo"]<"2"){
              
           echo "<button class='btn-sm btn-primary' title='editar' onclick='editar(".$v["id"].")'>E</button>&nbsp;";
           };
          echo "<button class='btn-sm btn-info' title='revisar' onclick='rev(".$v["id"].")'>REV</button>&nbsp;";  
          if($v["agrupador"]=="0" && un_campo("select count(*) from movil_viajes where agrupador=".$v["id"])=="0"){
          echo "<button class='btn-sm btn-warning' title='viaje regular' onclick='regular(".$v["id"].")'>REP</button>&nbsp;";
         }
          echo "</td></tr>";
          
     };// del while $v..
  
  ?>
  </tbody></table></div>
  <?php 
}; // del if existen fechas
        ?>
<h8>Ids viajes observados</h8>
<var id="vo"></var>
</div>	
</div></div>

<script> 
  
  
  function ver(id){
        navega("mv_viaje_ver?id="+id);

  }
  function editar(id){
        navega("mv_viaje_edit?id="+id);

  }
  
  function regular(id){
   navega("mv_viaje_regular?id="+id);
  }
  
  function excel(){
    naveganuevo("mv_adm_viajes_excel?fini="+document.getElementById("fini").value+"&ffin="+document.getElementById("ffin").value);
  }
  

  function rev(id){
   resp=eje("val_revisar?id="+id);

   if(resp!="ok"){
    document.getElementById("e"+id).innerHTML=eje('vl_estado?id='+id+'&estado=OBS&texto='+texto);

   } else{
    document.getElementById("e"+id).innerHTML=eje("val_estado?id="+id);

   }
  }
  function revaut(){
  mnsg=""
  tabla=document.getElementById("tabla");
  for(i=1;i<tabla.rows.length;i++){
    id=tabla.rows[i].cells[0].innerHTML;
    estado=tabla.rows[i].cells[4].innerHTML;
    if(estado!="REC" && estado!="APR"){
      revi=eje("val_revisar?id="+id);
      if(revi=="ok"){
          tabla.rows[i].cells[4].innerHTML="OK";}
      else{
        tabla.rows[i].cells[4].innerHTML="NOOK";
        mnsg=mnsg+id+";";}
      
    }
  }
  if(mnsg!="") document.getElementById("vo").innerHTML=mnsg;
}

</script>
