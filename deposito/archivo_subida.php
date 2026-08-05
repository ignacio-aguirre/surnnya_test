<?php
include("funciones.php");
session_start();
$status = "Es obligatorio indicar el tipo de archivo y una descripción del mismo";

if ($_FILES["archivo"]["name"]!="") {
    // obtenemos los datos del archivo
    $tipo=$_POST["tipo"];
    $id=$_POST["id"];
    $referencia=$_POST["referencia"];
    $retorno=$_POST["retorno"];
    $archivo = normaliza($_FILES["archivo"]['name']);
    $destino = "archivos/".substr($_SESSION["hoy"],-4)."/".substr($_SESSION["hoy"],3,2)."/".$id."_".$archivo;
    if ($archivo != "") {       
        if (copy($_FILES['archivo']['tmp_name'],$destino)) {
            $status = "Archivo subido: ".$archivo;
            $sql="insert into archivos(tipo,referencia,ruta,usuario,fecha) values(".tsql($tipo).",".tsql($referencia).",".tsql($destino).",".$_SESSION["usuario"].",curdate())";
            $idarchivo=inserte($sql);
            if($tipo=="ARTIC") ejecute("update articulos set archivo=".$idarchivo." where idarticulos=".$id);
            if($tipo=="COMPR") ejecute("update comprobantes set archivo=".$idarchivo." where idcomprobantes=".$id);
            if($tipo=="INVEN") Redirect("stock_excel_inventario?archivo=".$idarchivo);
            Redirect($retorno);
        } else {
            $status = "Error al subir el archivo";
        }
    } else {
        $status = "El nombre de archivo está vacío";
    }
};


Alerte($status);

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