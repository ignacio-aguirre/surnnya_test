<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
include("Funciones.php");
session_start();
$ruta="../surnnya/intercambio/expo_nnya.xlsx";
$oE = IOFactory::load($ruta);
$oE->setActiveSheetIndex(0);
$fil=2;
while(e_get($oE,'A'.ltrim((string)$fil))!=""){
 $a=e_get($oE,'A'.ltrim((string)$fil));
 $b=e_get($oE,'B'.ltrim((string)$fil));
 $c=e_get($oE,'C'.ltrim((string)$fil));
 $d=e_get($oE,'D'.ltrim((string)$fil));
 $e=e_get($oE,'E'.ltrim((string)$fil));
 $g=e_get($oE,'G'.ltrim((string)$fil));
 $h=e_get($oE,'H'.ltrim((string)$fil));
 $i=e_get($oE,'I'.ltrim((string)$fil));
 $p=e_get($oE,'P'.ltrim((string)$fil));

 $idnnya=un_campo("select idalojados from alojados where idsurnnya=".$b);
 if(!$idnnya>0) {
   $idnnya=inserte("insert into alojados(idsurnnya,apellidos,nombres,dni,nacimiento) values(".$b.",".tsql($c).",".tsql($d).",".si($i=="","0",$i).",".fsql($g).")");
   if($p>0) ejecute("update alojados set defensoria_zonal=".$p." where idalojados=".$idnnya);
 }; 
  ejecute("update alojados set apellidos=".tsql($c).", nombres=".tsql($d).", dni=".si($i=="","0",tsql($i)).", nacimiento=".fsql($g)." where idalojados=".$idnnya);
  if($e!="") ejecute("update alojados set sexo=".si($e=="M",1,si($e=="F",2,3))." where idalojados=".$idnnya);
 
$fil=$fil+1;
};
Redirect($_SESSION["menu"]);
?>



           