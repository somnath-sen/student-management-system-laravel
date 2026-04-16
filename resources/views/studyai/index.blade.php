@extends(auth()->user()->role_id == 2 ? 'layouts.teacher' : 'layouts.student')

@section('title', 'StudyAI Mentor')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<style>
    body { background-color: #F8FAFC; }
    * { font-family: 'Outfit', sans-serif; }

    .chat-container {
        scrollbar-width: thin;
        scrollbar-color: #CBD5E1 transparent;
    }
    .chat-container::-webkit-scrollbar { width: 6px; }
    .chat-container::-webkit-scrollbar-track { background: transparent; }
    .chat-container::-webkit-scrollbar-thumb { background-color: #CBD5E1; border-radius: 10px; }

    /* Bubbles */
    .bubble-user {
        background-color: #0F172A;
        color: #F8FAFC;
        border-radius: 1.25rem 1.25rem 0 1.25rem;
    }
    .bubble-ai {
        background-color: #FFFFFF;
        color: #334155;
        border: 1px solid #E2E8F0;
        border-radius: 1.25rem 1.25rem 1.25rem 0;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    }

    .time-stamp {
        font-size: 0.65rem;
        opacity: 0.7;
        margin-top: 6px;
        display: block;
        text-align: right;
    }

    /* Typing Dots */
    .typing-dot {
        width: 6px;
        height: 6px;
        background-color: #94A3B8;
        border-radius: 50%;
        display: inline-block;
        animation: pulse 1.4s infinite ease-in-out both;
        margin: 0 2px;
    }
    .typing-dot:nth-child(1) { animation-delay: -0.32s; }
    .typing-dot:nth-child(2) { animation-delay: -0.16s; }

    @keyframes pulse {
        0%, 100% { transform: scale(0.8); opacity: 0.5; }
        50% { transform: scale(1.2); opacity: 1; }
    }

    /* Input area */
    .input-wrapper {
        box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    /* Markdown styling inside AI bubble */
    .prose-ai p { margin-bottom: 0.75rem; }
    .prose-ai p:last-child { margin-bottom: 0; }
    .prose-ai strong { color: #0F172A; font-weight: 600; }
    .prose-ai ul { list-style-type: disc; padding-left: 1.25rem; margin-bottom: 0.75rem; }
    .prose-ai ol { list-style-type: decimal; padding-left: 1.25rem; margin-bottom: 0.75rem; }
    .prose-ai a { color: #2563EB; text-decoration: underline; }

    .quick-action-btn {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        color: #475569;
        font-size: 0.75rem;
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        white-space: nowrap;
    }
    .quick-action-btn:hover {
        background: #F8FAFC;
        color: #0F172A;
        border-color: #CBD5E1;
        transform: translateY(-1px);
    }
</style>

<div class="h-[calc(100vh-100px)] flex flex-col max-w-4xl mx-auto bg-[#F8FAFC] md:bg-white md:shadow-xl md:rounded-2xl overflow-hidden md:border border-slate-200">
    
    <!-- Header -->
    <div class="bg-white px-6 py-4 flex items-center justify-between z-10 border-b border-slate-100 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-11 h-11 rounded-full bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center text-white shadow-md shrink-0">
                <i class="fa-solid fa-brain text-lg"></i>
            </div>
            <div>
                <h1 class="font-bold text-slate-800 text-lg leading-tight">StudyAI Mentor</h1>
                <div class="flex flex-wrap items-center gap-3 mt-0.5">
                    <p class="text-[11px] font-semibold text-emerald-600 uppercase tracking-widest flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block animate-pulse"></span> Context-Aware
                    </p>
                    <span class="text-[10px] font-semibold tracking-wider text-slate-500 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                        Daily Usage: <span id="usage-counter" class="{{ $todayChatsCount >= $chatLimit ? 'text-red-600' : 'text-slate-800' }}">{{ $todayChatsCount }}</span> / {{ $chatLimit }}
                    </span>
                </div>
            </div>
        </div>
        <div>    
            <button onclick="clearChat()" class="text-slate-400 hover:text-slate-700 bg-slate-50 border border-slate-200 hover:bg-slate-100 w-10 h-10 rounded-full transition-colors flex items-center justify-center" title="Clear Chat">
                <i class="fa-solid fa-rotate-right text-sm"></i>
            </button>
        </div>
    </div>

    <!-- Chat Area -->
    <div id="chat-container" class="chat-container flex-1 overflow-y-auto px-4 md:px-8 py-6 space-y-6 scroll-smooth bg-slate-50/50">
        
        <!-- Encryption / Info Notice -->
        <div class="flex justify-center mb-8">
            <div class="bg-blue-50 text-blue-700 text-xs font-medium px-5 py-2.5 rounded-xl border border-blue-100 text-center max-w-md flex items-center gap-2.5 shadow-sm">
                <i class="fa-solid fa-shield-halved shrink-0 text-blue-500"></i> 
                <span>Your academic context is securely analyzed to provide personalized guidance.</span>
            </div>
        </div>

        @if($messages->isEmpty())
        <div class="flex justify-center mb-6">
            <span class="bg-white border border-slate-200 text-slate-500 text-[10px] uppercase font-bold tracking-wider px-4 py-1.5 rounded-full shadow-sm">Today</span>
        </div>
        @endif

        @foreach($messages as $chat)
            <!-- User Message -->
            <div class="flex justify-end w-full fade-up">
                <div class="bubble-user px-5 py-3.5 max-w-[85%] md:max-w-[70%]">
                    <div class="text-[14.5px] leading-relaxed">{{ $chat->message }}</div>
                    <span class="time-stamp text-slate-400">{{ \Carbon\Carbon::parse($chat->created_at)->format('H:i') }}</span>
                </div>
            </div>

            <!-- AI Message -->
            <div class="flex justify-start w-full fade-up">
                <div class="bubble-ai px-5 py-4 max-w-[85%] md:max-w-[80%]">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fa-solid fa-brain text-slate-400 text-[10px]"></i>
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">StudyAI</span>
                    </div>
                    <div class="text-[14.5px] leading-relaxed prose-ai">
                        {!! \Illuminate\Support\Str::markdown($chat->response) !!}
                    </div>
                    <span class="time-stamp text-slate-400">{{ \Carbon\Carbon::parse($chat->created_at)->format('H:i') }}</span>
                </div>
            </div>
        @endforeach

        <!-- Typing Indicator -->
        <div id="typing-indicator" class="hidden flex justify-start w-full">
            <div class="bubble-ai px-5 py-4 shadow-sm inline-block">
                <div class="flex gap-1.5 items-center h-5">
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                </div>
            </div>
        </div>
        
        <div id="scroll-anchor"></div>
    </div>

    <!-- Quick Actions & Input Area -->
    <div class="bg-white border-t border-slate-100 z-10 w-full flex flex-col input-wrapper">
        
        <!-- Quick Actions Scrollable Row -->
        <div class="flex overflow-x-auto gap-2.5 px-6 py-4 no-scrollbar bg-slate-50/50">
            @if(auth()->user()->role_id == 3)
                <button class="quick-action-btn shrink-0" onclick="sendQuickAction('What is my current attendance?')">
                    <i class="fa-solid fa-clipboard-user text-blue-500 mr-1.5 text-sm"></i> Check Attendance
                </button>
                <button class="quick-action-btn shrink-0" onclick="sendQuickAction('What are my subject marks and weak subjects?')">
                    <i class="fa-solid fa-chart-pie text-purple-500 mr-1.5 text-sm"></i> View Marks
                </button>
                <button class="quick-action-btn shrink-0" onclick="sendQuickAction('Do I have any classes today?')">
                    <i class="fa-solid fa-calendar-day text-emerald-500 mr-1.5 text-sm"></i> Today's Class
                </button>
                <button class="quick-action-btn shrink-0" onclick="sendQuickAction('Are there any recent notices?')">
                    <i class="fa-solid fa-bell text-amber-500 mr-1.5 text-sm"></i> Latest Notices
                </button>
            @elseif(auth()->user()->role_id == 2)
                <button class="quick-action-btn shrink-0" onclick="sendQuickAction('What subjects do I teach?')">
                    <i class="fa-solid fa-book text-blue-500 mr-1.5 text-sm"></i> My Subjects
                </button>
                <button class="quick-action-btn shrink-0" onclick="sendQuickAction('What is my schedule for today?')">
                    <i class="fa-solid fa-calendar-week text-emerald-500 mr-1.5 text-sm"></i> My Schedule
                </button>
                <button class="quick-action-btn shrink-0" onclick="sendQuickAction('Help me plan a lesson for my next class')">
                    <i class="fa-solid fa-lightbulb text-amber-500 mr-1.5 text-sm"></i> Plan Lesson
                </button>
                <button class="quick-action-btn shrink-0" onclick="sendQuickAction('Are there any recent notices?')">
                    <i class="fa-solid fa-bell text-purple-500 mr-1.5 text-sm"></i> Latest Notices
                </button>
            @endif
        </div>

        <!-- Text Input -->
        <div class="flex items-end gap-3 px-6 py-4">
            <form id="chat-form" class="flex-1 relative flex items-center bg-slate-100/80 rounded-2xl border border-slate-200 focus-within:border-slate-400 focus-within:bg-white focus-within:shadow-sm transition-all duration-300">
                <textarea 
                    id="user-input"
                    name="message" 
                    rows="1"
                    class="w-full bg-transparent border-0 px-5 py-3.5 text-[15px] font-medium text-slate-800 focus:ring-0 resize-none max-h-32 no-scrollbar outline-none placeholder-slate-400"
                    placeholder="Ask StudyAI a question..."
                    required></textarea>
            </form>
            
            <button id="submit-btn" class="bg-slate-900 text-white hover:bg-slate-800 hover:shadow-md w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0 transition-all duration-300 disabled:opacity-50 disabled:hover:shadow-none" onclick="document.getElementById('chat-form').dispatchEvent(new Event('submit'))">
                <i class="fa-solid fa-paper-plane text-[15px] ml-0.5"></i>
            </button>
        </div>
    </div>
</div>

<style>
    .fade-up {
        animation: fadeUpMsg 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes fadeUpMsg {
        0% { opacity: 0; transform: translateY(15px); }
        100% { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    const chatContainer = document.getElementById('chat-container');
    const scrollAnchor = document.getElementById('scroll-anchor');
    const form = document.getElementById('chat-form');
    const input = document.getElementById('user-input');
    const submitBtn = document.getElementById('submit-btn');
    const typingIndicator = document.getElementById('typing-indicator');

    // Auto-resize textarea
    input.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
        if(this.value === '') this.style.height = 'auto';
    });

    // Handle Enter key for submit
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

    function sendQuickAction(text) {
        input.value = text;
        form.dispatchEvent(new Event('submit'));
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const message = input.value.trim();
        if (!message) return;

        // Reset UI
        input.value = '';
        input.style.height = 'auto';
        input.disabled = true;
        submitBtn.disabled = true;

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
                
                // Update quota counter dynamically
                const usageCounter = document.getElementById('usage-counter');
                if(usageCounter) {
                    let currentCount = parseInt(usageCounter.innerText);
                    currentCount++;
                    usageCounter.innerText = currentCount;
                    if(currentCount >= {{ $chatLimit }}) {
                        usageCounter.classList.remove('text-slate-800');
                        usageCounter.classList.add('text-red-600');
                    }
                }
            } else {
                appendMessage('error', data.error || 'Something went wrong.');
            }

        } catch (error) {
            typingIndicator.classList.add('hidden');
            appendMessage('error', '⚠️ Network error. Please check your connection.');
        } finally {
            input.disabled = false;
            submitBtn.disabled = false;
            input.focus();
            scrollAnchor.scrollIntoView({ behavior: 'smooth' });
        }
    });

    function appendMessage(sender, text) {
        const div = document.createElement('div');
        div.classList.add('flex', 'w-full', 'fade-up');
        const time = formatTime();
        
        if (sender === 'user') {
            div.classList.add('justify-end');
            div.innerHTML = `
                <div class="bubble-user px-5 py-3.5 max-w-[85%] md:max-w-[70%]">
                    <div class="text-[14.5px] leading-relaxed">${escapeHtml(text)}</div>
                    <span class="time-stamp text-slate-400">${time}</span>
                </div>
            `;
        } else if (sender === 'ai') {
            div.classList.add('justify-start');
            const formattedText = marked.parse(text); 
            div.innerHTML = `
                <div class="bubble-ai px-5 py-4 max-w-[85%] md:max-w-[80%]">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fa-solid fa-brain text-slate-400 text-[10px]"></i>
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">StudyAI</span>
                    </div>
                    <div class="text-[14.5px] leading-relaxed prose-ai">
                        ${formattedText}
                    </div>
                    <span class="time-stamp text-slate-400">${time}</span>
                </div>
            `;
        } else {
            div.classList.add('justify-center', 'my-2');
            div.innerHTML = `
                <div class="bg-red-50 text-red-600 text-xs font-medium px-4 py-2 rounded-lg border border-red-100 shadow-sm text-center">
                    <i class="fa-solid fa-circle-exclamation mr-1"></i> ${text}
                </div>
            `;
        }

        // Insert just before the typing indicator
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
        if(confirm('Clear this chat history from view?')) {
            const messages = chatContainer.querySelectorAll('.flex.w-full');
            messages.forEach(msg => {
                if(msg.id !== 'typing-indicator') msg.remove();
            });
        }
    }
</script>
@endsection