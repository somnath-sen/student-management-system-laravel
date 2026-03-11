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
        z-index: 10; /* Keep it below dropdowns */
    }

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
                    
                    <button onclick="getLocation()" id="ping-btn" class="w-full py-3.5 bg-slate-900 hover:bg-rose-600 text-white rounded-xl font-bold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-satellite"></i> Ping My Location Now
                    </button>
                    <p id="geo-status" class="text-xs font-bold text-rose-500 mt-3 hidden"></p>
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
                            <p class="text-xs text-slate-500 mt-0.5">Last updated: {{ $student->location_updated_at->diffForHumans() }}</p>
                            <p class="text-[10px] text-slate-400 mt-1">{{ $student->location_updated_at->format('l, d F Y - h:i A') }}</p>
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

        <div class="lg:col-span-2 animate-enter stagger-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden h-full flex flex-col min-h-[500px] relative">
                
                @if($student->last_lat && $student->last_lng)
                    <div id="map" class="flex-1 w-full relative z-0"></div>
                    
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-xl shadow-lg border border-slate-200 z-[400] flex items-center gap-2">
                        <span class="flex h-2.5 w-2.5 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        </span>
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wide">Live GPS Signal</span>
                    </div>
                @else
                    <div class="flex-1 flex flex-col items-center justify-center p-8 text-center bg-slate-50 border-2 border-dashed border-slate-200 m-6 rounded-xl">
                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-slate-300 mb-4 shadow-sm">
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
            navigator.geolocation.getCurrentPosition(showPosition, showError, {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            });
        } else {
            status.innerHTML = "Geolocation is not supported by your browser.";
            status.classList.remove('hidden');
            resetButton(btn);
        }
    }

    function showPosition(position) {
        // Put the coordinates into the hidden form
        document.getElementById('lat-input').value = position.coords.latitude;
        document.getElementById('lng-input').value = position.coords.longitude;
        
        // Submit the form
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
                status.innerHTML = "Location information is unavailable.";
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

    // Map Initialization Logic (Only runs if coordinates exist in database)
    @if($student->last_lat && $student->last_lng)
        document.addEventListener('DOMContentLoaded', function() {
            var lat = {{ $student->last_lat }};
            var lng = {{ $student->last_lng }};
            
            // Initialize map and set center to student coordinates
            var map = L.map('map').setView([lat, lng], 16);

            // Load Premium English-forced Map Tiles (CartoDB Voyager)
            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors, © CARTO',
                subdomains: 'abcd'
            }).addTo(map);

            // Custom modern marker icon
            var customIcon = L.divIcon({
                className: 'custom-div-icon',
                html: "<div style='background-color:#e11d48; width:20px; height:20px; border-radius:50%; border:3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5);'></div>",
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            });

            // Add marker to map
            var marker = L.marker([lat, lng], {icon: customIcon}).addTo(map);
            
            // Add popup
            marker.bindPopup("<b>{{ $student->user->name }}</b><br>Last Known Safe Location").openPopup();
        });
    @endif
</script>

@endsection