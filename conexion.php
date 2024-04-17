<?php
session_start();  // Inicia la sesión

$host = "localhost";
$dbname = "contacto";
$user = "postgres";
$password = "admin1234";

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname;user=$user;password=$password");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conexión exitosa";  // No es necesario mostrar esto aquí
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $telefono = $_POST["telefono"];
    $mensaje = $_POST["mensaje"];

    try {
        $stmt = $conn->prepare("INSERT INTO contact_usuarios (nombre, email, telefono, mensaje) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $email, $telefono, $mensaje]);

        // Establece un mensaje de éxito en una variable de sesión
        $_SESSION['success_message'] = "Datos insertados correctamente en la base de datos.";

        // Redirige de vuelta al formulario
        header('Location: index.html');
        exit();
    } catch (PDOException $e) {
        echo "Error al insertar datos: " . $e->getMessage();
    }
}
?>
