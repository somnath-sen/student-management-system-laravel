@extends(auth()->user()->role_id == 2 ? 'layouts.teacher' : 'layouts.student')

@section('title', 'StudyAI Assistant')

@section('content')

<style>
    /* Custom WA Background Pattern */
    .whatsapp-bg {
        background-color: #efeae2;
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M15 0a15 15 0 1 1 0 30 15 15 0 0 1 0-30zm0 2a13 13 0 1 0 0 26 13 13 0 0 0 0-26zm0 4a9 9 0 1 1 0 18 9 9 0 0 1 0-18zm0 2a7 7 0 1 0 0 14 7 7 0 0 0 0-14zm0 2a5 5 0 1 1 0 10 5 5 0 0 1 0-10z' fill='%23000000' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
    }

    /* Message Bubbles */
    .wa-bubble-sent {
        background-color: #d9fdd3;
        color: #111b21;
        border-radius: 8px 0 8px 8px;
        box-shadow: 0 1px 0.5px rgba(11,20,26,.13);
    }
    
    .wa-bubble-received {
        background-color: #ffffff;
        color: #111b21;
        border-radius: 0 8px 8px 8px;
        box-shadow: 0 1px 0.5px rgba(11,20,26,.13);
    }

    .wa-time {
        font-size: 11px;
        color: #667781;
        float: right;
        margin-top: 5px;
        margin-left: 12px;
        line-height: 1;
    }

    .wa-tick {
        color: #53bdeb; /* Blue ticks */
        font-size: 12px;
        margin-left: 3px;
    }

    .message-enter {
        animation: fadeIn 0.3s ease-out forwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Typing Dots */
    .typing-dot {
        width: 6px;
        height: 6px;
        background-color: #8696a0;
        border-radius: 50%;
        display: inline-block;
        animation: pulse 1.4s infinite ease-in-out both;
        margin: 0 1px;
    }
    .typing-dot:nth-child(1) { animation-delay: -0.32s; }
    .typing-dot:nth-child(2) { animation-delay: -0.16s; }

    @keyframes pulse {
        0%, 100% { transform: scale(0.8); opacity: 0.5; }
        50% { transform: scale(1.2); opacity: 1; }
    }

    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<div class="h-[calc(100vh-100px)] flex flex-col max-w-5xl mx-auto bg-white shadow-2xl rounded-[16px] overflow-hidden border border-[#d1d7db]/40">
    
    <!-- WhatsApp Header -->
    <div class="bg-[#f0f2f5] px-4 py-3 flex items-center justify-between z-10 border-b border-[#d1d7db]">
        <div class="flex items-center gap-3 w-full">
            <div class="w-10 h-10 rounded-full bg-[#128C7E] flex items-center justify-center text-white shadow-sm overflow-hidden border border-black/5 shrink-0">
                <i class="fa-solid fa-robot text-xl"></i>
            </div>
            <div class="flex-1 cursor-pointer">
                <h1 class="font-semibold text-[16px] text-[#111b21] leading-tight">StudyAI</h1>
                <p class="text-[13px] text-[#667781] leading-tight">online</p>
            </div>
            <div class="flex items-center gap-5 text-[#54656f] pr-2">
                <button class="hover:bg-black/5 w-10 h-10 rounded-full transition-colors flex items-center justify-center"><i class="fa-solid fa-magnifying-glass"></i></button>
                <button onclick="clearChat()" class="hover:bg-black/5 w-10 h-10 rounded-full transition-colors flex items-center justify-center" title="Clear Chat"><i class="fa-solid fa-ellipsis-vertical"></i></button>
            </div>
        </div>
    </div>

    <!-- Chat Area -->
    <div id="chat-container" class="flex-1 overflow-y-auto px-[5%] sm:px-[8%] py-6 space-y-[6px] whatsapp-bg scroll-smooth">
        
        <!-- Encryption Notice (WA Style) -->
        <div class="flex justify-center mb-6">
            <div class="bg-[#ffeecd] text-[#54656f] text-[12.5px] px-4 py-2 rounded-[10px] shadow-sm text-center max-w-sm border border-black/5 leading-snug">
                <i class="fa-solid fa-lock text-[10px] mr-1 text-[#8696a0]"></i> Messages and queries are secured by state-of-the-art AI processing parameters. No one outside of this chat can read them.
            </div>
        </div>

        @if($messages->isEmpty())
        <!-- Blank State Day Badge -->
        <div class="flex justify-center mb-4">
            <span class="bg-white text-[#54656f] text-xs px-3 py-1.5 rounded-lg uppercase shadow-sm font-medium">Today</span>
        </div>
        @endif

        @foreach($messages as $chat)
            <!-- User Message (Sent) -->
            <div class="flex justify-end message-enter w-full">
                <div class="wa-bubble-sent px-2.5 py-1.5 max-w-[85%] relative break-words flex flex-col">
                    <span class="text-[14.5px] leading-snug px-1 pb-1 pt-0.5 text-[#111b21]">{{ $chat->message }}</span>
                    <span class="wa-time mt-[-2px] self-end">
                        {{ \Carbon\Carbon::parse($chat->created_at)->format('H:i') }}
                        <i class="fa-solid fa-check-double wa-tick"></i>
                    </span>
                </div>
            </div>

            <!-- AI Message (Received) -->
            <div class="flex justify-start message-enter w-full">
                <div class="wa-bubble-received px-2.5 py-1.5 max-w-[85%] relative break-words flex flex-col">
                    <!-- Added sender name for AI -->
                    <span class="text-[12.5px] font-semibold text-[#128C7E] px-1 pt-0.5">StudyAI</span>
                    <div class="text-[14.5px] leading-[1.4] text-[#111b21] px-1 pb-1 prose-sm prose-p:my-1 prose-a:text-[#027eb5]">
                        {!! \Illuminate\Support\Str::markdown($chat->response) !!}
                    </div>
                    <span class="wa-time mt-[-2px] self-end">
                        {{ \Carbon\Carbon::parse($chat->created_at)->format('H:i') }}
                    </span>
                </div>
            </div>
        @endforeach

        <!-- Typing Indicator -->
        <div id="typing-indicator" class="hidden flex justify-start message-enter w-full">
            <div class="wa-bubble-received px-4 py-3 shadow-sm inline-block">
                <div class="flex gap-1.5">
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                </div>
            </div>
        </div>
        
        <div id="scroll-anchor"></div>
    </div>

    <!-- WA Input Area -->
    <div class="bg-[#f0f2f5] px-3 sm:px-4 py-[10px] flex items-end gap-2 sm:gap-4 z-10 w-full">
        <button class="text-[#54656f] hover:text-[#111b21] p-2 flex-shrink-0 mb-[2px] transition-colors hidden sm:block">
            <i class="fa-regular fa-face-smile text-[24px]"></i>
        </button>
        <button class="text-[#54656f] hover:text-[#111b21] p-2 flex-shrink-0 mb-[2px] transition-colors">
            <i class="fa-solid fa-paperclip text-[22px]"></i>
        </button>
        
        <form id="chat-form" class="flex-1 relative flex items-center bg-white rounded-[10px] shadow-sm focus-within:ring-0 transition-colors">
            <textarea 
                id="user-input"
                name="message" 
                rows="1"
                class="w-full bg-transparent border-0 px-4 py-2.5 text-[15px] text-[#111b21] focus:ring-0 resize-none max-h-32 no-scrollbar outline-none placeholder-[#8696a0]"
                placeholder="Type a message"
                required></textarea>
        </form>
        
        <button id="multi-btn" class="text-[#54656f] p-2 flex-shrink-0 mb-[2px] transition-all" onclick="document.getElementById('chat-form').dispatchEvent(new Event('submit'))">
            <i id="send-icon" class="fa-solid fa-microphone text-[24px]"></i>
        </button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<script>
    const chatContainer = document.getElementById('chat-container');
    const scrollAnchor = document.getElementById('scroll-anchor');
    const form = document.getElementById('chat-form');
    const input = document.getElementById('user-input');
    const multiBtn = document.getElementById('multi-btn');
    const sendIcon = document.getElementById('send-icon');
    const typingIndicator = document.getElementById('typing-indicator');

    // Auto-resize textarea and Toggle Icons
    input.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
        if(this.value === '') this.style.height = 'auto';
        
        // Toggle Send (Paper-plane) / Mic Icon based on input
        if (this.value.trim() !== '') {
            sendIcon.classList.remove('fa-microphone');
            sendIcon.classList.add('fa-paper-plane');
            multiBtn.classList.remove('text-[#54656f]');
            multiBtn.classList.add('text-[#00a884]');
        } else {
            sendIcon.classList.remove('fa-paper-plane');
            sendIcon.classList.add('fa-microphone');
            multiBtn.classList.add('text-[#54656f]');
            multiBtn.classList.remove('text-[#00a884]');
        }
    });

    // Handle Enter key for submit (desktop WA style)
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            if(input.value.trim() !== '') {
                form.dispatchEvent(new Event('submit'));
            }
        }
    });

    // Scroll to bottom on load
    scrollAnchor.scrollIntoView();

    function formatTime() {
        const now = new Date();
        return now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const message = input.value.trim();
        if (!message) return;

        // Reset UI
        input.value = '';
        input.style.height = 'auto';
        sendIcon.classList.remove('fa-paper-plane');
        sendIcon.classList.add('fa-microphone');
        multiBtn.classList.add('text-[#54656f]');
        multiBtn.classList.remove('text-[#00a884]');
        input.disabled = true;

        // Append User Message
        appendMessage('user', message);
        
        // Show Typing Indicator
        typingIndicator.classList.remove('hidden');
        scrollAnchor.scrollIntoView({ behavior: 'smooth' });

        try {
            const response = await fetch("{{ route('studyai.send') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();

            // Handle Response
            typingIndicator.classList.add('hidden');
            
            if (response.ok) {
                appendMessage('ai', data.response);
            } else {
                appendMessage('error', data.error || 'Something went wrong.');
            }

        } catch (error) {
            typingIndicator.classList.add('hidden');
            appendMessage('error', '[Offline] Please check your internet connection.');
        } finally {
            input.disabled = false;
            input.focus();
            scrollAnchor.scrollIntoView({ behavior: 'smooth' });
        }
    });

    function appendMessage(sender, text) {
        const div = document.createElement('div');
        div.classList.add('flex', 'message-enter', 'w-full');
        const time = formatTime();
        
        if (sender === 'user') {
            div.classList.add('justify-end');
            div.innerHTML = `
                <div class="wa-bubble-sent px-2.5 py-1.5 max-w-[85%] relative break-words flex flex-col">
                    <span class="text-[14.5px] leading-snug px-1 pb-1 pt-0.5 text-[#111b21]">${escapeHtml(text)}</span>
                    <span class="wa-time mt-[-2px] self-end">
                        ${time} <i class="fa-solid fa-check-double wa-tick"></i>
                    </span>
                </div>
            `;
        } else if (sender === 'ai') {
            div.classList.add('justify-start');
            const formattedText = marked.parse(text); 
            div.innerHTML = `
                <div class="wa-bubble-received px-2.5 py-1.5 max-w-[85%] relative break-words flex flex-col">
                    <span class="text-[12.5px] font-semibold text-[#128C7E] px-1 pt-0.5">StudyAI</span>
                    <div class="text-[14.5px] leading-[1.4] text-[#111b21] px-1 pb-1 prose-sm prose-p:my-1 prose-a:text-[#027eb5]">
                        ${formattedText}
                    </div>
                    <span class="wa-time mt-[-2px] self-end">
                        ${time}
                    </span>
                </div>
            `;
        } else {
            div.classList.add('justify-center', 'my-2');
            div.innerHTML = `
                <div class="bg-[#ffeecd] text-[#54656f] text-[12.5px] px-4 py-1.5 rounded-lg shadow-sm border border-black/5 text-center">
                    <i class="fa-solid fa-circle-exclamation text-red-500 mr-1"></i> ${text}
                </div>
            `;
        }

        chatContainer.insertBefore(div, typingIndicator);
        scrollAnchor.scrollIntoView({ behavior: 'smooth' });
    }

    function escapeHtml(text) {
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function clearChat() {
        if(confirm('Clear this chat?')) {
            const messages = document.querySelectorAll('.message-enter');
            messages.forEach(msg => {
                if(msg.id !== 'typing-indicator') msg.remove();
            });
        }
    }
</script>

@endsection