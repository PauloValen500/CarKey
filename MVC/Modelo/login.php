<?php
session_start(); // Inicia la sesión

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'carkey');

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recupera datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Credenciales fijas para administrador
$admin_username = 'carkeyadm';
$admin_password = '89632147'; 

// Verificar si las credenciales son del administrador
if ($username === $admin_username && $password === $admin_password) {
    $_SESSION['user_id'] = 'admin';
    $_SESSION['user_name'] = 'Administrador';
    header("Location: /CarKey/administrativo.php");
    exit();
}

// Preparar la consulta para obtener detalles del usuario
$consulta = "
    SELECT p.ID_Persona, p.Nombre, p.contrasena, c.ID_Cliente, e.ID_Empleado 
    FROM Persona p
    LEFT JOIN Cliente c ON p.ID_Persona = c.ID_Persona_Cl
    LEFT JOIN Empleado e ON p.ID_Persona = e.ID_Persona_Emp
    WHERE p.ID_Persona = ?
";
$stmt = $conn->prepare($consulta);
if (!$stmt) {
    die("Error en prepare: " . $conn->error);
}
$stmt->bind_param("s", $username); 

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verifica la contraseña
    if (password_verify($password, $row['contrasena']) || $password === $row['contrasena']) {
        // Establece las variables de sesión
        $_SESSION['user_id'] = $row['ID_Persona'];
        $_SESSION['user_name'] = $row['Nombre'];

        // Determina el rol y redirige según el caso
        if (!is_null($row['ID_Cliente'])) {
            // Usuario es un cliente
            header("Location: /CarKey/cliente.php");
            exit();
        } elseif (!is_null($row['ID_Empleado'])) {
            // Usuario es un empleado
            $_SESSION['idEmpleado'] = $row['ID_Empleado']; // Guarda el ID del empleado en la sesión
            header("Location: /CarKey/empleado.php");
            exit();
        } else {
            // Usuario sin rol asignado
            echo "Usuario sin rol asignado<br>";
            header("Location: /CarKey/falla.html");
            exit();
        }
    } else {
        echo "Contraseña incorrecta<br>";
        header("Location: /CarKey/falla.html");
        exit();
    }
} else {
    echo "Usuario no encontrado<br>";
    header("Location: /CarKey/falla.html");
    exit();
}

$stmt->close();
$conn->close();
?>
