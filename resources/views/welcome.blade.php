<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bótica Vida Saludable</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- AOS for Animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Custom Styles -->
    <style>
        .bg-pharmacy-left {
            background: url('https://images.pexels.com/photos/7615574/pexels-photo-7615574.jpeg?auto=compress&cs=tinysrgb&w=1920&h=1080&dpr=2') no-repeat center center/cover;
            position: relative;
            overflow: hidden;
        }
        
        .bg-overlay {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.85) 0%, rgba(67, 56, 202, 0.85) 100%);
        }
        
        .glass-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .title-gradient {
            background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #f7b733);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 800;
            font-size: 3.5rem;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            animation: gradientShift 5s ease infinite;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .subtitle-color {
            background: linear-gradient(90deg, #a3e4d7, #96ceb4);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-size: 1.5rem;
            text-shadow: 0 0 5px rgba(0, 0, 0, 0.4);
            margin-bottom: 2rem;
        }
        
        .button-primary {
            background-color: #ef4444;
            padding: 16px 32px;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 1.1rem;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
            display: inline-block;
            width: 100%;
            max-width: 280px;
            text-align: center;
            margin: 12px 0;
        }
        
        .button-primary:hover {
            background-color: #dc2626;
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.5);
        }
        
        .button-secondary {
            background: transparent;
            border: 2px solid #fff;
            padding: 16px 32px;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 1.1rem;
            letter-spacing: 1px;
            display: inline-block;
            width: 100%;
            max-width: 280px;
            text-align: center;
            margin: 12px 0;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
        }
        
        .button-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(255, 255, 255, 0.3);
        }
        
        .action-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05));
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 40px 30px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 100%;
            max-width: 480px;
        }
        
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 25px 0;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .divider::before {
            margin-right: 15px;
        }
        
        .divider::after {
            margin-left: 15px;
        }
        
        .social-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s;
            margin: 0 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .social-btn:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            margin: 0 auto 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        @media (max-width: 768px) {
            .split-layout {
                flex-direction: column;
            }
            
            .split-left, .split-right {
                width: 100%;
            }
            
            .split-left {
                height: 40vh;
            }
            
            .title-gradient {
                font-size: 2.5rem;
            }
            
            .action-card {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body class="font-poppins bg-gray-50">
    <!-- Main Content -->
    <div class="min-h-screen flex split-layout">
        <!-- Left Column: Branding and Image -->
        <div class="w-1/2 split-left bg-pharmacy-left relative flex items-center justify-center">
            <div class="absolute inset-0 bg-overlay"></div>
            <div class="content relative z-10 text-center px-8" data-aos="fade-right" data-aos-duration="1000">
                <div class="glass-card">
                    <h1 class="title-gradient mb-6">Vida Saludable</h1>
                    <p class="subtitle-color mb-8 text-white">
                        Tu botica de confianza, comprometida con tu bienestar con productos de calidad y atención personalizada.
                    </p>
                    
                    <!-- Features Section -->
                    <div class="grid grid-cols-3 gap-4 mt-10">
                        <div data-aos="fade-up" data-aos-delay="100">
                            <div class="feature-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                            </div>
                            <p class="text-white font-medium">Productos Certificados</p>
                        </div>
                        <div data-aos="fade-up" data-aos-delay="200">
                            <div class="feature-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <p class="text-white font-medium">Calidad Garantizada</p>
                        </div>
                        <div data-aos="fade-up" data-aos-delay="300">
                            <div class="feature-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <p class="text-white font-medium">Atención Personal</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column: Action Buttons -->
        <div class="w-1/2 split-right flex items-center justify-center p-8 bg-gradient-to-br from-indigo-900 to-indigo-700">
            <div class="w-full max-w-md" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                <div class="action-card">
                    <div class="text-center mb-8">
                        <div class="flex justify-center mb-6">
                            <div class="bg-gray-200 border-2 border-dashed rounded-xl w-16 h-16" />
                        </div>
                        <h2 class="text-3xl font-bold text-white mb-2">Bienvenido a Vida Saludable</h2>
                        <p class="text-indigo-200">Accede a tu cuenta o regístrate para disfrutar de nuestros servicios</p>
                    </div>
                    
                    <!-- Botones de Acción -->
                    <div class="mt-10">
                        <a href="{{ route('login') }}" class="button-primary text-white">
                            Iniciar Sesión
                        </a>
                        
                        <a href="{{ route('register') }}" class="button-secondary text-white">
                            Crear Cuenta
                        </a>
                    </div>
                    
                    <!-- Divider -->
                    <div class="divider">
                        O continúa con
                    </div>
                    
                    <!-- Social Login -->
                    <div class="flex justify-center">
                        <a href="#" class="social-btn">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-btn">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-btn">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.954 4.569c-.885.389-1.83.654-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.896-.959-2.173-1.559-3.591-1.559-2.717 0-4.92 2.203-4.92 4.917 0 .39.045.765.127 1.124-4.09-.193-7.715-2.157-10.141-5.126-.427.722-.666 1.561-.666 2.475 0 1.71.87 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.39 0-.779-.023-1.17-.067 2.189 1.394 4.768 2.209 7.557 2.209 9.054 0 14-7.503 14-14v-.617c.961-.689 1.8-1.56 2.46-2.548z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Info adicional -->
                <div class="mt-8 text-center text-sm text-indigo-200">
                    <p>© 2023 Bótica Vida Saludable. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Initialize AOS -->
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    </script>
</body>
</html>