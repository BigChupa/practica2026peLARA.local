<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('home');
});

use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Models\Service;

Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/api/shop/models', [ShopController::class, 'getModels'])->name('shop.models');
Route::get('/api/shop/years', [ShopController::class, 'getYears'])->name('shop.years');
Route::post('/api/vin/decode', [App\Http\Controllers\VinDecoderController::class, 'decode'])->name('vin.decode');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/sync', [CartController::class, 'syncGuest'])->name('cart.sync');
use App\Http\Controllers\CheckoutController;

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/confirmation', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');

// Delivery API routes
use App\Http\Controllers\DeliveryController;
Route::prefix('api')->group(function () {
    Route::get('/delivery/cities', [DeliveryController::class, 'getCities'])->name('api.delivery.cities');
    Route::get('/delivery/warehouses', [DeliveryController::class, 'getWarehouses'])->name('api.delivery.warehouses');
    Route::post('/delivery/sync', [DeliveryController::class, 'syncWarehouses'])->name('api.delivery.sync');
    
    // Test route
    Route::get('/test', function() {
        return response()->json(['message' => 'API works!']);
    });
});

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/services', function (Request $request) {
    $categories = [
        [
            'slug' => 'maintenance',
            'title' => 'Планове ТО',
            'description' => 'Регулярні роботи для підтримки технічного стану автомобіля.',
            'services' => [
                ['slug' => 'air-filter', 'name' => 'Заміна повітряного фільтра', 'price' => 420, 'description' => 'Замінюємо повітряний фільтр для чистого повітря в двигуні.'],
                ['slug' => 'ac-cleaning', 'name' => 'Чистка кондиціонера авто', 'price' => 720, 'description' => 'Профілактична чистка системи кондиціювання та обробка дренажу.'],
                ['slug' => 'power-steering-fluid', 'name' => 'Заміна рідини гідропідсилювача керма', 'price' => 680, 'description' => 'Оновлення рідини ГУР для плавного та безпечного управління.'],
                ['slug' => 'timing-belt', 'name' => 'Заміна ременя ГРМ', 'price' => 2200, 'description' => 'Замінюємо ремінь газорозподільного механізму з перевіркою натягу.'],
                ['slug' => 'oil-and-filter', 'name' => 'Заміна масла і фільтра', 'price' => 980, 'description' => 'Комплексна заміна моторної оливи та фільтра.'],
                ['slug' => 'drive-belt', 'name' => 'Заміна приводного ременя', 'price' => 890, 'description' => 'Оновлюємо приводний ремінь для правильного обертання агрегатів.'],
                ['slug' => 'coolant', 'name' => 'Заміна охолоджуючої рідини', 'price' => 650, 'description' => 'Заміна антифризу для стабільної роботи системи охолодження.'],
                ['slug' => 'spark-plugs', 'name' => 'Заміна свічок запалювання', 'price' => 540, 'description' => 'Заміна свічок з контролем зазорів для оптимального запалення.'],
                ['slug' => 'fuel-filter', 'name' => 'Заміна паливного фільтра', 'price' => 520, 'description' => 'Очищення паливної системи шляхом заміни фільтра.'],
                ['slug' => 'brake-fluid', 'name' => 'Заміна гальмівної рідини', 'price' => 760, 'description' => 'Заміна та тестування гальмівної рідини для стабільного гальмування.'],
                ['slug' => 'cabin-filter', 'name' => 'Заміна салонного фільтра', 'price' => 390, 'description' => 'Заміна фільтра салону для свіжого повітря в салоні.'],
                ['slug' => 'ac-service', 'name' => 'Обслуговування системи кондиціонування', 'price' => 1100, 'description' => 'Планове обслуговування кондиціонера та перевірка фреону.'],
            ],
        ],
        [
            'slug' => 'diagnostics',
            'title' => 'Діагностика авто',
            'description' => 'Повна перевірка вузлів та систем авто для швидкого виявлення несправностей.',
            'services' => [
                ['slug' => 'chassis', 'name' => 'Діагностика ходової частини', 'price' => 520, 'description' => 'Перевірка підвіски, шарнірів та елементів ходової частини.'],
                ['slug' => 'computer', 'name' => 'Комп’ютерна діагностика авто', 'price' => 890, 'description' => 'Сканування електронних систем та зчитування кодів помилок.'],
                ['slug' => 'steering', 'name' => 'Діагностика рульового управління', 'price' => 580, 'description' => 'Профілактична перевірка рульових механізмів та компонентів.'],
                ['slug' => 'brakes', 'name' => 'Діагностика гальмівної системи', 'price' => 620, 'description' => 'Перевірка стану гальмівних дисків, колодок і системи.'],
                ['slug' => 'cooling-system', 'name' => 'Діагностика системи охолодження', 'price' => 600, 'description' => 'Перевірка радіатора, термостата та охолоджуючих контурів.'],
                ['slug' => 'ignition', 'name' => 'Діагностика системи запалювання', 'price' => 570, 'description' => 'Аналіз електроніки та компонентів запалювання.'],
            ],
        ],
        [
            'slug' => 'engine',
            'title' => 'Двигун',
            'description' => 'Роботи з двигуном та його системами для надійної роботи авто.',
            'services' => [
                ['slug' => 'oil-filter', 'name' => 'Заміна масла і масляного фільтра', 'price' => 980, 'description' => 'Повна заміна масла та масляного фільтра двигуна.'],
                ['slug' => 'timing-belt-replacement', 'name' => 'Заміна ременя ГРМ', 'price' => 2200, 'description' => 'Заміна ременя ГРМ з налаштуванням натягу.'],
                ['slug' => 'timing-chain', 'name' => 'Заміна ланцюга ГРМ', 'price' => 3100, 'description' => 'Роботи з заміною ланцюгового приводу ГРМ.'],
                ['slug' => 'engine-flush', 'name' => 'Промивання двигуна автомобіля', 'price' => 1700, 'description' => 'Профілактичне промивання двигуна від забруднень.'],
                ['slug' => 'air-filter-engine', 'name' => 'Заміна повітряного фільтра', 'price' => 420, 'description' => 'Замінюємо повітряний фільтр для оптимальної роботи мотора.'],
                ['slug' => 'throttle-clean', 'name' => 'Чистка дросельної заслінки', 'price' => 760, 'description' => 'Очищення дроселя для стабільної роботи двигуна.'],
                ['slug' => 'valve-cover-gasket', 'name' => 'Заміна прокладки клапанної кришки', 'price' => 1200, 'description' => 'Запобігаємо підтікання масла заміною прокладки.'],
                ['slug' => 'camshaft-seal', 'name' => 'Заміна сальників распредвала', 'price' => 980, 'description' => 'Заміна сальників для уникнення масляних витоків.'],
                ['slug' => 'head-gasket', 'name' => 'Заміна прокладки ГБЦ', 'price' => 3600, 'description' => 'Ремонтні роботи при проблемах з прокладкою головки блоку.'],
                ['slug' => 'engine-mounts', 'name' => 'Заміна подушок двигуна', 'price' => 1450, 'description' => 'Заміна опор для зниження вібрацій та шуму.'],
            ],
        ],
        [
            'slug' => 'steering',
            'title' => 'Рульове керування',
            'description' => 'Роботи з рульовим механізмом та його допоміжними компонентами.',
            'services' => [
                ['slug' => 'steering-rack', 'name' => 'Заміна рульової рейки', 'price' => 2800, 'description' => 'Ремонт або заміна рульової рейки з регулюванням.'],
                ['slug' => 'tie-rod', 'name' => 'Заміна рульової тяги', 'price' => 920, 'description' => 'Оновлення тяги за результатами діагностики.'],
                ['slug' => 'tie-rod-end', 'name' => 'Заміна рульових наконечників', 'price' => 760, 'description' => 'Заміна наконечників для точності керування.'],
                ['slug' => 'power-steering-pump', 'name' => 'Заміна насоса ГУР', 'price' => 2300, 'description' => 'Заміна насоса і перевірка тиску рідини.'],
                ['slug' => 'steering-boot', 'name' => 'Заміна пильника рульового наконечника', 'price' => 520, 'description' => 'Заміна захисного пильника кермового наконечника.'],
                ['slug' => 'steering-rod-boot', 'name' => 'Заміна пильника кермової тяги', 'price' => 520, 'description' => 'Захист елементів рульового керування від пилу та вологи.'],
            ],
        ],
        [
            'slug' => 'electrical',
            'title' => 'Електрообладнання',
            'description' => 'Роботи з електричними та електронними системами авто.',
            'services' => [
                ['slug' => 'alarm-installation', 'name' => 'Установка сигналізації на авто', 'price' => 1500, 'description' => 'Установка та налаштування автомобільної сигналізації.'],
                ['slug' => 'battery-replacement', 'name' => 'Заміна АКБ', 'price' => 1250, 'description' => 'Заміна акумулятора з перевіркою зарядної системи.'],
                ['slug' => 'generator-replacement', 'name' => 'Заміна генератора', 'price' => 2100, 'description' => 'Ремонт або заміна генератора та перевірка навантаження.'],
                ['slug' => 'starter-replacement', 'name' => 'Заміна стартера', 'price' => 1900, 'description' => 'Замінюємо стартер і тестуємо його роботу.'],
                ['slug' => 'parktronics', 'name' => 'Встановлення парктроніків', 'price' => 1100, 'description' => 'Установка датчиків паркування для безпечних маневрів.'],
                ['slug' => 'ignition-coil', 'name' => 'Заміна котушки запалювання', 'price' => 680, 'description' => 'Заміна котушки для стабільного іскроутворення.'],
                ['slug' => 'rear-camera', 'name' => 'Встановлення камери заднього виду', 'price' => 1450, 'description' => 'Встановлення камери та інтеграція з монітором.'],
                ['slug' => 'crankshaft-sensor', 'name' => 'Заміна датчика коленвала', 'price' => 780, 'description' => 'Заміна датчика колінчастого вала для коректної роботи двигуна.'],
                ['slug' => 'high-voltage-wires', 'name' => 'Заміна високовольтних проводів', 'price' => 620, 'description' => 'Оновлення проводів запалювання для надійної роботи системи.'],
                ['slug' => 'knock-sensor', 'name' => 'Заміна датчика детонації', 'price' => 760, 'description' => 'Заміна датчика та тестування роботи двигуна.'],
                ['slug' => 'lambda-sensor', 'name' => 'Заміна датчика лямбда зонд', 'price' => 850, 'description' => 'Заміна датчика для контролю змішування палива.'],
                ['slug' => 'camshaft-sensor', 'name' => 'Заміна датчика распредвала', 'price' => 850, 'description' => 'Заміна датчика для коректної роботи ГРМ.'],
                ['slug' => 'temperature-sensor', 'name' => 'Заміна датчика температури ОР', 'price' => 620, 'description' => 'Заміна датчика температури охолоджуючої рідини.'],
                ['slug' => 'ignition-lock', 'name' => 'Ремонт замку запалювання', 'price' => 990, 'description' => 'Ремонт або заміна замка запалювання.'],
                ['slug' => 'headlamp-bulb', 'name' => 'Заміна лампочки фари', 'price' => 240, 'description' => 'Швидка заміна та перевірка освітлення.'],
            ],
        ],
        [
            'slug' => 'transmission',
            'title' => 'Трансмісія',
            'description' => 'Обслуговування трансмісійних вузлів та приводів.',
            'services' => [
                ['slug' => 'at-replacement', 'name' => 'Заміна АКПП', 'price' => 7800, 'description' => 'Ремонт або заміна автоматичної коробки передач.'],
                ['slug' => 'at-oil-change', 'name' => 'АКПП – заміна масла', 'price' => 1650, 'description' => 'Заміна масла в автоматичній коробці передач.'],
                ['slug' => 'cv-joint', 'name' => 'Заміна ШРУСа', 'price' => 1800, 'description' => 'Оновлення шарніра рівних кутових швидкостей.'],
                ['slug' => 'mt-oil-change', 'name' => 'Заміна масла в МКПП', 'price' => 1400, 'description' => 'Заміна масла в механічній коробці передач.'],
                ['slug' => 'bearing-replacement', 'name' => 'Заміна підвісного підшипника', 'price' => 920, 'description' => 'Оновлення підвісного підшипника карданного валу.'],
                ['slug' => 'u-joint', 'name' => 'Заміна хрестовини кардана', 'price' => 1170, 'description' => 'Заміна карданної хрестовини та балансування.'],
                ['slug' => 'drive-shaft', 'name' => 'Заміна карданного валу', 'price' => 2150, 'description' => 'Ремонт або заміна карданного валу.'],
            ],
        ],
        [
            'slug' => 'brakes',
            'title' => 'Гальмівна система',
            'description' => 'Роботи з гальмівними вузлами для безпеки на дорозі.',
            'services' => [
                ['slug' => 'brake-fluid-change', 'name' => 'Заміна гальмівної рідини', 'price' => 760, 'description' => 'Заміна рідини для надійного гальмування.'],
                ['slug' => 'brake-pad-replacement', 'name' => 'Заміна гальмівних колодок', 'price' => 1500, 'description' => 'Заміна колодок із перевіркою гальмівних дисків.'],
                ['slug' => 'caliper-repair', 'name' => 'Супорт гальмівний ремонт', 'price' => 1450, 'description' => 'Ремонт супорту та перевірка стану гальмівної системи.'],
                ['slug' => 'brake-disc-replacement', 'name' => 'Заміна гальмівного диска', 'price' => 1360, 'description' => 'Заміна диска зі шліфуванням та балансуванням.'],
                ['slug' => 'vacuum-booster', 'name' => 'Заміна вакуумного підсилювача гальм', 'price' => 2100, 'description' => 'Ремонт та заміна вакуумного підсилювача.'],
                ['slug' => 'brake-hose', 'name' => 'Заміна гальмівного шланга', 'price' => 620, 'description' => 'Оновлення шлангів для безпечної гальмівної системи.'],
                ['slug' => 'master-cylinder', 'name' => 'Заміна головного гальмівного циліндра', 'price' => 2450, 'description' => 'Заміна та тестування головного гальмівного циліндра.'],
            ],
        ],
        [
            'slug' => 'clutch',
            'title' => 'Зчеплення',
            'description' => 'Роботи з вузлом зчеплення та його допоміжними елементами.',
            'services' => [
                ['slug' => 'clutch-kit', 'name' => 'Заміна комплекту зчеплення', 'price' => 3850, 'description' => 'Комплексна заміна комплекта зчеплення.'],
                ['slug' => 'dual-mass-flywheel', 'name' => 'Заміна двомасового маховика', 'price' => 4700, 'description' => 'Заміна маховика з перевіркою диску.'],
                ['slug' => 'release-bearing', 'name' => 'Заміна вижимного підшипника', 'price' => 980, 'description' => 'Замінюємо підшипник зчеплення для плавного перемикання.'],
                ['slug' => 'clutch-master', 'name' => 'Заміна головного циліндра зчеплення', 'price' => 1450, 'description' => 'Заміна головного циліндра та перевірка гідравліки.'],
                ['slug' => 'clutch-slave', 'name' => 'Заміна робочого циліндра зчеплення', 'price' => 1380, 'description' => 'Оновлення робочого циліндра зчеплення.'],
                ['slug' => 'clutch-fluid', 'name' => 'Гідропривід зчеплення заміна рідини', 'price' => 560, 'description' => 'Заміна рідини у гідроприводі зчеплення.'],
                ['slug' => 'clutch-fork', 'name' => 'Заміна вилки зчеплення', 'price' => 980, 'description' => 'Заміна вилки зчеплення та регулювання.'],
            ],
        ],
        [
            'slug' => 'suspension',
            'title' => 'Ходова частина',
            'description' => 'Послуги з підвіскою, амортизаторами та іншими елементами ходової частини.',
            'services' => [
                ['slug' => 'stabilizer-link', 'name' => 'Заміна стійки стабілізатора', 'price' => 820, 'description' => 'Оновлення стабілізаторів для стабільності керування.'],
                ['slug' => 'stabilizer-bushings', 'name' => 'Заміна втулок стабілізатора', 'price' => 540, 'description' => 'Заміну втулок стабілізатора для зниження шуму.'],
                ['slug' => 'ball-joint', 'name' => 'Заміна шарової опори', 'price' => 1020, 'description' => 'Заміна шарової опори для точності руху.'],
                ['slug' => 'spring-replacement', 'name' => 'Заміна пружин', 'price' => 1450, 'description' => 'Оновлення пружин підвіски для комфортної їзди.'],
                ['slug' => 'shock-absorber', 'name' => 'Заміна амортизаторів', 'price' => 1980, 'description' => 'Заміна амортизаторів на якісніші моделі.'],
                ['slug' => 'control-arm', 'name' => 'Заміна ричага', 'price' => 1150, 'description' => 'Оновлення ричагів для стабільної геометрії коліс.'],
                ['slug' => 'wheel-bearing', 'name' => 'Заміна ступіци', 'price' => 1420, 'description' => 'Заміна ступиці з перевіркою підшипника.'],
                ['slug' => 'strut-mount', 'name' => 'Заміна опори передньої стійки', 'price' => 930, 'description' => 'Заміну опори для зниження вібрацій.'],
            ],
        ],
        [
            'slug' => 'air-conditioning',
            'title' => 'Система кондиціонування',
            'description' => 'Роботи з кондиціюванням та кліматичними системами авто.',
            'services' => [
                ['slug' => 'cabin-filter', 'name' => 'Заміна салонного фільтра', 'price' => 390, 'description' => 'Встановлення нового фільтру салону для чистого повітря.'],
                ['slug' => 'ac-recharge', 'name' => 'Заправка автокондиціонерів', 'price' => 1250, 'description' => 'Заправка фреону та перевірка тиску у системі.'],
                ['slug' => 'ac-valve', 'name' => 'Заміна заправного вентиля', 'price' => 720, 'description' => 'Оновлення вентиля системи кондиціонування.'],
                ['slug' => 'heater-core', 'name' => 'Заміна радіатора пічки', 'price' => 1680, 'description' => 'Заміну радіатора печі для кращого опалення салону.'],
            ],
        ],
        [
            'slug' => 'exhaust',
            'title' => 'Вихлопна система',
            'description' => 'Ремонт та діагностика вузлів вихлопу.',
            'services' => [
                ['slug' => 'exhaust-diagnostics', 'name' => 'Діагностика вихлопної системи', 'price' => 620, 'description' => 'Перевірка стану глушника та петель.'],
                ['slug' => 'lambda-sensor-replacement', 'name' => 'Заміна датчика лямбда зонд', 'price' => 850, 'description' => 'Заміна датчика для контролю викидів.'],
                ['slug' => 'catalyst-replacement', 'name' => 'Заміна каталізатора', 'price' => 4200, 'description' => 'Заміну каталізатора на новий елемент.'],
                ['slug' => 'exhaust-gasket', 'name' => 'Заміна прокладки вихлопної системи', 'price' => 690, 'description' => 'Заміна прокладки для усунення витоків.'],
                ['slug' => 'muffler-replacement', 'name' => 'Заміна глушника', 'price' => 1580, 'description' => 'Заміну глушника з встановленням нової труби.'],
            ],
        ],
        [
            'slug' => 'cooling',
            'title' => 'Система охолодження',
            'description' => 'Охолоджуюча система двигуна та її компоненти.',
            'services' => [
                ['slug' => 'coolant-replacement', 'name' => 'Заміна охолоджуючої рідини', 'price' => 650, 'description' => 'Заміну антифризу з промиванням системи.'],
                ['slug' => 'thermostat-replacement', 'name' => 'Заміна термостата', 'price' => 860, 'description' => 'Заміна термостата для стабільного прогріву.'],
                ['slug' => 'radiator-replacement', 'name' => 'Заміна радіатора охолодження', 'price' => 2280, 'description' => 'Заміна радіатора та перевірка герметичності.'],
                ['slug' => 'expansion-tank', 'name' => 'Заміна розширювального бачка', 'price' => 740, 'description' => 'Оновлення бачка системи охолодження.'],
                ['slug' => 'coolant-hose', 'name' => 'Заміна патрубка системи охолодження', 'price' => 520, 'description' => 'Заміна шланга для безперебійної циркуляції охолоджуючої рідини.'],
                ['slug' => 'radiator-fan', 'name' => 'Заміна вентилятора радіатора охолодження', 'price' => 930, 'description' => 'Заміну вентилятора для стабільного охолодження.'],
                ['slug' => 'water-pump', 'name' => 'Заміна насоса системи охолодження', 'price' => 1580, 'description' => 'Заміна помпи охолоджуючої системи.'],
            ],
        ],
        [
            'slug' => 'fuel',
            'title' => 'Паливна система',
            'description' => 'Паливні системи та їх діагностика.',
            'services' => [
                ['slug' => 'fuel-filter', 'name' => 'Заміна паливного фільтра', 'price' => 520, 'description' => 'Заміна фільтра для очищення палива.'],
                ['slug' => 'fuel-system-clean', 'name' => 'Чистка паливної системи', 'price' => 980, 'description' => 'Очищення форсунок та магістралей.'],
                ['slug' => 'fuel-system-diagnostics', 'name' => 'Діагностика паливної системи', 'price' => 720, 'description' => 'Комплексна перевірка роботи паливної системи.'],
            ],
        ],
    ];

    $selectedCategory = null;
    $selectedService = null;

    if ($request->query('category')) {
        $selectedCategory = collect($categories)->firstWhere('slug', $request->query('category'));
    }

    if ($request->query('service')) {
        foreach ($categories as $category) {
            foreach ($category['services'] as $service) {
                if ($service['slug'] === $request->query('service')) {
                    $selectedService = $service;
                    $selectedCategory = $category;
                    break 2;
                }
            }
        }
    }

    return view('services', compact('categories', 'selectedCategory', 'selectedService'));
})->name('services');

Route::get('/contacts', function () {
    return view('contacts');
})->name('contacts');



Route::get('/appointments/create/{service}', [App\Http\Controllers\AppointmentController::class, 'create'])->name('appointments.create');
Route::post('/appointments', [App\Http\Controllers\AppointmentController::class, 'store'])->name('appointments.store');
Route::get('/appointments', [App\Http\Controllers\AppointmentController::class, 'index'])->name('appointments.index');
Route::get('/appointments/{appointment}', [App\Http\Controllers\AppointmentController::class, 'show'])->name('appointments.show');
Route::post('/appointments/{appointment}/cancel', [App\Http\Controllers\AppointmentController::class, 'cancel'])->name('appointments.cancel');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('orders', App\Http\Controllers\OrderController::class, ['only' => ['index', 'show']]);
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::resource('posts', App\Http\Controllers\PostController::class);
    Route::resource('categories', App\Http\Controllers\CategoryController::class, ['only' => ['index', 'show']]);
    Route::resource('users', App\Http\Controllers\UserController::class, ['only' => ['show', 'edit', 'update']]);
});

require __DIR__ . '/admin.php';
