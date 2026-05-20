<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="auth-id" content="{{ auth()->id() }}">

    <title>Dashboard Chat</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>

<div class="container">

   
    <div class="sidebar">
    <a href="/group/create">
    <button class="tombol" style="width:100%; margin-bottom:20px;">
        + Buat Grup
    </button>
        </a>
        <div class="sidebar-header">

            <div class="search-box">
                <input type="text" placeholder="Cari chat">
            </div>

        </div>

        
        <div class="chat-list">

            @foreach ($users as $user)

            <div class="chat-item"
                 onclick="openChat(this, {{ $user->id }}, '{{ $user->name }}', 'Online')">

                <div class="chat-info">
                    <h4>{{ $user->name }}</h4>
                    <p>Mulai chat...</p>
                </div>

            </div>

            @endforeach

     @foreach ($groups as $group)

    <div class="chat-item"
         onclick="window.location='/chat/{{ $group->id }}'">

        <div class="chat-info">

            <h4>{{ $group->name }}</h4>

            <p>Grup Chat</p>

        </div>

    </div>
                
     @endforeach

        </div>

    </div>
   
    <div class="chat-area">

        
        <div class="chat-header">

            <div>
                <h4>Pilih chat</h4>
                <small></small>
            </div>

        </div>

    
        <div class="chat-body">

        </div>


        <div class="chat-footer">

            <form id="chatForm" onsubmit="event.preventDefault(); sendMessage();">

                <input
                    type="text"
                    id="messageInput"
                    placeholder="Ketik pesan..."
                    autocomplete="off"
                >

                <button type="submit">
                    Kirim
                </button>

            </form>

        </div>

    </div>

</div>

<script src="{{ asset('js/style.js') }}"></script>

</body>
</html>