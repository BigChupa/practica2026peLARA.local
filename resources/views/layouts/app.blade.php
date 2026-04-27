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
            overflow: visible;
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
            z-index: 2000;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); 
            border: none;
        }

        .dropdown-menu.services-menu {
            width: auto;
            padding: 0.5rem;
            min-width: 320px;
        }

        .dropdown-menu.services-menu .dropdown-item {
            color: rgba(255,255,255,0.95);
            padding: 0.35rem 1rem;
            white-space: nowrap;
        }

        .dropdown-menu.services-menu .dropdown-item:hover,
        .dropdown-menu.services-menu .dropdown-item:focus {
            color: #fff;
            background-color: rgba(255,255,255,0.08);
        }

        .dropdown-menu .dropdown-submenu {
            position: relative;
        }

        .dropdown-menu .dropdown-submenu > .dropdown-menu {
            top: 0;
            left: 100%;
            margin-left: 0.1rem;
            display: none;
            position: absolute;
            min-width: 220px;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }

        .dropdown-menu .dropdown-submenu:hover > .dropdown-menu {
            display: block;
        }

        .dropdown-menu .dropdown-submenu > .dropdown-toggle::after {
            border-top: 0.3em solid;
            border-right: 0.3em solid transparent;
            border-left: 0.3em solid transparent;
            content: "";
            float: right;
            margin-top: 0.35rem;
        }

        .dropdown-menu.services-menu .service-link {
            color: rgba(255,255,255,0.92);
            display: block;
            padding: 0.2rem 0;
        }

        .dropdown-menu.services-menu .service-link:hover {
            color: #fff;
            text-decoration: none;
        }

       
        @media (hover: hover) {
            .nav-item.dropdown:hover > .dropdown-menu {
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
                            <ul class="dropdown-menu services-menu" aria-labelledby="servicesDropdown">
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="{{ route('services', ['category' => 'maintenance']) }}">Планове ТО</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('services', ['category' => 'maintenance']) }}">Усі послуги ➜</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'air-filter']) }}">Заміна повітряного фільтра</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'ac-cleaning']) }}">Чистка кондиціонера авто</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'power-steering-fluid']) }}">Заміна рідини гідропідсилювача керма</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'timing-belt']) }}">Заміна ременя ГРМ</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'oil-and-filter']) }}">Заміна масла і фільтра</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="{{ route('services', ['category' => 'diagnostics']) }}">Діагностика авто</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('services', ['category' => 'diagnostics']) }}">Усі послуги ➜</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'chassis']) }}">Діагностика ходової частини</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'computer']) }}">Комп’ютерна діагностика авто</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'steering']) }}">Діагностика рульового управління</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'brakes']) }}">Діагностика гальмівної системи</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'cooling-system']) }}">Діагностика системи охолодження</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="{{ route('services', ['category' => 'engine']) }}">Двигун</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('services', ['category' => 'engine']) }}">Усі послуги ➜</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'oil-filter']) }}">Заміна масла і масляного фільтра</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'timing-belt-replacement']) }}">Заміна ременя ГРМ</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'timing-chain']) }}">Заміна ланцюга ГРМ</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'engine-flush']) }}">Промивання двигуна автомобіля</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="{{ route('services', ['category' => 'steering']) }}">Рульове керування</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('services', ['category' => 'steering']) }}">Усі послуги ➜</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'steering-rack']) }}">Заміна рульової рейки</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'tie-rod']) }}">Заміна рульової тяги</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'tie-rod-end']) }}">Заміна рульових наконечників</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'power-steering-pump']) }}">Заміна насоса ГУР</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="{{ route('services', ['category' => 'electrical']) }}">Електрообладнання</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('services', ['category' => 'electrical']) }}">Усі послуги ➜</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'alarm-installation']) }}">Установка сигналізації на авто</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'battery-replacement']) }}">Заміна АКБ</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'generator-replacement']) }}">Заміна генератора</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="{{ route('services', ['category' => 'transmission']) }}">Трансмісія</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('services', ['category' => 'transmission']) }}">Усі послуги ➜</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'at-replacement']) }}">Заміна АКПП</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'at-oil-change']) }}">АКПП – заміна масла</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'cv-joint']) }}">Заміна ШРУСа</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="{{ route('services', ['category' => 'brakes']) }}">Гальмівна система</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('services', ['category' => 'brakes']) }}">Усі послуги ➜</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'brake-fluid-change']) }}">Заміна гальмівної рідини</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'brake-pad-replacement']) }}">Заміна гальмівних колодок</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'caliper-repair']) }}">Супорт гальмівний ремонт</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="{{ route('services', ['category' => 'clutch']) }}">Зчеплення</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('services', ['category' => 'clutch']) }}">Усі послуги ➜</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'clutch-kit']) }}">Заміна комплекту зчеплення</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'release-bearing']) }}">Заміна вижимного підшипника</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'clutch-master']) }}">Заміна головного циліндра зчеплення</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="{{ route('services', ['category' => 'suspension']) }}">Ходова частина</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('services', ['category' => 'suspension']) }}">Усі послуги ➜</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'stabilizer-link']) }}">Заміна стійки стабілізатора</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'ball-joint']) }}">Заміна шарової опори</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'shock-absorber']) }}">Заміна амортизаторів</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="{{ route('services', ['category' => 'air-conditioning']) }}">Система кондиціонування</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('services', ['category' => 'air-conditioning']) }}">Усі послуги ➜</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'cabin-filter']) }}">Заміна салонного фільтра</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'ac-recharge']) }}">Заправка автокондиціонерів</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'heater-core']) }}">Заміна радіатора пічки</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="{{ route('services', ['category' => 'exhaust']) }}">Вихлопна система</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('services', ['category' => 'exhaust']) }}">Усі послуги ➜</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'exhaust-diagnostics']) }}">Діагностика вихлопної системи</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'lambda-sensor-replacement']) }}">Заміна датчика лямбда зонд</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'catalyst-replacement']) }}">Заміна каталізатора</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="{{ route('services', ['category' => 'cooling']) }}">Система охолодження</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('services', ['category' => 'cooling']) }}">Усі послуги ➜</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'coolant-replacement']) }}">Заміна охолоджуючої рідини</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'thermostat-replacement']) }}">Заміна термостата</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'radiator-replacement']) }}">Заміна радіатора охолодження</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="{{ route('services', ['category' => 'fuel']) }}">Паливна система</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('services', ['category' => 'fuel']) }}">Усі послуги ➜</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'fuel-filter']) }}">Заміна паливного фільтра</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'fuel-system-clean']) }}">Чистка паливної системи</a></li>
                                        <li><a class="dropdown-item" href="{{ route('services', ['service' => 'fuel-system-diagnostics']) }}">Діагностика паливної системи</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contacts') }}">Контакти</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-danger btn-sm text-white px-3" href="{{ route('services') }}">Запис на СТО</a>
                        </li>
                    </ul>

                   
                     
                        <ul class="navbar-nav ms-auto">
                        @guest
                            @if(request()->routeIs('shop'))
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
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @php $avatar = Auth::user()->avatar ?? null; @endphp
                                    <img src="{{ $avatar ? '/' . 'storage/app/public/' . $avatar : 'https://www.gravatar.com/avatar/'.md5(strtolower(trim(Auth::user()->email))).'?s=40&d=mp' }}" alt="avatar" class="rounded-circle me-2" style="width:34px;height:34px;object-fit:cover">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('users.show', auth()->user()) }}">👤 Профіль</a>

                                    @if(Auth::user()->isAdmin())
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
