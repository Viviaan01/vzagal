<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['id_usuario'] = $_COOKIE['id_usuario'];
    header("Location: index.php");
    exit();
}

require_once 'db.php';
$db = conectarDB();

$autores = $db->query("SELECT * FROM autores")->fetchAll();
$libros = $db->query("SELECT * FROM libros")->fetchAll();
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
    <title>Sistema Biblioteca </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-width: 280px;
            --pastel-pink: #fce4ec;
            --medium-pink: #f8bbd0;
            --dark-pink: #f06292;
            --text-color: #880e4f;
        }
        body { background-color: var(--pastel-pink); color: var(--text-color); overflow-x: hidden; }
        
        /* Estilo del Menú Lateral */
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            background: white;
            border-right: 2px solid var(--medium-pink);
            transition: all 0.3s;
            z-index: 1000;
        }
        #content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            min-height: 100vh;
        }
        .nav-link {
            color: var(--text-color);
            padding: 15px 25px;
            border-radius: 0 25px 25px 0;
            margin-right: 10px;
            margin-bottom: 5px;
            font-weight: 500;
        }
        .nav-link:hover, .nav-link.active {
            background-color: var(--medium-pink);
            color: var(--dark-pink) !important;
        }
        
        /* Tarjetas y Formularios */
        .card { border: none; border-radius: 20px; box-shadow: 0 8px 20px rgba(240, 98, 146, 0.1); }
        .card-header { background: var(--dark-pink) !important; color: white; border-radius: 20px 20px 0 0 !important; }
        .btn-primary { background-color: var(--dark-pink); border: none; border-radius: 25px; padding: 10px 25px; }
        .btn-primary:hover { background-color: #e91e63; }
        
        /* Imagen de Bienvenida */
        .welcome-img {
            max-width: 400px;
            width: 100%;
            border-radius: 20px;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            #sidebar { margin-left: calc(-1 * var(--sidebar-width)); }
            #content { margin-left: 0; }
        }
    </style>
</head>
<body>

    <div id="sidebar" class="d-flex flex-column p-3">
        <h4 class="text-center py-4 fw-bold"><i class="bi bi-book-half"></i> Biblioteca</h4>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto" id="pills-tab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active w-100 text-start" id="tab-inicio" data-bs-toggle="pill" data-bs-target="#inicio" type="button">
                    <i class="bi bi-house-heart me-2"></i> Inicio
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link w-100 text-start" id="tab-autor" data-bs-toggle="pill" data-bs-target="#reg-autor" type="button">
                    <i class="bi bi-person-plus me-2"></i> Registrar Autor
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link w-100 text-start" id="tab-libro" data-bs-toggle="pill" data-bs-target="#reg-libro" type="button">
                    <i class="bi bi-journal-plus me-2"></i> Registrar Libro
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link w-100 text-start" id="tab-prestamo" data-bs-toggle="pill" data-bs-target="#reg-prestamo" type="button">
                    <i class="bi bi-arrow-left-right me-2"></i> Préstamos
                </button>
            </li>
        </ul>
        <hr>
        <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a>
    </div>

    <div id="content">
        <div class="tab-content" id="pills-tabContent">
            
            <div class="tab-pane fade show active" id="inicio" role="tabpanel">
                <div class="text-center mt-5">
                    <h1 class="display-4 fw-bold">¡Bienvenido a nuestra Biblioteca!</h1>
                    <p class="lead"></p>
                    <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=1000&auto=format&fit=crop" alt="Libros" class="welcome-img shadow">
                </div>
            </div>

            <div class="tab-pane fade" id="reg-autor" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card mt-4">
                            <div class="card-header h5 text-center">Registrar Nuevo Autor</div>
                            <div class="card-body p-4">
                                <form action="procesar.php" method="POST">
                                    <input type="hidden" name="tipo" value="autor">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nombre Completo del Autor</label>
                                        <input type="text" name="nombre" class="form-control form-control-lg" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Guardar Autor</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="reg-libro" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card mt-4">
                            <div class="card-header h5 text-center">Registrar Nuevo Libro</div>
                            <div class="card-body p-4">
                                <form action="procesar.php" method="POST">
                                    <input type="hidden" name="tipo" value="libro">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Título del Libro</label>
                                        <input type="text" name="titulo" class="form-control form-control-lg" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Número de Páginas</label>
                                        <input type="number" name="paginas" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Guardar Libro</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="reg-prestamo" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card mt-4">
                            <div class="card-header h5 text-center">Vincular Préstamo / Autor-Libro</div>
                            <div class="card-body p-4">
                                <form action="procesar.php" method="POST">
                                    <input type="hidden" name="tipo" value="prestamo">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">ID del Autor</label>
                                        <input type="number" name="id_autor" class="form-control" placeholder="Ej: 1" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">ID del Libro</label>
                                        <input type="number" name="id_libro" class="form-control" placeholder="Ej: 5" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Registrar Vínculo</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> <div class="mt-5 container">
            <h3 class="text-center mb-4 mt-5 fw-bold"><i class="bi bi-database"></i> Registros Actuales</h3>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="bg-white p-3 rounded-4 shadow-sm">
                        <h6 class="text-center fw-bold">Autores</h6>
                        <table class="table table-sm text-center">
                            <thead><tr><th>ID</th><th>Nombre</th></tr></thead>
                            <tbody>
                                <?php foreach ($autores as $a): ?>
                                <tr><td><?= $a['id_autor'] ?></td><td><?= htmlspecialchars($a['nombre']) ?></td></tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="bg-white p-3 rounded-4 shadow-sm">
                        <h6 class="text-center fw-bold">Libros</h6>
                        <table class="table table-sm text-center">
                            <thead><tr><th>ID</th><th>Título</th></tr></thead>
                            <tbody>
                                <?php foreach ($libros as $l): ?>
                                <tr><td><?= $l['id_libro'] ?></td><td><?= htmlspecialchars($l['titulo']) ?></td></tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="bg-white p-3 rounded-4 shadow-sm">
                        <h6 class="text-center fw-bold">Préstamos</h6>
                        <table class="table table-sm text-center">
                            <thead><tr><th>Autor</th><th>Libro</th></tr></thead>
                            <tbody>
                                <?php foreach ($prestamos as $p): ?>
                                <tr>
                                    <td class="small"><?= htmlspecialchars($p['nombre']) ?></td>
                                    <td class="small"><?= htmlspecialchars($p['titulo']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>