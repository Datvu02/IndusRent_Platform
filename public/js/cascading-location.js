/**
 * Cascading Location Selector
 * Chọn Tỉnh → Quận → Xã (auto-load)
 * Exposes window.reinitCascadingLocation() for re-init after AJAX content load.
 */

function initCascadingLocation() {
    const provinceSelect = document.getElementById('province-select');
    const districtSelect = document.getElementById('district-select');
    const wardSelect = document.getElementById('ward-select');
    const locationIdInput = document.getElementById('location_id');
    const hiddenProvinceInputs = document.querySelectorAll('#search_province, #sidebar_province');
    const hiddenDistrictInputs = document.querySelectorAll('#search_district, #sidebar_district');
    
    if (!provinceSelect || !districtSelect || !wardSelect) return;
    
    const currentLocale = document.documentElement.lang || 'vi';
    const placeholders = window.locationI18n || {};
    const phProvince = placeholders.province || '--';
    const phDistrict = placeholders.district || '--';
    const phWard = placeholders.ward || '--';
    
    // Load tỉnh khi trang load
    loadProvinces();
    
    provinceSelect.addEventListener('change', function() {
        const province = this.value;
        
        districtSelect.innerHTML = `<option value="">${phDistrict}</option>`;
        wardSelect.innerHTML = `<option value="">${phWard}</option>`;
        districtSelect.disabled = !province;
        wardSelect.disabled = true;
        if (locationIdInput) {
            locationIdInput.value = '';
        }
        hiddenProvinceInputs.forEach(input => input.value = province || '');
        
        if (province) {
            loadDistricts(province);
        }
    });
    
    // Khi chọn quận → load xã
    districtSelect.addEventListener('change', function() {
        const province = provinceSelect.value;
        const district = this.value;
        
        wardSelect.innerHTML = `<option value="">${phWard}</option>`;
        wardSelect.disabled = !district;
        if (locationIdInput) {
            locationIdInput.value = '';
        }
        hiddenDistrictInputs.forEach(input => input.value = district || '');
        
        if (province && district) {
            loadWards(province, district);
        }
    });
    
    // Khi chọn xã → set location_id (nếu có hidden input riêng)
    wardSelect.addEventListener('change', function() {
        if (locationIdInput) {
            locationIdInput.value = this.value;
        }
    });
    
    function loadProvinces() {
        fetch('/api/provinces')
            .then(res => {
                return res.json();
            })
            .then(data => {
                provinceSelect.innerHTML = `<option value="">${phProvince}</option>`;
                
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.value;
                    option.textContent = getLocalizedLabel(item);
                    provinceSelect.appendChild(option);
                });
                
                
                // Restore selected value if exists
                const savedProvince = provinceSelect.dataset.selected;
                if (savedProvince) {
                    provinceSelect.value = savedProvince;
                    provinceSelect.dispatchEvent(new Event('change'));
                }
            })
            .catch(err => console.error('Error loading provinces:', err));
    }
    
    function loadDistricts(province) {
        fetch(`/api/districts?province=${encodeURIComponent(province)}`)
            .then(res => {
                return res.json();
            })
            .then(data => {
                districtSelect.innerHTML = `<option value="">${phDistrict}</option>`;
                
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.value;
                    option.textContent = getLocalizedLabel(item);
                    districtSelect.appendChild(option);
                });
                
                districtSelect.disabled = false;
                
                // Restore selected value if exists
                const savedDistrict = districtSelect.dataset.selected;
                if (savedDistrict) {
                    districtSelect.value = savedDistrict;
                    districtSelect.dispatchEvent(new Event('change'));
                }
            })
            .catch(err => console.error('Error loading districts:', err));
    }
    
    function loadWards(province, district) {
        fetch(`/api/wards?province=${encodeURIComponent(province)}&district=${encodeURIComponent(district)}`)
            .then(res => {
                return res.json();
            })
            .then(data => {
                wardSelect.innerHTML = `<option value="">${phWard}</option>`;
                
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.value;
                    option.textContent = getLocalizedLabel(item);
                    wardSelect.appendChild(option);
                });
                
                wardSelect.disabled = false;
                
                // Restore selected value if exists
                const savedWard = wardSelect.dataset.selected;
                if (savedWard) {
                    wardSelect.value = savedWard;
                    if (locationIdInput) {
                        locationIdInput.value = savedWard;
                    }
                }
            })
            .catch(err => console.error('Error loading wards:', err));
    }
    
    function getLocalizedLabel(item) {
        if (currentLocale === 'en' && item.label_en) {
            return item.label_en;
        }
        if (currentLocale === 'zh' && item.label_zh) {
            return item.label_zh;
        }
        return item.label;
    }
}

window.reinitCascadingLocation = initCascadingLocation;

document.addEventListener('DOMContentLoaded', initCascadingLocation);
