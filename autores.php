<?php
// Manejo de Sesiones
session_start();
$_SESSION["username"] = "juan";
$_SESSION["login_time"] = time();

// Configuración de la base de datos
require_once 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // CORRECCIÓN: Asegúrate de que los nombres coincidan con tu formulario HTML
    $id_autor = $_POST['id_autor'] ?? $_POST['id_autor']; 
    $nombre   = $_POST['nombre'];

    $db = conectarDB();

    try {
        // CORRECCIÓN: Eliminada la coma extra en el SQL y unificado el nombre del marcador
        $sql = "INSERT INTO autores (id_autor, nombre) VALUES (:id_autor, :nombre)";
        $query = $db->prepare($sql);

        $resultado = $query->execute([
            'id_autor' => $id_autor,
            'nombre'   => $nombre
        ]);

        if ($resultado) {
            // Mostramos la interfaz de éxito directamente
            echo "
            <!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <style>
                    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
                    .card { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; max-width: 400px; }
                    h2 { color: #2ecc71; }
                    p { color: #666; margin-bottom: 25px; }
                    .btn { background-color: #3498db; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; transition: background 0.3s; }
                    .btn:hover { background-color: #2980b9; }
                </style>
            </head>
            <body>
                <div class='card'>
                    <h2>Registro Exitoso</h2>
                    <p>El autor <strong>" . htmlspecialchars($nombre) . "</strong> ha sido registrado correctamente en el sistema.</p>
                    <a href='index.html' class='btn'>Regresar a la interfaz</a>
                </div>
            </body>
            </html>";
        }

    } catch (PDOException $e) {
        // Manejo de duplicados (Error 1062)
        if ($e->errorInfo[1] == 1062) {
            echo "<div style='text-align:center; margin-top:50px;'>
                    <p>El ID <strong>$id_autor</strong> ya existe. <a href='index.html'>Volver a intentar</a></p>
                  </div>";
        } else {
            echo "Error Crítico: " . $e->getMessage();
        }
    }
} else {
    header("Location: index.html");
    exit();
}
?>