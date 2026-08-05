<?php
include("funciones.php");
session_start();
$_SESSION['DiaHoy']=ffec(un_campo("select curdate() as hoy"));
tranca();
    // obtenemos los datos del archivo
    $descripcion=$_POST["descripcion"];
    $tamano = $_FILES["archivo"]['size'];
    $tipo = $_FILES["archivo"]['type'];
    $archivo = normaliza($_FILES["archivo"]['name']);
    $usuario=$_POST["id"];
    $id=inserte("insert into archivos(descripcion,fecha,usuario,fecha_alta) values('CLAUSULA CONFIDENCIALIDAD',curdate(),".$_SESSION["usuario"].",curdate())");
    $destino = "repositorio/".substr($_SESSION["DiaHoy"],-4)."/".substr($_SESSION["DiaHoy"],3,2)."/".$id."_".$archivo;
    if ($archivo != "") {
       if (copy($_FILES['archivo']['tmp_name'],$destino)) {
            $status = "Archivo subido: ".$archivo;
            ejecute("update archivos set ruta=".tsql($destino)." where idarchivos=".$id);
	    ejecute("update usuarios set clausula=".$id." where idusuarios=".$usuario);	
            Redirect("unusuario?id=".$usuario);
        } else {
            $status = "Error al subir el archivo";
        }
    } else {
        $status = "El nombre de archivo está vacío";
    };


echo $status;

function normaliza($texto){
 $t=strtolower($texto);
 $largocadena=strlen($t);
 $salida="";
 for ($i = 0; $i < $largocadena; $i++) {
    $l=substr($t,$i,1);
    if(!esletnum($l)) $l="x";
    $salida=$salida.$l;
 };
return $salida;
}

function esletnum($letra){
if(($letra<"a"||$letra>"z"))
 {
    if($letra!="." && $letra!="\\"&& $letra!=":" && $letra!=" " && $letra!="_" && $letra!="-" && $letra!="+") {
      if(($letra<"0"||$letra>"9")) {
         return false;
      };
    };
 };
return true;
}


?>
</body>
</html>