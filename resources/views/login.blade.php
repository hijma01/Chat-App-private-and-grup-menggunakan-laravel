<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="card">

        <h2>Masuk</h2>

        @if(session('error'))
            <div class="alert">{{ session('error') }}</div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <div class="field">
                <label>Nama</label>
                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama lengkap" required>
            </div>

            <div class="field">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" required>
            </div>

            <div class="field">
                <label>Kata Sandi</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn">Masuk</button>

        </form>

        <p class="link">Belum punya akun? <a href="/daftar">Daftar</a></p>

    </div>

</body>
</html>