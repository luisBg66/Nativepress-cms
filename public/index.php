<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';

// Obtener proyectos activos
$proyectos = $pdo->query('SELECT * FROM proyectos WHERE activo = 1 ORDER BY orden ASC')->fetchAll();

// Obtener últimos 3 artículos publicados
$articulos = $pdo->query('SELECT id, titulo, slug, imagen_portada, created_at FROM articulos WHERE publicado = 1 ORDER BY created_at DESC LIMIT 3')->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cat Code — Portafolio</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/bootstrap.min.css">
    <style>
        html { scroll-behavior: smooth; }
        #hero { min-height: 100vh; background: #1a1a2e; color: white; }
        .nav-link { color: rgba(255,255,255,0.8) !important; }
        .nav-link:hover { color: white !important; }
        .seccion { padding: 80px 0; }
        .seccion-gris { background: #f8f9fa; }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Cat Code</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#hero">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#sobre-mi">Sobre mí</a></li>
                    <li class="nav-item"><a class="nav-link" href="#servicios">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link" href="#portafolio">Portafolio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#blog">Blog</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section id="hero" class="d-flex align-items-center justify-content-center text-center">
        <div>
            <h1 class="display-3 fw-bold">Hola, soy <span class="text-warning">Cat Code</span></h1>
            <p class="lead mt-3 mb-4">Desarrollo web a medida — limpio, rápido y profesional.</p>
            <a href="#portafolio" class="btn btn-warning btn-lg me-2">Ver portafolio</a>
            <a href="#contacto" class="btn btn-outline-light btn-lg">Contacto</a>
        </div>
    </section>

    <!-- Sobre mí -->
    <section id="sobre-mi" class="seccion">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="fw-bold mb-3">Sobre mí</h2>
                    <p class="text-muted">Soy desarrollador web especializado en PHP, MySQL y soluciones a medida para negocios y profesionales. Me apasiona crear productos digitales funcionales, limpios y fáciles de usar.</p>
                    <p class="text-muted">Trabajo con tecnologías modernas sin depender de frameworks pesados, lo que hace mis proyectos ligeros, rápidos y fáciles de mantener.</p>
                </div>
                <div class="col-md-6 text-center">
                    <div style="width:200px;height:200px;background:#1a1a2e;border-radius:50%;margin:auto;display:flex;align-items:center;justify-content:center;">
                        <span style="font-size:80px;">🐱</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Servicios -->
    <section id="servicios" class="seccion seccion-gris">
        <div class="container">
            <h2 class="fw-bold text-center mb-5">Servicios</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm text-center p-3">
                        <div class="fs-1 mb-3">💻</div>
                        <h5 class="fw-bold">Desarrollo Web</h5>
                        <p class="text-muted">Sitios y aplicaciones web a medida en PHP puro y MySQL.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm text-center p-3">
                        <div class="fs-1 mb-3">🎨</div>
                        <h5 class="fw-bold">Diseño UI</h5>
                        <p class="text-muted">Interfaces limpias, modernas y responsivas con Bootstrap.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm text-center p-3">
                        <div class="fs-1 mb-3">⚙️</div>
                        <h5 class="fw-bold">CMS a medida</h5>
                        <p class="text-muted">Paneles de administración personalizados sin frameworks.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portafolio -->
    <section id="portafolio" class="seccion">
        <div class="container">
            <h2 class="fw-bold text-center mb-5">Portafolio</h2>
            <?php if (empty($proyectos)): ?>
                <p class="text-center text-muted">Próximamente...</p>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($proyectos as $p): ?>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            <?php if ($p['imagen']): ?>
                                <img src="<?= BASE_URL ?>/uploads/proyectos/<?= $p['imagen'] ?>" class="card-img-top" style="height:200px;object-fit:cover;">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title fw-bold"><?= htmlspecialchars($p['titulo']) ?></h5>
                                <p class="card-text text-muted"><?= htmlspecialchars($p['descripcion']) ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Blog -->
    <section id="blog" class="seccion seccion-gris">
        <div class="container">
            <h2 class="fw-bold text-center mb-5">Blog</h2>
            <?php if (empty($articulos)): ?>
                <p class="text-center text-muted">Próximamente...</p>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($articulos as $a): ?>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            <?php if ($a['imagen_portada']): ?>
                                <img src="<?= BASE_URL ?>/uploads/blog/<?= $a['imagen_portada'] ?>" class="card-img-top" style="height:200px;object-fit:cover;">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title fw-bold"><?= htmlspecialchars($a['titulo']) ?></h5>
                                <small class="text-muted"><?= date('d/m/Y', strtotime($a['created_at'])) ?></small>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <a href="<?= BASE_URL ?>/public/blog/articulo.php?slug=<?= $a['slug'] ?>" class="btn btn-sm btn-outline-dark">Leer más</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="text-center mt-4">
                    <a href="<?= BASE_URL ?>/public/blog/index.php" class="btn btn-dark">Ver todos los artículos</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Contacto -->
    <section id="contacto" class="seccion">
        <div class="container">
            <h2 class="fw-bold text-center mb-5">Contacto</h2>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control" placeholder="Tu nombre">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Correo</label>
                                    <input type="email" class="form-control" placeholder="tu@correo.com">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mensaje</label>
                                    <textarea class="form-control" rows="4" placeholder="¿En qué te puedo ayudar?"></textarea>
                                </div>
                                <button type="submit" class="btn btn-dark w-100">Enviar mensaje</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4">
        <p class="mb-0">© <?= date('Y') ?> Cat Code — Todos los derechos reservados.</p>
    </footer>

    <script src="<?= BASE_URL ?>/public/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

