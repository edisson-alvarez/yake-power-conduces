<?php
// Conectamos con la carpeta config ya que este archivo está en la raíz
require_once 'config/conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar y limpiar las entradas del formulario de login
    $identificador = trim($_POST['identificador'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validar si algún campo vino vacío
    if (empty($identificador) || empty($password)) {
        header("Location: login.php?error=" . urlencode("Por favor, llena todos los campos."));
        exit;
    }

    // Consulta SQL preparada buscando en las columnas 'usuario' o 'correo'
    $sql = "SELECT id_usuario, usuario, nombre, password FROM usuarios WHERE usuario = ? OR correo = ? LIMIT 1";
    
    if ($stmt = $conexion->prepare($sql)) {
        // Enlazamos el identificador dos veces (para usuario y para correo)
        $stmt->bind_param("ss", $identificador, $identificador);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Verificar si encontramos al usuario
        if ($resultado && $resultado->num_rows === 1) {
            $usuarioBD = $resultado->fetch_assoc();

            // Validar la contraseña real utilizando password_verify()
            if (password_verify($password, $usuarioBD['password'])) {
                
                // Credenciales correctas: iniciamos la sesión básica para el proyecto
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['id_usuario'] = $usuarioBD['id_usuario'];
                $_SESSION['nombre'] = $usuarioBD['nombre'];
                $_SESSION['usuario'] = $usuarioBD['usuario'];

                // Redirigir al archivo principal index.html que está en tu raíz
                header("Location: index.html"); 
                exit;
            }
        }

        // Si no coincide la clave o el usuario no existe, cerramos consulta y enviamos error
        $stmt->close();
        header("Location: login.php?error=" . urlencode("Usuario, correo o contraseña incorrectos."));
        exit;

    } else {
        // Error de preparación de la consulta en la BD
        header("Location: login.php?error=" . urlencode("Error interno del servidor."));
        exit;
    }
} else {
    // Si intentan entrar escribiendo la URL directamente, los mandamos al formulario
    header("Location: login.php");
    exit;
}
