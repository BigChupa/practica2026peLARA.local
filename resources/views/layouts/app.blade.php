<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Моторист - {{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        
        .navbar {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            color: #fff !important;
            margin-right: 2rem;
        }
        
        .navbar a, .navbar-nav .nav-link {
            color: #fff !important;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            padding: 0.5rem 1rem;
        }

       
        .nav-item.dropdown {
            position: relative;
        }

        .nav-item .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 220px;
            margin-top: 0; 
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
            z-index: 2000;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); 
            border: none;
        }

       
        @media (hover: hover) {
            .nav-item.dropdown:hover .dropdown-menu {
                display: block;
            }
        }

        .dropdown-menu .dropdown-item {
            color: #fff;
            padding: 0.5rem 1rem;
            transition: background-color 0.15s ease;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: rgba(255,255,255,0.08);
            color: #fff;
        }
        
        .hero {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 4rem 0;
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        
        .hero p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
        }
        
        .btn-custom {
            background-color: #ff6b6b;
            border: none;
            padding: 0.75rem 2rem;
            font-size: 1.1rem;
            box-shadow: 0 8px 16px rgba(255, 107, 107, 0.3);
        }
        
        footer {
            background-color: #1e3c72;
            color: white;
            margin-top: 4rem;
                            @if(request()->routeIs('shop'))
                                <!-- Адмін аватар та дропдаун видалено за запитом -->
                            @endif
            padding: 2rem 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Моторист
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Головна</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('shop') }}">Магазин</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('about') }}">Про нас</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{ route('services') }}" id="servicesDropdown" role="button" aria-expanded="false">
                                Послуги
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                                <li><a class="dropdown-item" href="{{ route('appointments.create', 6) }}"> Тех. огляд</a></li>
                                <li><a class="dropdown-item" href="{{ route('appointments.create', 2) }}"> Заміна масла</a></li>
                                <li><a class="dropdown-item" href="{{ route('appointments.create', 1) }}"> Діагностика двигуна</a></li>
                                <li><a class="dropdown-item" href="{{ route('appointments.create', 3) }}"> Заміна гальмівних колодок</a></li>
                                <li><a class="dropdown-item" href="{{ route('appointments.create', 4) }}"> Балансування коліс</a></li>
                                <li><a class="dropdown-item" href="{{ route('appointments.create', 5) }}"> Шиномонтаж</a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contacts') }}">Контакти</a>
                        </li>
                    </ul>

                   
                     
                        <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Вхід</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Реєстрація</a>
                                </li>
                            @endif
                        @else
                    
                            @if(request()->routeIs('shop'))
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        @php $avatar = Auth::user()->avatar ?? null; @endphp
                                        <img src="{{ $avatar ? '/' . 'storage/app/public/' . $avatar : 'https://www.gravatar.com/avatar/'.md5(strtolower(trim(Auth::user()->email))).'?s=40&d=mp' }}" alt="avatar" class="rounded-circle me-2" style="width:34px;height:34px;object-fit:cover">
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('users.show', auth()->user()) }}">👤 Профіль</a>

                                        @if(Auth::user()->isAdmin() && session('admin_area_authenticated'))
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">⚙️ Адмін панель</a>
                                        @endif

                                        <div class="dropdown-divider"></div>

                                        <a class="dropdown-item" href="{{ route('orders.index') }}">📦 Мої замовлення</a>

                                        <div class="dropdown-divider"></div>

                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Вихід</a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                    </div>
                                </li>
                            @endif
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
        
        <footer>
            <div class="container">
                <p>&copy; 2026 Моторист. Всі права захищені.</p>
                <p>Надання якісних послуг для вашого авто</p>
            </div>
        </footer>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
