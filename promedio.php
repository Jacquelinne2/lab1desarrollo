<?php
require "vendor/autoload.php";
$url = "http://localhost/webservice/wservice.php?wsdl";

$cliente = new nusoap_client($url, 'wsdl');
$error = $cliente->getError();
if ($error) {
    echo "Error de conexión en el webservice: $error";
    exit;
}

$parametros = array(
    'nombre' => $_POST["nombre"],
    'laboratorio1' => $_POST["laboratorio1"],
    'laboratorio2' => $_POST["laboratorio2"],
    'parcial' => $_POST["parcial"]
);

$resultado = $cliente->call('calcularPromedio', $parametros);

if ($cliente->fault) {
    echo "Fault: <pre>" . print_r($resultado, true) . "</pre>";
} else {
    $error = $cliente->getError();
    if ($error) {
        echo "Error: $error";
    } else {
        echo "
            <table border='1'>
                <tr>
                    <td>Nombre:</td>
                    <td>{$resultado['nombre']}</td>
                </tr>
                <tr>
                    <td>Laboratorio 1:</td>
                    <td>{$resultado['laboratorio1']}</td>
                </tr>
                <tr>
                    <td>Laboratorio 2:</td>
                    <td>{$resultado['laboratorio2']}</td>
                </tr>
                <tr>
                    <td>Parcial:</td>
                    <td>{$resultado['parcial']}</td>
                </tr>
                <tr>
                    <td>Promedio:</td>
                    <td>{$resultado['promedio']}</td>
                </tr>
            </table>
        ";
    }
}
?>
