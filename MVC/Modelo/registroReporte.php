<?php
session_start(); // Inicia la sesión

// Inicializa la conexión a la base de datos y las variables de mensaje
$conn = new mysqli('localhost', 'root', '', 'carkey');
$message = "";

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Chequea si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $placaReporte = $conn->real_escape_string($_POST['placaReporte']);
    $idClienteRep = $conn->real_escape_string($_POST['idClienteRep']);
    $idEmpleadoRep = $conn->real_escape_string($_POST['idEmpleadoRep']);
    $fechaInc = $conn->real_escape_string($_POST['fechaInc']);
    $details = $conn->real_escape_string($_POST['details']);

    // Crear la consulta SQL para insertar datos
    $sql = "INSERT INTO reporte (Id_Placa_Re, Fecha_Incidente, Detalles, Id_Empleado_Re, Id_Cliente_Re, Estado) 
            VALUES ('$placaReporte', '$fechaInc', '$details', '$idEmpleadoRep', '$idClienteRep', 0)";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Nuevo reporte creado correctamente.";
        header("Location: /CarKey/validoReporte.html");
        exit();
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
    }

    // Cerrar conexión
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes</title>
    <link rel="stylesheet" href="reporte.css"> 
    <style>
        .confirmation-message {
            padding: 10px;
            border: 1px solid #d6d6d6;
            background-color: #f4f4f4;
            color: #333;
            margin-bottom: 20px;
        }
        html {
    background-image: url(CarKey/img/fondo8.jpg);
    margin: 0;
    padding: 0;
    height: 100%;
    width: 100%;
    font-family: Arial, sans-serif;
    position: cover;
    background-position: cover;
}

.top-nav {
    
   
    padding: 10px 0px;
    text-align: center;
    align-items: center;
    

}
.top-nav h4{
    justify-content: center;
    font-size: 50px;
    text-align: center;
    font-family: cursive;
    color: rgb(250, 243, 243);
    margin: 2cm;
    margin-top: 0px;
    margin-bottom: 0%;
    
}
.top-nav h5{
    font-size: 15px;
    color: #474646;
    margin: 2cm;
    margin-top: 2px;
    margin-bottom: 5%;
    font-family: monospace;
}


.modal-content {
    background: rgba(90, 87, 87, 0.8);
    padding: 20px ;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    width: 300px;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}
.modal-content input {
    width: 100%;
    padding: 7px;
    margin-bottom: 3%;
    border: 1px solid #555;
    border-radius: 10px;
    background: rgba(231, 228, 228, 0.8);
    color: #000;
    font-family: cursive;
}

.modal-content label{
font-family: monospace;
font-size: 18px;
 left: 10%;
    margin-bottom: 5px;

}

.registro input {
    background-color: #000000;
    color: aliceblue;
    font-size: 14px;
    margin-top: 15px;
cursor: pointer; 
    transition: background-color 0.3s;
}
.registro input:hover {
    background-color: #fdfdfd; 
    color: #000000;
}
.close {
    color: #131111;
    position: absolute;
    right: 15px;
    top: 10px;
    font-size: 25px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: rgb(255, 255, 255);
    text-decoration: none;
    cursor: pointer;
}

.report input{
    size: 5cm;
}
    </style>
</head>
<body>
    <nav class="top-nav">
        <div class="registrer-container">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h4>CarKey</h4>
                <h5>Levantar Reporte</h5>
                
                <?php
                if (isset($_SESSION['message'])) {
                    echo "<div class='confirmation-message'>" . $_SESSION['message'] . "</div>";
                    unset($_SESSION['message']); // Eliminar el mensaje después de mostrarlo
                }
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"> 
                    <input type="text" id="placaReporte" name="placaReporte" placeholder="Placa Vehículo" required>
                    <input type="number" id="idClienteRep" name="idClienteRep" placeholder="ID Cliente">
                    <input type="number" id="idEmpleadoRep" name="idEmpleadoRep" placeholder="ID Empleado" required>
                    <label for="fechaInicio">Fecha Incidente</label>
                    <input type="date" id="fechaInc" name="fechaInc" required>
                    <div class="report">
                        <input type="text" id="details" name="details" placeholder="Descripción" required>
                    </div>
                    <div class="registro">
                        <input type="submit" value="Levantar Reporte">
                        <buttom onclick="window.location.href='empleado.php'">Salir</buttom>
                    </div>
                </form>
            </div>
        </div>
    </nav>
    <script src="public/js/scripts.js"></script>
</body> 
</html>
