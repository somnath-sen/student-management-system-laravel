@extends('layouts.student')

@section('title', 'Family Tracker')

@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

<style>
    .animate-enter { animation: fadeUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; transform: translateY(20px); }
    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }
    
    #map {
        height: 500px;
        width: 100%;
        border-radius: 1rem;
        z-index: 10; 
    }

    /* Ensure the Leaflet popup looks modern */
    .leaflet-popup-content-wrapper { border-radius: 12px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); }
    .leaflet-popup-content { font-family: 'Plus Jakarta Sans', sans-serif; margin: 14px 20px; }

    .pulse-ring {
        animation: pulsing 2s infinite;
    }
    @keyframes pulsing {
        0% { box-shadow: 0 0 0 0 rgba(244, 63, 94, 0.4); }
        70% { box-shadow: 0 0 0 15px rgba(244, 63, 94, 0); }
        100% { box-shadow: 0 0 0 0 rgba(244, 63, 94, 0); }
    }
</style>

<div class="max-w-6xl mx-auto">

    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 animate-enter">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Family Tracker <span class="text-rose-500">GPS</span></h1>
            <p class="text-slate-500 mt-1 font-medium">Securely ping your live location so your parents know you are safe.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center gap-3 animate-enter">
            <i class="fa-solid fa-satellite-dish text-xl animate-pulse"></i>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1 space-y-6 animate-enter stagger-1">
            
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-street-view text-indigo-500"></i> Location Broadcast
                    </h2>
                </div>
                
                <div class="p-6 text-center">
                    <div class="w-20 h-20 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-4 text-rose-500 pulse-ring">
                        <i class="fa-solid fa-location-dot text-3xl"></i>
                    </div>
                    
                    <h3 class="font-bold text-slate-900 text-lg mb-1">Update Coordinates</h3>
                    <p class="text-sm text-slate-500 mb-6">Click the button below to allow your browser to fetch your exact GPS coordinates and update the map.</p>
                    
                    <button onclick="getLocation()" id="ping-btn" class="w-full py-3.5 bg-slate-900 hover:bg-slate-700 text-white rounded-xl font-bold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 mb-3">
                        <i class="fa-solid fa-satellite"></i> Ping My Location Now
                    </button>
                    <p id="geo-status" class="text-xs font-bold text-rose-500 mt-3 hidden"></p>
                </div>

                <!-- SOS PANIC BUTTON SECTION -->
                <div class="px-6 pb-6">
                    <div class="border-t border-slate-100 pt-5">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-center mb-3">Emergency S.O.S</p>
                        
                        @if($student->is_panicking)
                            <!-- Cancel panic state -->
                            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-center">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <span class="relative flex h-3 w-3">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                    </span>
                                    <span class="text-sm font-black text-red-700">PANIC ALERT ACTIVE</span>
                                </div>
                                <p class="text-xs text-red-500 mb-1">Your parents have been notified of your emergency.</p>
                                <p class="text-[10px] text-red-400">Triggered: {{ $student->panic_triggered_at?->timezone('Asia/Kolkata')->diffForHumans() ?? 'just now' }}</p>
                            </div>
                            <button id="cancel-panic-btn" onclick="cancelPanic()" 
                                class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-black text-sm shadow-lg transition-all flex items-center justify-center gap-2">
                                <i class="fa-solid fa-shield-check"></i> I Am Safe — Cancel Alert
                            </button>
                        @else
                            <!-- Trigger panic -->
                            <button id="panic-btn" onclick="triggerPanic()"
                                class="w-full py-4 bg-red-600 hover:bg-red-700 active:bg-red-800 text-white rounded-xl font-black text-base shadow-xl shadow-red-600/40 transition-all relative overflow-hidden group flex items-center justify-center gap-3"
                                style="animation: pulsing 2s infinite;">
                                <span class="relative z-10 flex items-center gap-3">
                                    <i class="fa-solid fa-exclamation-triangle text-lg"></i>
                                    <span>PANIC — Send SOS</span>
                                    <i class="fa-solid fa-bell text-lg"></i>
                                </span>
                                <div class="absolute inset-0 bg-white/10 scale-0 group-active:scale-100 transition-transform rounded-xl"></div>
                            </button>
                            <p class="text-[10px] text-slate-400 text-center mt-2">Instantly alerts your parent with your GPS location</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-wider mb-4">Current Status</h3>
                
                @if($student->last_lat && $student->last_lng)
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">Location Active</p>
                            <p class="text-xs text-slate-500 mt-0.5">Last updated: {{ $student->location_updated_at->timezone('Asia/Kolkata')->diffForHumans() }}</p>
                            <p class="text-[10px] text-slate-400 mt-1 font-semibold">{{ $student->location_updated_at->timezone('Asia/Kolkata')->format('l, d M Y - h:i A') }}</p>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-100 text-xs font-mono text-slate-600 break-all">
                        Lat: {{ $student->last_lat }}<br>
                        Lng: {{ $student->last_lng }}
                    </div>
                @else
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">No Data Available</p>
                            <p class="text-xs text-slate-500 mt-0.5">You have not pinged your location yet. Map is currently offline.</p>
                        </div>
                    </div>
                @endif
            </div>

        </div>

        <div class="lg:col-span-2 animate-enter stagger-2 relative">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden h-full relative" style="min-height: 500px;">
                
                @if($student->last_lat && $student->last_lng)
                    <div id="map" class="w-full absolute inset-0 z-0" style="height: 100%; min-height: 500px;"></div>
                    
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-xl shadow-lg border border-slate-200 z-[400] flex items-center gap-2">
                        <span class="flex h-2.5 w-2.5 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        </span>
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wide">Live GPS Signal</span>
                    </div>
                @else
                    <div class="absolute inset-0 flex flex-col items-center justify-center p-8 text-center bg-slate-50">
                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-slate-300 mb-4 shadow-sm border border-slate-100">
                            <i class="fa-solid fa-map-location-dot text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-700">Map Offline</h3>
                        <p class="text-sm text-slate-500 mt-2 max-w-sm">Click the ping button on the left to activate the satellite map and log your current coordinates.</p>
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>

<form id="location-form" action="{{ route('student.location.update') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="lat" id="lat-input">
    <input type="hidden" name="lng" id="lng-input">
</form>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    // Geolocation Logic
    function getLocation() {
        const btn = document.getElementById('ping-btn');
        const status = document.getElementById('geo-status');
        
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Acquiring Satellite Lock...';
        btn.disabled = true;
        btn.classList.replace('hover:bg-rose-600', 'opacity-70');
        status.classList.add('hidden');

        if (navigator.geolocation) {
            // FORCED STRICT ACCURACY: This forces the browser to use raw GPS rather than IP address
            navigator.geolocation.getCurrentPosition(showPosition, showError, {
                enableHighAccuracy: true,
                timeout: 15000, // 15 seconds to lock onto satellites
                maximumAge: 0 // Do not use cached locations
            });
        } else {
            status.innerHTML = "Geolocation is not supported by your browser.";
            status.classList.remove('hidden');
            resetButton(btn);
        }
    }

    function showPosition(position) {
        document.getElementById('lat-input').value = position.coords.latitude;
        document.getElementById('lng-input').value = position.coords.longitude;
        document.getElementById('location-form').submit();
    }

    function showError(error) {
        const btn = document.getElementById('ping-btn');
        const status = document.getElementById('geo-status');
        
        switch(error.code) {
            case error.PERMISSION_DENIED:
                status.innerHTML = "Request denied. Please allow location access in your browser settings.";
                break;
            case error.POSITION_UNAVAILABLE:
                status.innerHTML = "Location information is unavailable. Are you on a desktop without GPS?";
                break;
            case error.TIMEOUT:
                status.innerHTML = "The request to get user location timed out.";
                break;
            case error.UNKNOWN_ERROR:
                status.innerHTML = "An unknown error occurred.";
                break;
        }
        status.classList.remove('hidden');
        resetButton(btn);
    }

    function resetButton(btn) {
        btn.innerHTML = '<i class="fa-solid fa-satellite"></i> Ping My Location Now';
        btn.disabled = false;
        btn.classList.replace('opacity-70', 'hover:bg-rose-600');
    }

    // Map Initialization Logic
    @if($student->last_lat && $student->last_lng)
        document.addEventListener('DOMContentLoaded', function() {
            var lat = {{ floatval($student->last_lat) }};
            var lng = {{ floatval($student->last_lng) }};
            
            // Initialize map with closer zoom for exact street tracking
            var map = L.map('map').setView([lat, lng], 17);

            // BULLETPROOF MAP LAYER: Google Maps Standard Tiles (Extreme accuracy, deep zoom, English labels)
            L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                attribution: '© Google Maps'
            }).addTo(map);

            // Custom modern marker icon
            var customIcon = L.divIcon({
                className: 'custom-div-icon',
                html: "<div style='background-color:#e11d48; width:22px; height:22px; border-radius:50%; border:3px solid white; box-shadow: 0 0 15px rgba(225,29,72,0.8);'></div>",
                iconSize: [22, 22],
                iconAnchor: [11, 11]
            });

            // Add marker to map
            var marker = L.marker([lat, lng], {icon: customIcon}).addTo(map);
            
            // Add popup
            marker.bindPopup("<div class='text-center mb-1'><b>{{ $student->user->name }}</b></div><div class='text-xs text-gray-500'>Last Known Safe Location</div>").openPopup();
            
            // Force Leaflet to recalculate the map size after a tiny delay 
            setTimeout(function() {
                map.invalidateSize();
            }, 250);
        });
    @endif
</script>

<script>
    // ── PANIC / SOS Functions ──────────────────────────────────────
    function triggerPanic() {
        const btn = document.getElementById('panic-btn');
        if (!btn) return;

        // Show a confirmation warning (safety against accidental press)
        if (!confirm('⚠️ EMERGENCY ALERT\n\nThis will instantly notify your parent with your live GPS location.\n\nPress OK only if you are in a real emergency.')) return;

        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Acquiring GPS & Alerting...';
        btn.disabled = true;

        if (!navigator.geolocation) {
            alert('GPS not available on this device.');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-exclamation-triangle text-lg"></i><span>PANIC — Send SOS</span><i class="fa-solid fa-bell text-lg"></i>';
            return;
        }

        navigator.geolocation.getCurrentPosition(function(position) {
            fetch('{{ route("student.location.panic") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'panic_activated') {
                    // Reload so the page shows "PANIC ACTIVE" + Cancel button
                    window.location.reload();
                }
            })
            .catch(() => {
                alert('Failed to send SOS. Please check your internet connection.');
                btn.disabled = false;
            });
        }, function(err) {
            alert('Could not get GPS location: ' + err.message + '\nPlease allow location access.');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-exclamation-triangle text-lg"></i><span>PANIC — Send SOS</span><i class="fa-solid fa-bell text-lg"></i>';
        }, {
            enableHighAccuracy: true,
            timeout: 15000,
            maximumAge: 0
        });
    }

    function cancelPanic() {
        const btn = document.getElementById('cancel-panic-btn');
        if (btn) {
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Cancelling Alert...';
            btn.disabled = true;
        }

        fetch('{{ route("student.location.cancel-panic") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'panic_cancelled') {
                window.location.reload();
            }
        })
        .catch(() => alert('Failed to cancel alert. Please try again.'));
    }
</script>

@endsection