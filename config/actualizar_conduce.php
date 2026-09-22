<?php
// api/actualizar_conduce.php
// Tareas: "Permitir modificar los datos" + "Actualizar correctamente la
//          información en la base de datos" + "Mostrar mensaje de confirmación"

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../conexion.php';

$datos = json_decode(file_get_contents("php://input"), true);

if (!$datos || empty($datos["idConduce"]) || empty($datos["idCliente"])) {
    http_response_code(400);
    echo json_encode(["exito" => false, "mensaje" => "Datos incompletos para actualizar el conduce."]);
    exit;
}

$idConduce      = (int) $datos["idConduce"];
$idCliente      = (int) $datos["idCliente"];
$numeroConduce  = trim($datos["numeroConduce"] ?? "");
$fecha          = trim($datos["fecha"] ?? "");
$observaciones  = trim($datos["observaciones"] ?? "");

$cliente        = trim($datos["cliente"] ?? "");
$rncCedula      = trim($datos["rnccedula"] ?? "");
$direccion      = trim($datos["direccion"] ?? "");
$atencion       = trim($datos["atencion"] ?? "");
$telefono       = trim($datos["telefono"] ?? "");

$productos = $datos["productos"] ?? [];

if ($numeroConduce === "" || $fecha === "" || $cliente === "" || $rncCedula === "" || empty($productos)) {
    http_response_code(400);
    echo json_encode(["exito" => false, "mensaje" => "Faltan datos obligatorios del conduce."]);
    exit;
}

$conexion->begin_transaction();

try {
    // 1. Actualizar datos del cliente
    $sqlCliente = "UPDATE clientes
                   SET nombre = ?, rnc_cedula = ?, direccion = ?, atencion = ?, telefono = ?
                   WHERE id_cliente = ?";
    $stmt = $conexion->prepare($sqlCliente);
    $stmt->bind_param("sssssi", $cliente, $rncCedula, $direccion, $atencion, $telefono, $idCliente);
    $stmt->execute();
    $stmt->close();

    // 2. Actualizar datos del conduce
    $sqlConduce = "UPDATE conduces
                   SET numero_conduce = ?, fecha = ?, observaciones = ?
                   WHERE id_conduce = ?";
    $stmt = $conexion->prepare($sqlConduce);
    $stmt->bind_param("sssi", $numeroConduce, $fecha, $observaciones, $idConduce);
    $stmt->execute();
    $stmt->close();

    // 3. Reemplazar el detalle de productos (borrar e insertar de nuevo)
    $stmtEliminar = $conexion->prepare("DELETE FROM detalle_conduce WHERE id_conduce = ?");
    $stmtEliminar->bind_param("i", $idConduce);
    $stmtEliminar->execute();
    $stmtEliminar->close();

    // Inserta o actualiza el producto en el catálogo (por código único)
    // y recupera su id_producto aunque ya existiera.
    $sqlProducto = "INSERT INTO productos (codigo, descripcion, serial)
                     VALUES (?, ?, ?)
                     ON DUPLICATE KEY UPDATE
                         descripcion = VALUES(descripcion),
                         serial = VALUES(serial),
                         id_producto = LAST_INSERT_ID(id_producto)";
    $stmtProducto = $conexion->prepare($sqlProducto);

    $sqlDetalle = "INSERT INTO detalle_conduce (id_conduce, id_producto, cantidad) VALUES (?, ?, ?)";
    $stmtDetalle = $conexion->prepare($sqlDetalle);

    foreach ($productos as $producto) {
        $codigo      = trim($producto["codigo"] ?? "");
        $descripcion = trim($producto["descripcion"] ?? "");
        $serial      = trim($producto["serial"] ?? "");
        $cantidad    = (int) ($producto["cantidad"] ?? 0);

        if ($codigo === "" || $descripcion === "" || $cantidad <= 0) {
            continue;
        }

        $stmtProducto->bind_param("sss", $codigo, $descripcion, $serial);
        $stmtProducto->execute();
        $idProducto = $stmtProducto->insert_id;

        $stmtDetalle->bind_param("iii", $idConduce, $idProducto, $cantidad);
        $stmtDetalle->execute();
    }

    $stmtProducto->close();
    $stmtDetalle->close();

    $conexion->commit();

    echo json_encode([
        "exito"   => true,
        "mensaje" => "El conduce se actualizó correctamente."
    ]);
} catch (Exception $e) {
    $conexion->rollback();
    http_response_code(500);
    echo json_encode([
        "exito"   => false,
        "mensaje" => "Ocurrió un error al actualizar el conduce."
    ]);
}

$conexion->close();
