@extends('layouts.teacher')

@section('title', 'Emergency Assistance')

@section('content')

<style>
    /* ================= ANIMATIONS ================= */
    .animate-enter {
        animation: fadeUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }

    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }

    /* SOS Button Pulse Animation */
    .pulse-animation {
        animation: pulse-red 2s infinite;
    }
    @keyframes pulse-red {
        0% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.7); }
        70% { box-shadow: 0 0 0 20px rgba(220, 38, 38, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); }
    }
</style>

<div class="max-w-4xl mx-auto">

    <div class="text-center mb-8 animate-enter">
        <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight flex items-center justify-center gap-3">
            <span class="text-4xl">🚨</span> Emergency Assistance
        </h1>
        <p class="text-gray-500 mt-2 text-lg">
            Quick access to emergency contacts and nearby safe locations.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12 animate-enter stagger-1">
        
        <div class="flex flex-col gap-4">
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <label for="search-radius" class="text-gray-700 font-bold text-sm">Search Radius:</label>
                <select id="search-radius" onchange="if(userLat) fetchAllServices()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block p-2.5 font-semibold cursor-pointer">
                    <option value="5000">5 km</option>
                    <option value="10000" selected>10 km</option>
                    <option value="15000">15 km</option>
                    <option value="20000">20 km</option>
                </select>
            </div>

            <button onclick="initLocationSearch()" id="locate-btn" class="group relative flex flex-col items-center justify-center p-6 bg-white border-2 border-red-100 rounded-2xl shadow-lg hover:border-red-500 hover:shadow-xl transition-all duration-300 flex-grow cursor-pointer">
                <div class="p-3 bg-red-50 text-red-600 rounded-full mb-3 group-hover:bg-red-600 group-hover:text-white transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Find Nearby Help</h3>
                <p class="text-gray-500 text-xs mt-1 text-center" id="status-msg">Click to start scanning</p>
            </button>
        </div>

        <a href="tel:112" class="pulse-animation flex flex-col items-center justify-center p-8 bg-red-600 rounded-2xl shadow-lg hover:bg-red-700 transition-colors text-white">
            <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
            <h3 class="text-3xl font-black tracking-widest">CALL 112</h3>
            <p class="text-red-100 text-sm font-medium mt-1">National Emergency Hotline</p>
        </a>
    </div>

    <div id="results-container" class="hidden animate-enter stagger-2">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2 flex justify-between items-center">
            <span>📍 Search Results</span>
            <span id="radius-display" class="text-sm font-normal text-gray-500 bg-gray-100 px-3 py-1 rounded-full"></span>
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <div class="flex items-center gap-2 mb-4 text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                    <h3 class="font-bold text-lg">Nearby Hospitals</h3>
                </div>
                <div id="hospital-results" class="space-y-4">
                    </div>
            </div>

            <div>
                <div class="flex items-center gap-2 mb-4 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <h3 class="font-bold text-lg">Nearby Police Stations</h3>
                </div>
                <div id="police-results" class="space-y-4">
                    </div>
            </div>
        </div>
    </div>

</div>

<script>
    // Global variables to store user location
    let userLat = null;
    let userLon = null;

    // Haversine formula to calculate distance
    function getDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radius of earth in km
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c; 
    }

    // 1. Trigger GPS Location
    function initLocationSearch() {
        const statusMsg = document.getElementById("status-msg");
        const locateBtn = document.getElementById("locate-btn");

        if (navigator.geolocation) {
            statusMsg.innerHTML = '<span class="animate-pulse font-semibold text-red-500">Acquiring GPS coordinates...</span>';
            locateBtn.classList.add('bg-gray-50');
            
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    // Store location globally
                    userLat = position.coords.latitude;
                    userLon = position.coords.longitude;
                    
                    statusMsg.innerText = "Location locked. Searching...";
                    document.getElementById("results-container").classList.remove("hidden");
                    
                    // Trigger the search
                    fetchAllServices();
                },
                (error) => {
                    statusMsg.innerHTML = '<span class="text-red-500 font-bold">Location denied. Please enable GPS.</span>';
                    alert("Error: " + error.message);
                    locateBtn.classList.remove('bg-gray-50');
                },
                { enableHighAccuracy: true, timeout: 15000 }
            );
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    // 2. Fetch both Hospitals and Police based on current radius
    function fetchAllServices() {
        if (!userLat || !userLon) return;

        const radiusSelect = document.getElementById("search-radius");
        const selectedRadius = radiusSelect.value;
        const radiusText = radiusSelect.options[radiusSelect.selectedIndex].text;

        document.getElementById("radius-display").innerText = "Current Radius: " + radiusText;

        fetchAmenities(userLat, userLon, 'hospital', 'hospital-results', selectedRadius);
        fetchAmenities(userLat, userLon, 'police', 'police-results', selectedRadius);
    }

    // 3. API Logic
    async function fetchAmenities(lat, lon, type, containerId, radius) {
        const container = document.getElementById(containerId);
        
        // Loader
        container.innerHTML = `
            <div class="animate-pulse flex space-x-4 p-4 border rounded-xl">
                <div class="flex-1 space-y-2 py-1">
                    <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                    <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                </div>
            </div>`;

        // Overpass API Query
        const query = `
            [out:json];
            (
              node["amenity"="${type}"](around:${radius},${lat},${lon});
              way["amenity"="${type}"](around:${radius},${lat},${lon});
            );
            out center 5; 
        `; 

        const url = `https://overpass-api.de/api/interpreter?data=${encodeURIComponent(query)}`;

        try {
            const response = await fetch(url);
            const data = await response.json();
            
            container.innerHTML = ""; // Clear loader

            if (data.elements && data.elements.length > 0) {
                // Calculate distance & Sort
                const sorted = data.elements.map(el => {
                    const elLat = el.lat || el.center.lat;
                    const elLon = el.lon || el.center.lon;
                    return {
                        ...el,
                        distance: getDistance(lat, lon, elLat, elLon)
                    };
                }).sort((a, b) => a.distance - b.distance);

                // Show top 3 results
                sorted.slice(0, 3).forEach(place => {
                    const placeName = place.tags.name || `Unknown ${type === 'hospital' ? 'Hospital' : 'Police Station'}`;
                    const pLat = place.lat || place.center.lat;
                    const pLon = place.lon || place.center.lon;
                    const distDisplay = place.distance.toFixed(1) + " km";

                    // FIXED: Google Maps Universal Link
                    const mapLink = `https://www.google.com/maps/dir/?api=1&destination=${pLat},${pLon}`;

                    const itemHtml = `
                        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-bold text-gray-900">${placeName}</h4>
                                    <p class="text-sm text-indigo-600 font-semibold mt-1">📍 ${distDisplay} away</p>
                                </div>
                            </div>
                            <a href="${mapLink}" target="_blank" class="mt-3 block w-full text-center bg-gray-900 text-white text-sm font-bold py-2.5 rounded-lg hover:bg-gray-800 transition-colors shadow-sm">
                                Get Directions
                            </a>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', itemHtml);
                });
            } else {
                const radiusKm = radius / 1000;
                container.innerHTML = `<p class="text-gray-500 text-sm italic p-2">No ${type}s found within ${radiusKm}km.</p>`;
            }
        } catch (err) {
            console.error(err);
            container.innerHTML = `<p class="text-red-500 text-sm">Failed to load data. API might be busy.</p>`;
        }
    }
</script>

@endsection