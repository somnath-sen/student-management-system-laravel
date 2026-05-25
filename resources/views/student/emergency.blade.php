@extends('layouts.student')

@section('title', 'Emergency Assistance')

@section('content')

<style>
    /* ================= FONTS & BASE ================= */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
    .emergency-wrap { font-family: 'Inter', sans-serif; }

    /* ================= ANIMATIONS ================= */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes pulseRing {
        0%   { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.55); }
        70%  { box-shadow: 0 0 0 22px rgba(220, 38, 38, 0); }
        100% { box-shadow: 0 0 0 0   rgba(220, 38, 38, 0); }
    }
    @keyframes shimmer {
        0%   { background-position: -600px 0; }
        100% { background-position:  600px 0; }
    }
    @keyframes spinOnce {
        from { transform: rotate(0deg); }
        to   { transform: rotate(360deg); }
    }

    .animate-enter   { animation: fadeUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) both; }
    .stagger-1       { animation-delay: 0.10s; }
    .stagger-2       { animation-delay: 0.20s; }
    .stagger-3       { animation-delay: 0.32s; }

    .pulse-ring      { animation: pulseRing 2s cubic-bezier(0.4,0,0.6,1) infinite; }

    /* Skeleton shimmer */
    .skeleton-line {
        background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
        background-size: 600px 100%;
        animation: shimmer 1.4s infinite linear;
        border-radius: 6px;
    }

    /* Result card hover lift */
    .result-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .result-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px -8px rgba(0,0,0,0.10);
    }

    /* Spinning GPS icon when loading */
    .spin { animation: spinOnce 0.9s ease-in-out; }

    /* OSM attribution link */
    .osm-link { color: #3b82f6; text-decoration: underline; }
    .osm-link:hover { color: #1d4ed8; }
</style>

<div class="emergency-wrap min-h-screen bg-[#FDFBF7]">
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-8 pb-16">

    {{-- ── Header ── --}}
    <div class="text-center mb-10 animate-enter">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-red-500 to-rose-600 shadow-lg shadow-red-500/30 mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Emergency Assistance</h1>
        <p class="text-slate-500 mt-2 text-base max-w-md mx-auto leading-relaxed">
            Instantly find nearby hospitals &amp; police stations, or call the national emergency line.
        </p>
    </div>

    {{-- ── Top Action Cards ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8 animate-enter stagger-1">

        {{-- GPS Finder Card --}}
        <div class="bg-white rounded-2xl border border-[#F0EBE1] shadow-sm p-5 flex flex-col gap-4">

            {{-- Search radius selector --}}
            <div class="flex items-center justify-between gap-3">
                <label for="search-radius" class="text-slate-700 font-semibold text-sm whitespace-nowrap">Search Range</label>
                <select id="search-radius"
                        onchange="if(userLat) fetchAllServices()"
                        class="flex-1 bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-2 focus:ring-red-400 focus:border-red-400 p-2.5 font-semibold cursor-pointer outline-none transition">
                    <option value="0.045">5 km</option>
                    <option value="0.09" selected>10 km</option>
                    <option value="0.135">15 km</option>
                    <option value="0.18">20 km</option>
                </select>
            </div>

            {{-- GPS Button --}}
            <button onclick="initLocationSearch()" id="locate-btn"
                    class="group relative flex flex-col items-center justify-center gap-3 p-6 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl hover:border-red-400 hover:bg-red-50 transition-all duration-300 cursor-pointer flex-grow">
                <div id="gps-icon-wrap"
                     class="w-14 h-14 rounded-full bg-white border border-slate-100 shadow-sm flex items-center justify-center text-slate-400 group-hover:text-red-500 group-hover:border-red-200 group-hover:shadow-md transition-all">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="text-center">
                    <p class="text-slate-800 font-bold text-base">Find Nearby Help</p>
                    <p class="text-slate-400 text-xs mt-0.5" id="status-msg">Tap to use your GPS location</p>
                </div>
            </button>
        </div>

        {{-- Emergency Call Card --}}
        <a href="tel:112"
           class="pulse-ring flex flex-col items-center justify-center gap-4 p-8 bg-gradient-to-br from-red-500 to-rose-600 rounded-2xl shadow-xl shadow-red-500/30 hover:from-red-600 hover:to-rose-700 transition-all duration-300 text-white group">
            <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center group-hover:bg-white/30 transition-colors">
                <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
            </div>
            <div class="text-center">
                <p class="text-4xl font-black tracking-widest leading-none">112</p>
                <p class="text-red-100 text-sm font-semibold mt-1">National Emergency Hotline</p>
                <p class="text-red-200 text-xs mt-0.5">Tap to call immediately</p>
            </div>
        </a>
    </div>

    {{-- ── Results Section ── --}}
    <div id="results-container" class="hidden animate-enter stagger-2">

        {{-- Section header --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-2">
                <span class="text-lg font-extrabold text-slate-800">📍 Nearby Results</span>
                <span id="radius-display"
                      class="text-xs font-bold text-slate-500 bg-slate-100 border border-slate-200 px-3 py-1 rounded-full"></span>
            </div>
            <button onclick="fetchAllServices()"
                    class="text-xs font-bold text-indigo-600 hover:text-white hover:bg-indigo-600 border border-indigo-200 hover:border-indigo-600 px-3 py-1.5 rounded-full transition-all flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Refresh
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- Hospitals --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-xl bg-emerald-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-800 text-base">Nearby Hospitals</h3>
                </div>
                <div id="hospital-results" class="space-y-3"></div>
            </div>

            {{-- Police Stations --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-800 text-base">Nearby Police Stations</h3>
                </div>
                <div id="police-results" class="space-y-3"></div>
            </div>
        </div>

        {{-- ── OpenStreetMap Attribution & Thank-you Note ── --}}
        <div class="mt-10 p-5 bg-white border border-[#F0EBE1] rounded-2xl shadow-sm animate-enter stagger-3">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4">

                {{-- OSM Logo placeholder --}}
                <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-xl bg-[#7EBC6F]/10 border border-[#7EBC6F]/20">
                    <svg class="w-7 h-7 text-[#7EBC6F]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z"/>
                    </svg>
                </div>

                <div class="flex-1 min-w-0">
                    <p class="text-slate-700 text-sm font-semibold mb-1">
                        🗺️ Powered by OpenStreetMap &amp; Nominatim
                    </p>
                    <p class="text-slate-500 text-xs leading-relaxed">
                        Location search data is provided by
                        <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener noreferrer" class="osm-link font-semibold">OpenStreetMap</a>
                        contributors, licensed under the
                        <a href="https://opendatacommons.org/licenses/odbl/" target="_blank" rel="noopener noreferrer" class="osm-link">ODbL</a>.
                        Geocoding is powered by
                        <a href="https://nominatim.org" target="_blank" rel="noopener noreferrer" class="osm-link font-semibold">Nominatim</a>.
                        We are grateful to the global OSM community for making open geospatial data freely available.
                    </p>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Page Footer Copyright ── --}}
    <div class="mt-10 text-center animate-enter stagger-3">
        <p class="text-xs text-slate-400 font-medium">
            &copy; {{ date('Y') }} EdFlow Campus Management System. All rights reserved.
        </p>
        <p class="text-[11px] text-slate-300 mt-1">
            Map data &copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener" class="hover:text-slate-400 transition-colors underline">OpenStreetMap</a> contributors
        </p>
    </div>

</div>
</div>

<script>
    let userLat = null;
    let userLon = null;

    // ── Haversine distance (km) ──
    function getDistance(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat/2) ** 2 +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLon/2) ** 2;
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    }

    // ── Init GPS ──
    function initLocationSearch() {
        const statusMsg  = document.getElementById('status-msg');
        const gpsWrap    = document.getElementById('gps-icon-wrap');

        if (!navigator.geolocation) {
            alert('Geolocation is not supported by your browser.');
            return;
        }

        statusMsg.innerHTML = '<span class="animate-pulse font-semibold text-amber-500">Acquiring GPS coordinates…</span>';
        gpsWrap.classList.add('spin');

        navigator.geolocation.getCurrentPosition(
            (pos) => {
                userLat = pos.coords.latitude;
                userLon = pos.coords.longitude;

                gpsWrap.classList.remove('spin');
                statusMsg.innerHTML = '<span class="text-emerald-600 font-semibold">✓ Location locked — searching…</span>';
                document.getElementById('results-container').classList.remove('hidden');
                fetchAllServices();
            },
            (err) => {
                gpsWrap.classList.remove('spin');
                statusMsg.innerHTML = '<span class="text-red-500 font-bold">⚠ Location denied. Please enable GPS.</span>';
            },
            { enableHighAccuracy: true, timeout: 15000 }
        );
    }

    // ── Fetch both service types ──
    function fetchAllServices() {
        if (!userLat || !userLon) return;

        const sel        = document.getElementById('search-radius');
        const offset     = parseFloat(sel.value);
        const radiusText = sel.options[sel.selectedIndex].text;

        document.getElementById('radius-display').innerText = 'Within ' + radiusText;

        const box = {
            left:   userLon - offset,
            top:    userLat + offset,
            right:  userLon + offset,
            bottom: userLat - offset
        };

        fetchNominatim('hospital', 'hospital-results', box, 'emerald');
        fetchNominatim('police',   'police-results',   box, 'blue');
    }

    // ── Query Nominatim & render results ──
    async function fetchNominatim(queryType, containerId, box, color) {
        const container = document.getElementById(containerId);

        // Skeleton loader
        container.innerHTML = ['', '', ''].map(() => `
            <div class="bg-white rounded-xl border border-slate-100 p-4 space-y-2">
                <div class="skeleton-line h-4 w-3/4"></div>
                <div class="skeleton-line h-3 w-full"></div>
                <div class="skeleton-line h-3 w-5/6"></div>
                <div class="skeleton-line h-8 w-full mt-2 rounded-lg"></div>
            </div>`).join('');

        const url = `https://nominatim.openstreetmap.org/search?format=json&q=${queryType}&limit=5` +
                    `&viewbox=${box.left},${box.top},${box.right},${box.bottom}&bounded=1` +
                    `&accept-language=en`;

        try {
            const res  = await fetch(url, { headers: { 'Accept-Language': 'en' } });
            const data = await res.json();
            container.innerHTML = '';

            if (!data || data.length === 0) {
                container.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-10 bg-white rounded-xl border border-dashed border-slate-200 text-center">
                        <svg class="w-10 h-10 text-slate-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-slate-500 text-sm font-semibold">No ${queryType}s found</p>
                        <p class="text-slate-400 text-xs mt-1">Try increasing the search range.</p>
                    </div>`;
                return;
            }

            // Sort by distance
            const sorted = data.map(item => ({
                ...item,
                distance: getDistance(userLat, userLon, parseFloat(item.lat), parseFloat(item.lon))
            })).sort((a, b) => a.distance - b.distance);

            const colorMap = {
                emerald: { badge: 'bg-emerald-50 text-emerald-700 border-emerald-100', btn: 'bg-emerald-600 hover:bg-emerald-700' },
                blue:    { badge: 'bg-blue-50 text-blue-700 border-blue-100',         btn: 'bg-blue-600 hover:bg-blue-700'     },
            };
            const c = colorMap[color] || colorMap['blue'];

            sorted.forEach((place, idx) => {
                const distDisplay = place.distance < 1
                    ? (place.distance * 1000).toFixed(0) + ' m'
                    : place.distance.toFixed(1) + ' km';
                const mapLink  = `https://www.google.com/maps/dir/?api=1&destination=${place.lat},${place.lon}`;
                const cleanName = (place.name || place.display_name).split(',')[0];
                const address   = place.display_name.split(',').slice(1, 3).join(',').trim();

                container.insertAdjacentHTML('beforeend', `
                    <div class="result-card bg-white rounded-xl border border-slate-100 shadow-sm p-4"
                         style="animation: fadeUp 0.4s ${idx * 80}ms cubic-bezier(0.2,0.8,0.2,1) both;">
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-slate-900 text-sm truncate">${cleanName}</h4>
                                <p class="text-xs text-slate-400 mt-0.5 line-clamp-2 leading-relaxed">${address || place.display_name}</p>
                            </div>
                            <span class="flex-shrink-0 text-xs font-bold px-2.5 py-1 rounded-full border ${c.badge}">
                                ${distDisplay}
                            </span>
                        </div>
                        <a href="${mapLink}" target="_blank" rel="noopener noreferrer"
                           class="flex items-center justify-center gap-2 w-full text-white text-xs font-bold py-2.5 rounded-xl ${c.btn} transition-colors shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            Get Directions
                        </a>
                    </div>`);
            });

        } catch (err) {
            console.error(err);
            container.innerHTML = `
                <div class="bg-red-50 border border-red-100 rounded-xl p-4 text-center">
                    <p class="text-red-500 text-sm font-semibold">Failed to load data</p>
                    <p class="text-red-400 text-xs mt-1">Check your internet connection and try again.</p>
                </div>`;
        }
    }
</script>

@endsection