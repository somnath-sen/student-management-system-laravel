{{-- ═══════════════════════════════════════════════════════════
     GLOBAL SUPPORT MODAL COMPONENT
     Shared across Student, Teacher, Parent layouts
     Usage: Include this file at the bottom of each layout
     (before </body>)
     ═══════════════════════════════════════════════════════════ --}}

<style>
/* ── Support Modal Styles ───────────────────────────────────────── */
.support-overlay {
    position: fixed; inset: 0; z-index: 10000;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(12px) saturate(180%);
    -webkit-backdrop-filter: blur(12px) saturate(180%);
    display: flex; align-items: center; justify-content: center;
    padding: 20px;
    opacity: 0; pointer-events: none;
    transition: opacity 0.3s ease;
}
.support-overlay.show { opacity: 1; pointer-events: all; }

.support-modal {
    background: #fff;
    border-radius: 28px;
    width: 100%; max-width: 540px;
    max-height: 90vh;
    overflow: hidden;
    display: flex; flex-direction: column;
    box-shadow: 0 32px 80px rgba(0,0,0,0.25), 0 8px 30px rgba(0,0,0,0.15);
    transform: translateY(30px) scale(0.96);
    transition: transform 0.35s cubic-bezier(0.25,0.46,0.45,0.94),
                opacity 0.3s ease;
    opacity: 0;
}
.support-overlay.show .support-modal {
    transform: translateY(0) scale(1);
    opacity: 1;
}

.support-modal-header {
    padding: 26px 28px 20px;
    background: linear-gradient(135deg, #007AFF 0%, #5AC8FA 100%);
    flex-shrink: 0;
    position: relative;
}
.support-modal-header .close-btn {
    position: absolute; top: 18px; right: 18px;
    width: 32px; height: 32px; border-radius: 50%;
    background: rgba(255,255,255,0.2);
    border: none; cursor: pointer; color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.9rem; transition: background 0.18s;
}
.support-modal-header .close-btn:hover { background: rgba(255,255,255,0.35); }
.support-modal-header h3 {
    font-size: 1.2rem; font-weight: 800; color: #fff; letter-spacing: -0.03em; margin-bottom: 4px;
}
.support-modal-header p {
    font-size: 0.8rem; color: rgba(255,255,255,0.82);
}
.header-icon-wrap {
    width: 48px; height: 48px; border-radius: 16px;
    background: rgba(255,255,255,0.22);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.2rem; margin-bottom: 14px;
}

.support-modal-body {
    padding: 24px 28px;
    overflow-y: auto; flex: 1;
}

.form-group { margin-bottom: 18px; }
.form-label {
    display: block; font-size: 0.78rem; font-weight: 700;
    color: #1C1C1E; margin-bottom: 7px; letter-spacing: -0.01em;
}
.form-label .required { color: #FF3B30; margin-left: 2px; }
.form-input, .form-textarea {
    width: 100%; border: 1.5px solid rgba(60,60,67,0.18);
    border-radius: 14px; padding: 12px 16px;
    font-size: 0.9rem; font-family: inherit;
    color: #1C1C1E; background: #F2F2F7;
    transition: all 0.18s; outline: none; resize: none;
}
.form-input:focus, .form-textarea:focus {
    border-color: #007AFF;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(0,122,255,0.12);
}
.form-input::placeholder, .form-textarea::placeholder { color: rgba(60,60,67,0.45); }
.form-textarea { min-height: 120px; }
.form-hint {
    margin-top: 7px; font-size: 0.72rem; color: rgba(60,60,67,0.5);
    display: flex; align-items: center; gap: 5px;
}

.submit-btn {
    width: 100%; padding: 15px 24px;
    background: linear-gradient(135deg, #007AFF, #5AC8FA);
    color: #fff; border: none; border-radius: 16px;
    font-size: 0.95rem; font-weight: 700; cursor: pointer;
    letter-spacing: -0.01em;
    transition: all 0.22s cubic-bezier(0.25,0.46,0.45,0.94);
    display: flex; align-items: center; justify-content: center; gap: 9px;
    box-shadow: 0 4px 16px rgba(0,122,255,0.35);
    position: relative; overflow: hidden;
}
.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,122,255,0.45);
}
.submit-btn:active { transform: translateY(0); }
.submit-btn:disabled {
    opacity: 0.7; cursor: not-allowed; transform: none;
}
.submit-btn::after {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
    pointer-events: none;
}

/* ── Success Screen ────────────────────────────────────────── */
.success-screen {
    display: none; flex-direction: column; align-items: center;
    padding: 28px 28px 32px; text-align: center;
}
.success-screen.show { display: flex; }
.success-circle {
    width: 80px; height: 80px; border-radius: 50%;
    background: linear-gradient(135deg, #30D158, #34C759);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 2rem; margin-bottom: 20px;
    box-shadow: 0 8px 30px rgba(52,199,89,0.4);
    animation: successPop 0.5s cubic-bezier(0.175,0.885,0.32,1.275) forwards;
}
@keyframes successPop {
    0% { transform: scale(0) rotate(-10deg); opacity: 0; }
    60% { transform: scale(1.15) rotate(5deg); }
    100% { transform: scale(1) rotate(0deg); opacity: 1; }
}
.success-title {
    font-size: 1.2rem; font-weight: 800; color: #1C1C1E;
    letter-spacing: -0.03em; margin-bottom: 8px;
}
.success-sub { font-size: 0.85rem; color: rgba(60,60,67,0.6); line-height: 1.55; margin-bottom: 28px; }

/* ── Status Timeline ──────────────────────────────────────── */
.timeline {
    width: 100%; display: flex; align-items: flex-start;
    gap: 0; margin-bottom: 28px; position: relative;
}
.timeline-step {
    display: flex; flex-direction: column; align-items: center;
    flex: 1; position: relative;
}
.step-dot {
    width: 36px; height: 36px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.9rem; font-weight: 700;
    position: relative; z-index: 2; flex-shrink: 0;
    transition: all 0.4s ease;
}
.step-dot.done {
    background: linear-gradient(135deg, #30D158, #34C759);
    color: #fff; box-shadow: 0 4px 14px rgba(52,199,89,0.4);
}
.step-dot.active {
    background: linear-gradient(135deg, #007AFF, #5AC8FA);
    color: #fff; box-shadow: 0 4px 14px rgba(0,122,255,0.4);
    animation: stepPulse 2s infinite;
}
.step-dot.pending {
    background: rgba(60,60,67,0.08);
    color: rgba(60,60,67,0.35); border: 1.5px solid rgba(60,60,67,0.15);
}
@keyframes stepPulse {
    0%,100% { box-shadow: 0 4px 14px rgba(0,122,255,0.4); }
    50% { box-shadow: 0 4px 24px rgba(0,122,255,0.7); transform: scale(1.06); }
}
.step-label {
    font-size: 0.65rem; font-weight: 700; margin-top: 8px;
    text-align: center; color: rgba(60,60,67,0.5);
    text-transform: uppercase; letter-spacing: 0.06em; line-height: 1.3;
}
.step-label.active-label { color: #007AFF; }
.step-label.done-label { color: #30D158; }

/* Connecting lines between steps */
.step-connector {
    flex: 1; height: 3px; margin-top: 16px;
    border-radius: 100px; transition: all 0.6s ease;
}
.step-connector.done { background: linear-gradient(90deg, #30D158, #34C759); }
.step-connector.active { background: linear-gradient(90deg, #30D158, rgba(0,122,255,0.3)); }
.step-connector.pending { background: rgba(60,60,67,0.1); }

/* ── Support Button (floating / nav) ──────────────────────── */
.support-fab {
    display: flex; align-items: center; gap: 9px;
    padding: 10px 20px; border-radius: 14px;
    background: linear-gradient(135deg, #007AFF, #5AC8FA);
    color: #fff; font-size: 0.82rem; font-weight: 700;
    border: none; cursor: pointer;
    box-shadow: 0 4px 16px rgba(0,122,255,0.3);
    transition: all 0.22s ease; letter-spacing: -0.01em;
}
.support-fab:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,122,255,0.4);
}

/* ── My Tickets view (embedded in support section) ────────── */
.my-tickets-list { display: flex; flex-direction: column; gap: 10px; margin-top: 16px; }
.ticket-item {
    background: #fff; border: 1.5px solid rgba(60,60,67,0.1);
    border-radius: 16px; padding: 0; overflow: hidden;
    transition: all 0.2s;
}
.ticket-item:hover { border-color: #007AFF; box-shadow: 0 4px 16px rgba(0,122,255,0.1); }
.ticket-item-top { padding: 14px 18px; }
.ticket-item-subject {
    font-size: 0.88rem; font-weight: 700; color: #1C1C1E; margin-bottom: 5px;
}
.ticket-item-question {
    font-size: 0.78rem; color: rgba(60,60,67,0.6); line-height: 1.5;
    margin-bottom: 10px;
}
.ticket-item-meta {
    display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
}
.tpill { font-size: 0.62rem; font-weight: 700; padding: 3px 10px; border-radius: 100px; text-transform: uppercase; letter-spacing: 0.05em; }
.tpill-submitted { background: rgba(0,122,255,0.1); color: #007AFF; }
.tpill-in_progress { background: rgba(255,159,10,0.12); color: #FF9F0A; }
.tpill-solved { background: rgba(52,199,89,0.1); color: #30D158; }
.ticket-item-reply {
    background: linear-gradient(135deg, #F0F7FF, #EBF4FF);
    border-top: 1px solid rgba(0,122,255,0.1);
    padding: 12px 18px;
}
.ticket-reply-label {
    font-size: 0.62rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.07em; color: #007AFF; margin-bottom: 5px;
}
.ticket-reply-text { font-size: 0.82rem; color: #1C1C1E; line-height: 1.6; }
</style>

{{-- ═══════ SUPPORT MODAL ═══════ --}}
<div class="support-overlay" id="supportOverlay" onclick="closeSupportModalIfBg(event)">
    <div class="support-modal" id="supportModal">

        {{-- ── Header ── --}}
        <div class="support-modal-header">
            <button class="close-btn" onclick="closeSupportModal()" id="supportModalCloseBtn">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="header-icon-wrap">
                <i class="fa-solid fa-circle-question"></i>
            </div>
            <h3>Ask a Doubt</h3>
            <p>Submit your question and our team will help you</p>
        </div>

        {{-- ── Form Body ── --}}
        <div class="support-modal-body" id="supportFormBody">
            <form id="supportDoubtForm" onsubmit="submitDoubt(event)">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="doubt-subject">
                        Subject <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="doubt-subject"
                        name="subject"
                        class="form-input"
                        placeholder="Brief title for your doubt"
                        maxlength="255"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="doubt-question">
                        Your Question <span class="required">*</span>
                    </label>
                    <textarea
                        id="doubt-question"
                        name="question"
                        class="form-textarea"
                        placeholder="Describe your doubt in detail..."
                        rows="5"
                        maxlength="5000"
                        required
                    ></textarea>
                    <div class="form-hint">
                        <i class="fa-solid fa-lightbulb" style="color:#FF9F0A;"></i>
                        Be specific about the topic for faster help
                    </div>
                </div>

                <button type="submit" class="submit-btn" id="supportSubmitBtn">
                    <i class="fa-solid fa-paper-plane"></i>
                    Submit
                </button>
            </form>
        </div>

        {{-- ── Success Screen ── --}}
        <div class="success-screen" id="supportSuccessScreen">
            <div class="success-circle"><i class="fa-solid fa-check"></i></div>
            <div class="success-title">Doubt Submitted!</div>
            <div class="success-sub">
                Our team will review your question and respond as soon as possible.<br>
                Track your progress below.
            </div>

            {{-- Animated Status Timeline --}}
            <div class="timeline" style="max-width:360px;margin:0 auto 28px;">
                {{-- Step 1: Submitted --}}
                <div class="timeline-step">
                    <div class="step-dot done"><i class="fa-solid fa-check" style="font-size:0.75rem;"></i></div>
                    <div class="step-label done-label">Submitted</div>
                </div>
                {{-- Connector 1 --}}
                <div class="step-connector pending" id="connector-1"></div>
                {{-- Step 2: In Progress --}}
                <div class="timeline-step">
                    <div class="step-dot pending" id="step-inprogress"><i class="fa-solid fa-hourglass-half" style="font-size:0.75rem;"></i></div>
                    <div class="step-label" id="label-inprogress">In Progress</div>
                </div>
                {{-- Connector 2 --}}
                <div class="step-connector pending" id="connector-2"></div>
                {{-- Step 3: Solved --}}
                <div class="timeline-step">
                    <div class="step-dot pending" id="step-solved"><i class="fa-solid fa-check-circle" style="font-size:0.75rem;"></i></div>
                    <div class="step-label" id="label-solved">Solved</div>
                </div>
            </div>

            {{-- My Tickets Button → dedicated support page --}}
            <a href="{{ 
                auth()->user()?->role === 'teacher' ? route('teacher.support.index') : 
                (auth()->user()?->role === 'parent' ? route('parent.support.index') : route('student.support.index'))
            }}" class="submit-btn" style="max-width:280px;text-decoration:none;" onclick="closeSupportModal()">
                <i class="fa-solid fa-ticket"></i>
                View My Support Page
            </a>
        </div>

        {{-- ── My Tickets Screen ── --}}
        <div id="myTicketsScreen" style="display:none;flex-direction:column;padding:20px 28px 28px;">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
                <button onclick="backToForm()" style="width:32px;height:32px;border-radius:10px;background:rgba(60,60,67,0.08);border:none;cursor:pointer;color:rgba(60,60,67,0.6);display:flex;align-items:center;justify-content:center;">
                    <i class="fa-solid fa-arrow-left" style="font-size:0.8rem;"></i>
                </button>
                <div>
                    <h4 style="font-size:1rem;font-weight:800;color:#1C1C1E;letter-spacing:-0.025em;">My Doubts</h4>
                    <p style="font-size:0.72rem;color:rgba(60,60,67,0.5);">Track status of your submitted questions</p>
                </div>
            </div>
            <div id="myTicketsBody" style="overflow-y:auto;max-height:55vh;">
                <div style="text-align:center;padding:32px;color:rgba(60,60,67,0.4);">
                    <i class="fa-solid fa-spinner fa-spin" style="font-size:1.5rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
/* ──────────────────────────────────────────────────
   SUPPORT MODAL JAVASCRIPT
   ────────────────────────────────────────────────── */
let currentTicketId = null;
let pollingInterval = null;

function openSupportModal() {
    const overlay = document.getElementById('supportOverlay');
    overlay.classList.add('show');
    document.body.style.overflow = 'hidden';
    setTimeout(() => {
        document.getElementById('doubt-subject')?.focus();
    }, 350);
}

function closeSupportModal() {
    const overlay = document.getElementById('supportOverlay');
    overlay.classList.remove('show');
    document.body.style.overflow = '';
    stopPolling();
}

function closeSupportModalIfBg(e) {
    if (e.target.id === 'supportOverlay') closeSupportModal();
}

function submitDoubt(e) {
    e.preventDefault();
    const btn = document.getElementById('supportSubmitBtn');
    const subject  = document.getElementById('doubt-subject').value.trim();
    const question = document.getElementById('doubt-question').value.trim();

    if (!subject || !question) return;

    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Submitting...';

    fetch('/support/tickets', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                         || '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ subject, question }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            currentTicketId = data.ticket.id;
            showSuccessScreen();
            startPolling(currentTicketId);
        } else {
            alert('Something went wrong. Please try again.');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Submit';
        }
    })
    .catch(() => {
        alert('Network error. Please check your connection and try again.');
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Submit';
    });
}

function showSuccessScreen() {
    document.getElementById('supportFormBody').style.display = 'none';
    const successScreen = document.getElementById('supportSuccessScreen');
    successScreen.style.display = 'flex';
    successScreen.classList.add('show');

    // Reset timeline to "Submitted" state
    resetTimeline();
}

function resetTimeline() {
    const stepIP    = document.getElementById('step-inprogress');
    const stepSolved= document.getElementById('step-solved');
    const conn1     = document.getElementById('connector-1');
    const conn2     = document.getElementById('connector-2');
    const labelIP   = document.getElementById('label-inprogress');
    const labelSolved = document.getElementById('label-solved');

    if (stepIP)    { stepIP.className    = 'step-dot pending'; }
    if (stepSolved){ stepSolved.className = 'step-dot pending'; }
    if (conn1)     { conn1.className     = 'step-connector pending'; }
    if (conn2)     { conn2.className     = 'step-connector pending'; }
    if (labelIP)   { labelIP.className   = 'step-label'; }
    if (labelSolved){ labelSolved.className = 'step-label'; }
}

function updateTimeline(status) {
    const stepIP    = document.getElementById('step-inprogress');
    const stepSolved= document.getElementById('step-solved');
    const conn1     = document.getElementById('connector-1');
    const conn2     = document.getElementById('connector-2');
    const labelIP   = document.getElementById('label-inprogress');
    const labelSolved = document.getElementById('label-solved');

    if (status === 'in_progress') {
        if (conn1)     conn1.className     = 'step-connector active';
        if (stepIP)    stepIP.className    = 'step-dot active';
        if (labelIP)   labelIP.className   = 'step-label active-label';
    } else if (status === 'solved') {
        if (conn1)     conn1.className     = 'step-connector done';
        if (conn2)     conn2.className     = 'step-connector done';
        if (stepIP)    stepIP.className    = 'step-dot done';
        if (stepSolved) stepSolved.className = 'step-dot done';
        if (labelIP)   labelIP.className   = 'step-label done-label';
        if (labelSolved) labelSolved.className = 'step-label done-label';
        stopPolling();
    }
}

function startPolling(ticketId) {
    // Poll every 8 seconds for status updates
    pollingInterval = setInterval(() => {
        fetch('/support/tickets', {
            headers: { 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            const ticket = data.tickets?.find(t => t.id === ticketId);
            if (ticket) {
                updateTimeline(ticket.status);
                if (ticket.status === 'solved') stopPolling();
            }
        })
        .catch(() => {});
    }, 8000);
}

function stopPolling() {
    if (pollingInterval) {
        clearInterval(pollingInterval);
        pollingInterval = null;
    }
}

function loadMyTickets() {
    document.getElementById('supportSuccessScreen').style.display = 'none';
    const screen = document.getElementById('myTicketsScreen');
    screen.style.display = 'flex';

    fetch('/support/tickets', {
        headers: { 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        renderTickets(data.tickets || []);
    })
    .catch(() => {
        document.getElementById('myTicketsBody').innerHTML =
            '<p style="text-align:center;color:#FF3B30;font-size:0.85rem;">Failed to load tickets.</p>';
    });
}

function renderTickets(tickets) {
    const body = document.getElementById('myTicketsBody');
    if (!tickets.length) {
        body.innerHTML = `
            <div style="text-align:center;padding:40px 20px;">
                <div style="width:48px;height:48px;border-radius:16px;background:rgba(60,60,67,0.06);display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:1.3rem;color:rgba(60,60,67,0.3);">
                    <i class="fa-solid fa-inbox"></i>
                </div>
                <p style="font-size:0.88rem;font-weight:700;color:#1C1C1E;">No doubts submitted yet</p>
                <p style="font-size:0.75rem;color:rgba(60,60,67,0.5);margin-top:5px;">Submit your first question above!</p>
            </div>`;
        return;
    }

    const pillMap = {
        submitted:   'tpill-submitted',
        in_progress: 'tpill-in_progress',
        solved:      'tpill-solved',
    };
    const labelMap = { submitted: 'Submitted', in_progress: 'In Progress', solved: 'Solved' };
    const iconMap  = { submitted: 'fa-circle-dot', in_progress: 'fa-hourglass-half', solved: 'fa-check-circle' };

    body.innerHTML = tickets.map(t => `
        <div class="ticket-item" style="margin-bottom:10px;">
            <div class="ticket-item-top">
                <div class="ticket-item-subject">${escHtml(t.subject)}</div>
                <div class="ticket-item-question">${escHtml(t.question.substring(0,120))}${t.question.length>120?'…':''}</div>

                {{-- Mini Timeline --}}
                <div style="display:flex;align-items:center;gap:6px;margin:10px 0 8px;">
                    <div style="display:flex;align-items:center;gap:4px;flex:1;">
                        <div style="width:22px;height:22px;border-radius:50%;background:linear-gradient(135deg,#30D158,#34C759);display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.55rem;flex-shrink:0;box-shadow:0 2px 6px rgba(52,199,89,0.3);">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div style="flex:1;height:2px;border-radius:4px;background:${t.status_step>=1?'linear-gradient(90deg,#30D158,'+( t.status_step>=2?'#30D158':'rgba(0,122,255,0.3)')+')'  :'rgba(60,60,67,0.1)'};transition:all 0.5s;"></div>
                        <div style="width:22px;height:22px;border-radius:50%;background:${t.status_step>=1?'linear-gradient(135deg,#007AFF,#5AC8FA)':'rgba(60,60,67,0.08)'};display:flex;align-items:center;justify-content:center;color:${t.status_step>=1?'#fff':'rgba(60,60,67,0.3)'};font-size:0.55rem;flex-shrink:0;box-shadow:${t.status_step>=1?'0 2px 8px rgba(0,122,255,0.3)':'none'};transition:all 0.4s;">
                            <i class="fa-solid fa-hourglass-half"></i>
                        </div>
                        <div style="flex:1;height:2px;border-radius:4px;background:${t.status_step>=2?'linear-gradient(90deg,#30D158,#34C759)':'rgba(60,60,67,0.1)'};transition:all 0.5s;"></div>
                        <div style="width:22px;height:22px;border-radius:50%;background:${t.status_step>=2?'linear-gradient(135deg,#30D158,#34C759)':'rgba(60,60,67,0.08)'};display:flex;align-items:center;justify-content:center;color:${t.status_step>=2?'#fff':'rgba(60,60,67,0.3)'};font-size:0.55rem;flex-shrink:0;box-shadow:${t.status_step>=2?'0 2px 6px rgba(52,199,89,0.3)':'none'};transition:all 0.4s;">
                            <i class="fa-solid fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <div class="ticket-item-meta">
                    <span class="tpill ${pillMap[t.status]||'tpill-submitted'}">
                        <i class="fa-solid ${iconMap[t.status]||'fa-circle-dot'}" style="margin-right:3px;font-size:0.55rem;"></i>
                        ${labelMap[t.status]||t.status}
                    </span>
                    <span style="font-size:0.65rem;color:rgba(60,60,67,0.45);">${t.created_at}</span>
                </div>
            </div>

            ${t.admin_reply ? `
            <div class="ticket-item-reply">
                <div class="ticket-reply-label"><i class="fa-solid fa-reply" style="margin-right:4px;"></i>Support Reply ${t.replied_at?'• '+t.replied_at:''}</div>
                <div class="ticket-reply-text">${escHtml(t.admin_reply)}</div>
            </div>` : ''}
        </div>
    `).join('');
}

function escHtml(str) {
    const d = document.createElement('div');
    d.textContent = str;
    return d.innerHTML;
}

function backToForm() {
    document.getElementById('myTicketsScreen').style.display = 'none';
    if (currentTicketId) {
        document.getElementById('supportSuccessScreen').style.display = 'flex';
    } else {
        document.getElementById('supportFormBody').style.display = 'block';
    }
}

// Keyboard ESC to close
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeSupportModal();
});
</script>
