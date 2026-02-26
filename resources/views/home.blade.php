@extends('layouts.app')

@section('content')
<div class="hero">
    <div class="container">
        <h1>Добро пожалувати до Моториста!</h1>
        <p>Найкращі послуги для вашого автомобіля</p>
        <a href="#services" class="btn btn-custom text-white">Дізнатись більше</a>
    </div>
</div>

<div class="container py-5">
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <section id="about" class="mb-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="mb-4">Про нас</h2>
                <p class="lead">Ми надаємо професійні послуги з обслуговування та ремонту автомобілів. З нами ваш автомобіль завжди буде в ідеальному стані.</p>
                <ul class="list-unstyled">
                    <li><strong>✓ Професійна команда</strong> - досвід більше 10 років</li>
                    <li><strong>✓ Сучасне обладнання</strong> - новітні технології</li>
                    <li><strong>✓ Гарантія якості</strong> - 100% задоволення клієнтів</li>
                    <li><strong>✓ Доступні ціни</strong> - конкурентні пропозиції</li>
                </ul>
            </div>
            <div class="col-md-6">
                <img src="https://picsum.photos/400/300?random=1" alt="Про нас" class="img-fluid rounded">
            </div>
        </div>
    </section>

    <hr class="my-5">

    <section id="services" class="mb-5">
        <h2 class="text-center mb-5">Наші послуги</h2>
        <div class="row">
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">🔧 Ремонт</h5>
                        <p class="card-text">Професійний ремонт усіх систем автомобіля</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">🛠️ Обслуговування</h5>
                        <p class="card-text">Регулярне технічне обслуговування</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">🔍 Діагностика</h5>
                        <p class="card-text">Комп'ютерна діагностика автомобіля</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">💨 Миття</h5>
                        <p class="card-text">Професійне миття та полірування</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-5">

    <section id="contact" class="mb-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2 class="text-center mb-4">Зв'яжіться з нами</h2>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h5>📍 Адреса</h5>
                                <p>вул. Гаврилишина, 15<br>м. Львів, 79000</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h5>📞 Телефон</h5>
                                <p><a href="tel:+380671234567">+38 067 123 45 67</a></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h5>📧 Email</h5>
                                <p><a href="mailto:info@motoryst.ua">info@motoryst.ua</a></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h5>🕐 Час роботи</h5>
                                <p>Пн-Пт: 09:00 - 18:00<br>Сб: 09:00 - 16:00<br>Нд: вихідний</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-5">

    <div class="text-center py-5">
        <h3>Готові обслужити ваш автомобіль?</h3>
        <p class="lead">Запишіться на прийом розташунку або пишіть нам</p>
        <a href="{{ route('services') }}" class="btn btn-custom btn-lg text-white">Зв'язатися</a>
    </div>
</div>
@endsection
