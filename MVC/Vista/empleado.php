<?php
session_start(); // Inicia la sesión

// Verificar si los IDs están en la sesión
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    header("Location: /CarKey/inicio.html"); // Redirige si no están los datos necesarios
    exit();
}

$user_name = $_SESSION['user_name'];
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Empleado Carkey</title>
    <script src="https://kit.fontawesome.com/81581fb069.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="empleado.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
</head>

<style>
     body {
            display: flex; 
            align-items: flex-start; 
            justify-content: space-between; 
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
            background-image: url(img/fondoEmpl.png)
            
        }
        .logo-container {
            width: 90%; 
            padding: 5px;
            background-color: none;
            display: grid;
            margin-left:70px;
        }
        .logo {
            width: 50%;
            height: auto;
            margin-left:70px;
            margin-top: 20%;
        }
        .dashboard {
            width: 85%; /* Asegura que el dashboard ocupe la mayor parte de la pantalla */
            background: rgba(255, 255, 255, 0.1); /* Fondo suave y ligeramente transparente */
            padding: 30px;
            border-radius: 20px; /* Bordes más redondeados */
             box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37); /* Sombra suave y difusa */
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(10px); /* Difuminado del fondo */
    -webkit-backdrop-filter: blur(10px); /* Difuminado para Safari */
    border: 1px solid rgba(255, 255, 255, 0.18); /* Borde con transparencia */
            
            margin-top: 20px; /* Ajusta la distancia desde el top */
            transition: all 0.3s ease; /* Transición suave en el cambio de estilo */
        }
        .menu {
            display: grid; 
            grid-template-columns: repeat(2, 1fr); /* 2 columnas de igual tamaño */
            gap: 20px; /* Espacio entre los botones */
            width: 100%;
            margin-top: 30px; /* Ajusta la distancia desde el top */
        }
        .menu button {
            font-size: 1em;
            background-color: #053659;
            
            color: white;
            border: none;
            padding: 15px 20px;
            margin: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 80%; 
            font-family: Lora;
        }
        .menu button i {
            margin-right: 5px;
        }
        .menu button:hover {
            background-color: black;
        }
        h1 {
            font-family: Lora;
            color: white;
            margin-bottom: 0px;
        }
        .header {
        display: flex;
        align-items: center; /* Alinea verticalmente el logo y el saludo */
        justify-content: flex-start; /* Alinea horizontalmente hacia la izquierda */
        width: 100%;
        margin-bottom: 20px; /* Espacio entre el encabezado y el menú */
}

    </style>
<body>
<div class="logo-container">
<img src="img/logo.jpg" alt="Logo de CarKey" class="logo">
    </div>
    <div class="dashboard">
       
        
        <h1>Hola, <?php echo htmlspecialchars($user_name); ?></h1>
        <div class="menu">
            <button onclick="window.location.href='clientes.php'">
                <i class="fa-solid fa-user"></i> Registrar Cliente
            </button>
            <button onclick="window.location.href='autos.html'">
                <i class="fa-solid fa-car"></i> Registrar Auto
            </button>
            <button onclick="window.location.href='autosDispo.html'">
                <i class="fa-solid fa-car-side"></i> Autos Disponibles
            </button>
            <button onclick="window.location.href='reporte.html'">
                <i class="fa-solid fa-flag"></i> Crear Reporte
            </button>
            <button onclick="window.location.href='catalogo.html'">
                <i class="fa-solid fa-book"></i> Catálogo
            </button>
            <button onclick="window.location.href='renta.html'">
                <i class="fa-regular fa-rectangle-list"></i> Tramitar Renta
            </button>
            <button onclick="window.location.href='listaClientes.php'">
                <i class="fa-solid fa-users"></i> Consultar Cliente
            </button>
            <button onclick="window.location.href='rentasEnCurso.php'">
                <i class="fa-solid fa-list"></i> Rentas en Curso
            </button>
            <button onclick="window.location.href='rentaslinea.php'">Rentas en línea</buttom>
            <button onclick="window.location.href='codigoqr.php'">Escanear QR</buttom>
            <button onclick="window.location.href='index.php'">
                <i class="fa-solid fa-right-from-bracket"></i> Salir
            </button>
        </div>
    </div>
</body>
</html>
