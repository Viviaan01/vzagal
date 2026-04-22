<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.html");
    exit();
}

require_once 'db.php';
$db = conectarDB();

// Consulta de registros para mostrar en las tablas
$autores = $db->query("SELECT * FROM autores")->fetchAll();
$libros = $db->query("SELECT * FROM libros")->fetchAll();
// Unimos las tablas en préstamos para mostrar nombres en lugar de solo IDs
$prestamos = $db->query("
    SELECT al.id_autor, a.nombre, al.id_libro, l.titulo 
    FROM auto_libro al
    JOIN autores a ON al.id_autor = a.id_autor
    JOIN libros l ON al.id_libro = l.id_libro
")->fetchAll();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --pastel-pink: #fce4ec;
            --medium-pink: #f8bbd0;
            --dark-pink: #f06292;
            --text-color: #880e4f;
        }
        body { background-color: var(--pastel-pink); color: var(--text-color); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { background-color: var(--medium-pink) !important; border-bottom: 2px solid var(--dark-pink); }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(240, 98, 146, 0.15); height: 100%; }
        .card-header { background-color: var(--dark-pink) !important; color: white; border-radius: 15px 15px 0 0 !important; font-weight: bold; }
        .btn-primary { background-color: var(--dark-pink); border: none; border-radius: 20px; padding: 8px 20px; transition: 0.3s; }
        .btn-primary:hover { background-color: #e91e63; transform: translateY(-2px); }
        
        /* Alineación y estilo de inputs */
        .form-control { border: 1px solid var(--medium-pink); border-radius: 10px; }
        .form-control:focus { border-color: var(--dark-pink); box-shadow: 0 0 0 0.2rem rgba(240, 98, 146, 0.25); outline: none; }
        
        /* Estilo de Tablas */
        .table-container { background: white; border-radius: 15px; padding: 20px; margin-top: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .table thead { background-color: var(--medium-pink); color: var(--text-color); }
        .table-hover tbody tr:hover { background-color: #fff1f5; }
    </style>
</head>
<body>
    <header class="navbar sticky-top p-2 shadow">
        <div class="container-fluid">
            <a class="navbar-brand text-white fw-bold" href="#"><i class="bi bi-book-half pe-2"></i>Biblioteca</a>
            <a class="nav-link text-white" href="logout.php"><i class="bi bi-box-arrow-right"></i> Salir</a>
        </div>
    </header>

    <div class="container mt-5">
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">Registrar Autor</div>
                    <div class="card-body">
                        <form action="procesar.php" method="POST">
                            <input type="hidden" name="tipo" value="autor">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Nombre Completo</label>
                                <input type="text" name="nombre" class="form-control" placeholder="Nombre del autor" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Guardar Autor</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">Registrar Libro</div>
                    <div class="card-body">
                        <form action="procesar.php" method="POST">
                            <input type="hidden" name="tipo" value="libro">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Título</label>
                                <input type="text" name="titulo" class="form-control" placeholder="Título del libro" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Número de Páginas</label>
                                <input type="number" name="paginas" class="form-control" placeholder="Ej: 200" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Guardar Libro</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">Vincular Préstamo</div>
                    <div class="card-body">
                        <form action="procesar.php" method="POST">
                            <input type="hidden" name="tipo" value="prestamo">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">ID Autor</label>
                                <input type="number" name="id_autor" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">ID Libro</label>
                                <input type="number" name="id_libro" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Vincular Registro</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-5" style="color: var(--dark-pink); opacity: 0.3;">

        <h3 class="text-center mb-4"><i class="bi bi-journal-text"></i> Registros en el Sistema</h3>
        
        <div class="row">
            <div class="col-lg-4">
                <div class="table-container">
                    <h5 class="text-center mb-3">Autores</h5>
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr><th>ID</th><th>Nombre</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($autores as $a): ?>
                            <tr><td><?= $a['id_autor'] ?></td><td><?= htmlspecialchars($a['nombre']) ?></td></tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="table-container">
                    <h5 class="text-center mb-3">Libros</h5>
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr><th>ID</th><th>Título</th><th>Págs</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($libros as $l): ?>
                            <tr>
                                <td><?= $l['id_libro'] ?></td>
                                <td><?= htmlspecialchars($l['titulo']) ?></td>
                                <td><?= $l['numero_de_paginas'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="table-container">
                    <h5 class="text-center mb-3">Préstamos (Vínculos)</h5>
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr><th>Autor</th><th>Libro</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($prestamos as $p): ?>
                            <tr>
                                <td class="small"><?= htmlspecialchars($p['nombre']) ?> (ID:<?= $p['id_autor'] ?>)</td>
                                <td class="small"><?= htmlspecialchars($p['titulo']) ?> (ID:<?= $p['id_libro'] ?>)</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="py-5"></div>
</body>
</html>