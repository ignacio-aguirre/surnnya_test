<?php 
include("funciones.php");
session_start();
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$tabla=$_GET["tipo"];
if(!strpos($tabla,"EXCEL")) echo "<table id='brow' class='table table-bordered table-condensed'>";
if($tabla=="STOCK"){
 $rubro=nget("rubro");
 echo "<tr class='bg-primary'><th>Rubro</th><th>Art&iacute;culo</th><th>F&iacute;sico</th><th>M&iacute;nimo</th><th>Acciones</th></tr>";
 $reg=registros("select articulos.descripcion,articulos_rubros.descripcion as rub, rubro, idarticulos,minimo, cantidad as stk from articulos
 left join articulos_rubros on rubro=idarticulos_rubros 
 left join existencias on idarticulos=articulo where articulos.baja is null ".si($rubro==0,""," and rubro=".$rubro).
 " order by articulos_rubros.descripcion, articulos.descripcion");
 while($r=mysqli_fetch_assoc($reg)){
  echo "<tr".si($r["stk"]<$r["minimo"]," style=color:red","")."><td>".$r["rub"]."</td><td>".$r["descripcion"]."</td><td align='right'>".$r["stk"]."</td>
 <td align='right'><input class='form-control-small' size='4' maxlength='4' value='".$r["minimo"]."' id='".$r['idarticulos']."' onblur='carga_minimo(this.id)'></td><td>";
  echo "<img src='imagenes/ver.svg' height='20' width='20' onclick='movimientos(".$r["rubro"].",".$r["idarticulos"].")'>&nbsp;";
};
echo "</table>";
};

if($tabla=="STOCKBU"){
 $rubro=nget("rubro");
 echo "<tr class='bg-primary'><th>Rubro</th><th>Art&iacute;culo</th><th>Ficha estante</th><th>F&iacute;sico</th></tr>";
 $reg=registros("select articulos.descripcion,articulos_rubros.descripcion as rub, rubro, idarticulos,minimo, cantidad as stk from articulos
 left join articulos_rubros on rubro=idarticulos_rubros 
 left join existencias on idarticulos=articulo where articulos.tipo_bien=2 and articulos.baja is null ".si($rubro==0,""," and rubro=".$rubro).
 " order by articulos_rubros.descripcion, articulos.descripcion");
 while($r=mysqli_fetch_assoc($reg)){
  echo "<tr><td>".$r["rub"]."</td><td>".$r["descripcion"]."</td><td></td><td align='right'>".$r["stk"]."</td></tr>";
  $uni=registros("select * from unidades where articulo=".$r["idarticulos"]." and f_egreso is null order by f_ingreso");
  while($u=mysqli_fetch_assoc($uni)){
    echo "<tr><td></td><td>ingreso ".ffec($u["f_ingreso"])."</td><td>".$u["ficha_estante"]."</td><td align='right'>1</td></tr>";

  };
};
echo "</table>";
};

if($tabla=="STOCK_CRITICO"){
 $rubro=nget("rubro");
 echo "<tr class='bg-primary'><th>Rubro</th><th>Art&iacute;culo</th><th>F&iacute;sico</th><th>M&iacute;nimo</th><th>Faltante</th><th>Editar Min</th></tr>";
 $reg=registros("select articulos.descripcion,articulos_rubros.descripcion as rub, articulo, rubro, minimo, cantidad as stk from articulos
 left join articulos_rubros on articulos.rubro=idarticulos_rubros   
 left join existencias on idarticulos=articulo  where articulos.baja is null ".si($rubro==0,""," and rubro=".$rubro).
 " having stk<minimo order by rub, articulos.descripcion");
 while($r=mysqli_fetch_assoc($reg)){
  echo "<tr><td>".utf8_encode($r["rub"])."</td><td>".utf8_encode($r["descripcion"])."</td><td align='right'>".$r["stk"]."</td><td align='right'>".$r["minimo"]."</td><td align='right'>".(string)($r["minimo"]-$r["stk"])."</td><td align='right'>";
  echo "<input class='form-control-small' size='4' maxlength='4' value='".$r["minimo"]."' id='".$r['articulo']."' onblur='carga_minimo(".$r["articulo"].",this.value)'></td></tr>";
  };
echo "</table>";
};


if($tabla=="STOCK_MOVIMIENTOS"){
 $articulo=nget("articulo");
 $stock=un_campo("select sum(cantidad) from existencias where articulo=".$articulo);
 echo "<tr class='bg-primary'><th>Fecha</th><th>Operaci&oacute;n</th>
 <th>Efector</th><th>Cantidad</th></tr>";
 $reg=registros("select origen_fecha as fecha,origen_tipo,origen_id, cantidad,observaciones from  stock    where articulo=".$articulo." order by fecha desc");
 while($r=mysqli_fetch_assoc($reg)){
  $nro=$r["origen_id"];
  $f_estante="";
  $efector="";
  if($r["origen_tipo"]=="RME"){ $remito=un_registro("select numero,efector,nombre  from remitos where idremitos=".$r["origen_id"]);
       $nro=$remito["numero"];
       $efector=$remito["nombre"];
};
  if($r["origen_tipo"]=="ING"){ $remito=un_registro("select observaciones from ingresos where idingresos=".$r["origen_id"]);
       $efector=$remito["observaciones"];
}; 
  if($r["origen_tipo"]=="AJU"){ $remito=un_registro("select motivo from ajustes where idajustes=".$r["origen_id"]);
       $efector=$remito["motivo"];
}; 

  echo "<tr><td>".ffec($r["fecha"])."</td><td>".$r["origen_tipo"]." ".$nro."</td><td>".$efector."</td><td align='right'>".$r["cantidad"]."</td></tr>";
 };
echo "</table><br>Stock Actual:".$stock;
};


if($tabla=="AJUSTES"){
 $desde=fget("desde");
 $hasta=fget("hasta");
 echo "<tr class='bg-primary'><th>Fecha</th><th>Id</th><th>Motivo</th><th>Acciones</th></tr>";
 $reg=registros("select fecha,idajustes, motivo from ajustes  where fecha between ".$desde." and ".$hasta." order by fecha desc, idajustes desc");
 while($r=mysqli_fetch_assoc($reg)){
  echo "<tr><td>".ffec($r["fecha"])."</td><td>".$r["idajustes"]."</td><td>".$r["motivo"].
  "</td><td><img src='imagenes/ver.svg' height='20' width='20' onclick='ver(".$r["idajustes"].")'>&nbsp;<img src='imagenes/eliminar.png' height='20' width='20' onclick='eliminar(".$r["idajustes"].")'></td></tr>";
 };
echo "</table>";
};



if($tabla=="STOCK_EXCEL"){
 $rubro=nget("rubro");
 error_reporting(E_STRICT);
 

 $oE = new Spreadsheet();
 
 e_put($oE,'A1', 'Rubro');
 e_put($oE,'B1', utf8_encode('Artículo'));
 e_put($oE,'C1', 'Stock');
 e_put($oE,'D1', utf8_encode('Mínimo'));
 $fecha=ffec(un_campo("select curdate() from dual"));
 e_put($oE,'E1',substr($fecha,-4));
 e_put($oE,'F1',substr($fecha,3,2));
 e_put($oE,'G1',substr($fecha,0,2));

 $reg=registros("select articulos.descripcion,articulos_rubros.descripcion as rub, minimo, cantidad as stk 
 from articulos left join articulos_rubros on rubro=idarticulos_rubros left join existencias on idarticulos=articulo where articulos.baja is null ".si($rubro==0,""," and rubro=".$rubro).
 " order by articulos_rubros.descripcion, articulos.descripcion");
 $f=2;
  while($r=mysqli_fetch_assoc($reg)){
    e_put($oE,'A'.ltrim((string)$f), $r["rub"]);
    e_put($oE,'B'.ltrim((string)$f), $r["descripcion"]);
    e_put($oE,'C'.ltrim((string)$f), $r["stk"]);
    e_put($oE,'D'.ltrim((string)$f), $r["minimo"]);
    $f=$f+1;
  };
  for($col="A";$col<="G";$col++){
   ajusta($col);
  };
  $oE->getActiveSheet()->setTitle('Consulta de Stock');
  $oE->setActiveSheetIndex(0);
  $filename = 'Consulta-stock.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Expires: 0');
header('Pragma: public');

$writer = new Xlsx($oE);
$writer->save('php://output');
exit;

  
};

if($tabla=="STOCK_CRITICO_EXCEL"){
 $rubro=nget("rubro");
 error_reporting(E_STRICT);
 $oE = new Spreadsheet();
 e_put($oE,'A1', 'Rubro');
 e_put($oE,'B1', 'Artículo');
 e_put($oE,'C1', 'Stock');
 e_put($oE,'D1', 'Mínimo');
 e_put($oE,'E1', 'Faltante');
 e_put($oE,'F1', un_campo("select curdate() from dual"));

 $reg=registros("select articulos.descripcion,articulos_rubros.descripcion as rub, minimo, cantidad 
 from articulos left join articulos_rubros on rubro=idarticulos_rubros left join existencias on idarticulos=articulo where 
 cantidad<minimo and articulos.baja is null ".si($rubro==0,""," and rubro=".$rubro)." order by articulos_rubros.descripcion, articulos.descripcion");
 $f=2;
 while($r=mysqli_fetch_assoc($reg)){
    e_put($oE,'A'.ltrim((string)$f), $r["rub"]);
    e_put($oE,'B'.ltrim((string)$f), $r["descripcion"]);
    e_put($oE,'C'.ltrim((string)$f), $r["cantidad"]);
    e_put($oE,'D'.ltrim((string)$f), $r["minimo"]);
    e_put($oE,'E'.ltrim((string)$f), intval($r["minimo"])-intval($r["cantidad"]));
   $f=$f+1;
  };
  ajusta("A");
  ajusta("B");
  ajusta("C");
  ajusta("D");
  $oE->getActiveSheet()->setTitle('StockCritico');
  $oE->setActiveSheetIndex(0);
  $filename = 'Consulta-critico.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Expires: 0');
header('Pragma: public');

$writer = new Xlsx($oE);
$writer->save('php://output');
exit;
  
};


function ajusta($r){
global $oE;
$oE->getActiveSheet()->getColumnDimension($r)->setAutoSize(true);
};

?>















