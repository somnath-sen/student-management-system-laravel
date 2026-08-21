<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Support & Doubts | Parent Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    :root {
        --bg:#F2F2F7;--bg-2:#FFFFFF;--accent:#5856D6;--accent-soft:rgba(88,86,214,0.1);
        --text-primary:#1C1C1E;--text-secondary:#3A3A3C;--text-muted:#8E8E93;
        --border:rgba(60,60,67,0.12);--divider:rgba(60,60,67,0.08);
    }
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:'Inter',-apple-system,sans-serif;background:var(--bg);color:var(--text-primary);-webkit-font-smoothing:antialiased;min-height:100vh;}

    /* Header */
    .top-hdr{height:64px;background:#fff;border-bottom:1px solid var(--divider);display:flex;align-items:center;justify-content:space-between;padding:0 24px;position:sticky;top:0;z-index:50;}
    .hdr-back{display:flex;align-items:center;gap:8px;color:var(--accent);font-size:0.85rem;font-weight:600;text-decoration:none;padding:8px 14px;border-radius:100px;background:var(--accent-soft);transition:all 0.18s;}
    .hdr-back:hover{background:rgba(88,86,214,0.18);}
    .hdr-brand{font-size:0.95rem;font-weight:800;color:var(--text-primary);}
    .hdr-brand span{color:var(--accent);}

    .sp-wrap{max-width:860px;margin:0 auto;padding:28px 20px 80px;}

    /* Hero */
    .sp-hero{background:linear-gradient(135deg,#5856D6 0%,#7C3AED 60%,#6D28D9 100%);border-radius:24px;padding:32px 32px 28px;margin-bottom:28px;position:relative;overflow:hidden;}
    .sp-hero::before{content:'';position:absolute;top:-40px;right:-40px;width:200px;height:200px;background:rgba(255,255,255,0.08);border-radius:50%;}
    .sp-hero-title{font-size:1.5rem;font-weight:800;color:#fff;letter-spacing:-0.035em;margin-bottom:6px;position:relative;z-index:1;}
    .sp-hero-sub{font-size:0.82rem;color:rgba(255,255,255,0.78);position:relative;z-index:1;margin-bottom:22px;}
    .sp-ask-btn{display:inline-flex;align-items:center;gap:9px;padding:12px 24px;border-radius:100px;background:rgba(255,255,255,0.2);border:1.5px solid rgba(255,255,255,0.4);color:#fff;font-size:0.88rem;font-weight:700;cursor:pointer;transition:all 0.22s ease;backdrop-filter:blur(8px);position:relative;z-index:1;}
    .sp-ask-btn:hover{background:rgba(255,255,255,0.35);transform:translateY(-2px);}

    /* Inline form */
    .sp-ask-form{background:#fff;border-radius:22px;border:1.5px solid rgba(88,86,214,0.2);padding:26px 28px;margin-bottom:28px;box-shadow:0 8px 32px rgba(88,86,214,0.1);display:none;}
    .sp-ask-form.open{display:block;animation:fadeSlideIn 0.3s ease;}
    @keyframes fadeSlideIn{from{opacity:0;transform:translateY(-12px);}to{opacity:1;transform:translateY(0);}}
    .sp-form-title{font-size:1rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.025em;margin-bottom:20px;display:flex;align-items:center;gap:10px;}
    .sp-form-field{margin-bottom:16px;}
    .sp-form-label{font-size:0.72rem;font-weight:600;color:var(--text-secondary);margin-bottom:7px;display:block;text-transform:uppercase;letter-spacing:0.06em;}
    .sp-form-input,.sp-form-textarea{width:100%;border:1.5px solid rgba(60,60,67,0.15);border-radius:14px;padding:13px 16px;font-size:0.88rem;font-family:inherit;background:#F9F9FB;color:var(--text-primary);outline:none;transition:all 0.18s;}
    .sp-form-input:focus,.sp-form-textarea:focus{border-color:#5856D6;background:#fff;box-shadow:0 0 0 3px rgba(88,86,214,0.1);}
    .sp-form-textarea{resize:vertical;min-height:110px;}
    .sp-form-row{display:flex;gap:10px;margin-top:4px;flex-wrap:wrap;}
    .sp-form-submit{flex:1;min-width:140px;padding:13px 24px;border-radius:14px;background:linear-gradient(135deg,#5856D6,#7C3AED);color:#fff;font-size:0.88rem;font-weight:700;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all 0.2s;box-shadow:0 4px 14px rgba(88,86,214,0.3);}
    .sp-form-submit:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(88,86,214,0.4);}
    .sp-form-cancel{padding:13px 20px;border-radius:14px;background:rgba(60,60,67,0.06);color:rgba(60,60,67,0.6);font-size:0.85rem;font-weight:600;border:none;cursor:pointer;}
    .sp-form-success{display:none;text-align:center;padding:24px;background:rgba(88,86,214,0.06);border-radius:16px;border:1px solid rgba(88,86,214,0.2);}
    .sp-form-success-icon{font-size:2.5rem;color:#5856D6;margin-bottom:12px;}

    .sp-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:28px;}
    .sp-stat{background:#fff;border:1px solid var(--border);border-radius:18px;padding:18px 16px;text-align:center;transition:all 0.2s;}
    .sp-stat:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,0.08);}
    .sp-stat-num{font-size:1.9rem;font-weight:800;letter-spacing:-0.04em;}
    .sp-stat-lbl{font-size:0.65rem;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--text-muted);margin-top:4px;}

    .sp-section-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;}
    .sp-section-title{font-size:1rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.025em;}

    .sp-ticket{background:#fff;border:1.5px solid var(--border);border-radius:22px;overflow:hidden;transition:all 0.25s cubic-bezier(0.34,1.56,0.64,1);margin-bottom:14px;}
    .sp-ticket:hover{transform:translateY(-2px);box-shadow:0 10px 32px rgba(0,0,0,0.09);}
    .sp-ticket.is-solved{border-color:rgba(88,86,214,0.3);}
    .sp-ticket.is-in_progress{border-color:rgba(88,86,214,0.2);}
    .sp-ticket-top{padding:20px 22px;}
    .sp-ticket-header{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:10px;}
    .sp-ticket-subject{font-size:0.95rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;}
    .sp-ticket-question{font-size:0.82rem;color:var(--text-secondary);line-height:1.6;margin-bottom:18px;}

    .sp-pill{font-size:0.6rem;font-weight:700;padding:4px 12px;border-radius:100px;text-transform:uppercase;letter-spacing:0.06em;flex-shrink:0;display:flex;align-items:center;gap:5px;}
    .sp-pill-submitted{background:rgba(0,122,255,0.1);color:#007AFF;}
    .sp-pill-in_progress{background:rgba(88,86,214,0.12);color:#5856D6;}
    .sp-pill-solved{background:rgba(88,86,214,0.12);color:#5856D6;}

    .sp-timeline{display:flex;align-items:center;gap:0;margin-bottom:16px;padding:14px 18px;background:rgba(60,60,67,0.03);border-radius:14px;border:1px solid rgba(60,60,67,0.07);}
    .sp-step{display:flex;flex-direction:column;align-items:center;gap:6px;flex-shrink:0;}
    .sp-step-dot{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;transition:all 0.4s cubic-bezier(0.34,1.56,0.64,1);}
    .sp-step-dot.done{background:linear-gradient(135deg,#5856D6,#7C3AED);color:#fff;box-shadow:0 4px 14px rgba(88,86,214,0.4);}
    .sp-step-dot.active{background:linear-gradient(135deg,#5856D6,#6D28D9);color:#fff;box-shadow:0 4px 14px rgba(88,86,214,0.4);animation:spPA2 2s infinite;}
    .sp-step-dot.pending{background:rgba(60,60,67,0.08);color:rgba(60,60,67,0.3);border:1.5px solid rgba(60,60,67,0.12);}
    @keyframes spPA2{0%,100%{box-shadow:0 4px 14px rgba(88,86,214,0.4);transform:scale(1);}50%{box-shadow:0 4px 24px rgba(88,86,214,0.7);transform:scale(1.08);}}
    .sp-step-label{font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);text-align:center;line-height:1.2;white-space:nowrap;}
    .sp-step-label.done-lbl{color:#5856D6;}.sp-step-label.active-lbl{color:#5856D6;}
    .sp-connector{flex:1;height:3px;border-radius:100px;margin:0 6px;margin-bottom:18px;transition:all 0.6s ease;}
    .sp-connector.done{background:linear-gradient(90deg,#5856D6,#7C3AED);}
    .sp-connector.active{background:linear-gradient(90deg,#5856D6,rgba(88,86,214,0.3));}
    .sp-connector.pending{background:rgba(60,60,67,0.1);}

    .sp-reply-wrap{border-top:1px solid var(--divider);padding:16px 22px;background:linear-gradient(135deg,rgba(88,86,214,0.04),rgba(124,58,237,0.02));}
    .sp-reply-label{font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#5856D6;margin-bottom:10px;display:flex;align-items:center;gap:6px;}
    .sp-reply-bubble{background:#fff;border:1.5px solid rgba(88,86,214,0.2);border-radius:6px 18px 18px 18px;padding:14px 18px;font-size:0.85rem;color:var(--text-primary);line-height:1.65;box-shadow:0 4px 14px rgba(88,86,214,0.08);}
    .sp-reply-time{font-size:0.65rem;color:var(--text-muted);margin-top:8px;display:flex;align-items:center;gap:4px;}
    .sp-solved-banner{background:linear-gradient(135deg,rgba(88,86,214,0.08),rgba(124,58,237,0.04));border-top:1px solid rgba(88,86,214,0.15);padding:12px 22px;display:flex;align-items:center;gap:10px;font-size:0.8rem;font-weight:600;color:#5856D6;}
    .sp-ticket-footer{display:flex;align-items:center;gap:10px;flex-wrap:wrap;border-top:1px solid var(--divider);padding:10px 22px;background:rgba(60,60,67,0.02);}
    .sp-ticket-footer-time{font-size:0.65rem;color:var(--text-muted);}
    .sp-ticket-id{font-size:0.65rem;color:var(--text-muted);}

    .sp-pulse{display:inline-block;width:7px;height:7px;border-radius:50%;}
    .sp-pulse.submitted{background:#007AFF;animation:spPAP 2s infinite;}
    .sp-pulse.in_progress{background:#5856D6;animation:spPAP 1.4s infinite;}
    .sp-pulse.solved{background:#5856D6;}
    @keyframes spPAP{0%,100%{opacity:1;transform:scale(1);}50%{opacity:0.5;transform:scale(0.85);}}

    .sp-empty{text-align:center;padding:64px 20px;background:#fff;border-radius:24px;border:1.5px dashed var(--border);}
    .sp-empty-icon{width:72px;height:72px;border-radius:22px;background:var(--accent-soft);display:flex;align-items:center;justify-content:center;margin:0 auto 18px;font-size:1.8rem;color:var(--accent);}
    .sp-live-badge{display:flex;align-items:center;gap:6px;font-size:0.65rem;font-weight:600;color:#5856D6;padding:4px 12px;background:rgba(88,86,214,0.1);border-radius:100px;}
    .sp-live-dot{width:6px;height:6px;background:#5856D6;border-radius:50%;animation:spPAP 1.5s infinite;}
    </style>
</head>
<body>
    <header class="top-hdr">
        <a href="{{ route('parent.dashboard') }}" class="hdr-back"><i class="fa-solid fa-arrow-left"></i> Dashboard</a>
        <div class="hdr-brand">Ed<span>Flow</span> | Support</div>
        <div style="width:80px;"></div>
    </header>

    <div class="sp-wrap">

        <div class="sp-hero">
            <div class="sp-hero-title"><i class="fa-solid fa-circle-question" style="margin-right:10px;opacity:0.85;"></i>My Support & Doubts</div>
            <div class="sp-hero-sub">Submit questions and track their status in real-time</div>
            <button class="sp-ask-btn" onclick="toggleAskForm()">
                <i class="fa-solid fa-plus" id="askBtnIcon"></i>
                <span id="askBtnText">Ask a New Doubt</span>
            </button>
        </div>

        <div class="sp-ask-form" id="askForm">
            <div class="sp-form-title"><i class="fa-solid fa-paper-plane" style="color:#5856D6;"></i> Ask a New Doubt</div>
            <div id="formContent">
                <form id="supportForm" onsubmit="submitDoubt(event)">
                    @csrf
                    <div class="sp-form-field">
                        <label class="sp-form-label">Subject / Topic</label>
                        <input type="text" class="sp-form-input" id="doubSubject" name="subject" placeholder="e.g. Fee receipt question" maxlength="255" required>
                    </div>
                    <div class="sp-form-field">
                        <label class="sp-form-label">Describe Your Query</label>
                        <textarea class="sp-form-textarea" id="doubQuestion" name="question" placeholder="Write your question in detail..." maxlength="5000" required rows="5"></textarea>
                    </div>
                    <div class="sp-form-row">
                        <button type="submit" class="sp-form-submit" id="submitBtn"><i class="fa-solid fa-paper-plane"></i> Submit</button>
                        <button type="button" class="sp-form-cancel" onclick="toggleAskForm()">Cancel</button>
                    </div>
                </form>
            </div>
            <div class="sp-form-success" id="formSuccess">
                <div class="sp-form-success-icon"><i class="fa-solid fa-circle-check"></i></div>
                <div style="font-size:1rem;font-weight:800;color:var(--text-primary);margin-bottom:6px;">Query Submitted!</div>
                <div style="font-size:0.82rem;color:var(--text-muted);margin-bottom:18px;">Our support team will review and reply shortly.</div>
                <button onclick="window.location.reload()" class="sp-form-submit" style="max-width:200px;margin:0 auto;"><i class="fa-solid fa-rotate-right"></i> Refresh</button>
            </div>
        </div>

        @php
            $totalCount   = $tickets->count();
            $pendingCount = $tickets->where('status','submitted')->count();
            $ipCount      = $tickets->where('status','in_progress')->count();
            $doneCount    = $tickets->where('status','solved')->count();
        @endphp
        <div class="sp-stats">
            <div class="sp-stat"><div class="sp-stat-num" style="color:var(--text-primary);">{{ $totalCount }}</div><div class="sp-stat-lbl">Total</div></div>
            <div class="sp-stat"><div class="sp-stat-num" style="color:#FF9F0A;">{{ $pendingCount + $ipCount }}</div><div class="sp-stat-lbl">Open</div></div>
            <div class="sp-stat"><div class="sp-stat-num" style="color:#5856D6;">{{ $doneCount }}</div><div class="sp-stat-lbl">Solved</div></div>
        </div>

        <div class="sp-section-head">
            <div class="sp-section-title">My Doubts</div>
            <div class="sp-live-badge"><span class="sp-live-dot"></span> Live Updates</div>
        </div>

        @if($tickets->isEmpty())
            <div class="sp-empty">
                <div class="sp-empty-icon"><i class="fa-solid fa-inbox"></i></div>
                <p style="font-size:1.05rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.025em;margin-bottom:8px;">No queries yet</p>
                <p style="font-size:0.82rem;color:var(--text-muted);margin-bottom:24px;">Submit a question — our team will help you quickly!</p>
                <button class="sp-ask-btn" onclick="toggleAskForm()" style="background:linear-gradient(135deg,#5856D6,#7C3AED);border:none;padding:14px 28px;font-size:0.9rem;">
                    <i class="fa-solid fa-paper-plane"></i> Ask Your First Question
                </button>
            </div>
        @else
            <div id="ticketContainer">
                @foreach($tickets as $ticket)
                @php $step = $ticket->status_step; @endphp
                <div class="sp-ticket is-{{ $ticket->status }}" id="sp-ticket-{{ $ticket->id }}" data-status="{{ $ticket->status }}">
                    <div class="sp-ticket-top">
                        <div class="sp-ticket-header">
                            <div class="sp-ticket-subject">{{ $ticket->subject }}</div>
                            <span class="sp-pill sp-pill-{{ $ticket->status }}">
                                <span class="sp-pulse {{ $ticket->status }}"></span>
                                {{ $ticket->status_label }}
                            </span>
                        </div>
                        <div class="sp-ticket-question">{{ Str::limit($ticket->question, 200) }}</div>
                        <div class="sp-timeline">
                            <div class="sp-step">
                                <div class="sp-step-dot done"><i class="fa-solid fa-check" style="font-size:0.7rem;"></i></div>
                                <div class="sp-step-label done-lbl">Submitted</div>
                            </div>
                            <div class="sp-connector {{ $step >= 1 ? ($step >= 2 ? 'done' : 'active') : 'pending' }}"></div>
                            <div class="sp-step">
                                <div class="sp-step-dot {{ $step >= 2 ? 'done' : ($step >= 1 ? 'active' : 'pending') }}">
                                    <i class="fa-solid fa-hourglass-half" style="font-size:0.7rem;"></i>
                                </div>
                                <div class="sp-step-label {{ $step >= 2 ? 'done-lbl' : ($step >= 1 ? 'active-lbl' : '') }}">In Progress</div>
                            </div>
                            <div class="sp-connector {{ $step >= 2 ? 'done' : 'pending' }}"></div>
                            <div class="sp-step">
                                <div class="sp-step-dot {{ $step >= 2 ? 'done' : 'pending' }}">
                                    <i class="fa-solid fa-check-circle" style="font-size:0.7rem;"></i>
                                </div>
                                <div class="sp-step-label {{ $step >= 2 ? 'done-lbl' : '' }}">Solved</div>
                            </div>
                        </div>
                    </div>
                    @if($ticket->admin_reply)
                        <div class="sp-reply-wrap">
                            <div class="sp-reply-label"><i class="fa-solid fa-shield-halved"></i> Support Team Reply</div>
                            <div class="sp-reply-bubble">{{ $ticket->admin_reply }}</div>
                            <div class="sp-reply-time"><i class="fa-regular fa-clock"></i> {{ $ticket->replied_at?->diffForHumans() ?? 'Just now' }}</div>
                        </div>
                    @endif
                    @if($ticket->status === 'solved')
                        <div class="sp-solved-banner"><i class="fa-solid fa-circle-check" style="font-size:1rem;"></i><span>This query has been resolved!</span></div>
                    @endif
                    <div class="sp-ticket-footer">
                        <span class="sp-ticket-id">#{{ $ticket->id }}</span>
                        <span style="color:var(--border);font-size:0.7rem;">•</span>
                        <span class="sp-ticket-footer-time"><i class="fa-regular fa-clock" style="margin-right:3px;"></i>{{ $ticket->created_at->diffForHumans() }}</span>
                        @if(!$ticket->admin_reply)
                            <span style="margin-left:auto;font-size:0.65rem;color:var(--text-muted);"><i class="fa-solid fa-hourglass" style="margin-right:3px;"></i>Awaiting reply</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
    let askFormOpen = false;
    function toggleAskForm() {
        askFormOpen = !askFormOpen;
        const form = document.getElementById('askForm');
        const icon = document.getElementById('askBtnIcon');
        const txt  = document.getElementById('askBtnText');
        form.classList.toggle('open', askFormOpen);
        if (icon) icon.className = askFormOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-plus';
        if (txt)  txt.textContent = askFormOpen ? 'Close Form' : 'Ask a New Doubt';
        if (askFormOpen) form.scrollIntoView({ behavior:'smooth', block:'start' });
    }
    function submitDoubt(event) {
        event.preventDefault();
        const subject  = document.getElementById('doubSubject').value.trim();
        const question = document.getElementById('doubQuestion').value.trim();
        const btn      = document.getElementById('submitBtn');
        if (!subject || !question) return;
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Submitting...';
        fetch('/support/tickets', {
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'},
            body: JSON.stringify({ subject, question }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                document.getElementById('formContent').style.display = 'none';
                document.getElementById('formSuccess').style.display = 'block';
            } else {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Submit';
            }
        })
        .catch(() => { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Submit'; });
    }
    document.addEventListener('DOMContentLoaded', () => {
        setInterval(() => {
            fetch('/support/tickets', { headers:{'Accept':'application/json'} })
                .then(r => r.json())
                .then(data => {
                    (data.tickets||[]).forEach(t => {
                        const card = document.getElementById('sp-ticket-'+t.id);
                        if (!card || card.dataset.status === t.status) return;
                        card.dataset.status = t.status;
                        const pill = card.querySelector('.sp-pill');
                        if (pill) {
                            const lm={submitted:'Submitted',in_progress:'In Progress',solved:'Solved'};
                            pill.className='sp-pill sp-pill-'+t.status;
                            pill.innerHTML=`<span class="sp-pulse ${t.status}"></span>${lm[t.status]}`;
                        }
                        card.style.borderColor='#5856D6';card.style.boxShadow='0 0 0 3px rgba(88,86,214,0.15)';
                        setTimeout(()=>{card.style.borderColor='';card.style.boxShadow='';},2500);
                    });
                }).catch(()=>{});
        }, 12000);
    });
    </script>
</body>
</html>
