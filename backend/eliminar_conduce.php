<?php
require_once '../config/conexion.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos en formato JSON
    $data = json_decode(file_get_contents("php://input"), true);
    $id_conduce = isset($data['id_conduce']) ? (int)$data['id_conduce'] : 0;

    if ($id_conduce <= 0) {
        die(json_encode(["status" => "error", "message" => "ID de conduce inválido."]));
    }

    // La base de datos manejará los registros en detalle_conduce gracias al ON DELETE CASCADE
    $stmt = $conexion->prepare("DELETE FROM conduces WHERE id_conduce = ?");
    $stmt->bind_param("i", $id_conduce);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(["status" => "success", "message" => "El conduce ha sido eliminado correctamente."]);
        } else {
            echo json_encode(["status" => "error", "message" => "No se encontró el conduce especificado en la base de datos."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error al eliminar el registro: " . $conexion->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido."]);
}
?>