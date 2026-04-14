<x-mail::message>
    # 🚨 EMERGENCY SOS ALERT 🚨

    **Attention!**

    Your child, **{{ $student->user->name }}**, has just activated their Emergency PANIC button from the EdFlow Family
    Tracker.

    **Time Triggered:**
    {{ $student->panic_triggered_at?->timezone('Asia/Kolkata')->format('l, d M Y - h:i A') ?? now()->timezone('Asia/Kolkata')->format('l, d M Y - h:i A') }}

    **Last Known GPS Coordinates:**
    - **Latitude:** {{ $student->panic_lat }}
    - **Longitude:** {{ $student->panic_lng }}

    <x-mail::button :url="'https://www.google.com/maps/search/?api=1&query=' . $student->panic_lat . ',' . $student->panic_lng" color="error">
        View Live Location on Google Maps
    </x-mail::button>

    Please try to contact your child immediately or alert the appropriate authorities if necessary.

    Stay Safe,<br>
    {{ config('EdFlow') }} Team
</x-mail::message>