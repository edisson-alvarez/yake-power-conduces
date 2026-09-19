<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Iniciar Sesión | Yake Power Systems</title>
    <link rel="stylesheet" href="css/estilos.css" />
    <style>
        /* ===== Reset ligero / base ===== */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, Arial, sans-serif;
            background-color: #f2f2f2;
            color: #222;
        }

        /* ===== Encabezado ===== */
        header {
            text-align: center;
            padding: 48px 20px 36px;
            background: linear-gradient(180deg, #1c1c1c 0%, #333333 100%);
            color: #fff;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .brand-mark {
            width: 34px;
            height: 34px;
            flex-shrink: 0;
        }

        header h1 {
            margin: 0;
            font-size: 1.9rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        header h1 span {
            font-weight: 300;
            opacity: 0.85;
        }

        header p {
            margin: 10px 0 0;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            color: #cfcfcf;
            text-transform: uppercase;
        }

        .header-divider {
            width: 60px;
            height: 3px;
            background-color: #ffffff;
            opacity: 0.35;
            margin: 16px auto 0;
            border-radius: 2px;
        }

        /* ===== Login container ===== */
        .login-container {
            max-width: 400px;
            margin: -30px auto 60px;
            padding: 34px 30px 30px;
            border: 1px solid #e2e2e2;
            border-radius: 12px;
            background-color: #ffffff;
            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.12);
            position: relative;
        }

        .login-container h2 {
            text-align: center;
            margin: 0 0 26px;
            font-size: 1.3rem;
            font-weight: 600;
            color: #1c1c1c;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 0.88rem;
            color: #444;
        }

        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #333333;
            box-shadow: 0 0 0 3px rgba(51, 51, 51, 0.1);
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.3px;
            transition: background-color 0.2s ease, transform 0.1s ease;
        }

        .btn-submit:hover {
            background-color: #555;
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .error-message {
            color: #d9534f;
            background-color: #f2dede;
            border: 1px solid #ebccd1;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 18px;
            font-weight: bold;
            display: none;
        }

        .success-message {
            color: #3c763d;
            background-color: #dff0d8;
            border: 1px solid #d6e9c6;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 18px;
            font-weight: bold;
            display: none;
        }

        footer {
            text-align: center;
            padding: 20px;
            font-size: 0.78rem;
            color: #888;
        }

        @media (max-width: 480px) {
            header {
                padding: 38px 16px 30px;
            }

            header h1 {
                font-size: 1.5rem;
            }

            .login-container {
                margin: -22px 15px 40px;
                padding: 26px 20px;
            }
        }
    </style>
</head>
<body>

    <header>
        <div class="brand">
            <svg class="brand-mark" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13 2L4 14h6l-1 8 9-12h-6l1-8z" fill="#ffffff"/>
            </svg>
            <h1>YAKE <span>Power Systems</span></h1>
        </div>
        <p>Sistema de Gestión de Conduces</p>
        <div class="header-divider"></div>
    </header>

    <main>
        <div class="login-container">
            <h2>Iniciar Sesión</h2>

            <div id="error-alert" class="error-message"></div>
            <div id="success-alert" class="success-message"></div>

            <!-- Bloque PHP que lee la URL y muestra el error si las credenciales fallan -->
            <?php if (isset($_GET['error'])): ?>
                <div id="error-alert" class="error-message">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

             <form id="login-form" action="procesar_login.php" method="POST">
                <div class="form-group">
                    <label for="identifier">Usuario o Correo Electrónico:</label>
                    <input type="text" id="identifier" name="identificador" placeholder="ejemplo@yake.com o admin" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-submit">Ingresar al Sistema</button>
            </form>
        </div>
    </main>

    <footer>
        <p>Proyecto académico - Desarrollo de Aplicaciones Web ISW-306</p>
    </footer>

    <script src="js/login.js"></script>
</body>
</html>