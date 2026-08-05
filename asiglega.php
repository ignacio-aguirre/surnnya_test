<?PHP

include("Funciones.php");

session_start(); 

if (!isset($_SESSION['gldispo']) || !isset($_GET['ilega'])) header ("Location: salir");

$vlega=$_GET['ilega'];

$vinter=$_GET['inter'];

$sql="select legajo from sujetos where legajo=".$vlega;

$le = un_registro($sql);

if ($vlega==$le["legajo"]) {

$sql="select idintervenciones from intervenciones where idintervenciones=".$vinter;

$in = un_registro($sql);

if ($vinter==$in["idintervenciones"]) {

 ejecute("update  intervenciones set inter_legajo=".$vlega." where idintervenciones=".$vinter);

 header ("Location: consultaunainter?vid=".$vinter);

};

};

?>

</body>

</html>

