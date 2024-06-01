<?php 
require "vendor/autoload.php";

$server = new nusoap_server;
$server->configureWSDL('server', 'urn:server');
$server->wsdl->schemaTargetNamespace = 'urn:server';

$server->wsdl->addComplexType(
    'Resultado',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'nombre' => array('name' => 'nombre', 'type' => 'xsd:string'),
        'laboratorio1' => array('name' => 'laboratorio1', 'type' => 'xsd:float'),
        'laboratorio2' => array('name' => 'laboratorio2', 'type' => 'xsd:float'),
        'parcial' => array('name' => 'parcial', 'type' => 'xsd:float'),
        'promedio' => array('name' => 'promedio', 'type' => 'xsd:float'),
    )
);

$server->register(
    'calcularPromedio',
    array('nombre' => 'xsd:string', 'laboratorio1' => 'xsd:float', 'laboratorio2' => 'xsd:float', 
    'parcial' => 'xsd:float'),
    array('return' => 'tns:Resultado'),
    'urn:server',
    'urn:server#calcularPromedioServer',
    'rpc',
    'encoded',
    'Función para calcular el promedio'
);

function calcularPromedio($nombre, $laboratorio1, $laboratorio2, $parcial) {
    $promedio = ($laboratorio1 * 0.25) + ($laboratorio2 * 0.25) + ($parcial * 0.50);
    return array(
        'nombre' => $nombre,
        'laboratorio1' => $laboratorio1,
        'laboratorio2' => $laboratorio2,
        'parcial' => $parcial,
        'promedio' => $promedio
    );
}

$server->service(file_get_contents("php://input"));

