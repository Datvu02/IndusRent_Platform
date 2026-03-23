<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Location Cascading</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .test-box {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #1a3a52;
            border-bottom: 3px solid #D4AF37;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }
        select {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        select:disabled {
            background: #f0f0f0;
            cursor: not-allowed;
        }
        select:focus {
            outline: none;
            border-color: #D4AF37;
        }
        .result-box {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-left: 4px solid #D4AF37;
            border-radius: 4px;
        }
        .log {
            font-family: monospace;
            font-size: 12px;
            color: #666;
            margin-top: 10px;
            white-space: pre-wrap;
        }
        .success {
            color: #28a745;
            font-weight: bold;
        }
        .error {
            color: #dc3545;
            font-weight: bold;
        }
        button {
            background: #D4AF37;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        button:hover {
            background: #B8860B;
        }
    </style>
</head>
<body>
    <div class="test-box">
        <h1>🧪 Test Location Cascading (Tỉnh → Quận → Xã)</h1>
        
        <form id="test-form" action="{{ url('/tim-kiem') }}" method="GET">
            <div class="form-group">
                <label>1. Chọn Tỉnh/Thành phố</label>
                <select id="province-select">
                    <option value="">-- Chọn tỉnh --</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>2. Chọn Quận/Huyện</label>
                <select id="district-select" disabled>
                    <option value="">-- Chọn quận --</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>3. Chọn Phường/Xã</label>
                <select id="ward-select" name="location_id" disabled>
                    <option value="">-- Chọn phường/xã --</option>
                </select>
            </div>
            
            <button type="submit">🔍 Tìm kiếm với Location đã chọn</button>
        </form>
        
        <div class="result-box">
            <h3>📊 Kết quả:</h3>
            <div id="result">
                <p>Chưa chọn gì. Hãy chọn Tỉnh → Quận → Xã ở trên.</p>
            </div>
            <div class="log" id="log"></div>
        </div>
    </div>
    
    <script src="{{ asset('js/cascading-location.js') }}"></script>
    <script>
        const resultDiv = document.getElementById('result');
        const logDiv = document.getElementById('log');
        const form = document.getElementById('test-form');
        
        function addLog(message) {
            const timestamp = new Date().toLocaleTimeString();
            logDiv.textContent += `[${timestamp}] ${message}\n`;
            console.log(message);
        }
        
        document.getElementById('province-select').addEventListener('change', function() {
            const province = this.value;
            if (province) {
                resultDiv.innerHTML = `<p><span class="success">✓</span> Đã chọn tỉnh: <strong>${province}</strong></p>`;
                addLog(`Selected province: ${province}`);
            } else {
                resultDiv.innerHTML = `<p>Chưa chọn gì.</p>`;
            }
        });
        
        document.getElementById('district-select').addEventListener('change', function() {
            const district = this.value;
            const province = document.getElementById('province-select').value;
            if (district) {
                resultDiv.innerHTML = `<p><span class="success">✓</span> Tỉnh: <strong>${province}</strong><br>Quận: <strong>${district}</strong></p>`;
                addLog(`Selected district: ${district}`);
            }
        });
        
        document.getElementById('ward-select').addEventListener('change', function() {
            const ward = this.options[this.selectedIndex].text;
            const wardId = this.value;
            const district = document.getElementById('district-select').value;
            const province = document.getElementById('province-select').value;
            
            if (wardId) {
                resultDiv.innerHTML = `
                    <p class="success">✓ Hoàn thành chọn địa điểm!</p>
                    <p>
                        <strong>Tỉnh:</strong> ${province}<br>
                        <strong>Quận:</strong> ${district}<br>
                        <strong>Phường/Xã:</strong> ${ward}<br>
                        <strong>Location ID:</strong> ${wardId}
                    </p>
                    <p style="color:#666;font-size:13px;">Click "Tìm kiếm" để test search với location_id=${wardId}</p>
                `;
                addLog(`Selected ward: ${ward} (ID: ${wardId})`);
            }
        });
        
        form.addEventListener('submit', function(e) {
            const locationId = document.getElementById('ward-select').value;
            if (!locationId) {
                e.preventDefault();
                alert('⚠️ Vui lòng chọn đầy đủ Tỉnh → Quận → Xã trước khi tìm kiếm!');
                addLog('ERROR: No location_id selected');
            } else {
                addLog(`Submitting form with location_id=${locationId}`);
            }
        });
        
        addLog('Test page initialized');
    </script>
</body>
</html>
