<?php 
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Consulta viajes";
include("encabezado.php");
$cosa=revisa_programados();
$_SESSION["ret_menu"]="mv_vdispo_ver";
$oper=un_registro("select * from movil_procesos where id=".$_SESSION["idproceso"]);
$bl="b1_6";
$lini=$oper["desde_ab"];
if($oper[$bl]>"0") {$lini=$oper["desde_db"];};

$fini=$oper['desde_ab'];
$ffin=$oper['hasta'];

if(isset($_GET['fini'])){
  $fini=$_GET['fini'];
  $ffin=$_GET['ffin'];
}; 

$legajo="0";
if(isset($_GET["legajo"])){
  if($_GET['legajo']>"0") {$legajo=$_GET["legajo"];};
};

$estado="";
if(isset($_GET["estado"])){
  $estado=$_GET["estado"];
};

?>
</div>
<div class="container">
  <?php 
  
    $alojados=registros("select apellidos, nombres, legajo from hogares_admision left join sujetos on admi_legajo=sujetos.legajo where true ".
      si($_SESSION["hogar"]>"0", " and admi_hogar=".$_SESSION["hogar"],"")." and admi_alta is not null and admi_baja is null order by nombres,apellidos");
    $oal="<option value='0'>Todos</option>";
    while($al=mysqli_fetch_assoc($alojados)){
      $oal=$oal."<option value='".$al['legajo']."'>".$al["nombres"]." ".$al["apellidos"]."</option>";
    };?>
    
    
  
  <br><br>
  <form class="form-inline" method="get">
    <div class="row" style='font-size:.90em;'>
	<div class="form-group has-warning col-md-3">
		<label for="fini">Desde el </label>
		<input class="form-control-sm" id="fini" name="fini" required autofocus type="date" value="<?php echo $fini?>">
	</div> 
	<div class="form-group has-warning col-md-3">
		<label class="label-form">Hasta el </label>
		<input class="form-control-sm" type="date" id="ffin" name="ffin" required value="<?php echo $ffin?>">
	</div> 

  <div class="form-group has-warning col-md-4">
    <label class="label-form">Alojados </label>
    <select class="form-control-sm" id="legajo" name="legajo" required value><?php echo $oal?></select>
  </div> 
  <script>seleccionar("legajo","<?php echo $legajo?>")</script>
</div>
</div>
<div class="container">
<div class="row" style='font-size:.90em;'>
  <div class="form-group has-warning col-md-4">
    <label class="label-form">Estado </label>
    <select class="form-control-sm" id="estado" name="estado">
    <option value=''>Todos</option>
    <option value='APR'>Aprobados</option>
    <option value='REC'>Rechazados</option>
    <option value='OBS'>Observados</option>
    <option value='PRO'>Programados</option>
    <option value='BAJ'>Baja</option>
     </select>
  </div>
    <script>seleccionar("estado","<?php echo $estado?>")</script>
   <div class="form-group has-warning col-md-3"> 
    <br>
	<button class="btn-primary btn-sm">Consultar</button>
   </div>
<div class="form-group has-warning col-md-1"> 
  <br><a class="btn-sm form-control bg-success text-white" href="javascript:excel()">Excel</a></div>
</div>
  </form>
  <div class="table-responsive">
	<table class="table table-striped">
	<thead>
   <tr class="dark" style='font-size:.80em;'><th>Fecha y hora</th><th>Pas NNYA</th><th>Destino</th>
<th>Estado</th><th>Opciones</th><th>Obs</th></tr> 
</thead>
  <tbody>
	<?php 

	if(isset($_GET["fini"])){
      $f_ini=str_replace("-","",$_GET["fini"]);
      $f_fin=str_replace("-","",$_GET["ffin"]);
      if($_SESSION['hogar']>"0"){

        $cond=" dispositivo=".$_SESSION["hogar"];}
      else{
        $perf=substr(un_campo("select perfiles.denominacion from usuarios left join perfiles on perfil=perfiles.id where usuarios.id=".$_SESSION["usuario"]),-3);
        
        if($perf=="DO1"){
          $cond=$cond." ( sector=".$_SESSION["sector"]." or ong=-1 and direccion_operativa=1) ";
        }else if($perf=="DO2"){
          $cond=$cond." ( sector=".$_SESSION["sector"]." or ong=-1 and direccion_operativa=2) ";
        }
        else{
          $cond=" sector=".$_SESSION["sector"];
          }
        };

      

      $cond=$cond." and  movil_viajes.fecha between ".$f_ini." and ".$f_fin;
      
      
      if($legajo>"0"){
        $cond=$cond." and movil_viajes.id in (select distinct viaje from movil_pasajeros where tipo_pasajero=1 and legajo=".$legajo.") ";
      };
      if($estado!=''){
         $cond=$cond." and estado=".tsql($estado);
      };
      
	    $via=registros("select movil_viajes.*, ds from movil_viajes 
        left join fechas on movil_viajes.fecha=fechas.fecha 
        left join dispositivos on dispositivo=dispositivos.id 
        left join sectores on sector=sectores.id 
        where ".$cond." order by fecha,hora,id");

      while($v=mysqli_fetch_assoc($via)){
          echo "<tr style='font-size:.80em;'><td>".$v["ds"]." ".substr(ffec($v["fecha"]),0,5)."<br>".substr($v["hora"],0,5)."</td><td>";
          
          $pas=registros("select nombres from movil_pasajeros 
            left join sujetos on movil_pasajeros.legajo=sujetos.legajo 
            where tipo_pasajero=1 and viaje=".$v["id"]);
          $px="";
          while($p=mysqli_fetch_assoc($pas)){
            $px=$px.$p["nombres"]."<br>";
          };
          echo $px."</td><td>".$v["destino_1"];
          $otros=0;
          if($v["destino_2"]!=""){$otros++;};
          if($v["destino_3"]!=""){$otros++;};
          if($v["destino_4"]!=""){$otros++;};
          if($otros>0){ echo " y ".$otros." m&aacute;s";};
         
	       echo  "</td><td id='e".$v["id"]."'>".
          $v["estado"]."</td><td><button class='btn-xs btn-success' title='ver' onclick='ver(".$v["id"].")'>V</button>";
       $salto=0; 
       if( $v["bandeja"]==$_SESSION["bandeja"]  && $v["fecha"]>=$lini){
         echo "&nbsp;<button class='btn-xs btn-primary' title='editar' onclick='editar(".$v["id"].")'>E</button>";
          echo "<button class='btn-xs btn-info' title='revisar' onclick='rev(".$v["id"].")'>RV</button>&nbsp;";  
          echo "<br><button class='btn-xs btn-danger' title='eliminar' onclick='eliminar(".$v["id"].")'>X</button>&nbsp;";
          $salto=1;
         

          
          
         

      
      if($v["agrupador"]=="0" ){
          if($salto==0){echo "<br>";};
          echo "<button class='btn-xs btn-primary' title='viaje regular' onclick='regular(".$v["id"].")'>Rp</button>&nbsp;";
      };
      
     };
     echo "</td><td id='o".$v["id"]."'>".$v["observaciones"]."</td></tr>";
     
    
     
	   };// del while $v..
  
  echo "</tbody></table></div>";
  }
        ?>
	
</div>
<script>
  function eliminar(id){
     
        
        navega("mv_viaje_eliminar?id="+id);
     
  }	
  function editar(id){
        navega("mv_viaje_edit?id="+id);

  }
  function ver(id){
        navega("mv_viaje_ver?id="+id);

  }
  function regular(id){
   navega("mv_viaje_regular?id="+id);
  }

  function excel(){
    naveganuevo("mv_viajes_excel?fini="+document.getElementById("fini").value+"&ffin="+document.getElementById("ffin").value);
  }
   function rev(id){
   resp=eje("val_revisar?id="+id);
   alert(resp);
   if(resp!="ok"){
    document.getElementById("e"+id).innerHTML="OBS";
    document.getElementById("o"+id).innerHTML=resp;
   } else{
    document.getElementById("e"+id).innerHTML=eje("val_estado?id="+id);
    document.getElementById("o"+id).innerHTML="AUTOK";
   }
  }
function certificar(id){
   navega("mv_viaje_certificar?id="+id);
  }

</script>
