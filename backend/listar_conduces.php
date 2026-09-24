<?php
require_once '../config/conexion.php';
header('Content-Type: application/json');

// Extraer conduces uniéndolos con la tabla clientes para obtener el nombre
$query = "SELECT c.id_conduce, c.numero_conduce, c.fecha, cl.nombre AS cliente 
          FROM conduces c 
          INNER JOIN clientes cl ON c.id_cliente = cl.id_cliente 
          ORDER BY c.fecha DESC";

$resultado = $conexion->query($query);
$conduces = [];

if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        $conduces[] = $fila;
    }
}

echo json_encode($conduces);
?>