<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RAK AI Chatbot</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  * { box-sizing: border-box; font-family: 'Inter', sans-serif; margin:0; padding:0; }
body {
  min-height: 100vh; /* ensures full height */
  width: 100vw;      /* full width */
  margin: 0;
  padding: 0;
  background: linear-gradient(135deg,#6366f1,#22c55e);
  display: flex;
  align-items: center;
  justify-content: center;
}

.app {
  width: 100%;
  max-width: 500px;
  height: 95vh;
  display: flex;
  flex-direction: column;
  border-radius: 25px;
  overflow: hidden;
  background: rgba(255,255,255,0.85);
  backdrop-filter: blur(20px);
  box-shadow: 0 25px 50px rgba(0,0,0,0.4);
  border: 1px solid rgba(255,255,255,0.3);
  transition: all 0.3s;

  /* Keep it centered even on very large screens */
  margin: 2vh 0; 
}


  .app {
    width: 95%;
    max-width: 500px;
    height: 95vh;
    display: flex;
    flex-direction: column;
    border-radius: 25px;
    overflow: hidden;
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(20px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.4);
    border: 1px solid rgba(255,255,255,0.3);
    transition: all 0.3s;
  }

  /* Bot Tabs */
  .bot-tabs {
    display:flex;
    overflow-x:auto;
    background: rgba(43,43,75,0.9);
    padding:12px 8px;
    gap:10px;
  }
  .bot-tabs::-webkit-scrollbar { display:none; }
  .bot-tab {
    flex: 0 0 auto;
    padding:10px 20px;
    border-radius:30px;
    color:#fff;
    font-weight:600;
    cursor:pointer;
    white-space: nowrap;
    display:flex;
    align-items:center;
    gap:8px;
    font-size:14px;
    transition: all 0.3s;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    background: rgba(255,255,255,0.05);
  }
  .bot-tab:hover { transform: scale(1.05); background: rgba(255,255,255,0.1); }
  .bot-tab.active { 
    background: linear-gradient(135deg,#6366f1,#22c55e); 
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
  }

  /* Chat Header */
  .chat-header {
    display:flex;
    align-items:center;
    gap:14px;
    padding:14px 18px;
    border-bottom:1px solid rgba(0,0,0,0.05);
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(10px);
  }
  .chat-header .avatar {
    width:50px; height:50px; border-radius:50%; 
    background: linear-gradient(135deg,#22c55e,#6366f1); 
    color:#fff; display:flex; align-items:center; justify-content:center; 
    font-weight:700; font-size:20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
  }
  .chat-header strong { font-size:17px; color:#333; }
  .chat-header .status { font-size:12px; color:#22c55e; }

  /* Messages */
  .messages {
    flex:1;
    overflow-y:auto;
    display:flex;
    flex-direction:column;
    gap:12px;
    padding:16px 18px;
    background: #eef2ff;
    scrollbar-width: thin;
    scrollbar-color: rgba(99,102,241,0.3) transparent;
  }
  .messages::-webkit-scrollbar { width:6px; }
  .messages::-webkit-scrollbar-thumb { background: rgba(99,102,241,0.3); border-radius:3px; }
  .messages::-webkit-scrollbar-track { background: transparent; }

  .message {
    max-width:80%;
    padding:14px 18px;
    border-radius:25px;
    font-size:14px;
    line-height:1.6;
    word-wrap: break-word;
    animation:fade 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
  }
  .bot { background:#fff; align-self:flex-start; }
  .user { background: linear-gradient(135deg,#6366f1,#22c55e); color:#fff; align-self:flex-end; }

  .typing {
    display:flex; gap:6px;
    font-size:13px; color:#555;
    align-self:flex-start;
    animation:fade 0.3s ease;
  }
  .dot { width:7px; height:7px; background:#555; border-radius:50%; animation: bounce 1.4s infinite; }
  .dot:nth-child(2){ animation-delay: 0.2s; }
  .dot:nth-child(3){ animation-delay: 0.4s; }
  @keyframes bounce { 0%, 80%, 100% { transform: scale(0); } 40% { transform: scale(1); } }
  @keyframes fade { from{opacity:0; transform:translateY(6px);} to{opacity:1; transform:translateY(0);} }

  /* Input Area */
  .input-area {
    display:flex;
    gap:10px;
    padding:14px 18px;
    border-top:1px solid rgba(0,0,0,0.05);
    background: rgba(255,255,255,0.8);
    backdrop-filter: blur(10px);
  }
  .input-area input {
    flex:1; padding:14px 18px; border-radius:30px; border:1px solid #c7d2fe; outline:none;
    transition: all 0.3s;
    box-shadow: inset 0 2px 6px rgba(0,0,0,0.05);
  }
  .input-area input:focus { border-color:#6366f1; box-shadow:0 0 10px rgba(99,102,241,0.3); }
  .input-area button {
    width:50px; height:50px; border-radius:50%; border:none;
    background: linear-gradient(135deg,#6366f1,#22c55e); color:#fff; cursor:pointer;
    display:flex; align-items:center; justify-content:center; font-weight:600; font-size:20px;
    transition: all 0.3s;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
  }
  .input-area button:hover { transform:scale(1.1); box-shadow:0 6px 18px rgba(0,0,0,0.3); }

  @media(max-width:400px){
    .app { height:100vh; width:100%; border-radius:0; }
    .bot-tab { font-size:12px; padding:8px 14px; }
    .chat-header strong { font-size:15px; }
    .chat-header .status { font-size:11px; }
    .message { font-size:13px; max-width:85%; padding:12px 14px; border-radius:22px; }
    .input-area input { padding:12px 14px; }
    .input-area button { width:45px; height:45px; font-size:18px; }
  }
</style>
</head>
<body>
<div class="app">
  <!-- Bot Tabs -->
  <div class="bot-tabs">
    <div class="bot-tab active" onclick="selectBot(this,'RAK AI Bot')">💬 RAK AI Bot</div>
  </div>

  <!-- Chat Header -->
  <div class="chat-header">
    <div class="avatar" id="chatAvatar">💬</div>
    <div>
      <strong id="chatTitle">RAK AI Bot</strong><br>
      <span class="status" id="chatStatus">● Online</span>
    </div>
  </div>

  <!-- Messages -->
  <div class="messages" id="messages">
    <div class="message bot">Hello 👋 How can I help you today?</div>
  </div>

  <!-- Input -->
  <div class="input-area">
    <input id="messageInput" placeholder="Ask me anything..." onkeydown="if(event.key==='Enter') sendMessage()" />
    <button onclick="sendMessage()">➤</button>
  </div>
</div>

<script>
let currentBot = { name: 'RAK AI Bot', avatar: '💬', status: 'Online' };

function selectBot(el, name) {
  currentBot.name = name;
  currentBot.avatar = el.innerText.split(' ')[0];
  currentBot.status = 'Online';

  document.getElementById('chatTitle').innerText = currentBot.name;
  document.getElementById('chatAvatar').innerText = currentBot.avatar;
  document.getElementById('chatStatus').innerText = `● ${currentBot.status}`;

  document.querySelectorAll('.bot-tab').forEach(t => t.classList.remove('active'));
  el.classList.add('active');

  document.getElementById('messages').innerHTML = `<div class="message bot">You are chatting with ${currentBot.name}.</div>`;
}

async function sendMessage() {
  const input = document.getElementById('messageInput');
  const text = input.value.trim();
  if(!text) return;

  const messages = document.getElementById('messages');

  // User message
  const userMsg = document.createElement('div');
  userMsg.className = 'message user';
  userMsg.innerText = text;
  messages.appendChild(userMsg);
  input.value='';
  messages.scrollTop=messages.scrollHeight;

  // Typing
  const typing = document.createElement('div');
  typing.className='typing';
  typing.innerHTML = `${currentBot.name} is typing <span class="dot"></span><span class="dot"></span><span class="dot"></span>`;
  messages.appendChild(typing);
  messages.scrollTop=messages.scrollHeight;

  try {
    const res = await fetch('/chat/send', {
      method:'POST',
      headers:{
        'Content-Type':'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({ message: text, bot: currentBot.name })
    });
    const data = await res.json();
    typing.remove();

    const botMsg = document.createElement('div');
    botMsg.className='message bot';
    botMsg.innerText = data.reply ?? 'No response from AI';
    messages.appendChild(botMsg);
    messages.scrollTop=messages.scrollHeight;

  } catch (err) {
    typing.remove();
    const botMsg = document.createElement('div');
    botMsg.className='message bot';
    botMsg.innerText = '❌ Server error';
    messages.appendChild(botMsg);
    messages.scrollTop=messages.scrollHeight;
  }
}
</script>
</body>
</html>
