@extends('layouts.app')

@section('title','AI Chatbot')

@section('content')
<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fadeIn 0.3s ease-out;
}
</style>

<div class="max-w-5xl mx-auto">
    <div class="h-[80vh] flex flex-col rounded-3xl overflow-hidden bg-white dark:bg-gray-900 shadow-2xl">

        <!-- Header -->
        <div class="flex items-center gap-4 px-6 py-4 bg-gradient-to-r from-indigo-500 to-green-500 text-white">
            <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center text-xl">🤖</div>
            <div>
                <h2 class="font-semibold text-lg">New Generation AI Bot</h2>
                <p class="text-sm text-green-200">● Online</p>
            </div>
        </div>

        <!-- Messages -->
        <div id="messages" class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-100 dark:bg-gray-800">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-full bg-indigo-500 text-white flex items-center justify-center">🤖</div>
                <div class="bg-white dark:bg-gray-700 p-4 rounded-2xl shadow max-w-[75%]">
                    👋 Hello! How can I help you today?
                </div>
            </div>
        </div>

        <!-- Input -->
        <div class="p-4 bg-white dark:bg-gray-900 border-t dark:border-gray-700">
            <div class="flex gap-3 items-center">
                <input id="messageInput"
                       placeholder="Type your message..."
                       class="flex-1 px-5 py-3 rounded-full bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                       onkeydown="if(event.key==='Enter') sendMessage()">

                <button onclick="sendMessage()"
                        class="w-12 h-12 rounded-full bg-gradient-to-r from-indigo-500 to-green-500 text-white text-xl flex items-center justify-center hover:scale-110 transition shadow-lg">
                    ➤
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
/* ===============================
   CHAT HISTORY
================================ */
const chatHistory = [
    { role: 'model', parts: [{ text: "Hello! How can I help you today?" }] }
];

/* ===============================
   HELPERS
================================ */
function escapeHtml(text) {
    return text.replace(/[&<>"']/g, m => ({
        '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'
    }[m]));
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert("✅ Code copied!");
    });
}

/* ===============================
   SEND MESSAGE
================================ */
async function sendMessage() {
    const input = document.getElementById('messageInput');
    const text = input.value.trim();
    if (!text) return;

    const messages = document.getElementById('messages');

    /* User bubble */
    messages.insertAdjacentHTML('beforeend', `
        <div class="flex justify-end animate-fade-in">
            <div class="bg-gradient-to-r from-indigo-500 to-green-500 text-white p-4 rounded-2xl shadow max-w-[75%]">
                ${escapeHtml(text)}
            </div>
        </div>
    `);

    input.value = '';
    messages.scrollTop = messages.scrollHeight;

    chatHistory.push({ role: 'user', parts: [{ text }] });

    /* Loading */
    const loading = document.createElement('div');
    loading.innerHTML = `
        <div class="flex items-center gap-3 text-sm text-gray-500">
            <span class="animate-bounce">●</span>
            <span class="animate-bounce delay-150">●</span>
            <span class="animate-bounce delay-300">●</span>
            <span>AI is thinking...</span>
        </div>
    `;
    messages.appendChild(loading);
    messages.scrollTop = messages.scrollHeight;

    try {
        const res = await fetch('/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ message: text, history: chatHistory })
        });

        loading.remove();
        const data = await res.json();
        renderBotMessage(data.reply || 'No response.');

        chatHistory.push({
            role: 'model',
            parts: [{ text: data.reply }]
        });

    } catch {
        loading.remove();
        renderBotMessage("❌ Server error. Please try again.");
    }

    messages.scrollTop = messages.scrollHeight;
}

/* ===============================
   RENDER BOT MESSAGE (WITH CODE)
================================ */
function renderBotMessage(text) {
    const messages = document.getElementById('messages');

    const codeRegex = /```([\s\S]*?)```/g;
    let html = escapeHtml(text).replace(codeRegex, (match, code) => {
        const clean = escapeHtml(code.trim());
        return `
        <div class="relative group my-2">
            <pre class="bg-gray-900 text-green-300 text-sm p-4 rounded-lg overflow-x-auto"><code>${clean}</code></pre>
            <button onclick="copyToClipboard(\`${clean}\`)"
                class="absolute top-2 right-2 bg-indigo-500 text-white px-2 py-1 text-xs rounded opacity-0 group-hover:opacity-100 transition">
                Copy
            </button>
        </div>`;
    });

    messages.insertAdjacentHTML('beforeend', `
        <div class="flex items-start gap-3 animate-fade-in">
            <div class="w-10 h-10 rounded-full bg-indigo-500 text-white flex items-center justify-center">🤖</div>
            <div class="bg-white dark:bg-gray-700 p-4 rounded-2xl shadow max-w-[75%]">${html}</div>
        </div>
    `);
}
</script>
@endpush
