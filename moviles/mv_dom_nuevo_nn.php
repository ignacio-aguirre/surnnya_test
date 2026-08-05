<?php
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Nuevo domicilio no normalizado";
include("encabezado.php");
$calle="";
$altura="";
$calle_cruce="";
$localidad="";
if(isset($_GET["texto"])){
    if($_GET["texto"]!=""){
    
$texto=$_GET["texto"];
if(strpos($texto,", ")>-1){
    $pos=strpos($texto,", ");
    $localidad=substr($texto,$pos+2);
    $texto=substr($texto,0,$pos);   
}

if(strpos($texto," Y ")>0){
    $pos=strpos($texto," Y ");
        
    $calle_cruce=substr($texto,$pos+3);
    $texto=substr($texto,0,$pos);
}
for($i=0;$i<strlen($texto);$i++){
        $car=substr($texto,$i,1);
        if(strpos("#0123456789",$car)>-1){$altura=$altura.$car;}
        else if($car!=" " && $altura==""){$calle=$calle.$car;}
}
}
};
?>
<br><br></div>
<div class="container">
    <p class="text-danger">Se sugiere refinar la b&uacute;squeda antes de cargar un domicilio no normalizado. Para volver a b&uacute;squeda click <a href="mv_domicilio_nuevo">Aqu&iacute;</a></p>
<form class="form" method="get" onsubmit="return valida_formulario()" action="mv_dom_nuevo_nn_do">
    
    <div class="row">
    
    

    <div class="form-group has-warning col-md-4">
        <label class="label-form">Calle</label>
        <input class="form-control" id="calle" name="calle" size="30" maxlength="50"  required value="<?php echo $calle?>">
    </div>
    <div class="form-group has-warning col-md-4">
        <label class="label-form">Altura</label>
        <input class="form-control" type="number" min="0" id="altura" name="altura" value="<?php echo $altura?>">
    </div>
    <div class="form-group has-warning col-md-4">
        <label class="label-form">Calle cruce o referencia si no hay altura</label>
        <input class="form-control" id="calle_cruce" name="calle_cruce" size="30" maxlength="50" value="<?php echo $calle_cruce?>">
    </div>
    <div class="form-group has-warning col-md-4">
        <label class="label-form">Localidad</label>
        <select class="form-control" id="localidad" name="localidad"  onblur="sale_loc()" required>
            <option value=''>Completar</option>
            <?php
            $loc=registros("select * from localidades_nueva where provincia='CABA' or partido>'' order by case when nombre='CABA' then '1' else nombre end");
            while($l=mysqli_fetch_assoc($loc)){
                echo "<option value='".$l["nombre"]."'>".$l["nombre"].si($l["nombre"]=="CABA",""," Partido ".$l["partido"])."</option>";
            }
            
            ?>
            <option value="-1" >Otra (especificar)<option>
        </select>    


    </div>
    <div class="form-group has-warning col-md-4">
        <label class="label-form">Especificaci&oacute;n</label>
        <input class="form-control" name="loc_esp" id="loc_esp" disabled required>
    </div>    
    <div class="form-group has-warning col-md-4">
        <label class="label-form">Partido</label>
        <input class="form-control" id="partido" name="partido"  size="30" maxlength="50" required>
    </div>
    <div class="form-group has-warning col-md-6">
        <label class="label-form">Barrio (CABA)</label>
        <select class="form-control" id="barrio" name="barrio" onblur="sale_bar()">
            <option value=''></option>
            <?php 
            $barrios=registros("select barrio,comuna from barrios_caba order by barrio");
            while($b=mysqli_fetch_assoc($barrios)){
                echo "<option value='".$b["barrio"]."'>".$b["barrio"]."</option>";
            }
            ?>
        </select>    
    </div>
    <div class="form-group has-warning col-md-6">
        <label class="label-form">Comuna</label>
        <input class="form-control" id="comuna" name="comuna" type="number" min="0" max="15">
    </div>
    <div class="form-group has-warning col-md-6">
        <label class="label-form">Latitud (-34...)</label>
        <input class="form-control" id="latitud" name="latitud" >
    </div>
    <div class="form-group has-warning col-md-6">
        <label class="label-form">Longitud (-58...)</label>
        <input class="form-control" id="longitud" name="longitud" >
    </div>
    
    <div class="form-group has-warning col-md-6">
        <label class="label-form">Referencia general</label>
        <input class="form-control"  name="ref_general" > 
    </div>
    <div class="form-group has-warning col-md-6">
        <br>
        <button class="btn-success">Guardar</button>
    </div>    
</div>
</form>

<script>
    function sale_loc(){
        ob=document.getElementById("localidad");
        if(ob.value=="CABA"){
            document.getElementById("barrio").disabled=false;
            document.getElementById("comuna").disabled=false;
            document.getElementById("partido").disabled=true;
            document.getElementById("partido").value="CABA";
        }
        else{
            document.getElementById("barrio").disabled=true;
            seleccionar("barrio","n/c");
            document.getElementById("comuna").disabled=true;
            document.getElementById("comuna").value="0";
            document.getElementById("partido").disabled=false;
            document.getElementById("partido").value="";
            if(ob.value==-1){
                document.getElementById("loc_esp").disabled=false;
                document.getElementById("loc_esp").value="<?php echo $localidad?>";
                document.getElementById("loc_esp").focus();
            }else{
                document.getElementById("loc_esp").value="";
                document.getElementById("loc_esp").disabled=true;
                cad=ob.options[ob.selectedIndex].text;
                if(cad!==""){
                    posi=cad.indexOf("Partido");
                    partido=cad.substr(posi+8);
                    document.getElementById("partido").value=partido;
                }
            };
            
        }
        ;
    }
    function sale_bar(){
        if(document.getElementById("barrio").value!=""){
        valor=eje("vl_domicilios_comuna?barrio="+document.getElementById("barrio").value);
            document.getElementById("comuna").value=valor;
        } 
        else {
            document.getElementById("comuna").value="0";
        };
    }

    function dupli(){
        calle=document.getElementById("calle").value;
        calle_cruce=document.getElementById("calle_cruce").value;
        altura=document.getElementById("altura").value;
        localidad=document.getElementById("localidad").value;
        resp=eje("val_domicilio_existente_nn?calle="+calle+"&altura="+altura+"&localidad="+localidad);
        if(resp>"0"){
            status("domicilio duplicado");
            return false;  
        };
        return true;
    }
function valida_formulario(){
    calle=document.getElementById("calle").value;
    calle_cruce=document.getElementById("calle_cruce").value;
    altura=document.getElementById("altura").value;
    localidad=document.getElementById("localidad").value;
    partido=document.getElementById("partido").value;
    barrio=document.getElementById("barrio").value;
    comuna=document.getElementById("comuna").value;
    if(altura=="" & calle_cruce==""){status("altura o cruce");return false;};
    if(localidad=="CABA" && barrio==""){status("barrio");return false;};
    if(localidad=="CABA" && comuna<"1"){status("comuna");return false;};
    if(partido==""){status("partido");return false;};
    if(!dupli())    {return false;};
    document.getElementById("partido").disabled=false;
    document.getElementById("barrio").disabled=false;
    document.getElementById("comuna").disabled=false;
    status("");
    return true;
}    
</script>
</div>
</html>
	
