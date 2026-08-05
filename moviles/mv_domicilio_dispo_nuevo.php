<?php
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Nuevo domicilio";
include("encabezado.php");
$dispositivo=$_SESSION["hogar"];
$ndispo=un_campo("select nombre from dispositivos where id=".nulea($dispositivo));
$tdispo="d";
if(!$dispositivo>"0"){
    $dispositivo=$_SESSION["sector"];
    $ndispo=un_campo("select denominacion from sectores where id=".nulea($dispositivo));
    $tdispo="s";
};


?>
</div>
<br><br>
<script>
    
function domi(id){
    t=document.getElementById(id).value;
    if(t!=""){
      resp=eje("val_domicilios?t="+t);
      document.getElementById("respuesta").innerHTML=resp;
    };
}

function domi_alma(id){
    t=document.getElementById(id).value;
    if(t!=""){
        resp=eje("val_domicilios_almacenados?t="+t+"&td=<?php echo $tdispo?>"+"&dispo=<?php echo $dispositivo?>");
        document.getElementById("respuesta").innerHTML=resp;
        if(document.getElementById("respuesta").options.length==0){
            domi(id);
        };
    };
}
</script>
<div class="container">
    <?php if(isset($_SESSION["msg"])){
echo "<div class='row'><div class='col-md-6'>".$_SESSION["msg"]."</div></div>";
$_SESSION["msg"]=="";
}?>

<h4> <strong><?php echo $ndispo?></strong></h4>
<form class="form" method="get" onsubmit="return valida_formulario()" action="mv_domicilio_dispo_nuevo_do">
    <input hidden name="tdispo" value="<?php echo $tdispo?>">
    <input hidden name="dispositivo" value="<?php echo $dispositivo?>">
    <div class="row">
    
    <div class="form-group col-md-12 has-warning">
        <label class="label-form">Calle , n&uacute;mero y localidad o partido</label>
        <input class="form-control col-md-6" id="entrada" maxlength="70" name="entrada" required autofocus>
        <div class="form-group col-md-3 has-warning">
        
                <a class="btn-sm btn-success" href="javascript:domi_alma('entrada')">Buscar</a>&nbsp;
                <a class="btn-sm btn-success" href="javascript:domi('entrada')">+</a>
        </div> 
    
    </div>
    <br> 
</div>
<div class="row">
    <div class="form-group col-md-6 has-warning">
              <label class="label-form">Domicilios encontrados</label>
        <select id="respuesta" name="respuesta" class="form-control" >
        </select>  
    </div> 
    <div class="form-group col-md-6 has-warning">
        <br><br>
        <label class="label-form">Opciones</label>
        <a class="btn-sm btn-primary" href="javascript:seleccion()">Seleccionar</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn-sm btn-info" href="javascript:nuevo()">Nuevo</a>
    </div>
    
    </div>  
    <br>
    
    
    
    
<br><br>
    
<div class="row">
    <div class="form-group has-warning col-md-6">
        <label class="label-form">Referencia</label>
        <input class="form-control" id="referencia" name="referencia" size="70">
    </div>

        <div class="form-group has-warning col-md-6">
            <br><br>

        <button class="btn-success">Guardar</button>
    </div>    
</div>



</form>

<script>
function dupli(){
        dire=document.getElementById("entrada").value;
        if(dire!=""){
            resp=eje("val_dom_exi_dis?t="+dire+"&tdispo=<?php echo $tdispo?>"+"&dispo=<?php echo $dispositivo?>");
            if(resp>"0"){
                status("domicilio duplicado");
                return false;
            };
        };
        return true;
}

function valida_formulario(){
    entrada=document.getElementById("entrada").value;
    ex=eje("val_domicilio_existente?t="+entrada);
    if(ex=="0"){status("domicilio inexistente");return false;};
    if(!dupli()){return false;};
    status("");
    return true;
}


 
function nuevo(){
    
    navega("mv_domicilio_nuevo");
    
}


function seleccion(){
    
    
    obj=document.getElementById('entrada');
    ore=document.getElementById("respuesta");
    obj.value=eje("val_direccion?id="+ore.value);
    ore.options.length=0;

}


</script>
</div>
</html>
	
