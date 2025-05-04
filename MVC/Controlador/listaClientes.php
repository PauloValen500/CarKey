<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'carkey');

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta de todos los clientes con información de la persona
$sql = "SELECT c.ID_Cliente, p.Nombre, p.Primer_Apellido, p.Segundo_Apellido, p.Correo_Electronico, p.Telefono, c.RFC, c.INE, c.Licencia_de_conducir, c.ID_Persona_Cl
        FROM cliente c 
        JOIN persona p ON c.ID_Persona_Cl = p.ID_Persona";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes CarKey</title>
    <style>
        body {
            font-family: Lora;
            background-image: url('img/fondoCliente.png');
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #ffffff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.1); /* Fondo transparente */
            border-radius: 15px;
           

        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #000000;
            color: white;
        }
        td {
            color: white;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37); /* Efecto de profundidad */
            backdrop-filter: blur(10px); /* Difuminado del fondo */
            -webkit-backdrop-filter: blur(10px); /* Difuminado para Safari */
            border: 1px solid rgba(255, 255, 255, 0.18); /* Borde con transparencia */
        }
        a {
            text-decoration: none;
            color: rgb(0, 0, 0);
            font-weight: bold;
            
            padding: 1px;
        }
        a:hover {
            text-decoration: underline;
        }
        button {
            padding: 10px 20px;
            background-color: #000000;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 20px auto;
        }
        button:hover {
            background-color: #ffffff;
            color: black;
        }
    </style>
</head>
<body>
    <h1>Lista de Clientes CarKey</h1>
    <?php
    // Asumiendo que la conexión a la base de datos y la consulta ya se han hecho y $result contiene los datos
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Usuario</th><th>Nombre</th><th>Primer Apellido</th><th>Segundo Apellido</th><th>Email</th><th>Teléfono</th><th>RFC</th><th>INE</th><th>Licencia de Conducir</th><th>Acciones</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['ID_Cliente']) . "</td>";
            echo "<td>" . htmlspecialchars($row['ID_Persona_Cl']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Nombre']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Primer_Apellido']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Segundo_Apellido']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Correo_Electronico']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Telefono']) . "</td>";
            echo "<td>" . htmlspecialchars($row['RFC']) . "</td>";
            echo "<td>" . htmlspecialchars($row['INE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Licencia_de_conducir']) . "</td>";
            echo "<td>
                    <a href='editarCliente.php?id=" . $row['ID_Cliente'] . "'>Editar</a> |
                    <a href='eliminarCliente.php?id=" . $row['ID_Cliente'] . "' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este cliente?\")'>Eliminar</a>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No se encontraron clientes.</p>";
    }
    ?>
   <button onclick="window.history.back()">Salir</button>
</body>
</html>