<?php
session_start();
require("funciones.php"); 
$_SESSION["prestacion"]="Programar nuevo viaje";
include("encabezado.php");
$oper=un_registro("select * from movil_procesos where id=".$_SESSION['idproceso']);  
  $bl="b1_6";
  $ffin=un_campo("select date_add(curdate(),INTERVAL 30 day) from dual");
  $fini=$oper["desde_ab"];
  if($oper[$bl]>"0" && $_SESSION["perfil_moviles"]=="1") {$fini=$oper["desde_db"];}
  $bloqueado="0";
  $recreativo="0";
if(isset($_GET["bloqueado"]) && $_SESSION["perfil_moviles"]=="1"){
  $fini=un_campo("select curdate() from dual");
  if($oper[$bl]>"0"){
    $ffin=$oper["hasta"];
  } else{
    $ffin=un_campo("select date_add(desde_ab,INTERVAL -1 day) from movil_procesos where id=".$_SESSION["idproceso"]);
  } 
  $bloqueado="1";
}
if(isset($_GET["recreacion"]) && $_SESSION["perfil_moviles"]=="1"){
  $fini=$oper["desde_db"];

  $ffin=un_campo("select date_add(curdate(), interval 30 day) as ffin from dual");
  
  $bloqueado="1";
  $recreativo="1";
}
$administrador="0";
if(isset($_GET["adm"])){$administrador="1";};

$dispositivo=$_SESSION["hogar"];
$opc_renglones=registros("select * from movil_renglones order by id");

if($dispositivo>"0"){
    $sede=estandariza_dom(un_campo("select domicilio from movil_domicilios where referencia='Sede' and dispositivo=".$dispositivo));
    $empresa=un_campo("select transporte from dispositivos where id=".$dispositivo);    
  }
 else{   

     $dispositivo=$_SESSION["sector"];

     $sede=estandariza_dom(un_campo("select domicilio from movil_domicilios where referencia='Sede' and sector=".$dispositivo));
     $empresa=un_campo("select transporte from sectores where id=".$dispositivo);    
   };
     
$bandeja=$_SESSION["bandeja"];

?>

</div>
<script>
var ventana;
var minpasajeros=0; 
var maxpasajeros=0;

function cdi(){
  distancias();
  cespba();
}

function cespba(){
    espba="NO";
    dire=document.getElementById("partida").value;
    if(dire!=""){
     if(dire.indexOf("CABA")==-1){espba="SI";};
    }
    dire=document.getElementById("destino_1").value;
    if(dire!=""){
     if(dire.indexOf("CABA")==-1){espba="SI";};
    } 
    dire=document.getElementById("destino_2").value;
    if(dire!=""){
     if(dire.indexOf("CABA")==-1){espba="SI";};
    } 
    dire=document.getElementById("destino_3").value;
    if(dire!=""){
     if(dire.indexOf("CABA")==-1){espba="SI";};
    } 
    dire=document.getElementById("destino_4").value;
    if(dire!=""){
     if(dire.indexOf("CABA")==-1){espba="SI";};
    } 
    document.getElementById("pba").disabled=false;
    document.getElementById("pba").value=espba;
    document.getElementById("pba").disabled=true;
    if(espba=="SI"){
      seleccionar("tipo",7);
    }
    else {
      seleccionar("tipo","");
    };
    

}

function distancias(){
   if(false){
    kmt=0;
    document.getElementById('dom_partida').innerHTML=document.getElementById("partida").value;
    document.getElementById('lat_partida').innerHTML="";
    document.getElementById('lon_partida').innerHTML="";
    document.getElementById('des_1').innerHTML=document.getElementById("destino_1").value;
    document.getElementById('lat_d1').innerHTML="";
    document.getElementById('lon_d1').innerHTML="";
    document.getElementById('dis1').innerHTML="";
    document.getElementById('des_2').innerHTML=document.getElementById("destino_2").value;
    document.getElementById('lat_d2').innerHTML="";
    document.getElementById('lon_d2').innerHTML="";
    document.getElementById('dis2').innerHTML="";
    document.getElementById('des_3').innerHTML=document.getElementById("destino_3").value;
    document.getElementById('lat_d3').innerHTML="";
    document.getElementById('lon_d3').innerHTML="";
    document.getElementById('dis3').innerHTML="";
    document.getElementById('des_4').innerHTML=document.getElementById("destino_4").value;
    document.getElementById('lat_d4').innerHTML="";
    document.getElementById('lon_d4').innerHTML="";
    document.getElementById('dis4').innerHTML="";
    

    dire=document.getElementById("partida").value;
    if(dire!=""){
        latlon=eje("val_direccion_latlon?t="+dire);
        if(latlon!=""){
        ppc=latlon.indexOf(";");
        document.getElementById('lat_partida').innerHTML=latlon.substr(0,ppc);
        document.getElementById('lon_partida').innerHTML=latlon.substr(ppc+1);
        }
        dire=document.getElementById("destino_1").value;
        if(dire!=""){
          latlon=eje("val_direccion_latlon?t="+dire);
          if(latlon!=""){
            ppc=latlon.indexOf(";");
            document.getElementById('lat_d1').innerHTML=latlon.substr(0,ppc);
            document.getElementById('lon_d1').innerHTML=latlon.substr(ppc+1);
            km=eje("val_distancia_km?lat1="+
            document.getElementById('lat_partida').innerHTML+
            "&lon1="+document.getElementById('lon_partida').innerHTML+
            "&lat2="+document.getElementById('lat_d1').innerHTML+
            "&lon2="+document.getElementById('lon_d1').innerHTML);
            document.getElementById('dis1').innerHTML=km;
            kmt=kmt+parseFloat(km);
          }  
          dire=document.getElementById("destino_2").value;
          if(dire!=""){
            latlon=eje("val_direccion_latlon?t="+dire);
            if(latlon!=""){
              ppc=latlon.indexOf(";");
              document.getElementById('lat_d2').innerHTML=latlon.substr(0,ppc);
              document.getElementById('lon_d2').innerHTML=latlon.substr(ppc+1);
              km=eje("val_distancia_km?lat1="+
              document.getElementById('lat_d1').innerHTML+
              "&lon1="+document.getElementById('lon_d1').innerHTML+
              "&lat2="+document.getElementById('lat_d2').innerHTML+
              "&lon2="+document.getElementById('lon_d2').innerHTML);
              document.getElementById('dis2').innerHTML=km;
              kmt=kmt+parseFloat(km);
            }  
            dire=document.getElementById("destino_3").value;
            if(dire!=""){
              latlon=eje("val_direccion_latlon?t="+dire);
              if(latlon!=""){
                ppc=latlon.indexOf(";");
                document.getElementById('lat_d3').innerHTML=latlon.substr(0,ppc);
                document.getElementById('lon_d3').innerHTML=latlon.substr(ppc+1);
                km=eje("val_distancia_km?lat1="+
                document.getElementById('lat_d2').innerHTML+
                "lon1="+document.getElementById('lon_d2').innerHTML+
                "&lat2="+document.getElementById('lat_d3').innerHTML+
                "&lon2="+document.getElementById('lon_d3').innerHTML);
                document.getElementById('dis3').innerHTML=km;
                kmt=kmt+parseFloat(km);
              } 
              dire=document.getElementById("destino_4").value;
              if(dire!=""){
                latlon=eje("val_direccion_latlon?t="+dire);
                if(latlon!=""){
                  ppc=latlon.indexOf(";");
                  document.getElementById('lat_d4').innerHTML=latlon.substr(0,ppc);
                  document.getElementById('lon_d4').innerHTML=latlon.substr(ppc+1);
                  km=eje("val_distancia_km?lat1="+
                  document.getElementById('lat_d3').innerHTML+
                  "&lon1="+document.getElementById('lon_d3').innerHTML+
                  "&lat="+document.getElementById('lat_d4').innerHTML+
                  "&lon2="+document.getElementById('lon_d4').innerHTML);
                  document.getElementById('dis4').innerHTML=km;
                  kmt=kmt+parseFloat(km);
                }  
              }
            } 
          } 
        }
    } 
   document.getElementById("dis_calc").value=Math.ceil(kmt,2);
 };
   return true;
  }

function seleccion(){
  ore=document.getElementById("respuesta");
  t=ore.value;
  dino=eje("val_direccion?id="+t);
  const coldir=document.getElementsByClassName("dir");
  for(i=0;i<coldir.length;i++){
    if (coldir[i].value==dino){
      status("destino repetido");
      //break;
    };  
    if (coldir[i].value==""){
      coldir[i].value=dino;

      softstatus("");
      document.getElementById("entrada").value="";
      document.getElementById("entrada").focus();
      break;
    };
  };
  ore.options.length=0;
  
}

function domi(){
	
    t=document.getElementById("entrada").value;
    if(t!=""){
        
        resp=eje("val_domicilios?t="+t);
        document.getElementById("respuesta").innerHTML=resp;
        
       
        if(document.getElementById("respuesta").options.length==0){
            window.open("mv_domicilio_nuevo?texto="+t);

        }
        else if (document.getElementById("respuesta").options.length==1) {
          document.getElementById("entrada").value="";
        	seleccion();
          
        }
      }
      
}

function domi_alma(){
		
    t=document.getElementById("entrada").value;
    if(t!=""){
        resp=eje("val_domicilios_almacenados?t="+t);
        document.getElementById("respuesta").innerHTML=resp;
        if(document.getElementById("respuesta").options.length==0){
            domi();

        }
        else if (document.getElementById("respuesta").options.length==1) {
        	seleccion();
          
        }
    }
    
}

function foco_res(){
  if(document.getElementById("entrada").value=="") {
    cdi();
    document.getElementById("dis_total").focus();
  }
}

function valida_formulario(){
 if(!bl_renglon()) {return false;}
 dista=document.getElementById("dis_total").value;
 if(dista==""){
  status("distancia km");return false;
 }
 dista=parseInt(dista);

 v_tipo=document.getElementById("tipo").value;
 rng=JSON.parse(eje("val_renglon?renglon="+v_tipo));
 minpasajeros=rng.capacidad_min;
 maxpasajeros=rng.capacidad_max;
 
 if(rng.distancia_maxima<dista && rng.distancia_maxima>0){
    status("distancia mayor a "+rng.distancia_maxima);
    return false;
 }
 if(rng.distancia_minima>dista && rng.distancia_minima>0){
    status("distancia menor a "+rng.distancia_minima);
    return false;
 }
 
 document.getElementById("renglon").value=rng.id;

  // hora salida
  hora=document.getElementById("hora").value;
  hor=izq(hora,2);
  min=der(hora,2);
  if(hor>"23" || hor<"00") {
    status("hora incorrecta");
    return false;
  };
  if(min<"00"|| min>"59"){
    status("hora incorrecta minutos");
    return false;
  };
  // recorrido
  partida=document.getElementById("partida").value;
  
  destino_1=document.getElementById("destino_1").value;
  destino_2=document.getElementById("destino_2").value;
  destino_3=document.getElementById("destino_3").value;
  destino_4=document.getElementById("destino_4").value;
  ex_p=eje("val_domicilio_existente?t="+partida);
  ex_1=eje("val_domicilio_existente?t="+destino_1);
  ex_2="0";
  ex_3="0";
  ex_4="0";
  if(ex_p=="0"){status("partida");return false;};
  if(ex_1=="0"){status("destino 1");return false;};
  
  if(destino_2!=""){ex_2=eje("val_domicilio_existente?t="+destino_2);
    if(ex_2=="0"){status("destino 2");return false;};
  };
  if(destino_3!=""){ex_3=eje("val_domicilio_existente?t="+destino_3);
    if(ex_3=="0"){status("destino 3");return false;};
  };
  if(destino_4!=""){ex_4=eje("val_domicilio_existente?t="+destino_4);
    if(ex_4=="0"){status("destino 4");return false;};
  
  };
  
  if(destino_2==""){
    if(destino_3!=""||destino_4!=""){
      status("destinos");return false;  
    }
  } 

  if(destino_3==""){
    if(destino_4!=""){
      status("destinos");return false;
    }
  }
  ultimo_destino=destino_4;
  if(ultimo_destino=="") ultimo_destino=destino_3;
  if(ultimo_destino=="") ultimo_destino=destino_2;
  if(ultimo_destino=="") ultimo_destino=destino_1;
  if(ultimo_destino==partida && (rng.id==4 || rng.id==6)){
    status("destino final no puede ser =partida en rem CABA I/V");
    return false;
  }
  recuento();
 
  // debe haber por lo menos un alojado como pasajero
  td="d";
  if("<?php echo $dispositivo?>"=="<?php echo $_SESSION['sector']?>"){td="s";}
  
  palo=parseInt(document.getElementById("pasajeros_alojados").value);

  if( palo==0 && td=="d"){ status("sin alojados");    return false;};
  
  // debe haber por lo menos un acompaniante
  paco=parseInt(document.getElementById("pasajeros_acompaniantes").value);
  if(paco==0){ status("sin acompa&ntilde;antes");    return false;};
  pax=palo+paco;
  
  
  if(pax>maxpasajeros && rng.tipo==1){status("# pasajeros "+pax+" excede capacidad "+maxpasajeros); return false;};
  if(pax<minpasajeros && rng.tipo==1){status("# pasajeros "+pax+" menor a capacidad "+minpasajeros); return false;};
 status("");
 document.getElementById("pasajeros_alojados").readonly=false; 
 document.getElementById("pasajeros_acompaniantes").readonly=false; 
 document.getElementById("empresa").disabled=false; 
 document.getElementById("b10_km").readonly=false; 
 document.getElementById("hora_adicional").disabled=false; 
 document.getElementById("minutos_adicionales").disabled=false;


 return true;
} 



</script>
</div>
<br><br>
  
<div class="container">
<?php if($recreativo=="1"){
   echo "<p class='danger-text'>Modo viajes recreativos futuros</p>";
  }else if($bloqueado=="1"){
    echo "<p class='danger-text'>Modo agregar viajes luego del bloqueo</p>";
  }
?>
     <form class="form-inline" method="get" onsubmit="return valida_formulario()" action="mv_programar_do">
      <input hidden id="renglon">
      <input name="bloqueado" hidden value="<?php echo $bloqueado?>">
      <input name="recreativo" hidden value="<?php echo $recreativo?>">
      <input name="administrador" hidden value="<?php echo $administrador?>">
  <div class="row">
   <div class="form-group has-warning col-md-3"> 
    <label class="label-form">Fecha del viaje</label>
   <input name="fecha" id="fecha" value="<?php echo $fini?>" type="date" min="<?php echo $fini?>" max="<?php echo $ffin?>" autofocus required class="form-control"></div>
   <div class="form-group has-warning col-md-2">
      <label class="label-form">Hora partida<br></label>
      <input type="time" class="form-control" min="00:00" max="23:59"  name="hora" id="hora" value="07:00" required>
    </div>
    
		 <div class="form-group has-warning col-md-3">
          <label for="motivo_recurso" class="label-form">Motivo del recurso</label>
          <select class="form-control" id="motivo_recurso" name="motivo_recurso" required>
          <?php if($recreativo=="0"){
          echo "<option value=''>Completar</option>";
          echo opc_tabla("MVMT");
         } else{echo "<option value=4>Recreación</option>";}

           ?>
         
          
          </select>
    </div>
    <div class="form-group has-warning col-md-3">
          <label for="tipo_tipo" class="label-form">Tipo Veh&iacute;culo&nbsp;</label>
          <select class="form-control" id="tipo_tipo" name="tipo_tipo" required onblur="bl_tipo_tipo()">
            <?php if($recreativo=="0"){?>
           <option value="1">Remise</option><?php }?>
           <option value="2">Combi/Minibus</option> 
          </select>
    </div>  
  </div>
</div>
<div class="container">
  <div class="row">
  
    <div class="form-group col-md-4 has-warning">
      <label class="label-form">B&uacute;squeda</label>
      <input id="entrada" class="form-control" size="30" maxlength="70" onchange="domi_alma()" onblur="domi_alma()" autocomplete="off" >
    </div>  

    <div class="form-group col-md-8 has-warning">
        <label class="label-form">&nbsp;Resultados</label><br>
        <select id="respuesta" name="respuesta" class="form-control" onfocus="foco_res()">
        </select><br>
        <a class="btn-sm btn-primary" href="javascript:seleccion()">Seleccionar</a>&nbsp; 
      <a class="btn-sm btn-primary" href="javascript:domi()">+</a>
     </div>
    <br><br>
  </div>

  <div class="row"> 
    <div class="form-group has-warning col-md-4">
      <label class="label-form">Partida<br></label>
        <input class="form-control dir" size="30" maxlength="70" id="partida" name="partida" required value="<?php echo $sede?>"  ondblclick="limpia(this.id)" autocomplete="off" >
    </div>
    <div class="form-group has-warning col-md-4">
		<label class="label-form">Destino 1</label><br>
		<input class="form-control dir" id="destino_1"  name="destino_1" size="40" maxlength="70"  ondblclick="limpia(this.id)" autocomplete="off"  required>
		</div> 
		<div class="form-group has-warning col-md-4">
		<label class="label-form">Destino 2</label><br>
		<input class="form-control dir" id="destino_2"  name="destino_2" size="30" maxlength= "70" autocomplete="off" ondblclick="limpia(this.id)" >
	</div>
</div>
<br><br>
<div class="row">
	<div class="form-group has-warning col-md-6">
		<label class="label-form">Destino 3</label>
		<input class="form-control dir" id="destino_3"  name="destino_3" size="40" maxlength= "70"  autocomplete="off" ondblclick="limpia(this.id)">
	
	</div>
	<div class="form-group has-warning col-md-6">
		<label class="label-form">Destino 4</label>
		<input class="form-control dir" id="destino_4"  name="destino_4" size="40" maxlength= "70" autocomplete="off" ondblclick="limpia(this.id)" >
	
	</div>
</div>
<?php if(false){?>
<div class="table-responsive">
      <table  class="table table-borderless" id="tdista" onfocus()="distancias()">
        <thead class="table-success">
          <tr><th>Tipo</th><th>Direcci&oacute;n</th><th>Latitud</th><th>Longitud</th><th>Km aproximados</th></tr>
        </thead>
        <tbody id="">
          <tr><td>Partida</td><td id='dom_partida'></td><td id='lat_partida'></td><td id='lon_partida'></td><td></td></tr>
        
        
          <tr><td>Destino 1</td><td id='des_1'></td><td id='lat_d1'></td><td id='lon_d1'></td><td id='dis1'></td></tr>
          <tr><td>Destino 2</td><td id='des_2'></td><td id='lat_d2'></td><td id='lon_d2'></td><td id='dis2'></td></tr>
          <tr><td>Destino 3</td><td id='des_3'></td><td id='lat_d3'></td><td id='lon_d3'></td><td id='dis3'></td></tr>
          <tr><td>Destino 4</td><td id='des_4'></td><td id='lat_d4'></td><td id='lon_d4'></td><td id='dis4'></td></tr>
        </tbody>
      </table>
      
      
  </div>      

      <br>
    <?php }?>
  <div class="row">     

   <!--div class="form-group has-warning col-md-2">
      <label class="label-form">Km Referencia</label>
      <input class="form-control" name="dis_calc" id="dis_calc" readonly>
   </div> 
   <div class="form-group has-warning col-md-10">
    <p class="text-primary">La distancia de referencia nunca ser&aacute; exacta. Es responsabilidad del solicitante calcularla.</p>
   </div>
    
  </div>      
      <br><br>
  <div class="row"-->    
   <div class="form-group has-warning col-md-2">
      <label class="label-form">Distancia km</label>
      <input class="form-control" onfocus="cespba()" name="dis_total" id="dis_total" onblur="bl_distotal()" required>
   </div> 
   <div class="form-group has-warning col-md-1">
      <label class="label-form">PBA</label>
      <input class="form-control" name="pba" id="pba" disabled>
   </div> 

  <div class="form-group has-warning col-md-4">
      <label class="label-form" for="tipo">Rengl&oacute;n</label>
      <select class="form-control" id="tipo"  name="tipo_movil" onblur="bl_renglon()" required>
               <option value="">Completar</option>
        <?php
          $opc=$opc_renglones;
          while($o=mysqli_fetch_assoc($opc)){
          echo "<option value='".$o["id"]."'>".$o["nombre_info"]."</option>";
          
        };
         ?>
      </select>
    </div>
    <div class="form-group has-warning col-md-2">
          <label class="label-form">R7 x 10 km</label>
          <input class="form-control" id="b10_km" name="b10_km" readonly>
    </div>
    <div class="form-group has-warning col-md-3">
      <label class="label-form">Empresa</label>
      <select class="form-control" id="empresa" name="empresa" disabled>
        <?php
        $opc=registros("select valo,deno from tablas where tipo='ETRA' order by valo");
          while($o=mysqli_fetch_assoc($opc)){
          echo "<option value='".$o["valo"]."'>".$o["deno"]."</option>";}
         ?>
      </select>  
      <script>seleccionar("empresa","<?php echo $empresa?>")</script>
    </div>  
    
   </div>
  <div class="row">
   <div class="form-group has-warning col-md-2">
          <label class="label-form">Hora espera adicional</label>
          <input class="form-control" type="checkbox" id="hora_adicional" name="hora_adicional" onblur="sale_hora()" onchange="sale_hora()">
      </div>
      <div class="form-group has-warning col-md-3">
          <label class="label-form">Minutos adicionales de espera</label>
          <select class="form-control" id="minutos_adicionales" name="minutos_adicionales" disabled>
            <option value=0>No</option>
            <option value=1>10</option>
            <option value=2>20</option>
            <option value=3>30</option>
            <option value=4>40</option>
            <option value=5>50</option>
            <option value=6>60</option>
            <option value=7>70</option>
            <option value=8>80</option>
            <option value=9>90</option>
          </select>  
      </div>  
      
    
</div>



<div class="row">
        <h4 class="col-md-6">Pasajeros</h4>
</div>
  <br><br>
<div class="row">
        <div class="col-md-6">
            <label class="label-form">Alojados dispositivo</label>
            <select class="form-control" id="lista_alojados">
                <?php 
                 $cond="true";
                 if($_SESSION['hogar']>"0"){$cond="admi_hogar=".$dispositivo;};
                 $add=registros("select legajo, apellidos, nombres from hogares_admision left join sujetos on admi_legajo=sujetos.legajo where ".$cond." and admi_alta is not null and admi_baja is null order by nombres,apellidos");
                  while($e=mysqli_fetch_assoc($add)){
                    echo "<option value='".$e["legajo"]."'>".$e["nombres"]." ".$e["apellidos"]."</option>";
                  }
                ?>
        </select>
        <a class="btn-sm btn-primary" href="javascript:seleccional()">Seleccionar</a>
          
        </div>
        <div class="col-md-6">
            <label class="label-form">Adultos dispositivo</label>
        <select class="form-control" id="lista_adultos">
                <?php 
                if($_SESSION['hogar']>"0"){
                  $add=registros("select celular, apellido, nombre from movil_adultos where baja is null and dispositivo=".$dispositivo." order by apellido, nombre");}
                 else{
                  $add=registros("select celular, apellido, nombre from movil_adultos where baja is null and sector=".$dispositivo." order by apellido, nombre");
                 }; 
                  while($e=mysqli_fetch_assoc($add)){
                    echo "<option value='".$e["celular"]."'>".$e["apellido"]." ".$e["nombre"]."</option>";
                  };
                  ?>
        </select>
        <a class="btn-sm btn-primary" href="javascript:seleccionad()">Seleccionar</a>
      
        </div>
        
    </div>
    <br><br>
    
  <div class="row">      
	<div class="table-responsive col-md-6 pre-scrollable">
	<table class="table">
	<thead>
	 <tr class="bg-success" style="font-size:.9em"><th>Alojados</th><th>Legajo</th></tr>
        </thead>
        <tbody id="alojados">
          <?php
          for($i=1;$i<=40;$i++){
            echo "<tr><td><input size='40' id='p".$i."' name='p".$i."' class='form-control alo' autocomplete='off' onblur='salealo(".$i.")'></td>";
            echo "<td><input size='6' class='form-control lega' name='lega".$i."' id='lega".$i."'></td></tr>";
          }
          ?>
        </tbody>
        </table>
        </div>
	<div class="table-responsive  col-md-6 pre-scrollable">
	<table class="table">
	<thead>
	 <tr class="bg-success" style="font-size:.9em"><th>Otros</th><th>Celular</th></tr>
        </thead>
        <tbody id="otros">
          <?php
          for($i=1;$i<=10;$i++){
            echo "<tr><td><input size='35' id='a".$i."' name='a".$i."' class='form-control adu' autocomplete='off' onblur='saleadul(".$i.")'></td><td>";
            echo "<input size='10' class='form-control cel' name='acel".$i."' id='acel".$i."'></td></tr>";
          }
          ?>
        </tbody>
        </table>
        </div>

      </div>
      <div class="row">
      <div class="form-group has-warning col-md-6">
	<label class="label-form">Cantidad pasajeros alojados</label>
	<input class="form-control" readonly id="pasajeros_alojados" 
   name="pasajeros_alojados" onfocus="recuento()">
      </div>
      
      <div class="form-group has-warning col-md-6">
	<label class="label-form">Cantidad pasajeros acompa&ntilde;antes</label>
	<input class="form-control" readonly id="pasajeros_acompaniantes" name="pasajeros_acompaniantes" onfocus="recuento()">

      </div>
      <br><br>
    </div>
    
    <div class="row">
        </div>
      
      <div class="form-group has-warning col-md-6">
	<label class="label-form">Observaciones</label>
	<textarea class="form-control" cols="80" rows="4" id="comentarios" name="comentarios"></textarea>
      </div>
      </div>
  

      <button class="form-control btn-success">Guardar</button>					
  


  </form>	
  
</div>
<script>
  function limpia(id){
    document.getElementById (id).value="";
    document.getElementById ("entrada").focus();
  }
 function bl_tipo_tipo(){
  tipo_tipo=document.getElementById("tipo_tipo").value;
  document.getElementById("tipo").innerHTML=eje("val_tptp?tp="+tipo_tipo);
  if(tipo_tipo==2){
    seleccionar("empresa","2");
  }
  return true;
 } 

 function bl_distotal(){
  dt=document.getElementById("dis_total").value;
  destino_2=document.getElementById("destino_2").value;
  d2=0;
  if(destino_2!=""){d2=1;};
  if(dt==""){
    return false;
  };
  dtn=parseInt(dt);
  if(dtn!=NaN){
    document.getElementById("dis_total").value=dtn;
    tipo_tipo=document.getElementById("tipo_tipo").value;
    document.getElementById("tipo").innerHTML=eje("val_tpdi?tp="+tipo_tipo+"&di="+dtn+"&d2="+d2+"&pba="+document.getElementById("pba").value);
  };
  
  return true;
 }
 function bl_renglon(){
  v_tipo=document.getElementById("tipo").value;
  document.getElementById("renglon").value=v_tipo;
  document.getElementById("empresa").disabled=false;
  seleccionar("empresa","<?php echo $empresa?>");
  empre=document.getElementById("empresa").value;
  document.getElementById("empresa").disabled=true;
  rng=JSON.parse(eje("val_renglon?renglon="+v_tipo));
  
  if((empre==1 && rng.valor1==0)||(empre==2 && rng.valor2==0)){
    if(empre==1 && rng.id<3){
    document.getElementById("empresa").disabled=false;
    seleccionar("empresa","2");
    document.getElementById("empresa").disabled=true;
  } else{
    status("tipo móvil y empresa");
    seleccionar("tipo","");
    return false;
    }
  }
  if(document.getElementById("pba").value=="SI" && rng.es_pba==0 && rng.id!=2){
    status("PBA - renglon");
    seleccionar("tipo","");
    return false;
  }
  if(document.getElementById("pba").value=="NO" && rng.es_pba==1){
    status("PBA - renglon");
    seleccionar("tipo","");
    return false;
  }
  if(rng.es_pba==1){
    
    document.getElementById("b10_km").value=enterakm(document.getElementById("dis_total").value);
  
    
  }
  else{
    document.getElementById("b10_km").value="0";
  }
  if(rng.es_iv==0){
    document.getElementById("hora_adicional").checked=false;
    document.getElementById("hora_adicional").disabled=true;
    seleccionar("minutos_adicionales","0");
    document.getElementById("minutos_adicionales").disabled=true;
  }
  else{
    document.getElementById("hora_adicional").disabled=false;
    //document.getElementById("minutos_adicionales").disabled=false;
  }
  status("")
  return true;
  

 } 
 function enterakm(n){
    m=n;
    if(n<10){m=10;};
    r=m % 10;
    s=0;
    if(r>=5){s++;};
    ek=s+parseInt(m/10);
    return ek;
 }
function recuento(){
  recuentoalo();
  recuentoadu();
} 
function sale_hora(){
  if(document.getElementById("hora_adicional").checked==true){
    document.getElementById("minutos_adicionales").disabled=false;
    document.getElementById("minutos_adicionales").focus();
  }
  else{
    seleccionar("minutos_adicionales","0");
    document.getElementById("minutos_adicionales").disabled=true;

  }
}


</script>

</body>