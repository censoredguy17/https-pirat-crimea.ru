<div class="login-container" style="max-width: 400px; margin: 100px auto; text-align: center; font-family: serif;">
    <h2 style="color: #8b4513;">Вход в Логово Капитана</h2>

    <form action="{{ url('/admin/login') }}" method="POST" style="background: #f4e4bc; padding: 30px; border: 2px solid #8b4513; border-radius: 10px;">
        @csrf
        <div style="margin-bottom: 20px;">
            <label>Тайный пароль:</label><br>
            <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #8b4513;">
        </div>

        @if($errors->has('password'))
            <p style="color: red;">{{ $errors->first('password') }}</p>
        @endif

        <button type="submit" style="background: #8b4513; color: white; padding: 10px 20px; border: none; cursor: pointer;">
            Поднять паруса
        </button>
    </form>
</div>
