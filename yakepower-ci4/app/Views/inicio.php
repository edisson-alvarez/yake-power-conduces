<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Yake Power Systems</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f4f4f4;
        }

        header {
            background: #111;
            color: white;
            padding: 20px;
            text-align: center;
        }

        nav {
            background: #222;
            padding: 12px;
            text-align: center;
        }

        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
        }

        .contenedor {
            max-width: 900px;
            margin: 30px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.10);
        }

        .usuario {
            background: #e9f5ff;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<header>
    <h1>Yake Power Systems</h1>
    <p>Sistema Web para la Gestión y Generación de Conduces</p>
</header>

<nav>
    <a href="<?= site_url('inicio') ?>">Inicio</a>
    <a href="<?= site_url('conduces') ?>">Conduces</a>
    <a href="<?= site_url('logout') ?>">Cerrar sesión</a>
</nav>

<div class="contenedor">

    <div class="usuario">
        <strong>Usuario conectado:</strong>
        <?= esc(session()->get('nombre')) ?>
    </div>

    <h2>Bienvenido al Sistema de Gestión de Conduces</h2>

    <p>
        Esta aplicación permite gestionar los conduces de Yake Power Systems
        utilizando CodeIgniter 4, sesiones y acceso a base de datos.
    </p>

</div>

</body>
</html>