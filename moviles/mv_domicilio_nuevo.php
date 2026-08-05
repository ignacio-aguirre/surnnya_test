<?php
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Nuevo domicilio";
include("encabezado.php");
$t="";
if(isset($_GET["texto"])){$t=$_GET["texto"];}
?>
</div>
<br>
<div class="container">
    

<script>
var respuesta;
function norma(t){
 
 borra_campos();   

 //t=document.getElementById("entrada").value;   
 t=t.replace("Ñ","N").replace("ñ","n");
 osugerencias=document.getElementById("sugerencias");
 osugerencias.options.length=0;
 osugerencias.disabled=false;
 odireccion=document.getElementById("direccion");
 ocalle=document.getElementById("calle");
 ocalle_cruce=document.getElementById("calle_cruce");
 oaltura=document.getElementById("altura");
 olocalidad=document.getElementById("localidad");
 opartido=document.getElementById("partido");
 obarrio=document.getElementById("barrio");
 ocomuna=document.getElementById("comuna");
 longitud=document.getElementById("longitud");
 latitud=document.getElementById("latitud");
 var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         resp = xhttp.responseText;
         var objeto = JSON.parse(resp);
        if(typeof objeto.errorMessage!="undefined"){
        document.getElementById("dnn").style.visibility="visible";
        return false;};
        
        if(objeto.direccionesNormalizadas.length==1){
            respuesta=objeto.direccionesNormalizadas[0];
            odireccion.value=respuesta.direccion;
            ocalle.value=respuesta.nombre_calle;
            ocalle_cruce.value=respuesta.nombre_calle_cruce;
            oaltura.value=respuesta.altura;
            olocalidad.value=respuesta.nombre_localidad;
            opartido.value=respuesta.nombre_partido;
            latitud.value=respuesta.coordenadas.y;
            longitud.value=respuesta.coordenadas.x;
            if(olocalidad.value=="CABA"){
             adicionales();
            };
            document.getElementById("dnn").style.visibility="hidden";
			osugerencias.disabled=true; 

        } else if(objeto.direccionesNormalizadas.length>1){
            osugerencias.options.length=0;            	
            item=-1;
        	for(i=0;i<objeto.direccionesNormalizadas.length;i++){
              var c = document.createElement("option");
              respuesta=objeto.direccionesNormalizadas[i];
              c.text = respuesta.direccion;
              if(c.text==t){item=i;break;}
              osugerencias.options.add(c,i);
            };
        	if(item>=0){
                osugerencias.options.length=0;              
                respuesta=objeto.direccionesNormalizadas[item];
                odireccion.value=respuesta.direccion;
                ocalle.value=respuesta.nombre_calle;
                ocalle_cruce.value=respuesta.nombre_calle_cruce;
                oaltura.value=respuesta.altura;
                olocalidad.value=respuesta.nombre_localidad;
                opartido.value=respuesta.nombre_partido;
                latitud.value=respuesta.coordenadas.y;
                longitud.value=respuesta.coordenadas.x;
                if(olocalidad.value=="CABA"){
                    adicionales();
                };
            }
            
        } 
            
        
    };

    
       
   }; 
  xhttp.open("GET", "https://undato.com.ar/moviles/proxy_usig?direccion="+t, false);
  xhttp.send();
  
 
return true; 
}

function cdom(){
    osugerencias=document.getElementById("sugerencias");
    if(osugerencias.options.length>0){
    valor=osugerencias.options[osugerencias.selectedIndex].text;
    //document.getElementById("entrada").value=valor;
    //document.getElementById("entrada").focus();
    osugerencias.options.length=0;
    norma(valor);
    document.getElementById("direccion").value=valor;
    document.getElementById("dnn").style.visibility="hidden";
    }else{
      document.getElementById("dnn").style.visibility="visible";  
    }
}
    

function borra_campos(){
    document.getElementById("direccion").value="";
    document.getElementById("calle").value="";
    document.getElementById("calle_cruce").value="";
    document.getElementById("localidad").value="";
    document.getElementById("partido").value="";
    document.getElementById("altura").value="";
    document.getElementById("barrio").value="";
    document.getElementById("comuna").value="";
    document.getElementById("longitud").value="";
    document.getElementById("latitud").value="";
}
function adicionales(){
 
   var xhttp2 = new XMLHttpRequest();
   xhttp2.onreadystatechange = function() {
   if (this.readyState == 4 && this.status == 200) {
        resp = xhttp2.response;
        var obje = JSON.parse(resp);
	document.getElementById("barrio").value=obje.barrio;
    document.getElementById("comuna").value=parseInt(der(obje.comuna,2));
	;
 };
 
};
x=document.getElementById("longitud").value;
 y=document.getElementById("latitud").value;
xhttp2.open("GET", "https://undato.com.ar/moviles/proxy_usig_ad?x="+x+"&y="+y, true);
xhttp2.send();
return true;
}

</script>

<form  class="form" method="get" onsubmit="return valida_formulario()" action="mv_domicilio_nuevo_do">

    <div class="row">
    <div class="form-group col-md-6 has-warning">
        <label class="label-form">Calle , n&uacute;mero y localidad o partido</label>
        <input class="form-control" id="entrada" name="entrada" size="50" maxlength="150" onblur="norma(this.value)" value="<?php echo $t?>" autofocus required>
    </div>
    <div class="form-group col-md-4 has-warning">    
        <label class="label-form">Sugerencias</label>
        <select class="form-control" id="sugerencias"></select>
    </div>
    <div class="form-group col-md-2 has-warning">    
        <br>
    <a class="btn-sm btn-primary" href="javascript:cdom()">Seleccionar</a>&nbsp; 
    </div>
</div>
<div class="row">
    <div class="form-group has-warning col-md-6">
        <label class="label-form">Direcci&oacute;n normalizada</label>
        <input readonly class="form-control" id="direccion" name="direccion" size="70"  required onblur="dupli()">
    </div>
</div>
<div class="row">

    <div class="form-group has-warning col-md-4">
        <label class="label-form">Calle</label>
        <input  readonly class="form-control" id="calle" name="calle"  required>
    </div>
    <div class="form-group has-warning col-md-4">
        <label class="label-form">Altura</label>
        <input  readonly class="form-control" id="altura" name="altura" >
    </div>
    <div class="form-group has-warning col-md-4">
        <label class="label-form">Calle cruce</label>
        <input  readonly class="form-control" id="calle_cruce" name="calle_cruce" >
    </div>
    <div class="form-group has-warning col-md-6">
        <label class="label-form">Localidad</label>
        <input readonly  class="form-control" id="localidad" name="localidad"  required>
    </div>
    <div class="form-group has-warning col-md-6">
        <label class="label-form">Partido</label>
        <input  readonly class="form-control" id="partido" name="partido"  required>
    </div>
    <div class="form-group has-warning col-md-6">
        <label class="label-form">Barrio</label>
        <input  readonly class="form-control" id="barrio" name="barrio" >
    </div>
    <div class="form-group has-warning col-md-6">
        <label class="label-form">Comuna</label>
        <input  readonly class="form-control" id="comuna" name="comuna" >
    </div>
    <div class="form-group has-warning col-md-6">
        <label class="label-form">Latitud (-34...)</label>
        <input  readonly class="form-control" id="latitud" name="latitud" >
    </div>
    <div class="form-group has-warning col-md-6">
        <label class="label-form">Longitud (-58....)</label>
        <input  readonly class="form-control" id="longitud" name="longitud" >
    </div>
    <div class="form-group has-warning col-md-6">
        <label class="label-form">Referencia general</label>
        <input class="form-control"  name="ref_general" >
    </div>
  </div>
  <br>
  <div class="row">
    
    <div class="form-group has-warning col-md-6">
        <button class="btn btn-success">Guardar</button>&nbsp;
        
        <?php if($_SESSION['perfil_moviles']=="1"){?><a class="btn-sm btn-success" onclick="window.close()">Cerrar</a> <?php }?>
        
    </div>
    <div class="form-group has-warning col-md-6">
        <a class="btn btn-info" id="dnn" name="nnn" value="1" href="javascript:nnn1()">Domicilio no normalizado</a>
    </div>    
</div>
</form>



<script>
  
  function nnn1(){
        navega("mv_dom_nuevo_nn?texto="+document.getElementById("entrada").value);    
  }
    function dupli(){
        dire=document.getElementById("direccion").value;
        
        if(dire!=""){ 
            
            resp=eje("val_domicilio_existente?t="+dire);
            if(resp>"0"){
            
                status("domicilio duplicado "+resp);
                borra_campos();
                return true;
            };
            return false
        };
        return false;
    }
function valida_formulario(){
    if(document.getElementById("direccion").value==""){
        status("direccion"); return false;
    };
    if(document.getElementById("calle").value==""){
        status("calle"); return false;
    };
    if(document.getElementById("calle_cruce").value=="" && document.getElementById("altura").value==""){
        status("calle cruce o altura"); return false;
    };
    if(document.getElementById("localidad").value==""){
        status("localidad"); return false;
    };
    if(document.getElementById("localidad").value=="CABA" && document.getElementById("barrio").value==""){
        status("barrio"); return false;
    };
    if(document.getElementById("localidad").value=="CABA" && document.getElementById("comuna").value==""){
        status("comuna"); return false;
    };
    if(dupli()){return false;};
    status("");
    return true;

}    
</script>
</div>
</html>
	
