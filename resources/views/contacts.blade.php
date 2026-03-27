@extends('layouts.app')

@section('content')

    <div class="container pb-5">

        @include('layouts.breadcrumbs')

        <h1 class="pirate-h1">Связь с Капитанским Мостиком</h1>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="contact-card text-center">
                    <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                    <h3>Громкая связь</h3>
                    <a href="tel:+79787432661" class="contact-link">+7 (978) 743-26-61</a> - Крымский пират<br>
                    <small class="text-muted">Принимаем сигналы круглосуточно</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="contact-card text-center">
                    <div class="contact-icon"><i class="fas fa-envelope-open-text"></i></div>
                    <h3>Бутылочная почта</h3>
                    <a href="mailto:reklama2crim@mail.ru" class="contact-link">reklama2crim@mail.ru</a><br>
                    <small class="text-muted">Ответ прилетит с попутным ветром</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="contact-card text-center">
                    <div class="contact-icon"><i class="fas fa-map-marked-alt"></i></div>
                    <h3>Координаты бухты</h3>
                    <p class="contact-link m-0">Крым, г. Феодосия, пос. Орджоникидзе ул. Садовая, д. 28</p>
                    <small class="text-muted">Ориентир: Золотые Ворота</small>
                </div>
            </div>
        </div>


        <div class="social-shout">
            <h2 class="pirate-h1" style="font-size: 2.5rem;">Наши вести в сетях</h2>
            <a href="https://vk.com/news_ordjo" target="_blank" class="social-btn"><i class="fab fa-vk"></i></a>
            <a href="https://t.me/+79787432661" class="social-btn" target="_blank">
                <i class="fab fa-telegram-plane"></i>
            </a>
            <a href="https://wa.me/79787432661" class="social-btn" target="_blank">
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
    </div>

    @include('layouts.mapBlock')

    <section class="reviews-section py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="pirate-font text-white">Вести из Таверны</h2>
                <p class="gold-text">Честные истории наших гостей</p>
            </div>

            <div class="d-flex justify-content-center">
                <div class="map-frame" style="width: 100%; max-width: 760px; border: 5px solid #8b4513; box-shadow: 0 10px 30px rgba(0,0,0,0.5); border-radius: 15px; background: #fff; position: relative;">

                    <iframe
                        style="width:100%; height:800px; border:0; margin:0; display:block;"
                        src="https://yandex.ru/maps-reviews-widget/129204531633?comments">
                    </iframe>

                    <div style="box-sizing:border-box; background: #fff; padding: 10px 0; border-top: 1px solid #f0f0f0;">
                        <a href="https://yandex.ru/maps/org/dom_pirata/129204531633/"
                           target="_blank"
                           style="text-decoration:none; color:#b3b3b3; font-size:12px; font-family:YS Text,sans-serif; display:block; text-align:center;">
                            Дом Пирата на Яндекс Картах
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="https://yandex.ru/maps/org/dom_pirata/129204531633/reviews/"
                   target="_blank"
                   class="btn pirate-btn-sm">
                    Читать все отзывы на Яндексе
                </a>
            </div>
        </div>
    </section>

@endsection
