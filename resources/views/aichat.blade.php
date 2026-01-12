@extends('layouts.app')

@section('title','AI Chatbot')

@section('content')
<div class="max-w-5xl mx-auto">

    <!-- Chat Container -->
    <div class="h-[80vh] flex flex-col rounded-3xl overflow-hidden
                bg-white dark:bg-gray-900 shadow-2xl">

        <!-- Chat Header -->
        <div class="flex items-center gap-4 px-6 py-4
                    bg-gradient-to-r from-indigo-500 to-green-500 text-white">
            <div
                class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center text-xl shadow">
                🤖
            </div>
            <div>
                <h2 class="font-semibold text-lg">RAK AI Bot</h2>
                <p class="text-sm text-green-200">● Online</p>
            </div>
        </div>

        <!-- Messages -->
        <div id="messages"
             class="flex-1 overflow-y-auto p-6 space-y-4
                    bg-gray-100 dark:bg-gray-800">

            <!-- Bot welcome -->
            <div class="max-w-[75%] bg-white dark:bg-gray-700
                        p-4 rounded-2xl shadow">
                👋 Hello! How can I help you today?
            </div>
        </div>

        <!-- Input -->
        <div
            class="p-4 bg-white dark:bg-gray-900 border-t dark:border-gray-700">
            <div class="flex gap-3 items-center">

                <input id="messageInput"
                       placeholder="Type your message..."
                       class="flex-1 px-5 py-3 rounded-full
                              bg-gray-100 dark:bg-gray-800
                              border border-gray-300 dark:border-gray-600
                              focus:outline-none focus:ring-2
                              focus:ring-indigo-500 transition"
                       onkeydown="if(event.key==='Enter') sendMessage()">

                <button onclick="sendMessage()"
                        class="w-12 h-12 rounded-full
                               bg-gradient-to-r from-indigo-500 to-green-500
                               text-white text-xl flex items-center justify-center
                               hover:scale-110 transition shadow-lg">
                    ➤
                </button>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
async function sendMessage() {
    const input = document.getElementById('messageInput');
    const text = input.value.trim();
    if (!text) return;

    const messages = document.getElementById('messages');

    /* User message */
    const userMsg = document.createElement('div');
    userMsg.className =
        "max-w-[75%] ml-auto bg-gradient-to-r from-indigo-500 to-green-500 text-white p-4 rounded-2xl shadow";
    userMsg.innerText = text;
    messages.appendChild(userMsg);
    input.value = '';
    messages.scrollTop = messages.scrollHeight;

    /* Typing indicator */
    const typing = document.createElement('div');
    typing.className = "text-sm text-gray-500 dark:text-gray-400";
    typing.innerText = "RAK AI is typing...";
    messages.appendChild(typing);
    messages.scrollTop = messages.scrollHeight;

    try {
        const res = await fetch('/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ message: text })
        });

        const data = await res.json();
        typing.remove();

        /* Bot message */
        const botMsg = document.createElement('div');
        botMsg.className =
            "max-w-[75%] bg-white dark:bg-gray-700 p-4 rounded-2xl shadow";
        botMsg.innerText = data.reply ?? 'No response from AI';
        messages.appendChild(botMsg);
        messages.scrollTop = messages.scrollHeight;

    } catch (e) {
        typing.innerText = 'Server error';
    }
}
</script>
@endpush
