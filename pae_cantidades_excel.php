<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$ingresos=un_campo("select count(*) from pae_nomina where f_cons_inf between ".fget("desde")." and ".fget("hasta"));
$egresos=un_campo("select count(*) from pae_nomina where f_baja between ".fget("desde")." and ".fget("hasta"));
$incluidos=un_campo("select count(*) from pae_nomina where f_cons_inf<=".fget("hasta")." and (f_baja is null or f_baja>".fget("desde").")");
$porsexo=un_registro("select sum(case when sexo='F' then 1 else 0 end) as fem, sum(case when sexo='M' then 1 else 0 end) as mas from pae_nomina  
left join sujetos on pae_nomina.legajo=sujetos.legajo
where f_cons_inf<=".fget("hasta")." and (f_baja is null or f_baja>".fget("desde").")");
$femenino=$porsexo["fem"];
$masculino=$porsexo["mas"];
ejecute("delete from temp_pae_estados where sesion=".$_SESSION["gl_sesion"]);
ejecute("insert into temp_pae_estados(sesion,id_inclusion,legajo,etapa,hogar) select ".$_SESSION["gl_sesion"].",id,legajo,0,0 from pae_nomina 
where f_cons_inf<=".fget("hasta")." and (f_baja is null or f_baja>".fget("desde").")");
ejecute("update temp_pae_estados set etapa=(select etapa from pae_nomina_estados where inclusion=id_inclusion and fecha<=".fget("hasta")." and etapa in(1,2) order by fecha desc limit 1) where sesion=".$_SESSION["gl_sesion"]);
ejecute("update temp_pae_estados set hogar=(select admi_hogar from hogares_admision where admi_alta<=".fget("hasta").
" and (admi_baja is null or admi_baja>".fget("desde").") and admi_legajo=legajo order by admi_alta desc limit 1) where sesion=".$_SESSION["gl_sesion"]);
$cjv=registros("select * from cjoven_nomina where alta<=".fget("hasta")." and (baja is null or baja>".fget("desde").")");
while($c=mysqli_fetch_assoc($cjv)){
  ejecute("update temp_pae_estados set hogar=209 where legajo=".$c["legajo"]." and sesion=".$_SESSION["gl_sesion"]);	
};
$poretapa=un_registro("select sum(case when etapa=1 then 1 else 0 end) as e1, sum(case when etapa=2 then 1 else 0 end) as e2 from temp_pae_estados where  sesion=".$_SESSION["gl_sesion"]);  
$etapa1=$poretapa["e1"];
$etapa2=$poretapa["e2"];
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0)
            
            ->setCellValue('A3', 'Ingresos')
            ->setCellValue('A4', $ingresos)
            ->setCellValue('B3', 'Egresos')
            ->setCellValue('B4', $egresos)
            ->setCellValue('C3', 'Incluidos')
            ->setCellValue('C4', $incluidos)
            ->setCellValue('A6', 'Sobre el total de NNYA incluidos en el Periodo')
            ->setCellValue('A7', 'Etapa 1')
	    ->setCellValue('A8', $etapa1)
            ->setCellValue('B7', 'Etapa 2')
	    ->setCellValue('B8', $etapa2)
            ->setCellValue('C7', 'Femenino')
	    ->setCellValue('C8', $femenino)
            ->setCellValue('D7', 'Masculino')
	    ->setCellValue('D8', $masculino)
            ->setCellValue('A10','Segun Edad')
   ;

$tedad=0;
$fl=10;
$reg=registros("select edadcalc(f_nacimiento,sujetosEdad,SujetosMeses,SujetosActEdad,curdate()) as edad_calc,count(*) as cantidad
from pae_nomina left join sujetos on pae_nomina.legajo=sujetos.legajo
where f_cons_inf<=".fget("hasta")." and (f_baja is null or f_baja>".fget("desde").") group by edad_calc order by edad_calc");
while($r=mysqli_fetch_assoc($reg)){
 $fl=$fl+1;
 $tedad=$tedad+$r["cantidad"];
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), si($r["edad_calc"]=="","S/D",$r["edad_calc"]))
	    ->setCellValue('B'.ltrim((string)$fl), $r["cantidad"]);

};
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "TOTAL")
	    ->setCellValue('B'.ltrim((string)$fl), $tedad);


$fl=$fl+2;
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl),'Segun Nacionalidad');
$tnac=0;
$reg=registros("select paises.descripcion, count(*) as cantidad from pae_nomina
 left join sujetos on sujetos.legajo=pae_nomina.legajo 
 left join paises on nacionalidad=idpaises   
where f_cons_inf<=".fget("hasta")." and (f_baja is null or f_baja>".fget("desde").")  group by paises.descripcion order by paises.descripcion");
while($r=mysqli_fetch_assoc($reg)){
 $fl=$fl+1;
 $tnac=$tnac+$r["cantidad"];
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), si($r["descripcion"]=="","S/D",$r["descripcion"]))
	    ->setCellValue('B'.ltrim((string)$fl), $r["cantidad"]);
};
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "TOTAL")
	    ->setCellValue('B'.ltrim((string)$fl), $tnac);

$fl=$fl+2;
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl),'Segun Dispositivo Alojamiento');
$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl),'Dispositivo')
            ->setCellValue('B'.ltrim((string)$fl),'NNYA')
            ->setCellValue('C'.ltrim((string)$fl),'en Etapa 1')
            ->setCellValue('D'.ltrim((string)$fl),'en Etapa 2')
;

$alojados=0;
$aloj1=0;
$aloj2=0;
$noalojados=0;
$reg=registros("select nombre, count(*) as cantidad, sum(case when temp_pae_estados.etapa=1 then 1 else 0 end) as etapa1, 
sum(case when temp_pae_estados.etapa=2 then 1 else 0 end) as etapa2 
 from temp_pae_estados
 left join dispositivos on dispositivos.id=hogar 
 where  sesion=".$_SESSION["gl_sesion"]." group by nombre order by nombre");
while($r=mysqli_fetch_assoc($reg)){
 $fl=$fl+1;
 $alojados=$alojados+$r["cantidad"];
 $aloj1=$aloj1+$r["etapa1"]; 
 $aloj2=$aloj2+$r["etapa2"]; 
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), si($r["nombre"]=="","NO ALOJADOS",$r["nombre"]))
	    ->setCellValue('B'.ltrim((string)$fl), $r["cantidad"])
	    ->setCellValue('C'.ltrim((string)$fl), $r["etapa1"])
	    ->setCellValue('D'.ltrim((string)$fl), $r["etapa2"])
;
};
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "TOTALES")
	    ->setCellValue('B'.ltrim((string)$fl), $incluidos)
	    ->setCellValue('C'.ltrim((string)$fl), $etapa1)
	    ->setCellValue('D'.ltrim((string)$fl), $etapa2);

$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),axel("Usuario ".$_SESSION["glusua"]));
for($col='A'; $col<= 'A'; $col++){
	ajusta($col);
};
$spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'Cantidades NNYA PAE - '.$_GET["desde"]." - ".$_GET["hasta"]);
$spreadsheet->getActiveSheet()->setTitle('PAE Cantidades');
$spreadsheet->setActiveSheetIndex(0);
$filename="PAE-cantidades.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Expires: 0');
header('Pragma: public');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;

function ajusta($r){
global $spreadsheet;
$spreadsheet->getActiveSheet()->getColumnDimension($r)->setAutoSize(true);
};
?>
           