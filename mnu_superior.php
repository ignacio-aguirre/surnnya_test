<?php
echo '<nav class="navbar navbar-inverse">

  <div class="container-fluid">

    <div class="collapse navbar-collapse" id="myNavbar">

      <ul class="nav navbar-nav">

        <li'.si($_SESSION["posicion"]=="1"," class='active'","").'><a href="suje_cons_duros?legajo='.$lega.'">Principal</a></li>

        <li'.si($_SESSION["posicion"]=="2"," class='active'","").'><a href="suje_cons_alojamiento?legajo='.$lega.'">Alojamiento</a></li>

        <li'.si($_SESSION["posicion"]=="3"," class='active'","").'><a href="suje_cons_familiaescuela?legajo='.$lega.'">Familia/Escolaridad</a></li>

        <li'.si($_SESSION["posicion"]=="4"," class='active'","").'><a href="suje_cons_juridicos?legajo='.$lega.'">Jur&iacute;dicos</a></li>
        <li'.si($_SESSION["posicion"]=="5"," class='active'","").'><a href="suje_cons_archivos?legajo='.$lega.'">Archivos</a></li>
        
	<li'.si($_SESSION["posicion"]=="6"," class='active'","").'><a href="suje_cons_trimestrales?legajo='.$lega.'">Trimestrales</a></li>
        <li'.si($_SESSION["posicion"]=="7"," class='active'","").'><a href="suje_cons_salud?legajo='.$lega.'">Salud</a></li>
        <li'.si($_SESSION["posicion"]=="8"," class='active'","").'><a href="suje_cons_vivienda?legajo='.$lega.'">Vivienda</a></li>
<li'.si($_SESSION["posicion"]=="10"," class='active'","").'><a href="suje_otros?legajo='.$lega.'">Otros</a></li>br>';
if($_SESSION["glidperfil"]=="47"){
echo '<li'.si($_SESSION["posicion"]=="11"," class='active'","").'><a href="suje_cons_pae?legajo='.$lega.'">Datos PAE</a></li><br>';
};
echo '<li class="active"><a href="#">'.un_campo("select concat(apellidos,',',nombres,' ',legajo) as cosa from sujetos where legajo=".$lega).'</a></li>';
$grup=un_registro("select * from grupos left join grupos_legajos on idgrupos=grupo where grupo_legajo=".$lega);
if(!is_null($grup)) {echo '<li class="active"><a href="grupos2?id='.$grup['idgrupos'].'">Grupo de hermanos</a></li>';};
$fami=un_registro("select * from fv_familias_miembros left join fv_familias on familia=idfv_familias where legajo=".$lega);
if(!is_null($fami)) {echo '<li class="active"><a href="#">Grupo familiar '.$fami["descripcion"].' Legajo '.$fami["legajomanual"].'</a></li>';};

echo '<li class="active"><a href="consultasujetos">Volver a B&uacute;squeda</a></li></ul>
    </div>

  </div>

</nav>';



?>

