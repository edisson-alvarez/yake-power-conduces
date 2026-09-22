<?php
// api/listar_conduces.php
// Tarea: "Consultar los conduces guardados en la base de datos"
//        + "Incluir información básica del cliente y del conduce"

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../conexion.php';

$sql = "SELECT
            c.id_conduce,
            c.numero_conduce,
            c.fecha,
            cl.nombre       AS cliente,
            cl.rnc_cedula,
            cl.telefono
        FROM conduces c
        INNER JOIN clientes cl ON cl.id_cliente = c.id_cliente
        ORDER BY c.fecha DESC, c.id_conduce DESC";

$resultado = $conexion->query($sql);

$conduces = [];

if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        $conduces[] = $fila;
    }
}

echo json_encode([
    "exito"    => true,
    "conduces" => $conduces
]);

$conexion->close();
