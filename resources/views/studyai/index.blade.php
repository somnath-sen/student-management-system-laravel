@extends(auth()->user()->role_id == 2 ? 'layouts.teacher' : 'layouts.student')

@section('title', 'StudyAI Assistant')

@section('content')

<style>
    /* Custom Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .message-enter {
        animation: fadeIn 0.3s ease-out forwards;
    }

    .typing-dot {
        width: 6px;
        height: 6px;
        background-color: #6b7280;
        border-radius: 50%;
        display: inline-block;
        animation: pulse 1.4s infinite ease-in-out both;
    }

    .typing-dot:nth-child(1) { animation-delay: -0.32s; }
    .typing-dot:nth-child(2) { animation-delay: -0.16s; }

    /* Hide scrollbar for cleaner look */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<div class="h-[calc(100vh-100px)] flex flex-col max-w-5xl mx-auto bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
    
    <div class="bg-white border-b px-6 py-4 flex items-center justify-between z-10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white shadow-md">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
            </div>
            <div>
                <h1 class="font-bold text-lg text-gray-800">StudyAI Assistant</h1>
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                    <span class="text-xs text-gray-500 font-medium">Online & Ready</span>
                </div>
            </div>
        </div>
        <button onclick="clearChat()" class="text-xs text-gray-400 hover:text-red-500 transition-colors">Clear History</button>
    </div>

    <div id="chat-container" class="flex-1 overflow-y-auto p-6 space-y-6 bg-gray-50 scroll-smooth">
        
        @if($messages->isEmpty())
        <div class="text-center py-10 opacity-60">
            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">👋</div>
            <h3 class="text-gray-900 font-semibold">Welcome to StudyAI!</h3>
            <p class="text-gray-500 text-sm mt-1">Ask me about homework, complex topics, or study plans.</p>
        </div>
        @endif

        @foreach($messages as $chat)
            <div class="flex justify-end message-enter">
                <div class="max-w-[85%]">
                    <div class="bg-blue-600 text-white px-5 py-3 rounded-2xl rounded-tr-none shadow-md text-sm leading-relaxed">
                        {{ $chat->message }}
                    </div>
                    <div class="text-[10px] text-gray-400 text-right mt-1 mr-1">You</div>
                </div>
            </div>

            <div class="flex justify-start message-enter">
                <div class="max-w-[85%]">
                    <div class="bg-white border border-gray-200 text-gray-800 px-5 py-3 rounded-2xl rounded-tl-none shadow-sm text-sm leading-relaxed prose-sm">
                        {!! \Illuminate\Support\Str::markdown($chat->response) !!}
                    </div>
                    <div class="text-[10px] text-gray-400 mt-1 ml-1">StudyAI</div>
                </div>
            </div>
        @endforeach

        <div id="typing-indicator" class="hidden flex justify-start message-enter">
            <div class="bg-white border border-gray-200 px-4 py-3 rounded-2xl rounded-tl-none shadow-sm">
                <div class="flex gap-1">
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                </div>
            </div>
        </div>
        
        <div id="scroll-anchor"></div>
    </div>

    <div class="p-4 bg-white border-t">
        <form id="chat-form" class="relative flex items-end gap-2">
            <textarea 
                id="user-input"
                name="message" 
                rows="1"
                class="w-full bg-gray-100 border-0 rounded-xl px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all resize-none max-h-32 no-scrollbar"
                placeholder="Type your question here..."
                required></textarea>
            
            <button type="submit" id="send-btn" class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-xl transition-all shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed flex-shrink-0 mb-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            </button>
        </form>
        <p class="text-center text-[10px] text-gray-400 mt-2">AI can make mistakes. Verify important information.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<script>
    const chatContainer = document.getElementById('chat-container');
    const scrollAnchor = document.getElementById('scroll-anchor');
    const form = document.getElementById('chat-form');
    const input = document.getElementById('user-input');
    const sendBtn = document.getElementById('send-btn');
    const typingIndicator = document.getElementById('typing-indicator');

    // Auto-resize textarea
    input.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
        if(this.value === '') this.style.height = 'auto';
    });

    // Handle Enter key (Submit) vs Shift+Enter (New Line)
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            form.dispatchEvent(new Event('submit'));
        }
    });

    // Scroll to bottom on load
    scrollAnchor.scrollIntoView();

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const message = input.value.trim();
        if (!message) return;

        // 1. UI Updates immediately
        input.value = '';
        input.style.height = 'auto';
        input.disabled = true;
        sendBtn.disabled = true;

        // Append User Message
        appendMessage('user', message);
        
        // Show Typing Indicator
        typingIndicator.classList.remove('hidden');
        scrollAnchor.scrollIntoView({ behavior: 'smooth' });

        try {
            // 2. Fetch API
            const response = await fetch("{{ route('studyai.send') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();

            // 3. Handle Response
            typingIndicator.classList.add('hidden');
            
            if (response.ok) {
                appendMessage('ai', data.response);
            } else {
                appendMessage('error', data.error || 'Something went wrong.');
            }

        } catch (error) {
            typingIndicator.classList.add('hidden');
            appendMessage('error', 'Network error. Please check your connection.');
        } finally {
            input.disabled = false;
            sendBtn.disabled = false;
            input.focus();
            scrollAnchor.scrollIntoView({ behavior: 'smooth' });
        }
    });

    function appendMessage(sender, text) {
        const div = document.createElement('div');
        div.classList.add('flex', 'message-enter');
        
        if (sender === 'user') {
            div.classList.add('justify-end');
            div.innerHTML = `
                <div class="max-w-[85%]">
                    <div class="bg-blue-600 text-white px-5 py-3 rounded-2xl rounded-tr-none shadow-md text-sm leading-relaxed">
                        ${escapeHtml(text)}
                    </div>
                    <div class="text-[10px] text-gray-400 text-right mt-1 mr-1">Just now</div>
                </div>
            `;
        } else if (sender === 'ai') {
            div.classList.add('justify-start');
            // Parse Markdown for AI response
            const formattedText = marked.parse(text); 
            div.innerHTML = `
                <div class="max-w-[85%]">
                    <div class="bg-white border border-gray-200 text-gray-800 px-5 py-3 rounded-2xl rounded-tl-none shadow-sm text-sm leading-relaxed prose-sm">
                        ${formattedText}
                    </div>
                    <div class="text-[10px] text-gray-400 mt-1 ml-1">StudyAI</div>
                </div>
            `;
        } else {
            // Error message
            div.classList.add('justify-center');
            div.innerHTML = `
                <div class="bg-red-100 text-red-600 px-4 py-2 rounded-lg text-xs font-medium">
                    ${text}
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
        if(confirm('Clear visual chat history? (Database remains)')) {
            // This just clears the DOM for the current session visually
            const messages = document.querySelectorAll('.message-enter');
            messages.forEach(msg => {
                if(msg.id !== 'typing-indicator') msg.remove();
            });
        }
    }
</script>

@endsection