<?php
include("Funciones.php"); 
session_start();
$_SESSION["prestacion"]="Datos inclusi&oacute;n PAE";
include("encabezado.php");
$id=$_GET["id"];
$r=un_registro("select pae_nomina.*,concat(apellidos,', ',nombres) as apyn,edadcalc(f_nacimiento,sujetosEdad,SujetosMeses,SujetosActEdad,curdate()) as edad_calc,
apellidos,nombres,sujetosdni,cuil,f_nacimiento,rib_anio,rib_numero,rib_reparticion,paises.descripcion,telefonos,email from pae_nomina left join sujetos on pae_nomina.legajo=sujetos.legajo 
left join paises on sujetos.nacionalidad=idpaises where pae_nomina.id=".$id);
$p=un_registro("select * from sujetos_pae where legajo=".$r["legajo"]);
?>
</div>
<div class="container">
<h4>Inclusi&oacute;n en PAE de <?php echo $r["apyn"];?> Legajo <?php echo $r["legajo"];?> <a href='suje_cons_pae?legajo=<?php echo $r["legajo"]?>'>Ver m&aacute;s datos</a></h4>
<div class="row">
  <div class="col-md-2">Acci&oacute;n <strong><?php echo $r["accion_amb"]?></strong></div>
<?php if($r["accion_amb"]=="ALTA"){?>
<div class="col-md-3">Fecha firma consentimiento informado <strong><?php echo ffec($r["f_cons_inf"])?></strong></div>
<?php }else{?>
<div class="col-md-3">Fecha baja <strong><?php echo ffec($r["f_baja"])?></strong></div>
<?php }?>
</div>
<br>
<div class="row">
<div class="col-md-2">Etapa <strong><?php echo $r["etapa"]?></strong></div>
<div class="col-md-3">Fecha cambio de etapa <strong><?php echo ffec($r["f_cambio_etapa"])?></strong></div>
<?php if($r["accion_amb"]=="ALTA"){?>
<div class="col-md-2"><button class="btn-sm btn-success" onclick="cambia_etapa(<?php echo $id?>)">Cambiar</div>
<div class="col-md-2"><button class="btn-sm btn-primary" onclick="historial_cambios(<?php echo $id?>)">Historial</div>
<div class="col-md-2"><button class="btn-sm btn-danger" onclick="baja(<?php echo $id?>)">Baja</div>
<?php 
};
if($r["etapa"]=="2"){?>
  <div class="col-md-2"><button class="btn-sm btn-info" onclick="rua(<?php echo $r['legajo']?>)">RUA</div>
<?php };?>

</div>
<br>
<div class="row">
<div class="col-md-2">Jurisdicci&oacute;n <strong><?php echo $r["juris_responsable"]?></strong></div>
<div class="col-md-3">RIB <strong><?php echo rib2($r)?></strong></div>
<div class="col-md-6">Apellidos <strong><?php echo $r["apellidos"]?></strong> / Nombres <strong><?php echo $r["nombres"]?></strong></div>
</div>
<br>
<div class="row">
<div class="col-md-2">DNI <strong><?php echo $r["sujetosdni"]?></strong></div>
<div class="col-md-3">CUIL <strong><?php echo cuil($r["cuil"])?></strong></div>
<div class="col-md-6">Fecha nacimiento <strong><?php echo ffec($r["f_nacimiento"])?></strong> / Edad <strong><?php echo $r["edad_calc"]?></strong></div>
</div>
<div class="row">
<div class="col-md-2">Tel&eacute;fono <strong><?php echo $r["telefonos"]?></strong></div>
<div class="col-md-3">Email <strong><?php echo $r["email"]?></strong></div>
<div class="col-md-2"><button class="btn-sm btn-primary" onclick="vivienda(<?php echo $r['legajo']?>)">Vivienda</div>
<?php
  $hogar=un_registro("select nombre, tipo_dispositivo from hogares_admision left join dispositivos on admi_hogar=dispositivos.id where admi_legajo=".$r["legajo"]." and admi_alta is not null and admi_baja is null");
  if($hogar["nombre"]!=""){?>
   <div class="col-md-4">Alojado/a en <strong><?php echo $hogar["nombre"]?></strong></div>
  <?php }
  else{?>
<div class="col-md-2"><button class="btn-sm btn-success" onclick="alta(<?php echo $r['legajo']?>)">Ingreso a Dispositivo</div>
<?php };
?>
</div>

<br>
<form class="form-inline" action="pae_ver_do" method="post" onsubmit="return valida()">
  <div class="row">
	<div class="form-group has-warning">
	   <label class="label-form">Observaciones</label>
	   <textarea class="form-control" name="observaciones" id="observaciones" cols="80" rows="4">
	    </textarea>	
        </div>
  </div>	
  
  <input hidden name="id" value="<?php echo $id?>">
  <button class="btn btn-success">Actualizar</button>
</form>

</div>



<script type="text/javascript">
document.getElementById("observaciones").innerHTML="<?php echo trim($r["observaciones"])?>";

function cambia_etapa(id){
navega("pae_nomina_cambio?id="+id);
}

function historial_cambios(id){
navega("pae_nomina_historia?id="+id);
}

function baja(id){
navega("pae_baja?id="+id);
}

function valida(){

   return true;
}


function vivienda(lg){
  navega("suje_cons_vivienda?legajo="+lg);
}

function alta(lg){
  navega("alpre_ingreso?legajo="+lg);
}

function rua(lg){
  navega("rua_nuevo?legajo="+lg);
}

</script>
</body>
</html>