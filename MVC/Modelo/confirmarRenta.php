<?php
session_start();
require 'fpdf186/fpdf.php';
require 'phpqrcode-2010100721_1.1.4/phpqrcode/qrlib.php'; // Ajusta la ruta aquí

// Conexión a la base de datos
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'carkey');

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario
    $idEmpleado = 34; // Valor fijo para idEmpleado
    $idPersona = $_SESSION['user_id']; // ID de persona desde la sesión
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $placaR = $conn->real_escape_string($_POST['placaR']);
    $modelo = $conn->real_escape_string($_POST['modelo']);
    $seguro = $conn->real_escape_string($_POST['seguro']);
    $fechaInicio = $conn->real_escape_string($_POST['fechaInicio']);
    $fechaFin = $conn->real_escape_string($_POST['fechaFin']);

    // Obtener el ID_Cliente correspondiente al ID_Persona
    $clienteQuery = $conn->query("SELECT ID_Cliente FROM cliente WHERE ID_Persona_Cl = '$idPersona'");
    if ($clienteQuery->num_rows > 0) {
        $clienteData = $clienteQuery->fetch_assoc();
        $idCliente = $clienteData['ID_Cliente'];

        // Obtener el precio por día y depósito del auto
        $autoQuery = $conn->query("SELECT Precio_Dia, deposito FROM auto WHERE Id_Placa = '$placaR'");
        if ($autoQuery->num_rows > 0) {
            $autoData = $autoQuery->fetch_assoc();
            $precioDia = $autoData['Precio_Dia'];
            $deposito = $autoData['deposito'];

            // Calcular el número de días de la renta
            $datetime1 = new DateTime($fechaInicio);
            $datetime2 = new DateTime($fechaFin);
            $interval = $datetime1->diff($datetime2);
            $diasRenta = $interval->days;

            // Calcular el monto total
            $monto = ($precioDia * $diasRenta) + $deposito;

            // Crear la consulta SQL para insertar datos en la tabla de rentas
            $sqlRenta = "INSERT INTO renta (Id_Empleado_Ra, Id_Cliente_Ra, Fecha_Renta_Inicio, Fecha_Renta_Fin, Id_Placa_Ra, Seguro, Modelo) 
                         VALUES ('$idEmpleado', '$idCliente', '$fechaInicio', '$fechaFin', '$placaR', '$seguro', '$modelo')";

            // Ejecutar la consulta
            if ($conn->query($sqlRenta) === TRUE) {
                // Obtener el ID de la última inserción en la tabla de renta
                $rentaId = $conn->insert_id;

                // Crear la consulta SQL para insertar datos en la tabla de reservación
                $sqlReservacion = "INSERT INTO reservacion (Id_Auto_Rv, Fecha_Renta_Inicio, Fecha_Renta_Fin, Id_Cliente_Rv, Seguro, Monto) 
                                   VALUES ('$placaR', '$fechaInicio', '$fechaFin', '$idCliente', '$seguro', '$monto')";

                if ($conn->query($sqlReservacion) === TRUE) {
                    // Generar PDF con los datos de la renta
                    $filePath = generarPDF($nombre, $idCliente, $placaR, $fechaInicio, $fechaFin, $seguro, $monto, $modelo);

                    // Verificar y crear la carpeta src/qr si no existe
                    $qrDir = $_SERVER['DOCUMENT_ROOT'] . '/CarKey/src/qr';
                    if (!is_dir($qrDir)) {
                        mkdir($qrDir, 0777, true);
                    }

                    // Generar código QR con la información de la renta
                    $qrText = "Renta ID: $rentaId\nCliente: $nombre\nVehículo: $modelo\nPlaca: $placaR\nFecha Inicio: $fechaInicio\nFecha Fin: $fechaFin\nMonto: $$monto";
                    $qrFilePath = 'src/qr/Renta_' . $idCliente . '.png';
                    $fullQrFilePath = $_SERVER['DOCUMENT_ROOT'] . '/CarKey/' . $qrFilePath;

                    QRcode::png($qrText, $fullQrFilePath, QR_ECLEVEL_L, 10);

                    // Verificar si el archivo QR se ha creado correctamente
                    if (file_exists($fullQrFilePath)) {
                        $_SESSION['qrFilePath'] = $qrFilePath; // Guarda la ruta del archivo QR en la sesión

                        // Insertar la ruta del archivo QR en la base de datos
                        $sqlUpdateQR = "UPDATE renta SET qr_file_path = '$qrFilePath' WHERE Id_Renta = '$rentaId'";
                        if ($conn->query($sqlUpdateQR) === TRUE) {
                            $_SESSION['message'] = "Código QR guardado correctamente en la base de datos.";
                        } else {
                            $_SESSION['message'] = "Error al guardar el código QR en la base de datos.";
                        }
                    } else {
                        $_SESSION['qrFilePath'] = null;
                        $_SESSION['message'] = "Error al generar el código QR.";
                    }

                    $_SESSION['message'] = "Nueva renta creada correctamente.";
                    $_SESSION['filePath'] = $filePath; // Guardar la ruta del PDF en la sesión

                    // Redirigir a la página de validación con la ruta del PDF en la URL
                    header("Location: /CarKey/validacionrentaCliente.php");
                    exit();
                } else {
                    $_SESSION['message'] = "Error en la reservación: " . $conn->error;
                }
            } else {
                $_SESSION['message'] = "Error en la renta: " . $conn->error;
            }
        } else {
            $_SESSION['message'] = "Auto no encontrado.";
        }
    } else {
        $_SESSION['message'] = "Cliente no encontrado.";
    }

    // Cerrar conexión
    $conn->close();
}




function generarPDF($nombre, $idCliente, $placaR, $fechaInicio, $fechaFin, $seguro, $monto, $modelo) {
    // Crear una instancia de FPDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Agregar el logo
    $pdf->Image('img/logo.jpg', 10, 10, 30); // Ajusta la ruta y tamaño según sea necesario

    // Agregar el título
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 40, 'Detalles de la Renta de Vehiculo', 0, 1, 'C');

    // Agregar la información de la renta
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, "Nombre del Cliente: $nombre", 0, 1);
    $pdf->Cell(0, 10, "ID Cliente: $idCliente", 0, 1);
    $pdf->Cell(0, 10, "Modelo: $modelo", 0, 1);
    $pdf->Cell(0, 10, "Placa del Vehiculo: $placaR", 0, 1);
    $pdf->Cell(0, 10, "Fecha de Inicio: $fechaInicio", 0, 1);
    $pdf->Cell(0, 10, "Fecha de Fin: $fechaFin", 0, 1);
    $pdf->Cell(0, 10, "Seguro: $seguro", 0, 1);
    $pdf->Cell(0, 10, "Monto Total: $$monto", 0, 1);

    // Agregar las condiciones de renta
    $pdf->Ln(10);
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 10, utf8_decode(
        "-El arrendatario es responsable por cualquier daño, pérdida o robo del vehículo durante el periodo de renta.\n" .
        "-El vehículo no debe ser utilizado para actividades ilegales, transporte de materiales peligrosos, competencias, ni por personas no autorizadas.\n" .
        "-El vehículo debe ser devuelto limpio, con el tanque lleno y en las mismas condiciones en las que fue entregado, excepto por el desgaste normal."
    ));

    // Agregar un apartado para la firma
    $pdf->Ln(20); // Salto de línea
    $pdf->Cell(0, 10, '___________________', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Firma del Cliente', 0, 1, 'C');

    // Agregar la información de la empresa
    $pdf->Ln(2); // Salto de línea
    $pdf->Cell(0, 10, utf8_decode('CarKey SA de CV.'), 0, 1, 'C');
    $pdf->Cell(0, 10, utf8_decode('+52 477-364-02-58.'), 0, 1, 'C');
    $pdf->Cell(0, 10, utf8_decode('carkeey@gmail.com'), 0, 1, 'C');

    // Guardar el PDF en el servidor
    $filePath = 'src/contratos/Renta_' . $idCliente . '.pdf';
    $fullFilePath = $_SERVER['DOCUMENT_ROOT'] . '/CarKey/' . $filePath;
    $pdf->Output('F', $fullFilePath);

    return $filePath; // Devolver la ruta del archivo PDF
}
?>
