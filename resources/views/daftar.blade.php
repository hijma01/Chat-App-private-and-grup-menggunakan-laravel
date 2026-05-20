<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<div class="card">
    <h2>Daftar Akun</h2>

    @if($errors->any())
        <div class="alert">
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/daftar">
        @csrf
        <div class="field">
            <label>Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap" required>
        </div>
        <div class="field">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" required>
        </div>
        <div class="field">
            <label>Kata Sandi</label>
            <input type="password" name="password" placeholder="Min. 8 karakter" required>
        </div>
        <button type="submit" class="btn">Daftar</button>
    </form>

    <p class="link">Sudah punya akun? <a href="/login">Masuk</a></p>
</div>
</body>
</html>