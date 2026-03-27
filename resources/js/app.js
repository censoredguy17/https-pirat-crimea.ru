import './common.js'
import './gallery.js'

//Js Frontend


// Скрипт появления паука при скролле
// Ждем загрузки DOM
document.addEventListener('DOMContentLoaded', function () {
    const spider = document.getElementById('giant-spider'); // проверь, что ID совпадает с HTML
    let isSpiderReady = true; // Флаг, чтобы паук не прыгал туда-сюда постоянно

    window.addEventListener('scroll', function () {
        // Если прокрутили больше 400px и паук готов к вылазке
        if (window.scrollY > 400 && isSpiderReady) {
            isSpiderReady = false; // Блокируем повторный запуск, пока он не закончит маневр

            console.log("Паук спускается...");
            spider.classList.add('spider-show');

            // Ждем 3 секунды, пока он висит (плюс время на сам спуск 1.8с)
            setTimeout(() => {
                console.log("Паук уползает обратно!");
                spider.classList.remove('spider-show');

                // Через 10 секунд паук снова будет готов напугать пользователя,
                // если тот снова проскроллит вверх-вниз
                setTimeout(() => {
                    isSpiderReady = true;
                }, 10000);

            }, 3000);
        }
    });
});

// Добавим немного "плавного скролла" для всех ссылок
// document.querySelectorAll('a[href^="#"]').forEach(anchor => {
//     anchor.addEventListener('click', function (e) {
//         e.preventDefault();
//         document.querySelector(this.getAttribute('href')).scrollIntoView({
//             behavior: 'smooth'
//         });
//     });
// });

//map

// Сначала проверяем, есть ли блок на странице
if (document.getElementById("pirate-map")) {

    // Только если блок найден, подписываемся на событие ready
    ymaps.ready(init);

    function init() {
        var myMap = new ymaps.Map("pirate-map", {
            center: [44.970920, 35.353212],
            zoom: 15,
            controls: ['zoomControl', 'typeSelector', 'fullscreenControl']
        });

        var myPlacemark = new ymaps.Placemark([44.970920, 35.353212], {
            balloonContent: '<strong>Логово Пиратов Крыма</strong>',
            hintContent: 'Секретная точка'
        }, {
            preset: 'islands#yellowStretchyIcon',
            iconColor: '#ffcf40'
        });

        myMap.geoObjects.add(myPlacemark);
        myMap.behaviors.disable('scrollZoom');
    }
}


//Мышка
document.addEventListener('DOMContentLoaded', function () {
    const mouse = document.getElementById('global-mouse');
    let mouseRuns = 0;       // Сколько раз уже пробежала
    const maxRuns = 3;       // МАКСИМАЛЬНОЕ количество раз
    let isMouseRunning = false; // Флаг: бежит ли она прямо сейчас?

    window.addEventListener('scroll', function () {
        if (!mouse) return;

        const scrollHeight = document.documentElement.scrollHeight;
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const clientHeight = document.documentElement.clientHeight;

        // Условие: Дошли до низа (70px до края) И лимит не исчерпан И сейчас не бежит
        if (scrollTop + clientHeight >= scrollHeight - 70 && mouseRuns < maxRuns && !isMouseRunning) {

            isMouseRunning = true; // Блокируем новые запуски
            mouseRuns++;           // Увеличиваем счетчик

            console.log("Мышь пошла на круг №" + mouseRuns);
            mouse.classList.add('mouse-active');

            // Ждем завершения анимации (3.5 сек + небольшой запас)
            setTimeout(() => {
                mouse.classList.remove('mouse-active');
                isMouseRunning = false; // Разрешаем бежать снова, если лимит позволяет

                if (mouseRuns >= maxRuns) {
                    console.log("Мышь устала и ушла спать.");
                }
            }, 4000);
        }
    });
});

//раскрытие скрытие текста

document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.getElementById('manifestWrapper');
    const content = document.getElementById('manifestContent');
    const btnContainer = document.getElementById('manifestBtnContainer');
    const btn = document.getElementById('manifestToggleBtn');
    const btnText = btn?.querySelector('.btn-text');
    const btnIcon = btn?.querySelector('i');

    const maxHeight = 700;

    if (content && wrapper && content.scrollHeight > maxHeight) {
        // Показываем кнопку, если контент реально длинный
        btnContainer.classList.remove('d-none');

        btn.addEventListener('click', function () {
            const isExpanded = wrapper.classList.toggle('expanded');

            // Меняем текст и иконку
            if (isExpanded) {
                btnText.textContent = 'Скрыть манифест';
                btnIcon.classList.add('expanded-icon');
                // Опционально: скролл к началу блока при закрытии (ниже добавим логику)
            } else {
                btnText.textContent = 'Читать далее';
                btnIcon.classList.remove('expanded-icon');

                // Плавный скролл обратно к началу блока, чтобы юзер не потерялся
                wrapper.scrollIntoView({behavior: 'smooth', block: 'start'});
            }
        });
    }
});

/**
 * Универсальный скрипт раскрытия текстовых блоков
 */


document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.js-collapse-section').forEach(section => {
        const btn = section.querySelector('.js-expand-btn');
        const preview = section.querySelector('.js-preview-text');
        const full = section.querySelector('.js-full-text');
        const btnText = btn ? btn.querySelector('span') : null;
        const icon = btn ? btn.querySelector('i') : null;

        if (!btn || !preview || !full) return;

        btn.addEventListener('click', function () {
            // Проверяем, развернут ли текст сейчас
            const isExpanded = full.style.display === 'block';

            if (isExpanded) {
                // СВОРАЧИВАЕМ
                full.style.display = 'none';
                preview.style.display = 'block';

                if (btnText) btnText.textContent = 'Развернуть записи';
                if (icon) icon.style.transform = 'rotate(0deg)';

                // Плавный скролл к началу блока, чтобы пользователь не потерялся
                section.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else {
                // РАЗВОРАЧИВАЕМ
                full.style.display = 'block';
                preview.style.display = 'none';

                if (btnText) btnText.textContent = 'Свернуть записи';
                if (icon) icon.style.transform = 'rotate(180deg)';
            }
        });
    });
});

