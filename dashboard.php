<?php
session_start();

// ¿Existe la sesión? Si no, fuera de aquí.
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.html");
    exit();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Sistema de Autores</title>
    <link href="./wwwroot/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./wwwroot/css/bootstrap-icons.min.css">
    <script src="./wwwroot/js/jquery-4.0.0.min.js"></script>
    <script src="./wwwroot/js/script.js"></script>
  </head>
  <body>
    <header>
      <div class="px-3 py-2 text-bg-primary border-bottom">
        <div class="container">
          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none"> 
              <i class="bi bi-bootstrap fw-bold fs-5 pe-2"></i>
            </a>
            <nav>
              <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                <li><a class="nav-link text-white" href="#"><i class="bi bi-house fw-bold fs-5 pe-2"></i>Home</a></li>
                <li><a class="nav-link text-white" href="logout.php"><i class="bi bi-box-arrow-in-left fw-bold fs-5 pe-2"></i>Salir</a></li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </header>

    <div class="container-fluid">
      <div class="row">
        
        <aside class="col-lg-3 col-xl-2 d-none d-lg-block border-end" 
               style="position: fixed; top: 70px; bottom: 0; left: 0; padding-top: 15px; overflow-y: auto;">
          <div class="px-3">
            <nav>
              <ul class="nav nav-pills flex-column mb-auto">            
                <li class="nav-item">
                  <a class="nav-link active mb-2" href="#"><i class="bi bi-person-plus-fill fw-bold fs-5 pe-2"></i>Autores</a>
                </li>
              </ul>
            </nav>
          </div>
        </aside>

        <main class="col-lg-9 col-xl-10 offset-lg-3 offset-xl-2">
          <div class="row mt-5">
            
            <div class="col-12 col-md-6 text-center">
              <article id="article">
                <h5 class="text-muted mb-4">Estado del Sistema</h5>
                <figure>
                  <img id="lightbulb" class="img-fluid" src="./wwwroot/img/bulboff.gif" style="max-height: 300px;">
                </figure>
              </article>
            </div>

            <div class="col-12 col-md-6">
              <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                  <h4 class="mb-0 fs-5"><i class="bi bi-pencil-square pe-2 text-primary"></i>Registrar Nuevo Autor</h4>
                </div>
                <div class="card-body">
                  <form id="formAltaAutor">
                    <div class="mb-3">
                      <label for="id_auto" class="form-label small fw-bold">ID del Autor</label>
                      <input type="number" class="form-control" id="id_auto" name="id_auto" placeholder="Ej: 101" required>
                    </div>
                    <div class="mb-3">
                      <label for="nombre" class="form-label small fw-bold">Nombre Completo</label>
                      <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del autor" required>
                    </div>
                    <div class="d-grid">
                      <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save pe-2"></i>Guardar Autor
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div> </div>
        </main>

      </div>
    </div>

    <script src="./js/bootstrap.bundle.min.js"></script>
  </body>
</html>