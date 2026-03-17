<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cine - Tu mejor experiencia</title>

    <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- CSS principal -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    {{-- 🍪 COOKIE CONSENT STYLES --}}
    {!! CookieConsent::styles() !!}
    
    <style>
        /* ===== VARIABLES DE TEMA ===== */
        :root {
            /* Tema oscuro (por defecto) */
            --bg-gradient-1: #ee7752;
            --bg-gradient-2: #e73c7e;
            --bg-gradient-3: #23a6d5;
            --bg-gradient-4: #23d5ab;
            --header-bg: rgba(0, 0, 0, 0.2);
            --text-color: white;
            --button-bg: rgba(255, 255, 255, 0.15);
            --button-border: rgba(255, 255, 255, 0.25);
            --button-hover: rgba(255, 255, 255, 0.3);
            --user-bg: rgba(255, 255, 255, 0.15);
            --shadow-color: rgba(0, 0, 0, 0.3);
            --glow-color: rgba(255, 255, 255, 0.5);
            --active-color: #FFD700;
            --active-bg: rgba(255, 215, 0, 0.3);
        }

        /* Tema claro */
        [data-theme="light"] {
            --bg-gradient-1: #f6d5f7;
            --bg-gradient-2: #fbe9d7;
            --bg-gradient-3: #d4f1f9;
            --bg-gradient-4: #d5f5e3;
            --header-bg: rgba(255, 255, 255, 0.3);
            --text-color: #2c3e50;
            --button-bg: rgba(255, 255, 255, 0.4);
            --button-border: rgba(255, 255, 255, 0.6);
            --button-hover: rgba(255, 255, 255, 0.7);
            --user-bg: rgba(255, 255, 255, 0.4);
            --shadow-color: rgba(0, 0, 0, 0.1);
            --glow-color: rgba(255, 215, 0, 0.5);
            --active-color: #f39c12;
            --active-bg: rgba(243, 156, 18, 0.2);
        }

        /* ===== ANIMACIÓN DE FONDO ===== */
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 0.8; }
            100% { transform: scale(1); opacity: 0.5; }
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* ===== RESET Y ESTILOS BASE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            background: linear-gradient(-45deg, 
                var(--bg-gradient-1), 
                var(--bg-gradient-2), 
                var(--bg-gradient-3), 
                var(--bg-gradient-4));
            background-size: 400% 400%;
            animation: gradientMove 15s ease infinite;
            color: var(--text-color);
            transition: background 0.5s ease, color 0.3s ease;
        }

        /* Efecto de círculos flotantes */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 30%, rgba(255,255,255,0.15) 0%, transparent 20%),
                        radial-gradient(circle at 80% 70%, rgba(255,255,255,0.15) 0%, transparent 25%),
                        radial-gradient(circle at 40% 80%, rgba(255,255,200,0.1) 0%, transparent 30%);
            pointer-events: none;
            z-index: 0;
        }

        /* Círculos flotantes decorativos */
        .floating-circles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .circle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: float 8s infinite ease-in-out;
        }

        .circle1 {
            width: 300px;
            height: 300px;
            top: 10%;
            left: -100px;
            animation-delay: 0s;
        }

        .circle2 {
            width: 200px;
            height: 200px;
            bottom: 20%;
            right: -50px;
            animation-delay: 2s;
            background: rgba(255, 215, 0, 0.1);
        }

        .circle3 {
            width: 150px;
            height: 150px;
            top: 40%;
            right: 15%;
            animation-delay: 4s;
            background: rgba(0, 255, 255, 0.1);
        }

        .circle4 {
            width: 250px;
            height: 250px;
            bottom: 10%;
            left: 20%;
            animation-delay: 6s;
            background: rgba(255, 105, 180, 0.1);
        }

        /* ===== BOTÓN DE TEMA ===== */
        .theme-switch {
            margin-left: 10px;
        }

        .theme-button {
            background: var(--button-bg);
            border: 1px solid var(--button-border);
            color: var(--text-color);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            backdrop-filter: blur(10px);
            box-shadow: 0 5px 15px var(--shadow-color);
            position: relative;
        }

        .theme-button i {
            font-size: 24px;
            transition: all 0.5s;
        }

        .theme-button:hover {
            transform: scale(1.1) rotate(180deg);
            background: var(--button-hover);
            box-shadow: 0 8px 25px var(--glow-color);
        }

        .theme-button:hover i {
            transform: scale(1.1);
        }

        /* Tooltip del botón de tema - AHORA DEBAJO como los demás */
        .theme-button::before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: -50px;
            left: 50%;
            transform: translateX(-50%) translateY(10px);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 500;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.3);
            z-index: 1002;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .theme-button:hover::before {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }

        /* ===== HEADER CON EFECTO GLASS ===== */
        header {
            background: var(--header-bg);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--button-border);
            padding: 1rem 5%;
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 8px 32px var(--shadow-color);
            transition: background 0.3s ease;
        }

        /* ===== LOGO COMO BOTÓN DE INICIO ===== */
        .logo a {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s;
        }

        .logo h2 {
            font-size: 32px;
            font-weight: 800;
            color: var(--text-color);
            text-shadow: 0 0 20px var(--glow-color);
            letter-spacing: 2px;
            margin: 0;
            transition: color 0.3s ease;
        }

        .logo i {
            font-size: 36px;
            color: var(--active-color);
            filter: drop-shadow(0 0 15px var(--active-color));
            animation: float 3s ease-in-out infinite;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo:hover h2 {
            text-shadow: 0 0 30px var(--glow-color), 0 0 60px var(--active-color);
        }

        /* ===== MENÚ HAMBURGUESA ===== */
        .hamburger {
            display: none;
            font-size: 32px;
            color: var(--text-color);
            cursor: pointer;
            transition: all 0.3s;
            text-shadow: 0 0 20px var(--glow-color);
        }

        .hamburger:hover {
            transform: scale(1.2) rotate(180deg);
        }

        #menu-toggle {
            display: none;
        }

        /* ===== MENÚ PRINCIPAL ===== */
        .menu {
            display: flex;
            list-style: none;
            gap: 15px;
            align-items: center;
        }

        /* ===== ESTILO DE BOTONES (solo para acciones) ===== */
        .menu li a, .menu li button, .nav-button {
            color: var(--text-color);
            text-decoration: none;
            padding: 15px 25px;
            border-radius: 60px;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 16px;
            border: none;
            background: var(--button-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--button-border);
            box-shadow: 0 10px 30px var(--shadow-color), 0 0 20px var(--glow-color);
            cursor: pointer;
            position: relative;
            min-width: 70px;
            justify-content: center;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 14px;
        }

        /* Tooltip mejorado con brillo */
        .menu li a::before, .menu li button::before, .nav-button::before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: -50px;
            left: 50%;
            transform: translateX(-50%) translateY(10px);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 500;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.3);
            z-index: 1001;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            text-transform: none;
        }

        .menu li a:hover::before, .menu li button:hover::before, .nav-button:hover::before {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }

        /* Efecto hover con múltiples sombras */
        .menu li a:hover, .menu li button:hover, .nav-button:hover {
            background: var(--button-hover);
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 20px 40px var(--shadow-color), 0 0 30px var(--glow-color);
            border-color: var(--button-border);
        }

        /* ===== ESTADO ACTIVO CON EFECTO NEÓN ===== */
        .menu li a.active {
            background: var(--active-bg);
            border: 2px solid var(--active-color);
            box-shadow: 0 0 30px var(--active-color), 0 0 60px var(--active-bg);
            transform: scale(1.1);
        }

        .menu li a.active i {
            color: var(--active-color);
            filter: drop-shadow(0 0 15px var(--active-color));
        }

        /* Iconos con brillo */
        .menu li a i, .menu li button i, .nav-button i {
            font-size: 22px;
            color: var(--text-color);
            filter: drop-shadow(0 0 10px var(--glow-color));
            transition: all 0.3s;
        }

        .menu li a:hover i, .menu li button:hover i, .nav-button:hover i {
            transform: scale(1.3) rotate(5deg);
            filter: drop-shadow(0 0 20px var(--active-color));
        }

        /* ===== IDENTIFICADOR DE USUARIO (NO ES BOTÓN) ===== */
        .user-identifier {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            background: var(--user-bg);
            backdrop-filter: blur(10px);
            border-radius: 60px;
            border: 2px solid var(--active-color);
            box-shadow: 0 0 20px var(--active-color);
            color: var(--text-color);
            font-weight: 600;
            font-size: 16px;
            cursor: default;
            transition: all 0.3s;
            position: relative;
        }

        .user-identifier i {
            font-size: 22px;
            color: var(--active-color);
            filter: drop-shadow(0 0 10px var(--active-color));
        }

        /* Badge para admin dentro del identificador */
        .admin-badge {
            background: var(--active-bg);
            backdrop-filter: blur(5px);
            color: var(--active-color);
            padding: 3px 10px;
            border-radius: 40px;
            font-size: 10px;
            font-weight: 800;
            margin-left: 8px;
            border: 1px solid var(--active-color);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            box-shadow: 0 0 10px var(--active-color);
            display: inline-block;
        }

        /* Tooltip para el identificador (solo informativo) */
        .user-identifier::before {
            content: 'Perfil actual';
            position: absolute;
            bottom: -45px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            z-index: 1002;
            border: 1px solid var(--active-color);
        }

        .user-identifier:hover::before {
            opacity: 0.9;
            visibility: visible;
        }

        /* ===== MAIN CONTENT ===== */
        main {
            flex: 1;
            max-width: 1400px;
            margin: 50px auto;
            padding: 0 30px;
            width: 100%;
            position: relative;
            z-index: 2;
        }

        /* ===== MENSAJES FLASH ===== */
        .flash-message {
            padding: 20px 30px;
            border-radius: 70px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
            animation: slideDown 0.5s;
            backdrop-filter: blur(15px);
            border: 1px solid var(--button-border);
            color: var(--text-color);
            box-shadow: 0 15px 40px var(--shadow-color), 0 0 30px var(--glow-color);
            font-weight: 600;
        }

        .flash-success {
            background: rgba(46, 204, 113, 0.25);
            border-left: 6px solid #2ecc71;
        }

        .flash-error {
            background: rgba(231, 76, 60, 0.25);
            border-left: 6px solid #e74c3c;
        }

        .flash-message i {
            font-size: 28px;
            filter: drop-shadow(0 0 15px currentColor);
        }

        /* ===== ANIMACIONES ===== */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            header {
                padding: 1rem;
                flex-wrap: wrap;
            }

            .hamburger {
                display: block;
            }

            .menu {
                display: none;
                width: 100%;
                flex-direction: column;
                padding: 30px 0;
                gap: 15px;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: rgba(0, 0, 0, 0.9);
                backdrop-filter: blur(20px);
                border-bottom: 1px solid var(--button-border);
                box-shadow: 0 20px 50px var(--shadow-color);
            }

            #menu-toggle:checked ~ nav .menu {
                display: flex;
                animation: slideDown 0.3s;
            }

            .menu li {
                width: 100%;
            }

            .menu li a, .menu li button, .nav-button {
                width: 90%;
                margin: 0 auto;
                padding: 18px;
            }

            .user-identifier {
                width: 90%;
                margin: 10px auto;
                justify-content: center;
            }

            .menu li a::before, .menu li button::before, .nav-button::before {
                display: none;
            }

            .circle {
                opacity: 0.3;
            }

            .theme-button {
                width: 40px;
                height: 40px;
            }
        }

        /* ===== PERSONALIZACIÓN DEL BANNER DE COOKIES ===== */
        .cc-main {
            background: rgba(0, 0, 0, 0.9) !important;
            backdrop-filter: blur(10px) !important;
            border-top: 3px solid #FFD700 !important;
            color: white !important;
        }
        
        .cc-btn-accept {
            background: #FFD700 !important;
            color: #0A1929 !important;
            border-radius: 50px !important;
            font-weight: bold !important;
            border: none !important;
        }
        
        .cc-btn-accept:hover {
            background: #FFA500 !important;
            transform: scale(1.05) !important;
        }
        
        .cc-btn-reject {
            background: transparent !important;
            border: 2px solid #FFD700 !important;
            color: #FFD700 !important;
            border-radius: 50px !important;
        }
        
        .cc-btn-reject:hover {
            background: rgba(255, 215, 0, 0.1) !important;
        }
        
        .cc-btn-preferences {
            background: transparent !important;
            border: 1px solid rgba(255,255,255,0.3) !important;
            color: white !important;
            border-radius: 50px !important;
        }
        
        .cc-btn-preferences:hover {
            background: rgba(255,255,255,0.1) !important;
        }
        
        [data-theme="light"] .cc-main {
            background: rgba(255, 255, 255, 0.95) !important;
            color: #2c3e50 !important;
        }
        
        [data-theme="light"] .cc-btn-preferences {
            color: #2c3e50 !important;
        }
    </style>
</head>

<body data-theme="dark">
    <!-- Elementos decorativos flotantes -->
    <div class="floating-circles">
        <div class="circle circle1"></div>
        <div class="circle circle2"></div>
        <div class="circle circle3"></div>
        <div class="circle circle4"></div>
    </div>

<header>
    <!-- Logo como botón de inicio -->
    <div class="logo">
        <a href="{{ route('inicio') }}" data-tooltip="Ir al inicio">
            <i class="fas fa-film"></i>
            <h2>Cine</h2>
        </a>
    </div>

    <!-- Checkbox para menú responsive -->
    <input type="checkbox" id="menu-toggle">
    <label for="menu-toggle" class="hamburger">&#9776;</label>

    <nav style="display: flex; align-items: center; gap: 15px;">
        <ul class="menu">
            @auth
                {{-- Usuario autenticado --}}
                
                {{-- Menú ADMIN --}}
                @if(Auth::user()->is_admin)
                    <li><a href="{{ route('peliculas.index') }}" class="nav-button" data-tooltip="Películas"><i class="fas fa-film"></i></a></li>
                    <li><a href="{{ route('funciones.index') }}" class="nav-button" data-tooltip="Funciones"><i class="fas fa-clock"></i></a></li>

                @else
                    {{-- Menú CLIENTE --}}
                    <li><a href="{{ route('cliente.cartelera') }}" class="nav-button" data-tooltip="Cartelera"><i class="fas fa-ticket-alt"></i></a></li>
                    <li><a href="{{ route('cliente.funciones') }}" class="nav-button" data-tooltip="Funciones"><i class="fas fa-calendar-alt"></i></a></li>
                    <li><a href="{{ route('cliente.boletos') }}" class="nav-button" data-tooltip="Mis Boletos"><i class="fas fa-qrcode"></i></a></li>
                @endif

                {{-- Logout --}}
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" class="nav-button" data-tooltip="Cerrar sesión">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </li>

            @endauth

            {{-- Invitados --}}
            @guest
                <li><a href="{{ route('cliente.cartelera') }}" class="nav-button" data-tooltip="Cartelera"><i class="fas fa-ticket-alt"></i></a></li>
                <li><a href="{{ route('cliente.funciones') }}" class="nav-button" data-tooltip="Funciones"><i class="fas fa-calendar-alt"></i></a></li>
                <li><a href="{{ route('login') }}" class="nav-button" data-tooltip="Iniciar sesión"><i class="fas fa-sign-in-alt"></i></a></li>
                <li><a href="{{ route('register') }}" class="nav-button" data-tooltip="Registrarse"><i class="fas fa-user-plus"></i></a></li>
            @endguest
        </ul>

        @auth
            {{-- IDENTIFICADOR DE USUARIO (NO ES BOTÓN) --}}
            <div class="user-identifier">
                <i class="fas fa-user-circle"></i>
                <span>{{ Auth::user()->name }}</span>
                @if(Auth::user()->is_admin)
                    <span class="admin-badge">ADMIN</span>
                @endif
            </div>
        @endauth

        <!-- Botón de cambio de tema -->
        <div class="theme-switch">
            <button id="themeToggle" class="theme-button" data-tooltip="Cambiar tema">
                <i id="themeIcon" class="fas fa-moon"></i>
            </button>
        </div>
    </nav>
</header>

<main>
    {{-- Mensajes flash --}}
    @if(session('success'))
        <div class="flash-message flash-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="flash-message flash-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</main>

{{-- 🍪 COOKIE CONSENT SCRIPTS --}}
{!! CookieConsent::scripts() !!}

<script>
    // Marcar enlace activo
    document.addEventListener('DOMContentLoaded', function() {
        const currentUrl = window.location.pathname;
        document.querySelectorAll('.nav-button').forEach(link => {
            if (link.getAttribute('href') === currentUrl) {
                link.classList.add('active');
            }
        });
    });

    // Cerrar menú al hacer clic en un enlace
    document.querySelectorAll('.nav-button, .theme-button').forEach(item => {
        item.addEventListener('click', function() {
            document.getElementById('menu-toggle').checked = false;
        });
    });

    // ===== SISTEMA DE TEMA CLARO/OSCURO =====
    (function() {
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        
        // Verificar tema guardado
        const savedTheme = localStorage.getItem('theme') || 'dark';
        document.body.setAttribute('data-theme', savedTheme);
        updateIcon(savedTheme);
        
        // Función para actualizar icono
        function updateIcon(theme) {
            if (theme === 'dark') {
                themeIcon.className = 'fas fa-moon';
            } else {
                themeIcon.className = 'fas fa-sun';
            }
        }
        
        // Toggle de tema
        themeToggle.addEventListener('click', function() {
            const currentTheme = document.body.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.body.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateIcon(newTheme);
            
            // Animación adicional
            themeIcon.style.transform = 'rotate(360deg)';
            setTimeout(() => {
                themeIcon.style.transform = 'rotate(0deg)';
            }, 500);
        });
    })();

    // Crear partículas pequeñas aleatorias
    function createParticles() {
        const body = document.querySelector('body');
        for (let i = 0; i < 20; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.position = 'absolute';
            particle.style.width = Math.random() * 6 + 2 + 'px';
            particle.style.height = particle.style.width;
            particle.style.background = 'white';
            particle.style.borderRadius = '50%';
            particle.style.opacity = '0.2';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.animation = 'pulse ' + (Math.random() * 3 + 2) + 's infinite';
            particle.style.pointerEvents = 'none';
            particle.style.zIndex = '0';
            body.appendChild(particle);
        }
    }
    
    createParticles();
</script>

</body>
</html>