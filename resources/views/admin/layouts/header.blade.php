<header class="p-3 text-bg-dark">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li class="px-2 text-secondary"><h3>Админ панель</h3></li>
            </ul>
            @auth()
                <div class="text-end">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="button" class="btn btn-outline-light me-2">Выйти</button>
                    </form>
                </div>
            @endauth
            @guest()
                <div class="text-end">
                    <a href="{{ route('login') }}" class="nav-link link-body-emphasis px-2">
                        <button type="button" class="btn btn-outline-light me-2">Вход</button>
                    </a>
                    <a href="{{ route('register') }}" class="nav-link link-body-emphasis px-2">
                        <button type="button" class="btn btn-outline-light me-2">Регистрация</button>
                    </a>
                </div>
            @endguest

        </div>
    </div>
</header>
