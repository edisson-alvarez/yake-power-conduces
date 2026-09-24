<?php

require_once '../config/conexion.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Recibir datos del cliente
    $nombre      = trim($_POST['cliente_nombre'] ?? '');
    $rnc_cedula  = trim($_POST['rnc_cedula'] ?? '');
    $direccion   = trim($_POST['direccion'] ?? '');
    $atencion    = trim($_POST['atencion'] ?? '');
    $telefono    = trim($_POST['telefono'] ?? '');
    
    // 2. Recibir datos del conduce
    $observaciones = trim($_POST['observaciones'] ?? '');
    $id_usuario    = 1; 
    $fecha         = date('Y-m-d');
    $numero_conduce= 'COND-' . strtoupper(uniqid()); // Generación de un número de conduce único
    
    // 3. Recibir arrays de productos
    $productos   = $_POST['producto_id'] ?? []; 
    $cantidades  = $_POST['cantidad'] ?? [];

    // Validaciones básicas
    if (empty($nombre) || empty($rnc_cedula)) {
        die(json_encode(["status" => "error", "message" => "El nombre y RNC/Cédula del cliente son obligatorios."]));
    }
    if (empty($productos) || count($productos) !== count($cantidades)) {
        die(json_encode(["status" => "error", "message" => "Debe agregar productos válidos al conduce."]));
    }

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    try {
        $conn->begin_transaction();

        // 4. Guardar o reutilizar cliente
        $stmt_cliente = $conn->prepare("SELECT id_cliente FROM clientes WHERE rnc_cedula = ? LIMIT 1");
        $stmt_cliente->bind_param("s", $rnc_cedula);
        $stmt_cliente->execute();
        $resultado_cliente = $stmt_cliente->get_result();

        if ($fila = $resultado_cliente->fetch_assoc()) {
            $id_cliente = $fila['id_cliente'];
            
            // Opcional: Actualizar datos del cliente si cambiaron
            $stmt_update = $conn->prepare("UPDATE clientes SET nombre=?, direccion=?, atencion=?, telefono=? WHERE id_cliente=?");
            $stmt_update->bind_param("ssssi", $nombre, $direccion, $atencion, $telefono, $id_cliente);
            $stmt_update->execute();
        } else {
            $stmt_nuevo_cliente = $conn->prepare("INSERT INTO clientes (nombre, rnc_cedula, direccion, atencion, telefono) VALUES (?, ?, ?, ?, ?)");
            $stmt_nuevo_cliente->bind_param("sssss", $nombre, $rnc_cedula, $direccion, $atencion, $telefono);
            $stmt_nuevo_cliente->execute();
            $id_cliente = $stmt_nuevo_cliente->insert_id;
        }

        // 5. Crear el registro del conduce
        $stmt_conduce = $conn->prepare("INSERT INTO conduces (numero_conduce, fecha, id_cliente, id_usuario, observaciones) VALUES (?, ?, ?, ?, ?)");
        $stmt_conduce->bind_param("ssiis", $numero_conduce, $fecha, $id_cliente, $id_usuario, $observaciones);
        $stmt_conduce->execute();
        $id_conduce = $stmt_conduce->insert_id;

        
        // 6. Guardar los productos y el detalle del conduce
        $codigos      = $_POST['codigo'] ?? [];
        $descripciones= $_POST['descripcion'] ?? [];
        $seriales     = $_POST['serial'] ?? [];
        $cantidades   = $_POST['cantidad'] ?? [];

        $stmt_buscar_prod = $conn->prepare("SELECT id_producto FROM productos WHERE codigo = ? LIMIT 1");
        $stmt_nuevo_prod  = $conn->prepare("INSERT INTO productos (codigo, descripcion, serial) VALUES (?, ?, ?)");
        $stmt_detalle     = $conn->prepare("INSERT INTO detalle_conduce (id_conduce, id_producto, cantidad) VALUES (?, ?, ?)");
        
        for ($i = 0; $i < count($codigos); $i++) {
            $codigo = trim($codigos[$i]);
            $descripcion = trim($descripciones[$i]);
            $serial = trim($seriales[$i]);
            $cantidad = (int)$cantidades[$i];

            if (!empty($codigo) && $cantidad > 0) {
                // Verificar si el producto ya existe
                $stmt_buscar_prod->bind_param("s", $codigo);
                $stmt_buscar_prod->execute();
                $res_prod = $stmt_buscar_prod->get_result();
                
                if ($fila_prod = $res_prod->fetch_assoc()) {
                    $id_producto = $fila_prod['id_producto'];
                } else {
                    // Si no existe, crearlo
                    $stmt_nuevo_prod->bind_param("sss", $codigo, $descripcion, $serial);
                    $stmt_nuevo_prod->execute();
                    $id_producto = $stmt_nuevo_prod->insert_id;
                }

                // Insertar en la tabla pivote de detalles
                $stmt_detalle->bind_param("iii", $id_conduce, $id_producto, $cantidad);
                $stmt_detalle->execute();
            }
        }

        $conn->commit();
        
        echo json_encode([
            "status" => "success", 
            "message" => "El conduce $numero_conduce ha sido generado correctamente."
        ]);

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode([
            "status" => "error", 
            "message" => "Ocurrió un error en la base de datos: " . $e->getMessage()
        ]);
    }
}
?>