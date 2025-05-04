<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'carkey');

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta de todos los clientes con información de la persona
$sql = "SELECT c.ID_Empleado, p.Nombre, p.Primer_Apellido, p.Segundo_Apellido, p.Correo_Electronico, p.Telefono, c.RFC
        FROM empleado c 
        JOIN persona p ON c.ID_Persona_Emp = p.ID_Persona";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes</title>
    <link rel="stylesheet" href="styles.css"> 
    
    <style>
        body {
            font-family: Lora;
            background-image: url('img/fondoCliente.png');
            margin: 0;
            padding: 20px;
            color: #333;
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
        h1 {
            text-align: center;
            color: #ffffff;
        }
    </style>
    
</head>
<body>

    <h1>Empleados CarKey</h1>
    
    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Primer Apellido</th><th>Segundo Apellido</th><th>Email</th><th>Teléfono</th><th>RFC</th><th>Acciones</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['ID_Empleado'] . "</td>";
            echo "<td>" . $row['Nombre'] . "</td>";
            echo "<td>" . $row['Primer_Apellido'] . "</td>";
            echo "<td>" . $row['Segundo_Apellido'] . "</td>";
            echo "<td>" . $row['Correo_Electronico'] . "</td>";
            echo "<td>" . $row['Telefono'] . "</td>";
            echo "<td>" . $row['RFC'] . "</td>";
            
            
            echo "<td>
                    <a href='editarEmpleado.php?id=" . $row['ID_Empleado'] . "'>Editar</a> |
                    <a href='eliminarEmpleado.php?id=" . $row['ID_Empleado'] . "' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este empleado?\")'>Eliminar</a>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron clientes.";
    }

    // Cerrar conexión
    $conn->close();
    ?>
</body>
<button onclick="window.location.href='administrativo.php'">Salir
</html>

