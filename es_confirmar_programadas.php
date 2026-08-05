<?php
include("Funciones.php");
session_start();
include("encabezado.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
$idusua=$_SESSION["glidusua"];
if($idusua!=570 && $idusua!=596) {die("sin permiso de acceso");};
?>
</div>
<div class="container">
<hr>
<h4>Confirmar Acciones Programadas</h4>
<button class="btn-sm btn-success" onclick="marcar()">Marcar todas</button>&nbsp;&nbsp;<button class="btn-sm btn-danger" onclick="desmarcar()">Desmarcar todas</button>
<div class='table-responsive'>
<table class='table  table-bordered'>
<thead>
<tr class="bg-primary" style="font-size:.80em"><th>Profesional</th><th>Apellido y Nombre, edad</th><th>Dispositivo</th><th>Fecha y Hora</th><th>Tipo</th><th>Modalidad</th><th>Observaciones</th><th>Opciones</th></tr>
</thead>
<tbody id="tabla">
<?php
   $sql="select es_acciones.*, concat(sujetos.apellidos,', ',sujetos.nombres) as nnya, edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,curdate()) as edadc,
 dispositivos.nombre, concat(apellido,', ',es_profesionales.nombre) as prof,deno 
 from es_acciones
 left join dispositivos on dispositivos.id=dispositivo
 left join sujetos on es_acciones.legajo=sujetos.legajo
 left join es_profesionales on profesional=es_profesionales.id
 left join tablas on tablas.tipo='ESTIA' and tablas.valo=es_acciones.tipo  
 where estado=1 and fecha<=curdate() and year(fecha)>=2025 order by apellido, es_profesionales.nombre, fecha desc";
   $reg =registros($sql);
   $conta=0;
   while ($r = mysqli_fetch_assoc($reg)) {

       $conta=$conta+1;
       $lega=$r['legajo'];
       $apyn=si($lega=="0","",$r["nnya"]." (".$r["edadc"].")");
       echo "<tr style='font-size:.80em'><td>".$r["prof"]."</td><td>".$apyn."</td><td>".$r["nombre"]."</td><td>".ffec($r["fecha"])." ".$r["hora"]."</td><td>".
       $r["deno"]."</td><td>".si($r["modalidad"]=="P","Presencial","Virtual")."</td><td><input class='form-control' id='o".$r["id"]."' value='".$r["observaciones"]."' onblur='observa(".$r["id"].")' size='20' maxlength='100'></td><td>";
       echo "<label class='form-check-label' for='n".$r["id"]."'>Realizada</label><input class='form-check-input' type='checkbox' name='a".$r["id"]."' id='n".$r["id"]."'>";
       echo "&nbsp;&nbsp;<button class='btn-sm btn-danger' onclick='baja(".$r["id"].")'>Baja</button></td></tr>";
     
   };   
?>
</tbody>
</table>
<?php echo $conta . " Acciones a confirmar"?>
</div>
<button class="btn-primary" onclick="procesa()">Confirmar</button>
<script>
function observa(id){
  document.getElementById("o"+id).value=ejec_sq("sq_es_observa?id="+id+"&observaciones="+document.getElementById("o"+id).value);	
}
function procesa(){
  filas=document.getElementById("tabla").rows;
  for(i=0;i<filas.length;i++){
     t=filas[i].cells[6].innerHTML.substr(33,10);
     id="";
     for(j=0;t.substr(j,1)!='"';j++){id=id+t.substr(j,1);};
     obse=document.getElementById("o"+id).value;
     real="0";
     if(document.getElementById("n"+id).checked){
     ejec_sq("es_confirmar_programadas_do?id="+id+"&observaciones="+obse);
     };
  };	
  navega("<?php echo $_SESSION['menu']?>");
}
function marcar(){
 filas=document.getElementById("tabla").rows;
 for(i=0;i<filas.length;i++){
     t=filas[i].cells[6].innerHTML.substr(33,10);
     id="";
     for(j=0;t.substr(j,1)!='"';j++){id=id+t.substr(j,1);};
     document.getElementById("n"+id).checked=true;
 };
}
function desmarcar(){
 filas=document.getElementById("tabla").rows;
 for(i=0;i<filas.length;i++){
     t=filas[i].cells[6].innerHTML.substr(33,10);
     id="";
     for(j=0;t.substr(j,1)!='"';j++){id=id+t.substr(j,1);};
     document.getElementById("n"+id).checked=false;
 };
}
function baja(id){
   if(confirm("Confirmas que das de baja la accion?")){
	naveganuevo("es_accion_elimina?id="+id);
   };	
}

</script>
</body>

</html>