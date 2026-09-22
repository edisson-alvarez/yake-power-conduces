<?php
// api/obtener_conduce.php?id=ID
// Tarea: "Cargar en el formulario los datos existentes del conduce seleccionado"

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../conexion.php';

$idConduce = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($idConduce <= 0) {
    http_response_code(400);
    echo json_encode(["exito" => false, "mensaje" => "ID de conduce inválido."]);
    exit;
}

// Datos del conduce + cliente
$sqlConduce = "SELECT
                    c.id_conduce,
                    c.numero_conduce,
                    c.fecha,
                    c.observaciones,
                    cl.id_cliente,
                    cl.nombre    AS cliente,
                    cl.rnc_cedula,
                    cl.direccion,
                    cl.atencion,
                    cl.telefono
               FROM conduces c
               INNER JOIN clientes cl ON cl.id_cliente = c.id_cliente
               WHERE c.id_conduce = ?";

$stmt = $conexion->prepare($sqlConduce);
$stmt->bind_param("i", $idConduce);
$stmt->execute();
$resultadoConduce = $stmt->get_result();

if ($resultadoConduce->num_rows === 0) {
    http_response_code(404);
    echo json_encode(["exito" => false, "mensaje" => "El conduce no existe."]);
    exit;
}

$conduce = $resultadoConduce->fetch_assoc();
$stmt->close();

// Productos del conduce
$sqlProductos = "SELECT
                    p.codigo,
                    p.descripcion,
                    p.serial,
                    d.cantidad
                  FROM detalle_conduce d
                  INNER JOIN productos p ON p.id_producto = d.id_producto
                  WHERE d.id_conduce = ?";

$stmtProductos = $conexion->prepare($sqlProductos);
$stmtProductos->bind_param("i", $idConduce);
$stmtProductos->execute();
$resultadoProductos = $stmtProductos->get_result();

$productos = [];
while ($fila = $resultadoProductos->fetch_assoc()) {
    $productos[] = $fila;
}
$stmtProductos->close();

$conduce["productos"] = $productos;

echo json_encode([
    "exito"   => true,
    "conduce" => $conduce
]);

$conexion->close();
