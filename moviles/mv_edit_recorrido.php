<?php
session_start(); 
require("funciones.php"); 
$_SESSION["prestacion"]="Editar recorrido viaje";
include("encabezado.php");
$id=nget("id");
$bandejas="X".$_SESSION["bandeja"];
$_SESSION["retorno"]='mv_edit_menu?id='.$id;

if($_SESSION["supervisa"]=="B13"){
    $bandejas="X16789";
}

$v=un_registro("select * from movil_viajes where id=".$id);
if($v["dispositivo"]>"0"){$dispositivo=$v["dispositivo"];
  $tipo_dispositivo="Dispositivo";
   
};
if($v["sector"]>"0"){$dispositivo=$v["sector"];
   $tipo_dispositivo="Sector";
   
};

if(strpos($bandejas,$v["bandeja"])==0 && $v["bandeja"]!="80"){
    $_SESSION["msg"]="Viaje de otras bandejas";
    Redirect("aviso");

}

$_SESSION["retorno"]=$_SESSION['menu'];

?>
</div>
<br>





<div class="container">

    <div class="row">  
    <div class="form-group has-warning col-md-4">
         <label class="label-form">Solicitante&nbsp;</label>
        <p class="form-control text-primary"><?php 
        if($tipo_dispositivo=="Dispositivo") {
            echo un_campo("select nombre from dispositivos where id=".$dispositivo);}
        else{
            echo un_campo("select denominacion from sectores where id=".$dispositivo);}     
        ?></p>    
    </div>        
    <div class="form-group has-warning col-md-6">
        <label class="label-form">Observaciones del revisor/a</label>&nbsp;
        	<p class="form-control text-danger"><?php echo si($v["observaciones"]=="","Ninguna",$v["observaciones"])?></p>
     </div>
    </div>        
    
    <script>

    
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
            softstatus("");
            document.getElementById("entrada").value="";
            document.getElementById("entrada").focus();
            break;
        };
    };
    
    ore.options.length=0;

}
function foco_res(){
    if(document.getElementById("entrada").value==""){
        document.getElementById("entrada").focus();
    }
}
</script>

</div>

<div class="container">
     <form class="form" method="get" onsubmit="return valida_formulario()" action="mv_edit_recorrido_do">
   <input name="id" value="<?php echo $id?>" hidden>
 
  <div class="row">
        <div class="form-group has-warning col-md-4">
        <label class="label-form">Fecha del viaje&nbsp;</label>
        <p class="form-control text-primary">
        <?php echo ffec($v['fecha'])?>
        </p>
    </div>    
    <div class="form-group has-warning col-md-4">
        <label class="label-form">Hora de partida&nbsp;</label>
        <p class="form-control text-primary">
        <?php echo substr($v['hora'],0,5)?>
        </p>
    </div>
    <div class="form-group has-warning col-md-4">
        <label class="label-form">B&uacute;squeda&nbsp;</label>
      <input id="entrada" class="form-control" size="30" maxlength="70" onchange="domi_alma()" onblur="domi_alma()">
    </div>  
    <br><br>
</div>
    
<div class="row">
        
      
    <div class="form-group col-md-12 has-warning">
        <label class="label-form">Resultados&nbsp;</label>
        <select id="respuesta" name="respuesta" class="form-control" onfocus="foco_res()">
        </select><br>
        <a class="btn-sm btn-primary" href="javascript:seleccion()">Seleccionar</a>&nbsp; 
      <a class="btn-sm btn-primary" href="javascript:domi()">+</a>
     </div>
    <br><br>
  </div>

    <div class="row">
    
        <div class="form-group has-warning col-md-6">
         <label class="label-form">Partida</label>
                <input class="form-control dir" size="50" maxlength="70" id="partida" name="partida"  value="<?php echo estandariza_dom($v['partida'])?>" required 
                ondblclick="limpia(this.id)">
         </div>
         <br><br>
    </div>
    <div class="row">
        <div class="form-group has-warning col-md-6">
        <label class="label-form">Destino 1&nbsp;</label>
        <input class="form-control dir" id="destino_1"  name="destino_1" size="50" maxlength= "70" value="<?php echo estandariza_dom($v['destino_1'])?>" required ondblclick="limpia(this.id)">
        
        </div>
        
    <div class="form-group has-warning col-md-6">
        <label class="label-form">Destino 2&nbsp;</label>
        <input class="form-control dir" id="destino_2"  name="destino_2" size="50" maxlength= "70"  value="<?php echo estandariza_dom($v['destino_2'])?>" ondblclick="limpia(this.id)">
    
    </div>
</div>
<div class="row">
    <div class="form-group has-warning col-md-6">
        <label class="label-form">Destino 3&nbsp;</label>
        <input class="form-control dir" id="destino_3"  name="destino_3" size="50" maxlength= "70"  value="<?php echo estandariza_dom($v['destino_3'])?>" ondblclick="limpia(this.id)">
        
        
    </div>
    
    <div class="form-group has-warning col-md-6">
        <label class="label-form">Destino 4&nbsp;</label>
        <input class="form-control dir" id="destino_4"  name="destino_4" size="50" maxlength= "70"  value="<?php echo estandariza_dom($v['destino_4'])?>" ondblclick="limpia(this.id)">
        
    </div>
</div>
<br><br>  
    <br><br>
      <button class='form-control btn-success'>Guardar</button>
      
    </form></div>    

  

<script>

function valida_formulario(){
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
  
  return true;
} 

function limpia(id){
    document.getElementById (id).value="";
    document.getElementById ("entrada").focus();
  }

</script>

</body>