<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.html");
    exit();
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Biblioteca Pastel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --pastel-pink: #fce4ec;
            --medium-pink: #f8bbd0;
            --dark-pink: #f06292;
            --text-color: #880e4f;
        }
        body { background-color: var(--pastel-pink); color: var(--text-color); }
        .navbar, .sidebar { background-color: var(--medium-pink) !important; border-bottom: 2px solid var(--dark-pink); }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 10px rgba(240, 98, 146, 0.2); }
        .card-header { background-color: var(--dark-pink) !important; color: white; border-radius: 15px 15px 0 0 !important; }
        .btn-primary { background-color: var(--dark-pink); border: none; }
        .btn-primary:hover { background-color: #e91e63; }
        .nav-link { color: var(--text-color); font-weight: bold; }
        .nav-link.active { background-color: var(--dark-pink) !important; }
        input:focus { box-shadow: 0 0 0 0.25rem rgba(240, 98, 146, 0.25) !important; border-color: var(--dark-pink) !important; outline: none; }
    </style>
</head>
<body>
    <header class="navbar sticky-top flex-md-nowrap p-2 shadow">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#"><i class="bi bi-book-half pe-2"></i>Biblioteca Pastel</a>
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a class="nav-link text-white" href="logout.php"><i class="bi bi-box-arrow-right"></i> Salir</a>
                </li>
            </ul>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse p-3" style="min-height: 100vh;">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item"><a class="nav-link active mb-2" href="#"><i class="bi bi-person-heart"></i> Gestión</a></li>
                </ul>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header text-center"><h5>Registrar Autor</h5></div>
                            <div class="card-body">
                                <form action="procesar.php" method="POST">
                                    <input type="hidden" name="tipo" value="autor">
                                    <div class="mb-3"><label class="form-label">ID Autor</label><input type="number" name="id_autor" class="form-control" required autofocus="false"></div>
                                    <div class="mb-3"><label class="form-label">Nombre</label><input type="text" name="nombre" class="form-control" required></div>
                                    <button type="submit" class="btn btn-primary w-100">Guardar Autor</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header text-center"><h5>Registrar Libro</h5></div>
                            <div class="card-body">
                                <form action="procesar.php" method="POST">
                                    <input type="hidden" name="tipo" value="libro">
                                    <div class="mb-3"><label class="form-label">ID Libro</label><input type="number" name="id_libro" class="form-control" required></div>
                                    <div class="mb-3"><label class="form-label">Título</label><input type="text" name="titulo" class="form-control" required></div>
                                    <div class="mb-3"><label class="form-label">Páginas</label><input type="number" name="paginas" class="form-control" required></div>
                                    <button type="submit" class="btn btn-primary w-100">Guardar Libro</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header text-center"><h5>Registrar Préstamo</h5></div>
                            <div class="card-body">
                                <form action="procesar.php" method="POST">
                                    <input type="hidden" name="tipo" value="prestamo">
                                    <div class="mb-3"><label class="form-label">ID Autor</label><input type="number" name="id_autor" class="form-control" required></div>
                                    <div class="mb-3"><label class="form-label">ID Libro</label><input type="number" name="id_libro" class="form-control" required></div>
                                    <button type="submit" class="btn btn-primary w-100">Vincular Préstamo</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>