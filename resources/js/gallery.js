import PhotoSwipeLightbox from 'photoswipe/lightbox';
import PhotoSwipe from 'photoswipe';
import 'photoswipe/style.css';

const lightbox = new PhotoSwipeLightbox({
    gallery: '#pirate-gallery', // ID общего контейнера
    children: 'a',              // Все ссылки внутри станут слайдами
    pswpModule: PhotoSwipe,     // Передаем модуль напрямую для стабильности

    // Настройка анимации и управления
    showHideAnimationType: 'zoom',
    secondaryZoomLevel: 2,
    maxZoomLevel: 4,
});

// ФУНКЦИЯ ДЛЯ ПОДПИСИ (Только внутри просмотрщика)
lightbox.on('uiRegister', function() {
    lightbox.pswp.ui.registerElement({
        name: 'custom-caption',
        order: 9,
        isSettable: true,
        tagName: 'div',
        append: 'wrapper', // Добавляем в обертку просмотрщика
        onInit: (el, pswp) => {
            pswp.on('change', () => {
                const currSlideElement = pswp.currSlide.data.element;
                if (currSlideElement) {
                    // Берем текст из ALT картинки
                    const altText = currSlideElement.querySelector('img').getAttribute('alt');
                    el.innerHTML = altText ? `<div class="pswp-pirate-caption">${altText}</div>` : '';
                }
            });
        }
    });
});

lightbox.init();
