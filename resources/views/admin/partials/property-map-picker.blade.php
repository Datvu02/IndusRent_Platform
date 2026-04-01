@php
    $mapLat = $lat ?? null;
    $mapLng = $lng ?? null;
@endphp

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
<style>
#property-map {
    height: 380px;
    width: 100%;
    max-width: 900px;
    border-radius: 8px;
    border: 1px solid #ddd;
    z-index: 1;
}
</style>
@endpush

<div style="margin-bottom:16px;padding:16px;background:#f9fafb;border-radius:8px;border:1px solid #e5e7eb;">
    <h4 style="color:#1a3a52;margin:0 0 8px;">🗺️ Vị trí trên bản đồ (tùy chọn)</h4>
    <p style="color:#666;font-size:13px;margin:0 0 12px;">
        Click trên bản đồ để đặt ghim; kéo ghim để chỉnh. Bỏ trống nếu không cần hiển thị bản đồ trên trang tin.
    </p>
    <input type="hidden" name="latitude" id="map_latitude" value="{{ $mapLat !== null && $mapLat !== '' ? $mapLat : '' }}">
    <input type="hidden" name="longitude" id="map_longitude" value="{{ $mapLng !== null && $mapLng !== '' ? $mapLng : '' }}">
    <div style="margin-bottom:8px;font-size:13px;color:#444;">
        <span>Vĩ độ: <strong id="map_lat_display">—</strong></span>
        &nbsp;&nbsp;|&nbsp;&nbsp;
        <span>Kinh độ: <strong id="map_lng_display">—</strong></span>
    </div>
    <div id="property-map-container"
         data-lat="{{ $mapLat !== null && $mapLat !== '' ? $mapLat : '' }}"
         data-lng="{{ $mapLng !== null && $mapLng !== '' ? $mapLng : '' }}">
        <div id="property-map"></div>
    </div>
    <button type="button" class="admin-btn admin-btn-secondary" id="map_clear_btn" style="margin-top:10px;">Xóa vị trí bản đồ</button>
</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var container = document.getElementById('property-map-container');
    var mapEl = document.getElementById('property-map');
    if (!container || !mapEl || typeof L === 'undefined') return;

    var latInput = document.getElementById('map_latitude');
    var lngInput = document.getElementById('map_longitude');
    var latDisp = document.getElementById('map_lat_display');
    var lngDisp = document.getElementById('map_lng_display');
    var clearBtn = document.getElementById('map_clear_btn');

    function parseNum(v) {
        var n = parseFloat(v);
        return isNaN(n) ? NaN : n;
    }

    function updateDisplay(lat, lng) {
        if (latDisp) latDisp.textContent = lat != null && !isNaN(lat) ? Number(lat).toFixed(7) : '—';
        if (lngDisp) lngDisp.textContent = lng != null && !isNaN(lng) ? Number(lng).toFixed(7) : '—';
    }

    var initLat = parseNum(container.dataset.lat);
    var initLng = parseNum(container.dataset.lng);
    var defaultCenter = [16.0, 106.5];
    var zoom = 6;
    if (!isNaN(initLat) && !isNaN(initLng)) {
        defaultCenter = [initLat, initLng];
        zoom = 15;
    }
    updateDisplay(initLat, initLng);

    var map = L.map('property-map').setView(defaultCenter, zoom);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var marker = null;

    function setMarker(latlng) {
        if (marker) {
            map.removeLayer(marker);
        }
        marker = L.marker(latlng, { draggable: true }).addTo(map);
        latInput.value = latlng.lat.toFixed(7);
        lngInput.value = latlng.lng.toFixed(7);
        updateDisplay(latlng.lat, latlng.lng);
        marker.on('dragend', function(e) {
            var p = e.target.getLatLng();
            latInput.value = p.lat.toFixed(7);
            lngInput.value = p.lng.toFixed(7);
            updateDisplay(p.lat, p.lng);
        });
    }

    if (!isNaN(initLat) && !isNaN(initLng)) {
        setMarker(L.latLng(initLat, initLng));
    }

    map.on('click', function(e) {
        setMarker(e.latlng);
    });

    if (clearBtn) {
        clearBtn.addEventListener('click', function() {
            if (marker) {
                map.removeLayer(marker);
                marker = null;
            }
            latInput.value = '';
            lngInput.value = '';
            updateDisplay(NaN, NaN);
        });
    }

    setTimeout(function() { map.invalidateSize(); }, 200);
});
</script>
@endpush
