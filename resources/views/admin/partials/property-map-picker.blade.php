@php
    $mapLat = $lat ?? null;
    $mapLng = $lng ?? null;
@endphp

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
<style>
#property-minimap {
    height: 300px;
    width: 100%;
    border-radius: 0 0 8px 8px;
    border: 1px solid #d1d5db;
    border-top: none;
    z-index: 1;
    cursor: crosshair;
}
#addr-wrapper {
    position: relative;
}
#addr-dropdown {
    position: absolute;
    top: 100%;
    left: 0; right: 0;
    background: #fff;
    border: 1px solid #d1d5db;
    border-top: none;
    border-radius: 0 0 6px 6px;
    max-height: 240px;
    overflow-y: auto;
    z-index: 9999;
    box-shadow: 0 4px 12px rgba(0,0,0,.12);
    display: none;
}
#addr-dropdown .dd-item {
    padding: 9px 12px;
    font-size: 13px;
    cursor: pointer;
    border-bottom: 1px solid #f3f4f6;
    color: #333;
    line-height: 1.4;
}
#addr-dropdown .dd-item:last-child { border-bottom: none; }
#addr-dropdown .dd-item:hover,
#addr-dropdown .dd-item.active { background: #eef4ff; }
#addr-dropdown .dd-item .dd-main { font-weight: 500; }
#addr-dropdown .dd-item .dd-sub  { font-size: 11px; color: #888; margin-top:2px; }
#addr-dropdown .dd-msg {
    padding: 10px 12px;
    font-size: 13px;
    color: #6b7280;
    text-align: center;
}
#geocode-status {
    font-size: 12px;
    min-height: 18px;
    margin-top: 5px;
}
#geocode-status.success { color: #15803d; }
#geocode-status.error   { color: #dc2626; }
#geocode-status.loading { color: #6b7280; }
#map-tip {
    font-size: 12px;
    color: #6b7280;
    padding: 5px 10px;
    background: #f8f9fa;
    border: 1px solid #d1d5db;
    border-bottom: none;
    border-radius: 8px 8px 0 0;
}
</style>
@endpush

<div style="margin-bottom:16px;padding:16px;background:#f9fafb;border-radius:8px;border:1px solid #e5e7eb;">
    <h4 style="color:#1a3a52;margin:0 0 8px;">📍 Vị trí trên bản đồ (tùy chọn)</h4>
    <p style="color:#666;font-size:13px;margin:0 0 12px;">
        Gõ hoặc dán địa chỉ để tìm kiếm. Chọn từ danh sách gợi ý, hoặc click trực tiếp lên bản đồ để ghim chính xác.
    </p>

    {{-- Thanh tìm kiếm + dropdown --}}
    <div id="addr-wrapper">
        <div style="display:flex;gap:8px;">
            <input
                type="text"
                id="address_input"
                autocomplete="off"
                placeholder="Nhập hoặc dán địa chỉ — ví dụ: 10 Tôn Thất Thuyết, Cầu Giấy, Hà Nội"
                style="flex:1;padding:9px 12px;border:1px solid #d1d5db;border-radius:6px;font-size:14px;"
            >
            <button type="button" id="map_clear_btn"
                style="padding:9px 12px;background:#fff;border:1px solid #d1d5db;border-radius:6px;color:#555;font-size:13px;cursor:pointer;white-space:nowrap;">
                ✕ Xóa
            </button>
        </div>
        <div id="addr-dropdown"></div>
    </div>

    <div id="geocode-status"></div>

    {{-- Hidden inputs gửi lên server --}}
    <input type="hidden" name="latitude"  id="map_latitude"
           value="{{ $mapLat !== null && $mapLat !== '' ? $mapLat : '' }}">
    <input type="hidden" name="longitude" id="map_longitude"
           value="{{ $mapLng !== null && $mapLng !== '' ? $mapLng : '' }}">

    {{-- Tọa độ + minimap --}}
    <div id="minimap_section" style="margin-top:12px;display:none;">
        <div id="coord_display"
             style="font-size:12px;color:#555;margin-bottom:6px;padding:6px 10px;background:#eef6ff;border-radius:6px;border:1px solid #bdd7f5;display:flex;justify-content:space-between;align-items:center;">
            <span>📌 Vĩ độ: <strong id="disp_lat">—</strong> &nbsp;|&nbsp; Kinh độ: <strong id="disp_lng">—</strong></span>
            <span style="color:#999;font-size:11px;">Click bản đồ để điều chỉnh ghim</span>
        </div>
        <div id="map-tip">🖱 Click vào bản đồ để đặt ghim chính xác hơn — kéo ghim để tinh chỉnh</div>
        <div id="property-minimap"></div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
(function () {
    var latInput    = document.getElementById('map_latitude');
    var lngInput    = document.getElementById('map_longitude');
    var addrInput   = document.getElementById('address_input');
    var dropdown    = document.getElementById('addr-dropdown');
    var clearBtn    = document.getElementById('map_clear_btn');
    var status      = document.getElementById('geocode-status');
    var section     = document.getElementById('minimap_section');
    var dispLat     = document.getElementById('disp_lat');
    var dispLng     = document.getElementById('disp_lng');

    var map    = null;
    var marker = null;
    var debounceTimer = null;
    var activeIdx = -1;

    /* ── Reverse geocoding ── */
    function reverseGeocode(lat, lng) {
        var url = 'https://nominatim.openstreetmap.org/reverse?format=json&lat=' + lat + '&lon=' + lng;
        status.textContent = '⏳ Đang lấy địa chỉ...';
        status.className   = 'loading';
        fetch(url, { headers: { 'Accept-Language': 'vi,en' } })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data && data.display_name) {
                    addrInput.value    = data.display_name;
                    status.textContent = '📌 ' + data.display_name;
                    status.className   = 'success';
                } else {
                    status.textContent = '📌 Đã ghim — không lấy được tên địa chỉ.';
                    status.className   = 'success';
                }
            })
            .catch(function () {
                status.textContent = '📌 Đã ghim — không lấy được tên địa chỉ.';
                status.className   = 'success';
            });
    }

    /* ── Map init ── */
    function initMap(lat, lng) {
        section.style.display = 'block';
        if (!map) {
            map = L.map('property-minimap').setView([lat, lng], 16);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // Click on map to place/move marker + reverse geocode
            map.on('click', function (e) {
                placeMarker(e.latlng.lat, e.latlng.lng, true);
            });
        } else {
            map.setView([lat, lng], 16);
        }
        setTimeout(function () { map.invalidateSize(); }, 150);
    }

    function placeMarker(lat, lng, doReverse) {
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            marker.on('dragend', function (e) {
                var p = e.target.getLatLng();
                saveCoords(p.lat, p.lng);
                reverseGeocode(p.lat, p.lng);
            });
        }
        saveCoords(lat, lng);
        if (doReverse) reverseGeocode(lat, lng);
    }

    function saveCoords(lat, lng) {
        var rLat = parseFloat(lat).toFixed(7);
        var rLng = parseFloat(lng).toFixed(7);
        latInput.value = rLat;
        lngInput.value = rLng;
        dispLat.textContent = rLat;
        dispLng.textContent = rLng;
    }

    /* ── Dropdown helpers ── */
    function showDropdown(html) {
        dropdown.innerHTML = html;
        dropdown.style.display = 'block';
        activeIdx = -1;
    }
    function hideDropdown() {
        dropdown.style.display = 'none';
        dropdown.innerHTML = '';
        activeIdx = -1;
    }

    function buildDropdown(results) {
        if (!results || results.length === 0) {
            showDropdown('<div class="dd-msg">Không tìm thấy địa chỉ phù hợp</div>');
            return;
        }
        var html = '';
        results.forEach(function (r, i) {
            var parts = r.display_name.split(', ');
            var main  = parts.slice(0, 2).join(', ');
            var sub   = parts.slice(2).join(', ');
            html += '<div class="dd-item" data-idx="' + i + '" data-lat="' + r.lat + '" data-lon="' + r.lon + '" data-name="' + encodeURIComponent(r.display_name) + '">'
                  + '<div class="dd-main">' + escapeHtml(main) + '</div>'
                  + (sub ? '<div class="dd-sub">' + escapeHtml(sub) + '</div>' : '')
                  + '</div>';
        });
        showDropdown(html);

        dropdown.querySelectorAll('.dd-item').forEach(function (el) {
            el.addEventListener('mousedown', function (e) {
                e.preventDefault();
                selectItem(el);
            });
        });
    }

    function selectItem(el) {
        var lat  = parseFloat(el.dataset.lat);
        var lon  = parseFloat(el.dataset.lon);
        var name = decodeURIComponent(el.dataset.name);
        addrInput.value = name;
        initMap(lat, lon);
        placeMarker(lat, lon, false);
        status.textContent = '✅ Đã chọn: ' + name;
        status.className   = 'success';
        hideDropdown();
    }

    function escapeHtml(s) {
        return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    /* ── Nominatim search ── */
    function search(query) {
        if (!query.trim()) { hideDropdown(); return; }
        status.textContent = '⏳ Đang tìm...';
        status.className   = 'loading';

        var url = 'https://nominatim.openstreetmap.org/search?format=json&limit=7&countrycodes=vn&q='
                  + encodeURIComponent(query);

        fetch(url, { headers: { 'Accept-Language': 'vi,en' } })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                status.textContent = '';
                buildDropdown(data);
            })
            .catch(function () {
                status.textContent = '❌ Lỗi kết nối. Kiểm tra lại mạng.';
                status.className   = 'error';
                hideDropdown();
            });
    }

    /* ── Keyboard navigation ── */
    addrInput.addEventListener('keydown', function (e) {
        var items = dropdown.querySelectorAll('.dd-item');
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            activeIdx = Math.min(activeIdx + 1, items.length - 1);
            items.forEach(function (el, i) { el.classList.toggle('active', i === activeIdx); });
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            activeIdx = Math.max(activeIdx - 1, 0);
            items.forEach(function (el, i) { el.classList.toggle('active', i === activeIdx); });
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (activeIdx >= 0 && items[activeIdx]) {
                selectItem(items[activeIdx]);
            } else {
                search(addrInput.value);
            }
        } else if (e.key === 'Escape') {
            hideDropdown();
        }
    });

    /* ── Debounced input / paste ── */
    addrInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        var q = addrInput.value.trim();
        if (q.length < 3) { hideDropdown(); return; }
        debounceTimer = setTimeout(function () { search(q); }, 350);
    });

    addrInput.addEventListener('paste', function () {
        clearTimeout(debounceTimer);
        setTimeout(function () {
            var q = addrInput.value.trim();
            if (q.length >= 3) search(q);
        }, 60);
    });

    /* ── Đóng dropdown khi click ra ngoài ── */
    document.addEventListener('click', function (e) {
        if (!document.getElementById('addr-wrapper').contains(e.target)) {
            hideDropdown();
        }
    });

    /* ── Nút xóa ── */
    clearBtn.addEventListener('click', function () {
        addrInput.value = '';
        latInput.value  = '';
        lngInput.value  = '';
        dispLat.textContent = '—';
        dispLng.textContent = '—';
        section.style.display = 'none';
        status.textContent = '';
        status.className   = '';
        hideDropdown();
        if (marker && map) { map.removeLayer(marker); marker = null; }
    });

    /* ── Khởi tạo khi edit (đã có tọa độ sẵn) ── */
    document.addEventListener('DOMContentLoaded', function () {
        var initLat = parseFloat(latInput.value);
        var initLng = parseFloat(lngInput.value);
        if (!isNaN(initLat) && !isNaN(initLng)) {
            initMap(initLat, initLng);
            placeMarker(initLat, initLng, false);
            // Lấy lại địa chỉ từ tọa độ đã lưu để điền vào ô tìm kiếm
            reverseGeocode(initLat, initLng);
        }
    });
}());
</script>
@endpush
