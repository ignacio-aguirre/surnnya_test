<?php 
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Viajes proceso diario consolidados";
include("encabezado.php");
$cosa=revisa_programados();
$_SESSION["ret_menu"]="mv_viajes_bloqueados";
$bandeja=$_SESSION["bandeja"];
$oper=un_registro("select * from movil_procesos where id=".$_SESSION["idproceso"]);
      
      $fini=fsql(ffec($oper["desde_ab"]));
      $ffin=fsql(ffec($oper["hasta"]));
if($oper["b2_6"]=="0"){
  $idproceso=un_campo("select max(id) from movil_procesos where b2_6>0");
  $oper=un_registro("select * from movil_procesos where id=".$idproceso);
      $fini=fsql(ffec($oper["desde_ab"]));
      $ffin=fsql(ffec($oper["hasta"]));
}


$dispositivo=$_SESSION["hogar"];
$sector="0";
if($dispositivo=="0"){
  $sector=$_SESSION["sector"];
  $dispositivo="0";
};



?>

</div>
<br><br>
<div class="container">
  <div class="row">
  
  <div class="table-responsive pre-scrollable">
	<table class="table table-striped">
	<thead>
     
<tr class="bg-success" ><th>Id</th><th>Solicitante</th><th>Fecha y hora</th><th>Tipo M&oacute;vil</th><th>Empresa</th><th>Estado</th><th>Bandeja</th><th>Opciones</th><th>Observaciones</th></tr>
  </thead>
  <tbody>


      <?php
      
      
      $cond=" movil_viajes.bandeja =7  and movil_viajes.fecha between ".$fini." and ".$ffin;
            
      

      $via=registros("select movil_viajes.*,case when dispositivo>0 then dispositivos.nombre else denominacion end as solicit ,movil_renglones.nombre_info as tmov,etra.deno as empre, ds ,dispositivos.nombre from movil_viajes 
        left join movil_renglones on tipo_movil=movil_renglones.id  
        left join dispositivos on dispositivo=dispositivos.id 
        left join sectores on sector=sectores.id
        left join fechas on movil_viajes.fecha=fechas.fecha
        left join tablas etra on etra.tipo='ETRA' and etra.valo=movil_viajes.empresa 
         where ".$cond." order by solicit, fecha,hora,id");
      while($v=mysqli_fetch_assoc($via)){
          echo "<tr><td>".$v["id"]."</td><td>".
          $v["solicit"]."</td><td>".$v["ds"]." ".ffec($v["fecha"])." ".substr($v["hora"],0,5)."</td><td>";
          
          echo $v["tmov"]."</td><td>".$v["empre"]."</td><td id='e".$v["id"]."'>".
          $v["estado"]."</td><td>".$v["bandeja"]."</td><td>";


            echo "<button class='btn-xs btn-success' title='ver' onclick='ver(".$v["id"].")'>Ver</button>&nbsp;";
           if($v["estado"]=="APR"){ 
           echo "<button class='btn-xs btn-danger' title='cancelar' onclick='cancelar(".$v["id"].")'>Cancelar</button>&nbsp;";
           };
          
          echo "</td><td id='o".$v["id"]."''>".$v["observaciones"]."</td></tr>";
     };// del while $v..
  
  
  echo "</tbody></table></div>";

        ?>
	
</div>

<script>
  
  
  function ver(id){
        navega("mv_viaje_ver?id="+id);

  }
  function cancelar(id){
        if(confirm("Cancelar viaje "+id+"?")){
        navega("mv_viaje_cancelar?id="+id);
      }
      return true;
  }

  
  
</script>
