<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Device Locations
            </h2>
            <div class="flex gap-2">
                <button onclick="exportData('csv')" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                    Export CSV
                </button>
                <button onclick="exportData('json')" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Export JSON
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Controls -->
                    <div class="mb-6 space-y-4">
                        <!-- Date Range Filters -->
                        <div class="flex gap-4 items-end">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="datetime-local" id="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="datetime-local" id="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <button onclick="applyDateFilter()" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                Apply Filter
                            </button>
                        </div>

                        <!-- Map Controls -->
                        <div class="flex gap-2">
                            <button onclick="togglePath()" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                                Toggle Path
                            </button>
                            <button onclick="toggleMarkers()" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                                Toggle Markers
                            </button>
                            <button onclick="fitBounds()" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                                Fit All Points
                            </button>
                        </div>
                    </div>

                    <div id="map" style="height: 400px;" class="w-full rounded-lg mb-6"></div>
                    
                    <!-- Stats Overview -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-500">Total Points</h3>
                            <p id="total-points" class="text-2xl font-semibold">-</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-500">Average Speed</h3>
                            <p id="avg-speed" class="text-2xl font-semibold">-</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-500">Distance Traveled</h3>
                            <p id="total-distance" class="text-2xl font-semibold">-</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Latest Location</h3>
                            <div id="latest-location" class="p-4 bg-gray-50 rounded-lg">
                                Loading...
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-2">Location History</h3>
                            <div id="location-history" class="space-y-2 max-h-96 overflow-y-auto">
                                Loading...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initMap" async defer></script>
    <script>
        let map;
        let marker;
        let path;
        let markers = [];
        let showPath = true;
        let showMarkers = true;
        const deviceId = {{ $device->id }};

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 0, lng: 0 },
                zoom: 2,
            });

            // Initialize the polyline for the path
            path = new google.maps.Polyline({
                path: [],
                geodesic: true,
                strokeColor: "#FF0000",
                strokeOpacity: 1.0,
                strokeWeight: 2,
                map: map
            });

            fetchLatestLocation();
            fetchLocationHistory();
        }

        async function fetchLatestLocation() {
            try {
                const response = await fetch(`/devices/${deviceId}/locations/latest`);
                const location = await response.json();
                
                if (location) {
                    updateMap(location, true);
                    updateLatestLocationInfo(location);
                }
            } catch (error) {
                console.error('Error fetching latest location:', error);
            }
        }

        async function fetchLocationHistory() {
            try {
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                
                let url = `/devices/${deviceId}/locations/history`;
                if (startDate || endDate) {
                    const params = new URLSearchParams();
                    if (startDate) params.append('start_date', startDate);
                    if (endDate) params.append('end_date', endDate);
                    url += `?${params.toString()}`;
                }

                const response = await fetch(url);
                const data = await response.json();
                
                // Clear existing markers
                clearMarkers();
                
                // Update the path on the map
                const coordinates = data.data.map(location => ({
                    lat: parseFloat(location.latitude),
                    lng: parseFloat(location.longitude)
                }));
                path.setPath(coordinates);

                // Create markers for each point
                data.data.forEach((location, index) => {
                    if (showMarkers) {
                        const marker = new google.maps.Marker({
                            position: { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) },
                            map: map,
                            title: `Point ${index + 1}`,
                            label: `${index + 1}`,
                            icon: {
                                path: google.maps.SymbolPath.CIRCLE,
                                scale: 6,
                                fillColor: "#4285F4",
                                fillOpacity: 1,
                                strokeWeight: 2,
                                strokeColor: "#fff"
                            }
                        });
                        markers.push(marker);
                    }
                });

                // Update stats
                updateStats(data.data);
                
                const historyHtml = data.data.map((location, index) => `
                    <div class="p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer" onclick="centerOnPoint(${index})">
                        <div class="font-medium">Point ${index + 1}</div>
                        <div>Latitude: ${location.latitude}</div>
                        <div>Longitude: ${location.longitude}</div>
                        <div>Speed: ${location.speed || 'N/A'} m/s</div>
                        <div>Accuracy: ${location.accuracy || 'N/A'} meters</div>
                        <div>Time: ${new Date(location.timestamp).toLocaleString()}</div>
                    </div>
                `).join('');
                
                document.getElementById('location-history').innerHTML = historyHtml || '<p>No location history found for the selected period.</p>';
            } catch (error) {
                console.error('Error fetching location history:', error);
            }
        }

        function updateMap(location, centerMap = false) {
            const position = { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) };
            
            if (centerMap) {
                map.setCenter(position);
                map.setZoom(15);
            }

            if (marker) {
                marker.setPosition(position);
            } else {
                marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: 'Current Location',
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 8,
                        fillColor: "#4CAF50",
                        fillOpacity: 1,
                        strokeWeight: 2,
                        strokeColor: "#fff"
                    }
                });
            }
        }

        function updateLatestLocationInfo(location) {
            const html = `
                <div>
                    <div>Latitude: ${location.latitude}</div>
                    <div>Longitude: ${location.longitude}</div>
                    <div>Accuracy: ${location.accuracy || 'N/A'} meters</div>
                    <div>Speed: ${location.speed || 'N/A'} m/s</div>
                    <div>Heading: ${location.heading || 'N/A'}°</div>
                    <div>Altitude: ${location.altitude || 'N/A'} meters</div>
                    <div>Time: ${new Date(location.timestamp).toLocaleString()}</div>
                </div>
            `;
            document.getElementById('latest-location').innerHTML = html;
        }

        function updateStats(locations) {
            document.getElementById('total-points').textContent = locations.length;
            
            // Calculate average speed
            const speeds = locations.map(l => l.speed).filter(s => s !== null);
            const avgSpeed = speeds.length ? (speeds.reduce((a, b) => a + b, 0) / speeds.length).toFixed(2) : 'N/A';
            document.getElementById('avg-speed').textContent = `${avgSpeed} m/s`;
            
            // Calculate total distance
            let totalDistance = 0;
            for (let i = 1; i < locations.length; i++) {
                const prev = locations[i - 1];
                const curr = locations[i];
                totalDistance += calculateDistance(
                    prev.latitude, prev.longitude,
                    curr.latitude, curr.longitude
                );
            }
            document.getElementById('total-distance').textContent = `${totalDistance.toFixed(2)} km`;
        }

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Radius of the earth in km
            const dLat = deg2rad(lat2 - lat1);
            const dLon = deg2rad(lon2 - lon1);
            const a = 
                Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
                Math.sin(dLon/2) * Math.sin(dLon/2); 
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
            return R * c;
        }

        function deg2rad(deg) {
            return deg * (Math.PI/180);
        }

        function clearMarkers() {
            markers.forEach(marker => marker.setMap(null));
            markers = [];
        }

        function togglePath() {
            showPath = !showPath;
            path.setMap(showPath ? map : null);
        }

        function toggleMarkers() {
            showMarkers = !showMarkers;
            markers.forEach(marker => marker.setMap(showMarkers ? map : null));
        }

        function fitBounds() {
            const bounds = new google.maps.LatLngBounds();
            path.getPath().forEach(point => bounds.extend(point));
            if (!bounds.isEmpty()) {
                map.fitBounds(bounds);
            }
        }

        function centerOnPoint(index) {
            const location = path.getPath().getAt(index);
            map.setCenter(location);
            map.setZoom(15);
        }

        async function exportData(format) {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            
            let url = `/devices/${deviceId}/locations/export?format=${format}`;
            if (startDate) url += `&start_date=${startDate}`;
            if (endDate) url += `&end_date=${endDate}`;
            
            window.location.href = url;
        }

        function applyDateFilter() {
            fetchLocationHistory();
        }

        // Refresh data every 30 seconds
        setInterval(() => {
            fetchLatestLocation();
            fetchLocationHistory();
        }, 30000);

        // Set initial date range to last 24 hours
        const now = new Date();
        const yesterday = new Date(now.getTime() - (24 * 60 * 60 * 1000));
        document.getElementById('start_date').value = yesterday.toISOString().slice(0, 16);
        document.getElementById('end_date').value = now.toISOString().slice(0, 16);
    </script>
    @endpush
</x-app-layout> 