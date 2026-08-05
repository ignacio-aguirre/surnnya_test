<?php
include("Funciones.php");
session_start();
$legajos=registros("select sexo,sujetosdni,legajo from sujetos where sujetosdni is not null and (cuil is null or cuil='')");
 while($lega=mysqli_fetch_assoc($legajos)){
            if(strlen($lega["sujetosdni"])==8){
                $cuil=genera_cuil($lega["sexo"],$lega["sujetosdni"]);
                if (strlen($cuil)==11){ejecute("update sujetos set cuil=".tsql($cuil)." where legajo=".$lega["legajo"]);};
            }else{echo $lega["sujetosdni"]."<br>";  
            };
  };
   
 function genera_cuil($sexo,$dni){
        if($sexo=="F"){$pref="27";}
        else{$pref="20";};
        $cad=$pref.$dni;
        $mult='5432765432';
        $suma=0;
        for($i=1;$i<=10;$i++){
            $suma=$suma+(integer) substr($cad,$i,1) *(integer) substr($mult,$i,1);
        };
        $resto=$suma % 11;
        if($resto==1){
            $pref="23";
            if($sexo=="F"){$digi="4";} else{$digi="9";};
        };
        if($resto==0){$digi="0";};
        if($resto>1){$digi=(string)(11-intval($resto));};
        return $pref . $dni .$digi;
    }

   ?> 