<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $conduce ? 'Editar conduce' : 'Crear conduce' ?> - Yake Power Systems
    </title>

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
            max-width: 850px;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
        }

        label {
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 100px;
        }

        button {
            background: #0d6efd;
            color: white;
            border: none;
            padding: 12px 18px;
            cursor: pointer;
            border-radius: 5px;
        }

        .cancelar {
            display: inline-block;
            background: #6c757d;
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 5px;
            margin-left: 10px;
        }
    </style>
</head>
<body>

<header>
    <h1>Yake Power Systems</h1>
    <p><?= $conduce ? 'Editar conduce' : 'Crear nuevo conduce' ?></p>
</header>

<nav>
    <a href="<?= site_url('inicio') ?>">Inicio</a>
    <a href="<?= site_url('conduces') ?>">Conduces</a>
    <a href="<?= site_url('logout') ?>">Cerrar sesión</a>
</nav>

<div class="contenedor">

    <h2><?= $conduce ? 'Editar conduce' : 'Registrar conduce' ?></h2>

    <?php
        $esEdicion = !empty($conduce);

        $accion = $esEdicion
            ? site_url('conduces/actualizar/' . $conduce['id_conduce'])
            : site_url('conduces/guardar');
    ?>

    <form action="<?= $accion ?>" method="post">

        <label>Número de conduce</label>
        <input
            type="text"
            name="numero_conduce"
            value="<?= esc($conduce['numero_conduce'] ?? '') ?>"
            required
        >

        <label>Fecha</label>
        <input
            type="date"
            name="fecha"
            value="<?= esc($conduce['fecha'] ?? date('Y-m-d')) ?>"
            required
        >

        <label>Cliente</label>
        <input
            type="text"
            name="cliente"
            value="<?= esc($conduce['cliente'] ?? '') ?>"
            required
        >

        <label>RNC o cédula</label>
        <input
            type="text"
            name="rnc_cedula"
            value="<?= esc($conduce['rnc_cedula'] ?? '') ?>"
            required
        >

        <label>Dirección</label>
        <input
            type="text"
            name="direccion"
            value="<?= esc($conduce['direccion'] ?? '') ?>"
        >

        <label>Persona de atención</label>
        <input
            type="text"
            name="atencion"
            value="<?= esc($conduce['atencion'] ?? '') ?>"
        >

        <label>Teléfono</label>
        <input
            type="text"
            name="telefono"
            value="<?= esc($conduce['telefono'] ?? '') ?>"
        >

        <label>Observaciones</label>
        <textarea name="observaciones"><?= esc($conduce['observaciones'] ?? '') ?></textarea>

        <button type="submit">
            <?= $esEdicion ? 'Actualizar conduce' : 'Guardar conduce' ?>
        </button>

        <a class="cancelar" href="<?= site_url('conduces') ?>">
            Cancelar
        </a>

    </form>

</div>

</body>
</html>