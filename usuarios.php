 <?php



// Sesionecs

session_start();



$_SESSION["username"] = "juan";

$_SESSION["login_time"] = time();



// index.php

require_once 'db.php'; // Traemos el código del otro archivo



//require_once 'db-pgsql.php'; // Traemos el código del otro archivo





//  Obtenemos los datos del formulario

     $nombre = $_POST['nombre'];

     $email  = $_POST['email'];

     $pwd = $_POST['pwd'];

     // Llamamos a la función y guardamos el objeto en $db

     $db = conectarDB();

     



  try {

        //  Preparamos la consulta con "marcadores" (:nombre, :email)

        // Esto separa la estructura de la consulta de los datos reales

        $sql = "INSERT INTO usuarios (nombre, email,password) VALUES (:nombre, :email, :password)";

        $query = $db->prepare($sql);



    $passwordHash = password_hash($pwd, PASSWORD_DEFAULT);



        // Ejecutamos pasando los datos en un array

        $resultado = $query->execute([

            'nombre' => $nombre,

            'email'  => $email,

        'password' => $passwordHash

        ]);



        if ($resultado) {

            header("Location: index.html");

           

       echo "El usuario se ha almacenado correctamente!  <a href='index.html'>Continuar</a>";

       

        }



    } catch (PDOException $e) {

        // Manejo de errores (ej. si el email ya existe y es único)



        if ($e->errorInfo[1] == 1062) {

           

            echo "El email ya existe, favor de intendarlo con otro correo. <a href='index.html'>Continuar</a>";

        }else {

        // Handle other database errors

        echo "Database Error: " . $e->getMessage();

               

       

    }

     

    }













?>

Para realizar el registro en la tabla autores, he adaptado tu código PHP. He cambiado las variables recibidas por el método POST para que coincidan con los campos id_auto y nombre que definimos en tu formulario HTML anterior, y actualicé la consulta SQL.

Aquí tienes el código corregido:

PHP
<?php
// Manejo de Sesiones
session_start();

// index.php o registro_autor.php
require_once 'db.php'; // Asegúrate de que este archivo contenga la función conectarDB()

// Validar que los datos vengan por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Obtenemos los datos del formulario (coincidiendo con los 'id' del HTML anterior)
    $id_auto = $_POST['id_auto'];
    $nombre  = $_POST['nombre'];

    // Conexión a la base de datos
    $db = conectarDB();

    try {
        // Preparamos la consulta para la tabla 'autores'
        // Usamos marcadores (:id_auto, :nombre) para prevenir Inyección SQL
        $sql = "INSERT INTO autores (id_auto, nombre) VALUES (:id_auto, :nombre)";
        $query = $db->prepare($sql);

        // Ejecutamos pasando los datos en un array
        $resultado = $query->execute([
            'id_auto' => $id_auto,
            'nombre'  => $nombre
        ]);

        if ($resultado) {
            // Si todo sale bien, redirigimos o mandamos mensaje de éxito
            echo "¡El autor se ha registrado correctamente! <a href='index.php'>Regresar</a>";
            // Opcional: header("Location: dashboard.php");
        }

    } catch (PDOException $e) {
        // Manejo de errores específicos
        // Código 1062 suele ser para entradas duplicadas (ej: el ID ya existe)
        if ($e->errorInfo[1] == 1062) {
            echo "Error: El ID de autor ya existe en el sistema. <a href='index.php'>Intentar de nuevo</a>";
        } else {
            // Otros errores de base de datos
            echo "Error en la Base de Datos: " . $e->getMessage();
        }
    }
} else {
    echo "Acceso no permitido.";
}
?>