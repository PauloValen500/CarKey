<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarKey</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
    <style>
        /* Estilos Generales */
        h1 {
            font-family: 'Lora', sans-serif;
            font-size: 48px;
            text-align: center;
            color: #FF6347;
            opacity: 0;
            transform: translateX(-100px);
            animation: fadeInRight 2s ease-out forwards;
            position: absolute;
            top: 20px;
            left: 20px;
        }

        /* Animación de desvanecimiento y movimiento */
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(-100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        body {
            background-image: url('img/fondoPrincipal.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 50px;
            height: 100vh;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative; /* Asegura que el contenedor se quede en su lugar */
        }

        /* Contenedor principal */
        .container {
            display: flex;
            align-items: center; /* Alinea logo y botones en el centro verticalmente */
            justify-content: flex-start; /* Alinea el contenido a la izquierda */
            width: 40%; /* Mantiene el mismo ancho que antes */
            padding: 20px;
            background: rgba(255, 255, 255, 0.1); /* Fondo transparente */
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37); /* Efecto de profundidad */
            backdrop-filter: blur(10px); /* Difuminado del fondo */
            -webkit-backdrop-filter: blur(10px); /* Difuminado para Safari */
            border: 1px solid rgba(255, 255, 255, 0.18); /* Borde con transparencia */
            margin-top: 10px;
            margin-right: 790px; /* Mantiene la posición original */
            position: relative; /* Asegura que el contenedor quede en su lugar */
            z-index: 1;
            transition: opacity 0.3s ease-in-out; /* Suaviza la desaparición */
        }

        .container.hidden {
            opacity: 0;
            pointer-events: none; /* Desactiva eventos mientras el contenedor está oculto */
        }

        .logo-container {
            margin-right: 30px;
        }

        .logo {
            width: 200px;
            height: auto;
        }

        .botones {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            font-family: 'Lora';
            flex-grow: 1;
            margin-left: 10px;
        }

        .botones button, .botones .icon-link {
            background-color: #000000;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 15px 30px;
            margin: 8px;
            text-align: center;
            text-decoration: none;
            font-size: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .botones button:hover, .botones .icon-link:hover {
            background-color: #ffffff;
            color: black;
        }

        .botones .icon-link {
            display: flex;
            align-items: center;
        }

        .botones .icon-link i {
            margin-right: 8px;
        }

        #loginButton {
            background-color: #2f3235;
            font-family: Lora;
            color: #ffffff;
        }

        #loginButton:hover {
            background-color: #000000;
            color: white;
        }

        h1 {
            color: #ffffff;
            font-family: Lora;
            margin-top: 50px;
        }

        /* Estilos para el menú hamburguesa */
        .hamburger {
            display: none;
            font-size: 30px;
            color: #ffffff;
            cursor: pointer;
            z-index: 10;
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 20px;
            transform: translateY(-100%);
            transition: transform 0.3s ease-in-out;
            z-index: 5;
        }

        .menu.active {
            transform: translateY(0);
        }

        .menu a {
            color: white;
            text-decoration: none;
            font-size: 20px;
            padding: 15px;
            margin: 10px 0;
            text-align: center;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .menu a:hover {
            background-color: #ffffff;
            color: black;
        }

        /* Media Query para pantallas más pequeñas */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 20px;
                width: 80%;
            }

            .logo-container {
                margin-bottom: 20px;
            }

            .botones button, .botones .icon-link {
                width: 100%;
                padding: 15px;
                font-size: 18px;
            }

            .logo {
                width: 150px;
            }

            .hamburger {
                display: block;
            }

            .botones {
                display: none;
            }
        }
    </style>
</head>
<body>
    <h1>CarKey</h1>

    <!-- Botón Hamburguesa -->
    <div class="hamburger" id="hamburger">
        <i class="fa-solid fa-bars"></i>
    </div>

    <!-- Menú -->
    <div class="menu" id="menu">
        <a href="inicio.html">Iniciar Sesión</a>
        <a href="contacto.html"><i class="fa-solid fa-headset"></i> Contáctanos</a>
        <a href="servicios.html"><i class="fa-solid fa-store"></i> Servicios</a>
        <a href="catalogoCliente.html"><i class="fa-solid fa-bolt"></i> Catálogo</a>
    </div>

    <!-- Contenedor principal -->
    <div class="container" id="container">
        <div class="logo-container">
            <img src="img/logo.jpg" alt="Logo de CarKey" class="logo">
        </div>
        <div class="botones">
            <button id="loginButton">Iniciar Sesión</button>
            <a href="contacto.html" class="icon-link"><i class="fa-solid fa-headset"></i> Contáctanos</a>
            <a href="servicios.html" class="icon-link"><i class="fa-solid fa-store"></i> Servicios</a>
            <a href="catalogoCliente.html" class="icon-link"><i class="fa-solid fa-bolt"></i> Catálogo</a>
        </div>
    </div>

    <script>
        // Función para abrir y cerrar el menú hamburguesa
        document.getElementById('hamburger').addEventListener('click', function() {
            const menu = document.getElementById('menu');
            const container = document.getElementById('container');
            menu.classList.toggle('active');
            container.classList.toggle('hidden');  // Oculta o muestra el contenedor
        });

        // Redirección al hacer clic en el botón "Iniciar Sesión"
        document.getElementById('loginButton').addEventListener('click', function() {
            window.location.href = 'inicio.html';
        });
    </script>
</body>
</html>
