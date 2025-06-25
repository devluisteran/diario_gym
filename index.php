<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luis Teran | Full Stack Developer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome (iconos) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">LuisTeran</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#inicio">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#habilidades">Habilidades</a></li>
                    <li class="nav-item"><a class="nav-link" href="#proyectos">Proyectos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#sobremi">Sobre mí</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="inicio" class="hero d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h1>Hola, soy <span class="text-primary">Luis Teran</span></h1>
                    <h2>Full Stack Developer</h2>
                    <p class="lead">Especializado en Backend con Laravel php, Node.js y bases de datos.</p>
                    <a href="#proyectos" class="btn btn-primary btn-lg">Ver mis proyectos</a>
                </div>
                <!-- Sobre mí -->
                <div class="col-lg-6 text-center sm-mt-2"> <!-- Añadí text-center -->
                    <img src="profile2.jpeg" width="70%" alt="Sobre mí" class="img-fluid rounded mi-foto">
                </div>
            </div>
        </div>
    </section>

    <!-- Habilidades -->
    <section id="habilidades" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Mis Habilidades</h2>
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="fas fa-server fa-3x mb-3 text-primary"></i>
                            <h3>Backend</h3>
                            <p>Laravel, PHP, Node.js(básico), Express, APIs REST.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="fas fa-database fa-3x mb-3 text-primary"></i>
                            <h3>Bases de Datos</h3>
                            <p>MySQL, PostgreSQL, MongoDB(básico), Firebase.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="fas fa-code fa-3x mb-3 text-primary"></i>
                            <h3>Frontend</h3>
                            <p>HTML, CSS, JavaScript, Bootstrap, tailwind,Vue 2 y 3(básico), React (básico).</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Proyectos -->
    <section id="proyectos" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Mis Proyectos</h2>
            <div class="row">
                <!-- Proyecto 1 -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body" style="text-align: center;">
                            <i class="fas fa-server fa-3x mb-3 text-primary"></i>
                            <h5 class="card-title" style="text-align: justify;">Backend App Movil Gym-App</h5>
                            <p class="card-text" style="text-align: justify;">APIS desarrolladas con PHP para todo el manejo de logica, PostgreSQL
                                 para el manejo de información y lcobucci para el manejo de tokens .</p>
                            <a href="https://github.com/devluisteran/diario_gym.git" class="btn btn-primary">Ver código (GitHub)</a>
                        </div>
                    </div>
                </div>
                <!-- Proyecto 2 -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="gym.png" class="card-img-top" alt="Gym-App">

                        <div class="card-body">
                            <h5 class="card-title">App Movil Diary-Gym-App</h5>
                            <p class="card-text">App hecha en Flutter con ayuda de IA deepseek y copilot
                                 para el diseño de interfaces.</p>
                            <a href="#" class="btn btn-primary">Ver demo</a>
                        </div>
                    </div>
                </div>
                <!-- Proyecto 3 -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body" style="text-align: center;">
                            <i class="fas fa-code fa-3x mb-3 text-primary"></i>
                            <h5 class="card-title">Portafolio</h5>
                            <p class="card-text" style="text-align: justify;">Interfaz realizada con Html, Js y Css</p>
                            <a href="https://diario-gym.onrender.com/" class="btn btn-primary">Ver detalles</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sobre mí -->
    <section id="sobremi" class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <img src="sobre_mi.png" alt="Sobre mí" class="img-fluid rounded">
                </div>
                <div class="col-lg-6">
                    <h2>Sobre Mí</h2>
                    <p>Desarrollador Full Stack con 2+ años de experiencia, he trabajado en optimización de sistemas,
                        desarrollo de modulos de facturación y soluciones personalizadas, intregraciones con proveedores de timbrado y plataformas de pago.</p>
                    <p>Cuando no estoy programando, me gusta aprender nuevas tecnologías.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contacto -->
    <section id="contacto" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Contacto</h2>
            
            <div class="text-center mt-5">
                <a href="https://github.com/devluisteran" class="mx-2"><i class="fab fa-github fa-2x"></i></a>
                <a href="https://linkedin.com/in/luis-fernando-teran-112287241/" class="mx-2"><i class="fab fa-linkedin fa-2x"></i></a>
                <a href="mailto:devluisteran@gmail.com" class="mx-2"><i class="fas fa-envelope fa-2x"></i></a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 bg-dark text-white text-center">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Luis Teran. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JS Personalizado -->
    <script src="script.js"></script>
</body>
</html>