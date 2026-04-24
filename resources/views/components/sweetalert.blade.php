<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Custom SweetAlert2 Styling to match EdFlow SaaS aesthetic */
    .swal2-popup {
        border-radius: 1.5rem !important; /* 24px */
        padding: 2rem !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        border: 1px solid #f1f5f9 !important;
    }
    
    .swal2-title {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        font-weight: 800 !important;
        color: #0f172a !important;
    }
    
    .swal2-html-container {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        color: #64748b !important;
        font-weight: 500 !important;
    }

    .swal2-confirm {
        border-radius: 0.75rem !important;
        font-weight: 700 !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        padding: 0.75rem 1.5rem !important;
        background-color: #6366f1 !important; /* Indigo */
        box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.4) !important;
        transition: all 0.2s !important;
    }
    
    .swal2-confirm:hover {
        background-color: #4f46e5 !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 6px 8px -1px rgba(99, 102, 241, 0.5) !important;
    }

    .swal2-cancel {
        border-radius: 0.75rem !important;
        font-weight: 700 !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        padding: 0.75rem 1.5rem !important;
        background-color: #f1f5f9 !important;
        color: #64748b !important;
        transition: all 0.2s !important;
    }
    
    .swal2-cancel:hover {
        background-color: #e2e8f0 !important;
        color: #0f172a !important;
    }
    
    .swal2-confirm.bg-rose-600 {
        background-color: #e11d48 !important;
        box-shadow: 0 4px 6px -1px rgba(225, 29, 72, 0.4) !important;
    }
    .swal2-confirm.bg-rose-600:hover {
        background-color: #be123c !important;
        box-shadow: 0 6px 8px -1px rgba(225, 29, 72, 0.5) !important;
    }

    /* Toast Styles */
    .swal2-toast {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px) !important;
        border: 1px solid rgba(226, 232, 240, 0.8) !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
        border-radius: 1rem !important;
        padding: 0.75rem 1rem !important;
    }
    .swal2-toast .swal2-title {
        font-size: 0.95rem !important;
        font-weight: 700 !important;
        color: #1e293b !important;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // 1. GLOBAL TOAST CONFIGURATION
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // 2. LARAVEL SESSION FLASH MESSAGES
        @if(Session::has('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ Session::get("success") }}'
            });
        @endif

        @if(Session::has('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ Session::get("error") }}'
            });
        @endif

        @if(Session::has('warning'))
            Toast.fire({
                icon: 'warning',
                title: '{{ Session::get("warning") }}'
            });
        @endif

        @if(Session::has('info'))
            Toast.fire({
                icon: 'info',
                title: '{{ Session::get("info") }}'
            });
        @endif

        // 3. INTERCEPT FORMS WITH data-confirm
        document.body.addEventListener('submit', function(e) {
            const form = e.target;
            if (form.hasAttribute('data-confirm')) {
                // If already confirmed, let it submit naturally
                if (form.querySelector('input[name="_confirmed"]')) {
                    return;
                }

                e.preventDefault();
                
                const message = form.getAttribute('data-confirm') || "Are you sure you want to proceed?";
                const isDelete = message.toLowerCase().includes('delete') || message.toLowerCase().includes('remove') || message.toLowerCase().includes('revoke');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: message,
                    icon: isDelete ? 'warning' : 'question',
                    showCancelButton: true,
                    confirmButtonText: isDelete ? 'Yes, delete it!' : 'Yes, proceed',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: isDelete ? 'swal2-confirm bg-rose-600' : 'swal2-confirm',
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = '_confirmed';
                        input.value = '1';
                        form.appendChild(input);
                        form.submit();
                    }
                });
            }
        });

        // 4. INTERCEPT LINKS/BUTTONS WITH data-confirm (for non-form actions)
        document.body.addEventListener('click', function(e) {
            const target = e.target.closest('a[data-confirm], button[data-confirm]:not([type="submit"])');
            
            if (target) {
                e.preventDefault();
                
                const message = target.getAttribute('data-confirm') || "Are you sure you want to proceed?";
                const isDelete = message.toLowerCase().includes('delete') || message.toLowerCase().includes('remove') || message.toLowerCase().includes('revoke');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: message,
                    icon: isDelete ? 'warning' : 'question',
                    showCancelButton: true,
                    confirmButtonText: isDelete ? 'Yes, delete it!' : 'Yes, proceed',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: isDelete ? 'swal2-confirm bg-rose-600' : 'swal2-confirm',
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (target.tagName === 'A') {
                            window.location.href = target.href;
                        }
                    }
                });
            }
        });

    });
</script>
