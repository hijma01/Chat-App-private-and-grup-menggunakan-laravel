const authId = parseInt(
    document.querySelector('meta[name="auth-id"]').content
);

let activeChatId = null;

function openChat(el, id, name, status)
{
    activeChatId = id;

    document.querySelectorAll('.chat-item')
        .forEach(i => i.classList.remove('active'));

    el.classList.add('active');

    document.querySelector('.chat-header h4').textContent = name;

    document.querySelector('.chat-header small').textContent = status;

    loadMessages(id);
}
function loadMessages(chatId)
{
    fetch(`/chat/${chatId}/pesan`)

    .then(response => response.json())

    .then(messages => {

        const chatBody = document.querySelector('.chat-body');

        chatBody.innerHTML = '';

        messages.forEach(msg => {

            const msgDiv = document.createElement('div');

            if(msg.user_id == authId)
            {
                msgDiv.classList.add('message', 'sent');
            }
            else
            {
                msgDiv.classList.add('message', 'received');
            }

            const time = formatTime(msg.created_at);

            msgDiv.innerHTML = `
                <p>${msg.body}</p>
                <span class="time">${time}</span>
            `;

            chatBody.appendChild(msgDiv);

        });


        chatBody.scrollTop = chatBody.scrollHeight;

    })

    .catch(error => {

        console.error('Gagal mengambil pesan:', error);

    });
}

function sendMessage()
{
    const input = document.getElementById('messageInput');

    const text = input.value.trim();

    if(!text) return;

    if(activeChatId === null)
    {
        alert('Pilih chat terlebih dahulu');
        return;
    }

    fetch(`/chat/${activeChatId}/pesan`, {

        method: 'POST',

        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN':
                document.querySelector('meta[name="csrf-token"]').content
        },

        body: JSON.stringify({
            body: text
        })

    })

    .then(response => response.json())

    .then(data => {

        const chatBody = document.querySelector('.chat-body');

        const msgDiv = document.createElement('div');

        const time = formatTime(data.created_at);

        msgDiv.classList.add('message', 'sent');

        msgDiv.innerHTML = `
            <p>${data.body}</p>
            <span class="time">${time}</span>
        `;

        chatBody.appendChild(msgDiv);

        chatBody.scrollTop = chatBody.scrollHeight;

        input.value = '';

    })

    .catch(error => {

        console.error('Error:', error);

    });
}

function formatTime(datetime)
{
    const date = new Date(datetime);

    return date.getHours().toString().padStart(2, '0')
        + ':'
        + date.getMinutes().toString().padStart(2, '0');
}