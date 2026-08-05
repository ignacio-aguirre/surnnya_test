<?php
include("Funciones.php");
session_start();
include("encabezado.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
$id=$_GET["id"];
$profe=nulea(un_campo("select id from es_profesionales where usuario=".$_SESSION["glidusua"]));
$retorno=nget("retorno");
$r=un_registro("select * from es_participaciones where id=".$id);
$profe=$r["profesional"];
$a=un_registro("select * from es_acciones where solicitud=".$id." order by fecha desc, id desc limit 1");
$ult_dispositivo=$a["dispositivo"];
if($ult_dispositivo==""){$ult_dispositivo=$r["solicitante"];};
$ndispo=un_campo("select nombre from dispositivos where dispositivos.id=".$ult_dispositivo);
$ult_tipo=un_campo("select tipo from es_acciones where alcance=1 and solicitud=".$id." order by fecha desc, id desc limit 1");
?>
</div>
<div class="container">
 <div class="row">
   <div class="col-md-4">
	Fecha Solicitud <strong> <?php echo ffec($r["fecha_ingreso"])?></strong>
   </div>
   <div class="col-md-4">
	Tipo de Acci&oacute;n Solicitada <strong> <?php echo si($r["alcance"]=="1","Intervenci&oacute;n","Institucional")?></strong>
   </div>
   <div class="col-md-4">
	Dispositivo <strong> <?php echo si($r["solicitante"]=="-1",$r["solicitante_especificar"],$ndispo)?></strong>
   </div>

 </div>
 <div class="row">
   <div class="col-md-4">
	Profesi&oacute;n <strong> <?php echo un_campo("select deno from tablas where tipo='ESESP' and valo=".$r["especialidad"]);?></strong>
   </div>
   <div class="col-md-4"><strong>
     <?php
      if($r["legajo"]>0){
        echo "NNYA ".un_campo("select concat(apellidos,', ',nombres) from sujetos where legajo=".$r["legajo"]);
      }else{
      echo "No asociada a un NNYA";};
      ?></strong>
   </div>
   <div class="col-md-4">
	Fecha Ult.Atenci&oacute;n <strong> <?php echo ffec($a["fecha"]);?></strong>
   </div>

 </div>
 <h4>Programar pr&oacute;xima atenci&oacute;n</h4>
 <form class="form-inline" method="get" action="es_solicitud_programar_do" onsubmit="return valida()">
  <div class="form-group has-warning">
	<label class="label-form has-warning">Fecha</label>
	<input class="form-control" name="fecha_programada" id="fecha_programada" type="date" value="<?php echo ff($_SESSION['DiaHoy'])?>" min="<?php echo ff($_SESSION['DiaHoy'])?>" required autofocus>
  </div>
  <div class="form-group has-warning">
	<label class="label-form has-warning">Hora</label>
	<input class="form-control" name="hora_programada" id="hora_programada" value="<?php echo substr(un_campo('select curtime() from dual'),0,5)?>" type="time" required>
  </div>
  <div class="form-group has-warning">
	<label class="label-form has-warning">Modalidad</label>
	<select class="form-control" name="modalidad_programada" id="modalidad_programada" required>
          <option value='P'>Presencial</option>
          <option value='V'>Virtual</option>
        </select>
  </div>
  <div class="form-group has-warning">
	<label class="label-form has-warning">Tipo de Respuesta</label>
	<?php echo select_tabla("tipo","ESTIA",true,true)?>
        <script>seleccionar("tipo","<?php echo $ult_tipo?>")</script> 
  </div><br><br>
  <div class="form-group has-warning">
	  <label class="label-form">Dispositivo</label>
	  <select id="dispositivo" name="dispositivo" class="form-control" required>
          <option value=""></option>
		<?php echo $_SESSION['Opc_Hoga']?>
          <option value="-1">--Otros</option>
          </select>
	  <script>seleccionar("dispositivo","<?php echo $ult_dispositivo?>")</script>
 </div><br><br>
   <h4>Profesional(es)</h4>
   <div class="table-responsive">
     <table class="table table-condensed">
     <tr class="bg-primary"><th>Apellido y Nombre</th><th>Profesi&oacute;n</th><th>Seleccionar</th><th>Ver Calendario</th></tr>
     <?php
       if($retorno=="mias") {
       }
       else{
       $pro=registros("select es_profesionales.*, prof.deno as profes from es_profesionales left join tablas prof on prof.tipo='ESESP' and prof.valo=profesion 
 where es_profesionales.baja is null and profesion=".$r["especialidad"]." order by prof.deno, apellido, nombre");
       while($p=mysqli_fetch_assoc($pro)){
         echo "<tr><td>".$p["apellido"].", ".$p["nombre"]."</td><td>".$p["profes"]."</td><td><input class='form_control' id='p".$p["id"]."' name='p".$p["id"]."' type='checkbox' ".si($p["id"]==$profe,"checked ","").
  "</td><td><btn class='btn-sm btn-info' onclick='calendario(".$p["id"].")'>Ver</btn></td></tr>";
       };
       $pro=registros("select es_profesionales.*, prof.deno as profes from es_profesionales left join tablas prof on prof.tipo='ESESP' and prof.valo=profesion 
 where es_profesionales.baja is null and profesion<>".$r["especialidad"]." order by prof.deno, apellido, nombre");
       while($p=mysqli_fetch_assoc($pro)){
         echo "<tr><td>".$p["apellido"].", ".$p["nombre"]."</td><td>".$p["profes"]."</td><td><input class='form_control' id='p".$p["id"]."'  name='p".$p["id"]."' type='checkbox' ".si($p["id"]==$profe,"checked ","").
  "</td><td><btn class='btn-sm btn-info' onclick='calendario(".$p["id"].")'>Ver</btn></td></tr>";
       };
       };
     ?>
     </table>
   </div>
  <input hidden name="id" value="<?php echo $id?>">
  <input hidden name="retorno" value="<?php echo $retorno?>">
  <button class="btn-success">Programar</button>
  </form>
</div>
<script>
function valida(){
 if(!verifica_disponibilidad()){return false;};
 return true; 
}
function verifica_disponibilidad(){
  legajo="<?php echo $r["legajo"]?>";
  fecha=document.getElementById("fecha_programada").value;
  if(fecha==""){status("Fecha programada es obligatoria"); return false;};
  hora=document.getElementById("hora_programada").value;
  if(hora==""){status("Hora programada es obligatoria"); return false;};
  cadena="";
  for(i=1;i<=10000;i++){
    if(document.getElementById("p"+i)!=null ){
      if(document.getElementById("p"+i).checked){
       resp=ejec_sq("sq_veri_dispo?fecha="+fecha+"&hora="+hora+"&profesional="+i+"&legajo="+legajo);
       cadena=cadena+resp;
       };	
      };	
   };
   if("<?php echo $retorno?>"=="mias"){
     cadena=cadena+ejec_sq("sq_veri_dispo?fecha="+fecha+"&hora="+hora+"&profesional=<?php echo $prof?>"&legajo="+legajo);
   }; 
   if(cadena!=""){status("Conflicto en calendario de "+cadena);return false;}; 
  status("");
  return true; 
}
function calendario(id){
 f=document.getElementById("fecha_programada").value;
 anio=f.substring(0,4);
 mes=f.substring(5,7);
 naveganuevo("es_calendario?prof="+id+"&anio="+anio+"&mes="+parseInt(mes));
};
</script>
</body>
<?php
function ff($f){
 $f2=substr($f,-4)."-".substr($f,3,2)."-".substr($f,0,2);
 return $f2;
}
?>
</html>