@extends('layouts.student')

@section('title', 'Family Tracker GPS')

@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

<style>
    /* ── Fonts & Base ── */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
    .tracker-wrap { font-family: 'Inter', sans-serif; }

    /* ── Animations ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(22px); }
        to   { opacity: 1; transform: translateY(0);    }
    }
    @keyframes pulseRing {
        0%   { box-shadow: 0 0 0 0   rgba(244, 63, 94, 0.45); }
        70%  { box-shadow: 0 0 0 18px rgba(244, 63, 94, 0);   }
        100% { box-shadow: 0 0 0 0   rgba(244, 63, 94, 0);    }
    }
    @keyframes pingDot {
        0%,100% { transform: scale(1);   opacity: 1; }
        50%      { transform: scale(1.6); opacity: .5; }
    }

    .animate-enter { animation: fadeUp 0.6s cubic-bezier(0.2,0.8,0.2,1) both; }
    .stagger-1     { animation-delay: .10s; }
    .stagger-2     { animation-delay: .22s; }
    .stagger-3     { animation-delay: .34s; }

    .pulse-ring    { animation: pulseRing 2s cubic-bezier(0.4,0,0.6,1) infinite; }
    .ping-dot      { animation: pingDot 1.5s ease-in-out infinite; }

    /* ── Map ── */
    #map {
        height: 500px;
        width: 100%;
        border-radius: 0;
        z-index: 10;
    }

    /* ── Leaflet popup ── */
    .leaflet-popup-content-wrapper {
        border-radius: 14px;
        box-shadow: 0 12px 28px -8px rgba(0,0,0,.14);
    }
    .leaflet-popup-content {
        font-family: 'Inter', sans-serif;
        margin: 14px 18px;
    }

    /* ── Marker pulse ── */
    .marker-pulse {
        width: 20px; height: 20px;
        border-radius: 50%;
        background: #e11d48;
        border: 3px solid #fff;
        box-shadow: 0 0 0 0 rgba(225,29,72,.7);
        animation: pulseRing 2s infinite;
    }

    /* ── Attribution link ── */
    .attr-link { color: #3b82f6; text-decoration: underline; }
    .attr-link:hover { color: #1d4ed8; }
</style>

<div class="tracker-wrap min-h-screen bg-[#FDFBF7]">
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 pb-16">

    {{-- ── Header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 animate-enter gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-500 to-pink-600 flex items-center justify-center shadow-md shadow-rose-500/25">
                    <i class="fa-solid fa-location-dot text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-none">
                        Family Tracker <span class="text-rose-500">GPS</span>
                    </h1>
                    <p class="text-slate-500 text-sm font-medium mt-0.5">Securely broadcast your live location so your parents know you're safe.</p>
                </div>
            </div>
        </div>

        {{-- Live status pill --}}
        @if($student->last_lat && $student->last_lng)
        <div class="flex items-center gap-2 px-4 py-2 bg-emerald-50 border border-emerald-200 rounded-full self-start sm:self-auto">
            <span class="ping-dot w-2 h-2 rounded-full bg-emerald-500 flex-shrink-0"></span>
            <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Live Signal Active</span>
        </div>
        @else
        <div class="flex items-center gap-2 px-4 py-2 bg-amber-50 border border-amber-200 rounded-full self-start sm:self-auto">
            <span class="w-2 h-2 rounded-full bg-amber-400 flex-shrink-0"></span>
            <span class="text-xs font-bold text-amber-700 uppercase tracking-wider">Signal Offline</span>
        </div>
        @endif
    </div>

    {{-- ── Success toast ── --}}
    @if(session('success'))
    <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center gap-3 animate-enter shadow-sm">
        <div class="w-9 h-9 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
            <i class="fa-solid fa-satellite-dish text-emerald-600 animate-pulse"></i>
        </div>
        <span class="font-bold text-sm">{{ session('success') }}</span>
    </div>
    @endif

    {{-- ── Main Grid ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Sidebar ── --}}
        <div class="lg:col-span-1 space-y-5 animate-enter stagger-1">

            {{-- Location Broadcast Card --}}
            <div class="bg-white rounded-2xl border border-[#F0EBE1] shadow-sm overflow-hidden">

                {{-- Card header --}}
                <div class="px-5 py-4 border-b border-[#F0EBE1] bg-[#FDFBF7] flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                        <i class="fa-solid fa-street-view text-indigo-500 text-sm"></i>
                    </div>
                    <h2 class="text-sm font-bold text-slate-800">Location Broadcast</h2>
                </div>

                {{-- Ping area --}}
                <div class="p-6 text-center">
                    <div class="w-20 h-20 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-4 text-rose-500 pulse-ring">
                        <i class="fa-solid fa-location-dot text-3xl"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-1">Update Coordinates</h3>
                    <p class="text-xs text-slate-400 mb-5 leading-relaxed max-w-xs mx-auto">
                        Click below to let your browser fetch your exact GPS coordinates and update the map for your family.
                    </p>

                    <button onclick="getLocation()" id="ping-btn"
                            class="w-full py-3.5 bg-slate-900 hover:bg-slate-700 text-white rounded-xl font-bold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 mb-3 group">
                        <i class="fa-solid fa-satellite group-hover:animate-spin"></i>
                        Ping My Location Now
                    </button>

                    <p id="geo-status" class="text-xs font-semibold text-rose-500 mt-2 hidden leading-relaxed"></p>
                </div>

                {{-- SOS section --}}
                <div class="px-6 pb-6">
                    <div class="border-t border-[#F0EBE1] pt-5">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-center mb-4">
                            Emergency S.O.S
                        </p>

                        @if($student->is_panicking)
                            {{-- Panic active state --}}
                            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-center">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <span class="relative flex h-3 w-3">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                    </span>
                                    <span class="text-sm font-black text-red-700">PANIC ALERT ACTIVE</span>
                                </div>
                                <p class="text-xs text-red-500 mb-1">Your parents have been notified of your emergency.</p>
                                <p class="text-[10px] text-red-400">
                                    Triggered: {{ $student->panic_triggered_at?->timezone('Asia/Kolkata')->diffForHumans() ?? 'just now' }}
                                </p>
                            </div>
                            <button id="cancel-panic-btn" onclick="cancelPanic()"
                                    class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-black text-sm shadow-lg transition-all flex items-center justify-center gap-2">
                                <i class="fa-solid fa-shield-check"></i> I Am Safe — Cancel Alert
                            </button>
                        @else
                            {{-- Panic trigger button --}}
                            <button id="panic-btn" onclick="triggerPanic()"
                                    class="w-full py-4 bg-red-600 hover:bg-red-700 active:bg-red-800 text-white rounded-xl font-black text-base shadow-xl shadow-red-600/35 transition-all relative overflow-hidden group flex items-center justify-center gap-3"
                                    style="animation: pulseRing 2s infinite;">
                                <span class="relative z-10 flex items-center gap-3">
                                    <i class="fa-solid fa-exclamation-triangle text-lg"></i>
                                    <span>PANIC — Send SOS</span>
                                    <i class="fa-solid fa-bell text-lg"></i>
                                </span>
                                <div class="absolute inset-0 bg-white/10 scale-0 group-active:scale-100 transition-transform rounded-xl"></div>
                            </button>
                            <p class="text-[10px] text-slate-400 text-center mt-2 leading-relaxed">
                                Instantly alerts your parent with your GPS location
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Current Status Card --}}
            <div class="bg-white rounded-2xl border border-[#F0EBE1] shadow-sm p-5 animate-enter stagger-2">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Current Status</p>

                @if($student->last_lat && $student->last_lng)
                    <div class="flex items-start gap-3 mb-4">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 border border-emerald-100">
                            <i class="fa-solid fa-check text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">Location Active</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $student->location_updated_at->timezone('Asia/Kolkata')->diffForHumans() }}</p>
                            <p class="text-[10px] text-slate-400 mt-1 font-semibold">
                                {{ $student->location_updated_at->timezone('Asia/Kolkata')->format('l, d M Y — h:i A') }}
                            </p>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-100 text-xs font-mono text-slate-500 space-y-0.5">
                        <p><span class="text-slate-400">Lat:</span> {{ $student->last_lat }}</p>
                        <p><span class="text-slate-400">Lng:</span> {{ $student->last_lng }}</p>
                    </div>
                @else
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center flex-shrink-0 border border-amber-100">
                            <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">No Data Available</p>
                            <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">You haven't pinged your location yet. Map is currently offline.</p>
                        </div>
                    </div>
                @endif
            </div>

        </div>

        {{-- ── Map Column ── --}}
        <div class="lg:col-span-2 animate-enter stagger-2">
            <div class="bg-white rounded-2xl border border-[#F0EBE1] shadow-sm overflow-hidden relative" style="min-height: 480px;">

                @if($student->last_lat && $student->last_lng)

                    {{-- Map fills the card --}}
                    <div id="map" class="w-full" style="height:500px; z-index:10;"></div>

                    {{-- Live badge --}}
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-full shadow-md border border-white/60 z-[400] flex items-center gap-2">
                        <span class="ping-dot w-2 h-2 rounded-full bg-emerald-500 flex-shrink-0"></span>
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wide">Live GPS</span>
                    </div>

                    {{-- Google Maps attribution overlay (bottom of map) --}}
                    <div class="absolute bottom-0 inset-x-0 z-[400] px-4 py-2.5 bg-gradient-to-t from-black/30 to-transparent pointer-events-none">
                        <p class="text-white/80 text-[10px] font-medium text-right pointer-events-auto">
                            Map data &copy; <a href="https://www.google.com/maps" target="_blank" rel="noopener noreferrer"
                                class="underline hover:text-white transition-colors">Google Maps</a>
                            &nbsp;|&nbsp; Imagery &copy; {{ date('Y') }} Google
                        </p>
                    </div>

                @else
                    <div class="absolute inset-0 flex flex-col items-center justify-center p-8 text-center bg-[#FDFBF7]">
                        <div class="w-20 h-20 bg-white rounded-2xl flex items-center justify-center text-slate-300 mb-4 shadow-sm border border-[#F0EBE1]">
                            <i class="fa-solid fa-map-location-dot text-4xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-700">Map Offline</h3>
                        <p class="text-sm text-slate-400 mt-2 max-w-xs leading-relaxed">
                            Click <strong class="text-slate-600">Ping My Location Now</strong> to activate the satellite map and log your coordinates.
                        </p>
                    </div>
                @endif

            </div>

            {{-- ── Google Maps Thank-you & Attribution Card ── --}}
            <div class="mt-4 p-4 bg-white border border-[#F0EBE1] rounded-2xl shadow-sm animate-enter stagger-3">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">

                    {{-- Google Maps icon --}}
                    <div class="flex-shrink-0 flex items-center justify-center w-11 h-11 rounded-xl bg-blue-50 border border-blue-100">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z" fill="#4285F4"/>
                        </svg>
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-slate-700 text-sm font-semibold mb-0.5">
                            🗺️ Powered by Google Maps
                        </p>
                        <p class="text-slate-400 text-xs leading-relaxed">
                            Map tiles and satellite imagery are provided by
                            <a href="https://www.google.com/maps" target="_blank" rel="noopener noreferrer" class="attr-link font-semibold">Google Maps</a>.
                            We are grateful to Google for their high-accuracy mapping services that power this feature.
                            Map data &copy; {{ date('Y') }}
                            <a href="https://www.google.com/intl/en/about/products" target="_blank" rel="noopener noreferrer" class="attr-link">Google</a>.
                            All rights reserved.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ── Footer Copyright ── --}}
    <div class="mt-8 text-center animate-enter stagger-3">
        <p class="text-xs text-slate-400 font-medium">
            &copy; {{ date('Y') }} EdFlow Campus Management System. All rights reserved.
        </p>
        <p class="text-[11px] text-slate-300 mt-1">
            Map tiles &copy; <a href="https://www.google.com/maps" target="_blank" rel="noopener" class="hover:text-slate-400 transition-colors underline">Google Maps</a>
            &nbsp;&middot;&nbsp;
            Location data is encrypted and only shared with authorised family members.
        </p>
    </div>

</div>
</div>

{{-- Hidden form for location submission --}}
<form id="location-form" action="{{ route('student.location.update') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="lat" id="lat-input">
    <input type="hidden" name="lng" id="lng-input">
</form>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    // ── Geolocation ──────────────────────────────────────────────────
    function getLocation() {
        const btn    = document.getElementById('ping-btn');
        const status = document.getElementById('geo-status');

        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Acquiring Satellite Lock…';
        btn.disabled  = true;
        status.classList.add('hidden');

        if (!navigator.geolocation) {
            status.innerHTML = 'Geolocation is not supported by your browser.';
            status.classList.remove('hidden');
            resetButton(btn);
            return;
        }

        navigator.geolocation.getCurrentPosition(showPosition, showError, {
            enableHighAccuracy: true,
            timeout: 15000,
            maximumAge: 0
        });
    }

    function showPosition(position) {
        document.getElementById('lat-input').value = position.coords.latitude;
        document.getElementById('lng-input').value = position.coords.longitude;
        document.getElementById('location-form').submit();
    }

    function showError(error) {
        const btn    = document.getElementById('ping-btn');
        const status = document.getElementById('geo-status');
        const msgs   = {
            [error.PERMISSION_DENIED]:      'Location denied — please allow access in your browser settings.',
            [error.POSITION_UNAVAILABLE]:   'Location unavailable. Are you on a desktop without GPS?',
            [error.TIMEOUT]:                'GPS request timed out. Please try again.',
            [error.UNKNOWN_ERROR]:          'An unknown error occurred.',
        };
        status.innerHTML = msgs[error.code] || 'An error occurred.';
        status.classList.remove('hidden');
        resetButton(btn);
    }

    function resetButton(btn) {
        btn.innerHTML = '<i class="fa-solid fa-satellite"></i> Ping My Location Now';
        btn.disabled  = false;
    }

    // ── Map Init ─────────────────────────────────────────────────────
    @if($student->last_lat && $student->last_lng)
    document.addEventListener('DOMContentLoaded', function () {
        var lat = {{ floatval($student->last_lat) }};
        var lng = {{ floatval($student->last_lng) }};

        var map = L.map('map', { zoomControl: false }).setView([lat, lng], 17);

        // Google Maps standard tile layer — with OSM fallback if blocked
        var googleLayer = L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            attribution: 'Map data &copy; <a href="https://www.google.com/maps" target="_blank">Google Maps</a>'
        });

        var osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });

        // Try Google first; fall back to OSM after 5 s if no tiles load
        googleLayer.addTo(map);
        var googleLoaded = false;
        googleLayer.on('tileload', function() { googleLoaded = true; });
        setTimeout(function() {
            if (!googleLoaded) {
                map.removeLayer(googleLayer);
                osmLayer.addTo(map);
            }
        }, 5000);

        // Custom zoom control (top-left)
        L.control.zoom({ position: 'topleft' }).addTo(map);

        // Pulsing marker — inline styles for reliable rendering in Leaflet DivIcon
        var customIcon = L.divIcon({
            className: 'custom-div-icon',
            html: "<div style='background-color:#e11d48; width:22px; height:22px; border-radius:50%; border:3px solid white; box-shadow:0 0 0 0 rgba(225,29,72,0.7); animation:pulseRing 2s infinite;'></div>",
            iconSize:   [22, 22],
            iconAnchor: [11, 11],
            popupAnchor:[0, -14]
        });

        var marker = L.marker([lat, lng], { icon: customIcon }).addTo(map);

        marker.bindPopup(`
            <div style="text-align:center; min-width:140px;">
                <p style="font-weight:800; font-size:13px; color:#0f172a; margin:0 0 4px;">{{ $student->user->name }}</p>
                <p style="font-size:11px; color:#64748b; margin:0 0 6px;">Last Known Safe Location</p>
                <p style="font-size:10px; color:#94a3b8; font-weight:600; margin:0;">
                    {{ $student->location_updated_at?->timezone('Asia/Kolkata')->format('d M Y, h:i A') ?? '' }}
                </p>
            </div>`).openPopup();

        // Force map to recalculate size — critical for absolute/flex containers
        setTimeout(() => map.invalidateSize(), 100);
        setTimeout(() => map.invalidateSize(), 500);
    });
    @endif
</script>

<script>
    // ── Panic / SOS ──────────────────────────────────────────────────
    function triggerPanic() {
        const btn = document.getElementById('panic-btn');
        if (!btn) return;

        if (!confirm('⚠️ EMERGENCY ALERT\n\nThis will instantly notify your parent with your live GPS location.\n\nPress OK only if you are in a real emergency.')) return;

        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Acquiring GPS & Alerting…';
        btn.disabled  = true;

        if (!navigator.geolocation) {
            alert('GPS not available on this device.');
            btn.disabled  = false;
            btn.innerHTML = '<i class="fa-solid fa-exclamation-triangle text-lg"></i><span>PANIC — Send SOS</span><i class="fa-solid fa-bell text-lg"></i>';
            return;
        }

        navigator.geolocation.getCurrentPosition(function (position) {
            fetch('{{ route("student.location.panic") }}', {
                method: 'POST',
                headers: {
                    'Content-Type':  'application/json',
                    'X-CSRF-TOKEN':  '{{ csrf_token() }}',
                    'Accept':        'application/json',
                },
                body: JSON.stringify({ lat: position.coords.latitude, lng: position.coords.longitude })
            })
            .then(r => r.json())
            .then(data => { if (data.status === 'panic_activated') window.location.reload(); })
            .catch(() => {
                alert('Failed to send SOS. Please check your internet connection.');
                btn.disabled = false;
            });
        }, function (err) {
            alert('Could not get GPS location: ' + err.message + '\nPlease allow location access.');
            btn.disabled  = false;
            btn.innerHTML = '<i class="fa-solid fa-exclamation-triangle text-lg"></i><span>PANIC — Send SOS</span><i class="fa-solid fa-bell text-lg"></i>';
        }, { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 });
    }

    function cancelPanic() {
        const btn = document.getElementById('cancel-panic-btn');
        if (btn) {
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Cancelling Alert…';
            btn.disabled  = true;
        }

        fetch('{{ route("student.location.cancel-panic") }}', {
            method: 'POST',
            headers: {
                'Content-Type':  'application/json',
                'X-CSRF-TOKEN':  '{{ csrf_token() }}',
                'Accept':        'application/json',
            }
        })
        .then(r => r.json())
        .then(data => { if (data.status === 'panic_cancelled') window.location.reload(); })
        .catch(() => alert('Failed to cancel alert. Please try again.'));
    }
</script>

@endsection