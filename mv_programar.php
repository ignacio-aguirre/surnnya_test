<?php
session_start();
require("funciones.php"); 
$_SESSION["prestacion"]="Programar nuevo viaje";
include("encabezado-test.php");
$hoy_laborable=un_campo("select laborable from fechas where fecha=curdate()");
if($hoy_laborable=="0"){
$oper=un_registro("select * from movil_procesos where fecha_hoy=curdate() and estado_operativo ='FIND' order by id desc limit 1");  
  $fini=$oper["desde_ab"];
} else{

    $oper=un_registro("select * from movil_procesos where fecha_hoy=curdate() and estado_operativo='OPER' order by id desc limit 1");
      $bl=si( ($_SESSION['bandeja']==1 ||$_SESSION['bandeja']==3 ||$_SESSION['bandeja']==6),"b1_6","b1_5");
      $fini=$oper["desde_ab"];
      if($oper[$bl]>"0") {$fini=$oper["desde_db"];}
 };     

$dispositivo=$_SESSION["hogar"];

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


function seleccion(){
  ore=document.getElementById("respuesta");
  t=ore.value;
  dino=eje("val_direccion?id="+t);
  const coldir=document.getElementsByClassName("dir");
  for(i=0;i<coldir.length;i++){
    if (coldir[i].value==dino){
      status("destino repetido");
    };  
    if (coldir[i].value==""){
      coldir[i].value=dino;
      status("");
      document.getElementById("entrada").value="";
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
        
        };
        if(document.getElementById("respuesta").options.length==0){
            window.open("mv_domicilio_nuevo");

        }
        else if (document.getElementById("respuesta").options.length==1) {
          document.getElementById("entrada").value="";
        	seleccion();
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
    };
}



function valida_formulario(){
 obse_estado=false;
 obse_texto="";
 tipo=document.getElementById("tipo").value;
 acro=eje("val_minmax?tipo="+tipo);
 minpasajeros=parseInt(izq(acro,2));
 maxpasajeros=parseInt(der(acro,2));
 if (!distancias()){status("distancias");
 obse_estado=true;
 obse_texto="distancias error general";
 };
 d_calculada=document.getElementById("dis_total").value;
 v_tipo=document.getElementById("tipo");
 d_tipo=v_tipo.options[v_tipo.selectedIndex].text;
 
  if(d_calculada>7 && d_tipo.indexOf("h/6")>0){
    status("dc="+d_calculada+",tmovil="+ d_tipo);
    obse_estado=true;
    obse_texto=obse_texto+" dc="+d_calculada+",tmovil="+ d_tipo;
  };
  if(d_calculada<=5 && d_tipo.indexOf(">6")>0){
    status("dc="+d_calculada+" tmovil="+ d_tipo);
    obse_estado=true;
    obse_texto=obse_texto+" dc="+d_calculada+" tmovil="+ d_tipo;
 }

   
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
  
  
  if(pax>maxpasajeros){status("# pasajeros "+pax+" excede capacidad "+maxpasajeros); return false;};
 status("");
 document.getElementById("observaciones").value=obse_texto;
 
 return true;
} 



</script>
</div>
<br><br>
<div class="container">

     <form class="form-inline" method="get" onsubmit="return valida_formulario()" action="mv_programar_do">
      <input hidden name="observaciones" id="observaciones">
  <div class="row">
   <div class="form-group has-warning col-md-3"> 
    <label class="label-form">Fecha del viaje</label>
   <input name="fecha" id="fecha" value="<?php echo $fini?>" type="date" min="<?php echo $fini?>" autofocus required class="form-control"></div>
   <div class="form-group has-warning col-md-2">
      <label class="label-form">Hora partida<br></label>
      <input type="time" class="form-control" min="00:00" max="23:59"  name="hora" id="hora" value="07:00" required>
    </div>
    
		 <div class="form-group has-warning col-md-3">
          <label class="label-form">Motivo del recurso</label>
          <select class="form-control" id="motivo_recurso" name="motivo_recurso" required>
          <option value="">Completar</option>
          <?php echo opc_tabla("MVMT")?>
          </select>
    </div>
  
  </div>
</div>
<div class="container">
  <div class="row">
  
    <div class="form-group col-md-4 has-warning">
      <label class="label-form">B&uacute;squeda</label>
      <input id="entrada" class="form-control" size="30" maxlength="70" onchange="domi_alma()" onblur="cdi()">
    </div>  

    <div class="form-group col-md-8 has-warning">
        <label class="label-form">&nbsp;Resultados</label><br>
        <select id="respuesta" name="respuesta" class="form-control">
        </select><br>
        <a class="btn-sm btn-primary" href="javascript:seleccion()">Seleccionar</a>&nbsp; 
      <a class="btn-sm btn-primary" href="javascript:domi()">+</a>
     </div>
    <br><br>
  </div>

  <div class="row"> 
    <div class="form-group has-warning col-md-4">
      <label class="label-form">Partida<br></label>
        <input class="form-control dir" size="30" maxlength="70" id="partida" name="partida" required value="<?php echo $sede?>"  ondblclick="limpia(this.id)">
    </div>
    <div class="form-group has-warning col-md-4">
		<label class="label-form">Destino 1</label><br>
		<input class="form-control dir" id="destino_1"  name="destino_1" size="40" maxlength="70"  ondblclick="limpia(this.id)" required>
		</div> 
		<div class="form-group has-warning col-md-4">
		<label class="label-form">Destino 2</label><br>
		<input class="form-control dir" id="destino_2"  name="destino_2" size="30" maxlength= "70" ondblclick="limpia(this.id)" >
	</div>
</div>
<br><br>
<div class="row">
	<div class="form-group has-warning col-md-6">
		<label class="label-form">Destino 3</label>
		<input class="form-control dir" id="destino_3"  name="destino_3" size="40" maxlength= "70"  ondblclick="limpia(this.id)">
	
	</div>
	<div class="form-group has-warning col-md-6">
		<label class="label-form">Destino 4</label>
		<input class="form-control dir" id="destino_4"  name="destino_4" size="40" maxlength= "70" ondblclick="limpia(this.id)" >
	
	</div>
</div>
<div class="table-responsive">
      <table class="table table-striped" id="tdista" onfocus()="distancias()">
        <thead class="table-dark">
          <tr><th>Direcci&oacute;n</th><th>x</th><th>y</th><th>Distancia</th></tr>
          <tr><th id='dom_partida'></th><th id='x_partida'></th><th id='y_partida'></th><th>0</th></tr>
        </thead>  
        <tbody id="">
          <tr><th id='des_1'></th><th id='x_d1'></th><th id='y_d1'></th><th id='dis1'></th></tr>
          <tr><th id='des_2'></th><th id='x_d2'></th><th id='y_d2'></th><th id='dis2'></th></tr>
          <tr><th id='des_3'></th><th id='x_d3'></th><th id='y_d3'></th><th id='dis3'></th></tr>
          <tr><th id='des_4'></th><th id='x_d4'></th><th id='y_d4'></th><th id='dis4'></th></tr>
        </tbody>
      </table>
      
      
  </div>      
      <br><br>
  <div class="row">    
   <div class="form-group has-warning col-md-2">
      <label class="label-form">Distancia km</label>
      <input class="form-control" name="dis_total" id="dis_total">
   </div> 
   <div class="form-group has-warning col-md-2">
      <label class="label-form">PBA</label>
      <input class="form-control" name="pba" id="pba" readonly>
   </div> 
   
  <div class="form-group has-warning col-md-4">
      <label class="label-form">Tipo de m&oacute;vil</label>
      <select class="form-control" id="tipo"  name="tipo_movil" onchange="p_empresa()" required>
               <option value="">Completar</option>
        <?php
        $opc=registros("select valo,info from tablas where tipo='MVTT' order by valo");
          while($o=mysqli_fetch_assoc($opc)){
          echo "<option value='".$o["valo"]."'>".$o["info"]."</option>";}
         ?>
      </select>
    </div>
    <div class="form-group has-warning col-md-4">
      <label class="label-form">Empresa</label>
      <select class="form-control" id="empresa" name="empresa" readonly>
        <?php
        $opc=registros("select valo,deno from tablas where tipo='ETRA' order by valo");
          while($o=mysqli_fetch_assoc($opc)){
          echo "<option value='".$o["valo"]."'>".$o["deno"]."</option>";}
         ?>
      </select>  
      <script>seleccionar("empresa","<?php echo $empresa?>")</script>
    </div>  
    </div>
</div>

<div class="container">

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
                  $add=registros("select celular, apellido, nombre from movil_adultos where baja is null and sector=".$dispositivo." order by apellido, nombre")
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
	<div class="table-responsive col-md-6">
	<table class="table">
	<thead>
	 <tr class="bg-success" style="font-size:.9em"><th>Alojados<a class="btn-sm btn-success" href="javascript:vernomina()">N&oacute;mina</a></th><th>Legajo</th></tr>
        </thead>
        <tbody id="alojados">
          <?php
          for($i=1;$i<=30;$i++){
            echo "<tr ".si($i>10," hidden","")."><td><input size='40' id='p".$i."' name='p".$i."' class='form-control alo' autocomplete='off' onblur='salealo(".$i.")'></td>";
            echo "<td><input size='6' class='form-control lega' name='lega".$i."' id='lega".$i."'></td></tr>";
          }
          ?>
        </tbody>
        </table>
        </div>
	<div class="table-responsive  col-md-6">
	<table class="table">
	<thead>
	 <tr class="bg-success" style="font-size:.9em"><th>Otros <a class="btn-sm btn-success" href="javascript:nuevoadulto()">Nuevo</a></th><th>Celular</th></tr>
        </thead>
        <tbody id="otros">
          <?php
          for($i=1;$i<=10;$i++){
            echo "<tr><td><input size='35' id='a".$i."' name='a".$i."' class='form-control adu' autocomplete='off' onblur='saleadu(".$i.")'></td><td>";
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
	<input class="form-control" readonly id="pasajeros_alojados" name="pasajeros_alojados" onfocus="recuento()">
      </div>
      
      <div class="form-group has-warning col-md-6">
	<label class="label-form">Cantidad pasajeros acompa&ntilde;antes</label>
	<input class="form-control" readonly id="pasajeros_acompaniantes" name="pasajeros_acompaniantes" onfocus="recuento()">

      </div>
      <br><br>
    </div>
    <div class="row">  
      <h4 class="col-md-12">Datos adicionales</h4>
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
  function cdi(){
    if(document.getElementById ("entrada").value==""){
      distancias();
    }
  }
  function distancias(){
    kmt=0;
    espba="NO";
    dire=document.getElementById("partida").value;
    if(dire!=""){
    if(dire.indexOf("CABA")==-1){espba="SI";};
    document.getElementById('dom_partida').innerHTML=dire;
    xy=eje("val_direccion_xy?t="+dire);
    ppc=xy.indexOf(";");
    document.getElementById('x_partida').innerHTML=xy.substr(0,ppc);
    document.getElementById('y_partida').innerHTML=xy.substr(ppc+1);
    } else    
    {document.getElementById('dom_partida').innerHTML="";
     document.getElementById('x_partida').innerHTML="";
     document.getElementById('y_partida').innerHTML="";
     return false;
    }
    dire=document.getElementById("destino_1").value;
    if(dire!=""){

        if(dire.indexOf("CABA")==-1){espba="SI";};
        document.getElementById('des_1').innerHTML=dire;
        xy=eje("val_direccion_xy?t="+dire);
        ppc=xy.indexOf(";");
        document.getElementById('x_d1').innerHTML=xy.substr(0,ppc);
        document.getElementById('y_d1').innerHTML=xy.substr(ppc+1);
        km=eje("val_distancia_km?lat1="+document.getElementById('x_partida').innerHTML+"&long1="+document.getElementById('y_partida').innerHTML+"&lat2="+document.getElementById('x_d1').innerHTML+"&long2="+document.getElementById('y_d1').innerHTML);
      document.getElementById('dis1').innerHTML=km;
      kmt=kmt+parseFloat(km);
    }else{
      document.getElementById('des_1').innerHTML="";
     document.getElementById('x_d1').innerHTML="";
     document.getElementById('y_d1').innerHTML="";
      document.getElementById('dis1').innerHTML=0;
     return false;

    }
    dire=document.getElementById("destino_2").value;
    if(dire!=""){
      if(dire.indexOf("CABA")==-1){espba="SI";};
      document.getElementById('des_2').innerHTML=dire;
      xy=eje("val_direccion_xy?t="+dire);
      ppc=xy.indexOf(";");
      document.getElementById('x_d2').innerHTML=xy.substr(0,ppc);
      document.getElementById('y_d2').innerHTML=xy.substr(ppc+1);
      km=eje("val_distancia_km?lat1="+document.getElementById('x_d1').innerHTML+"&long1="+document.getElementById('y_d1').innerHTML+"&lat2="+document.getElementById('x_d2').innerHTML+"&long2="+document.getElementById('y_d2').innerHTML);
      document.getElementById('dis2').innerHTML=km;
      kmt=kmt+parseFloat(km);

    } else{
      document.getElementById('des_2').innerHTML="";
      document.getElementById('x_d2').innerHTML="";
      document.getElementById('y_d2').innerHTML="";
      document.getElementById('dis2').innerHTML="";

    }
    dire=document.getElementById("destino_3").value;
    if(dire!=""){
      if(dire.indexOf("CABA")==-1){espba="SI";};
      document.getElementById('des_3').innerHTML=dire;
      xy=eje("val_direccion_xy?t="+dire);
      ppc=xy.indexOf(";");
      document.getElementById('x_d3').innerHTML=xy.substr(0,ppc);
      document.getElementById('y_d3').innerHTML=xy.substr(ppc+1);
      
      km=eje("val_distancia_km?lat1="+document.getElementById('x_d2').innerHTML+"&long1="+document.getElementById('y_d2').innerHTML+"&lat2="+document.getElementById('x_d3').innerHTML+"&long2="+document.getElementById('y_d3').innerHTML);
      document.getElementById('dis3').innerHTML=km;
      kmt=kmt+parseFloat(km);
    
    } else{
      document.getElementById('des_3').innerHTML="";
      document.getElementById('x_d3').innerHTML="";
      document.getElementById('y_d3').innerHTML="";
      document.getElementById('dis3').innerHTML="";

    }  
    dire=document.getElementById("destino_4").value;
    if(dire!=""){
      if(dire.indexOf("CABA")==-1){espba="SI";};
      document.getElementById('des_4').innerHTML=dire;
        xy=eje("val_direccion_xy?t="+dire);
      ppc=xy.indexOf(";");
      document.getElementById('x_d4').innerHTML=xy.substr(0,ppc);
      document.getElementById('y_d4').innerHTML=xy.substr(ppc+1);
      
      km=eje("val_distancia_km?lat1="+document.getElementById('x_d3').innerHTML+"&long="+document.getElementById('y_d3').innerHTML+"&lat2="+document.getElementById('x_d4').innerHTML+"&long2="+document.getElementById('y_d4').innerHTML);
      document.getElementById('dis4').innerHTML=km;
      kmt=kmt+parseFloat(km);
    } else{
      document.getElementById('des_4').innerHTML="";
      document.getElementById('x_d4').innerHTML="";
      document.getElementById('y_d4').innerHTML="";
      document.getElementById('dis4').innerHTML="";
    }

    document.getElementById("dis_total").value=Math.ceil(kmt,2);
    document.getElementById("pba").value=espba;
    return true;
  }
 function p_empresa(){
  if(document.getElementById("tipo").value>"5"){
    seleccionar("empresa","2");
  }
  else{
    seleccionar("empresa","<?php echo $empresa?>");
    
  }
 } 
</script>

</body>