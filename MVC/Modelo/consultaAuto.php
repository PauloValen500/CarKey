<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'carkey');

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializamos las variables de búsqueda
$placa = isset($_POST['placa']) ? $_POST['placa'] : '';
$marca = isset($_POST['marca']) ? $_POST['marca'] : '';
$modelo = isset($_POST['modelo']) ? $_POST['modelo'] : '';

// Construimos la consulta con filtros de búsqueda
$sql = "SELECT * FROM auto WHERE 1";  // Usamos WHERE 1 para facilitar la concatenación de las condiciones

// Agregar condiciones a la consulta si se introducen filtros
if (!empty($placa)) {
    $placa = $conn->real_escape_string($placa);  // Seguridad contra inyecciones SQL
    $sql .= " AND Id_Placa LIKE '%$placa%'";
}

if (!empty($marca)) {
    $marca = $conn->real_escape_string($marca);
    $sql .= " AND Marca LIKE '%$marca%'";
}

if (!empty($modelo)) {
    $modelo = $conn->real_escape_string($modelo);
    $sql .= " AND Modelo LIKE '%$modelo%'";
}

// Ejecutar la consulta
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Autos</title>
    <link rel="stylesheet" href="styles.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        .btn {
            padding: 5px 10px;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-edit {
            background-color: #f0ad4e;
        }
        .btn-del {
            background-color: #d9534f;
        }
        .search-form {
            margin-bottom: 20px;
        }
        .search-form input {
            padding: 5px;
            margin-right: 10px;
        }
    </style>
</head>
<body>

    <h1>Lista de Autos CarKey</h1>

    <!-- Formulario de búsqueda -->
    <form action="consultaAuto.php" method="POST" class="search-form">
        <input type="text" name="placa" placeholder="Buscar por Placa" value="<?= htmlspecialchars($placa) ?>">
        <input type="text" name="marca" placeholder="Buscar por Marca" value="<?= htmlspecialchars($marca) ?>">
        <input type="text" name="modelo" placeholder="Buscar por Modelo" value="<?= htmlspecialchars($modelo) ?>">
        <button type="submit" class="btn">Buscar</button>
    </form>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID Placa</th><th>Marca</th><th>Modelo</th><th>Año</th><th>Color</th><th>Tipo Combustible</th><th>Kilometraje</th><th>Precio por Día</th><th>Depósito</th><th>Acciones</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Id_Placa'] . "</td>";
            echo "<td>" . $row['Marca'] . "</td>";
            echo "<td>" . $row['Modelo'] . "</td>";
            echo "<td>" . $row['Anio_Fabricacion'] . "</td>";
            echo "<td>" . $row['Color'] . "</td>";
            echo "<td>" . $row['Tipo_Combustible'] . "</td>";
            echo "<td>" . $row['Kilometraje'] . "</td>";
            echo "<td>" . $row['Precio_Dia'] . "</td>";
            echo "<td>" . $row['deposito'] . "</td>";
            echo "<td>
                    <a href='editarAuto.php?id=" . $row['Id_Placa'] . "' class='btn btn-edit'>Editar</a>
                    <a href='eliminarAuto.php?id=" . $row['Id_Placa'] . "' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este auto?\")' class='btn btn-del'>Eliminar</a>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron autos.";
    }

    // Cerrar conexión
    $conn->close();
    ?>
    <br>
    <button onclick="window.location.href='administrativo.php'" class="btn">Regresar</button>
</body>
</html>
