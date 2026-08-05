<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Validar parámetro
if (!isset($_GET["direccion"])) {
    echo json_encode(["error" => "Falta el parámetro 'direccion'"]);
    exit;
}

$direccion = urlencode($_GET["direccion"]);

$url = "https://servicios.usig.buenosaires.gob.ar/normalizar/?direccion={$direccion}&maxOptions=25&geocodificar=true";

// Inicializar CURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Ejecutar request
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(["error" => curl_error($ch)]);
    curl_close($ch);
    exit;
}

curl_close($ch);

// Enviar la respuesta del servicio USIG al frontend
echo $response;
?>