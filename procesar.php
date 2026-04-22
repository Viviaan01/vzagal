<?php
require_once 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = conectarDB();
    $tipo = $_POST['tipo'];
    $mensaje = "";

    try {
        if ($tipo == "autor") {
            $sql = "INSERT INTO autores (id_autor, nombre) VALUES (:id, :nom)";
            $stmt = $db->prepare($sql);
            $stmt->execute(['id' => $_POST['id_autor'], 'nom' => $_POST['nombre']]);
            $mensaje = "El autor " . $_POST['nombre'] . " fue registrado.";
        } 
        elseif ($tipo == "libro") {
            $sql = "INSERT INTO libros (id_libro, titulo, numero_de_paginas) VALUES (:id, :tit, :pag)";
            $stmt = $db->prepare($sql);
            $stmt->execute(['id' => $_POST['id_libro'], 'tit' => $_POST['titulo'], 'pag' => $_POST['paginas']]);
            $mensaje = "El libro '" . $_POST['titulo'] . "' fue guardado.";
        } 
        elseif ($tipo == "prestamo") {
            $sql = "INSERT INTO auto_libro (id_autor, id_libro) VALUES (:ida, :idl)";
            $stmt = $db->prepare($sql);
            $stmt->execute(['ida' => $_POST['id_autor'], 'idl' => $_POST['id_libro']]);
            $mensaje = "El préstamo fue vinculado exitosamente.";
        }

        // Pantalla de Éxito Estilo Pastel
        echo "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: sans-serif; background-color: #fce4ec; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
                .card { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 20px rgba(240, 98, 146, 0.2); text-align: center; border: 2px solid #f06292; }
                h2 { color: #d81b60; }
                p { color: #880e4f; font-size: 1.1rem; }
                .btn { background-color: #f06292; color: white; padding: 12px 25px; text-decoration: none; border-radius: 25px; display: inline-block; margin-top: 20px; transition: 0.3s; }
                .btn:hover { background-color: #d81b60; }
            </style>
        </head>
        <body>
            <div class='card'>
                <h2>¡Registro Exitoso! </h2>
                <p>$mensaje</p>
                <a href='dashboard.php' class='btn'>Volver al Panel</a>
            </div>
        </body>
        </html>";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage() . " <a href='dashboard.php'>Regresar</a>";
    }
}
?>