<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            {{ __('Account Settings') }}
        </h2>
    </x-slot>

    <style>
        /* ================= ANIMATIONS ================= */
        .animate-enter {
            animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }

        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }

        /* Card Hover */
        .settings-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .settings-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 animate-enter">

            <div class="settings-card p-4 sm:p-8 bg-white shadow-lg sm:rounded-2xl border-l-4 border-indigo-500 stagger-1 opacity-0 animate-enter">
                <div class="flex items-start gap-4 mb-6 border-b border-gray-100 pb-4">
                    <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ __('Profile Information') }}</h3>
                        <p class="text-sm text-gray-500">{{ __("Update your account's profile information and email address.") }}</p>
                    </div>
                </div>
                
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="settings-card p-4 sm:p-8 bg-white shadow-lg sm:rounded-2xl border-l-4 border-amber-500 stagger-2 opacity-0 animate-enter">
                <div class="flex items-start gap-4 mb-6 border-b border-gray-100 pb-4">
                    <div class="p-3 bg-amber-50 rounded-xl text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ __('Security') }}</h3>
                        <p class="text-sm text-gray-500">{{ __("Ensure your account is using a long, random password to stay secure.") }}</p>
                    </div>
                </div>

                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="settings-card p-4 sm:p-8 bg-white shadow-lg sm:rounded-2xl border-l-4 border-red-500 stagger-3 opacity-0 animate-enter">
                <div class="flex items-start gap-4 mb-6 border-b border-gray-100 pb-4">
                    <div class="p-3 bg-red-50 rounded-xl text-red-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ __('Danger Zone') }}</h3>
                        <p class="text-sm text-gray-500">{{ __("Once your account is deleted, all of its resources and data will be permanently deleted.") }}</p>
                    </div>
                </div>

                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>