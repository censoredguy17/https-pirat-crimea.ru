@extends('layouts.app')

@section('content')

    @include('layouts.slider')

    <section class="pirate-manifest-section">
        <div class="container">
            <div class="pirate-manifest-paper shadow-lg">
                <div class="manifest-divider top">
                    <i class="fas fa-scroll"></i>
                </div>

                <div class="manifest-content manifest-collapse-wrapper">
                    <h2 class="manifest-title">Кодекс Черного Моря</h2>

                    <p class="manifest-text">
                        <span class="first-letter">П</span>риветствуем тебя, путник, на берегах вольной Тавриды!
                        Здесь, где соленый бриз встречается с ароматом горных трав, начинается настоящая легенда.
                        Мы — не просто проводники, мы хранители морских традиций и тайн крымского побережья.
                    </p>

                    <p class="manifest-text italic">
                        «Тот, кто не боится шторма, обретет сокровища, сокрытые в лазурных бухтах Феодосии и скалах Кара-Дага...»
                    </p>

                    <div class="manifest-signature">
                        <p>Подписано морской солью,</p>
                        <img src="https://www.transparenttextures.com/patterns/p6.png" class="seal-placeholder" alt="">
                        <span class="captain-name">Капитан Крымских Вод</span>
                    </div>
                </div>

                <div class="manifest-divider bottom">
                    <i class="fas fa-anchor"></i>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.advertisementList')

    @include('layouts.servicesList')

    @include('layouts.mapBlock')

    @include('layouts.spiderJs')

@endsection
