<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conduces - Yake Power Systems</title>

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
            max-width: 1100px;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
        }

        .boton {
            display: inline-block;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .crear {
            background: #198754;
            color: white;
        }

        .editar {
            background: #0d6efd;
            color: white;
            padding: 6px 10px;
        }

        .eliminar {
            background: #dc3545;
            color: white;
            padding: 6px 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #f0f0f0;
        }

        .mensaje {
            background: #d1e7dd;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .error {
            background: #f8d7da;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<header>
    <h1>Yake Power Systems</h1>
    <p>Gestión de Conduces</p>
</header>

<nav>
    <a href="<?= site_url('inicio') ?>">Inicio</a>
    <a href="<?= site_url('conduces') ?>">Conduces</a>
    <a href="<?= site_url('logout') ?>">Cerrar sesión</a>
</nav>

<div class="contenedor">

    <h2>Listado de conduces</h2>

    <?php if (session()->getFlashdata('mensaje')): ?>
        <div class="mensaje">
            <?= esc(session()->getFlashdata('mensaje')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="error">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <a class="boton crear" href="<?= site_url('conduces/crear') ?>">
        Crear nuevo conduce
    </a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Número</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Observaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

        <?php if (!empty($conduces)): ?>

            <?php foreach ($conduces as $conduce): ?>
                <tr>
                    <td><?= esc($conduce['id_conduce']) ?></td>
                    <td><?= esc($conduce['numero_conduce']) ?></td>
                    <td><?= esc($conduce['fecha']) ?></td>
                    <td><?= esc($conduce['cliente']) ?></td>
                    <td><?= esc($conduce['observaciones'] ?? '') ?></td>

                    <td>
                        <a class="boton editar"
                           href="<?= site_url('conduces/editar/' . $conduce['id_conduce']) ?>">
                            Editar
                        </a>

                        <a class="boton eliminar"
                           href="<?= site_url('conduces/eliminar/' . $conduce['id_conduce']) ?>"
                           onclick="return confirm('¿Está seguro de eliminar este conduce?');">
                            Eliminar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>

        <?php else: ?>

            <tr>
                <td colspan="6">
                    No existen conduces registrados.
                </td>
            </tr>

        <?php endif; ?>

        </tbody>
    </table>

</div>

</body>
</html>