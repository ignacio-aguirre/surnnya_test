<?php
$reg=registros("select * from menues_contenido left join reportes on idreporte=reportes.id where menu=".$idmenu." and posicion=".$orden." order by orden");
while($r=mysqli_fetch_assoc($reg)){
echo '<p><a '.si($r["ventananueva"]=="1",' target="_blank"','').' href="'.$r["url"].'">'.si($r["nombre_menu"]=="",$r["titulo"],$r["nombre_menu"].si($r["excel"]==1,
"<img src='imagenes/excel.png' height='25' width='25' title='".$r["definicion_operativa"]."'></img>",
"<img src='imagenes/autorizar.png' height='25' width='25' title='".$r["definicion_operativa"]."'></img>")).'</a></p>';  
};
?>   

