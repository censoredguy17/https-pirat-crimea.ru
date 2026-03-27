{{--<section class="map-section py-5">--}}
{{--    <div class="container">--}}
{{--        <div class="text-center mb-4">--}}
{{--            <h2 class="pirate-font text-white">Наше Логово на Карте</h2>--}}
{{--            <p class="gold-text">Ищи крестик на песках Феодосии</p>--}}
{{--        </div>--}}

{{--        <div class="map-frame">--}}
{{--            <div id="pirate-map" style="width: 100%; height: 450px;"></div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}

{{--<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>--}}


<section class="map-section py-5" id="pirate-map-section">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="pirate-font text-white">Наше Логово на Карте</h2>
            <p class="gold-text">Ищи крестик на песках Коктебеля</p>
        </div>

        <div class="map-frame" style="border: 5px solid #8b4513; border-image: url('https://path-to-your-parchment-border.png') 30; box-shadow: 0 10px 30px rgba(0,0,0,0.5); overflow: hidden; border-radius: 15px;">
            <iframe
                src="https://yandex.ru/map-widget/v1/?z=16&ol=biz&oid=129204531633"
                width="100%"
                height="450"
                frameborder="0"
                style="display: block; filter: sepia(20%) contrast(110%);">
            </iframe>
        </div>

        <div class="text-center mt-3">
            <small class="text-muted">Крым, г. Феодосия, пос. Орджоникидзе ул. Садовая, д. 28</small>
        </div>
    </div>
</section>
