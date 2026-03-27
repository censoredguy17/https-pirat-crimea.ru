import './common.js'
import Sortable from 'sortablejs';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
window.ClassicEditor = ClassicEditor; // чтобы использовать глобально


function showMessage(message) {

    const modalElement = document.getElementById('messageModal');
    const modalText = document.getElementById('modalMessage');

    modalText.textContent = message;

    const modal = new bootstrap.Modal(modalElement);
    modal.show();
}

document.addEventListener('DOMContentLoaded', () => {
    // Выбираем все textarea с классом "ckeditor"
    const editors = document.querySelectorAll('textarea.ckeditor');

    editors.forEach((el) => {
        ClassicEditor
            .create(el)
            .then(editor => {
                // Правильная установка высоты
                editor.ui.view.editable.element.style.minHeight = '200px';
            })
            .catch(error => console.error(error));
    });
});

document.querySelectorAll('.image-update-form').forEach(form => {

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(form);
        const url = form.action;
        const dataType = form.getAttribute('data-type');

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if(dataType == 'setMain'){
                    document.querySelectorAll('.image-update-form button').forEach(btn => {
                        btn.removeAttribute('disabled');
                    });
                    form.querySelector('button').disabled = true;
                }
                if(dataType == 'delete'){
                    form.closest('.image-item').remove();
                }
                showMessage(data.message);
            })
            .catch(err => console.error(err));

    });

});

document.addEventListener('DOMContentLoaded', () => {

    const gallery = document.getElementById('gallery');
    const type = document.querySelector('input[name="type_sort_images"]');
    let url_fetch = '';
    if (type && type.value === 'slider') {
        url_fetch = '/admin/sliders/images/sort';
    }else if (type && type.value === 'content') {
        url_fetch = '/admin/images/sort';
    }
    if (!gallery) return;

    new Sortable(gallery, {
        animation: 150,
        draggable: '.image-item', // тянутся только карточки
        onEnd: function (evt) {
            const ids = Array.from(gallery.querySelectorAll('.image-item')).map(el => el.dataset.id);

            fetch(url_fetch, { // или используй blade route
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ ids: ids })
            });
        }
    });

});


//Videos
document.addEventListener('DOMContentLoaded', function () {
    const videoManager = document.getElementById('video-manager');
    if (!videoManager) return;

    const listWrapper = document.getElementById('video-list-wrapper');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Функция парсинга (YouTube / Rutube / Iframe)
    function parseVideoUrl(input) {
        let url = input.trim();
        const iframeMatch = url.match(/src=["']([^"']+)["']/);
        if (iframeMatch) url = iframeMatch[1];

        if (url.includes('youtube.com') || url.includes('youtu.be')) {
            let id = url.includes('v=') ? url.split('v=')[1].split('&')[0] :
                url.includes('youtu.be/') ? url.split('youtu.be/')[1].split('?')[0] :
                    url.includes('embed/') ? url.split('embed/')[1].split('?')[0] : '';
            return id ? `https://www.youtube.com/embed/${id}` : url;
        }

        if (url.includes('rutube.ru')) {
            const match = url.match(/(?:video|play\/embed)\/([a-zA-Z0-9]+)/);
            return match ? `https://rutube.ru/play/embed/${match[1]}` : url;
        }
        return url;
    }

    // --- ОБНОВЛЕНИЕ ---
    videoManager.addEventListener('click', async function (e) {
        const card = e.target.closest('.video-item-card');
        if (!card) return;

        if (e.target.closest('.btn-update-video')) {
            const btn = e.target.closest('.btn-update-video');

            // Собираем ВСЕ поля, включая iframe
            const payload = {
                title: card.querySelector('.video-edit-title').value,
                iframe: parseVideoUrl(card.querySelector('.video-edit-iframe').value), // перепарсим на случай ручного ввода
                sort_order: card.querySelector('.video-edit-order').value,
                is_published: card.querySelector('.video-edit-active').checked ? 1 : 0
            };

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i>';

            try {
                const response = await fetch(card.dataset.updateUrl, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                if (response.ok) {
                    // Обновляем плеер и визуальный статус
                    card.querySelector('iframe').src = payload.iframe;
                    card.querySelector('.video-edit-iframe').value = payload.iframe;
                    card.firstElementChild.style.opacity = payload.is_published ? '1' : '0.6';
                    payload.is_published ? card.firstElementChild.classList.remove('border-danger') : card.firstElementChild.classList.add('border-danger');

                    alert('Данные обновлены!');
                }
            } catch (err) { alert('Ошибка связи с сервером'); }
            finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-save me-1"></i> Сохранить изменения';
            }
        }

        // --- УДАЛЕНИЕ ---
        if (e.target.closest('.btn-delete-video')) {
            if (!confirm('Удалить видео?')) return;
            const res = await fetch(card.dataset.deleteUrl, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            if (res.ok) card.remove();
        }
    });

    // --- ДОБАВЛЕНИЕ НОВОГО ---
    document.getElementById('btn-add-video')?.addEventListener('click', async function () {
        const titleInput = document.getElementById('new_video_title');
        const rawInput = document.getElementById('new_video_raw');
        const cleanUrl = parseVideoUrl(rawInput.value);

        if (!cleanUrl) return alert('Введите ссылку!');

        const data = {
            content_id: videoManager.dataset.contentId,
            title: titleInput.value,
            iframe: cleanUrl,
            is_published: 1,
            sort_order: 0
        };

        const res = await fetch(videoManager.dataset.storeUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify(data)
        });

        if (res.ok) {
            const result = await res.json();
            listWrapper.insertAdjacentHTML('beforeend', result.html);
            titleInput.value = ''; rawInput.value = '';
        }
    });
});
