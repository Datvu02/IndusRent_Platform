/**
 * Admin Image Upload Validator
 * Kiểm tra kích thước file trước khi upload
 */

document.addEventListener('DOMContentLoaded', function() {
    const maxSize = 2 * 1024 * 1024; // 2MB in bytes
    
    // Tìm tất cả input type="file" có accept="image/*"
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    
    imageInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const files = e.target.files;
            if (!files || files.length === 0) return;
            
            let hasError = false;
            let errorFiles = [];
            
            // Kiểm tra từng file
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                
                if (file.size > maxSize) {
                    hasError = true;
                    errorFiles.push({
                        name: file.name,
                        size: fileSizeMB
                    });
                }
            }
            
            // Nếu có lỗi
            if (hasError) {
                // Tạo message
                let message = '❌ Ảnh vượt quá kích thước cho phép (2MB):\n\n';
                errorFiles.forEach(file => {
                    message += `• ${file.name} (${file.size} MB)\n`;
                });
                message += '\nVui lòng chọn ảnh nhỏ hơn 2MB!';
                
                // Hiển thị alert
                alert(message);
                
                // Highlight input bị lỗi
                input.style.borderColor = '#dc3545';
                input.style.backgroundColor = '#fff5f5';
                
                // Clear selection
                input.value = '';
                
                // Tạo error message dưới input
                showErrorMessage(input, errorFiles);
                
                return false;
            } else {
                // Reset style nếu OK
                input.style.borderColor = '';
                input.style.backgroundColor = '';
                removeErrorMessage(input);
                
                // Hiển thị success message
                showSuccessMessage(input, files);
            }
        });
    });
    
    function showErrorMessage(input, errorFiles) {
        removeErrorMessage(input);
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'file-error-message';
        errorDiv.style.cssText = 'color:#dc3545;font-size:13px;margin-top:8px;padding:10px;background:#fff5f5;border:1px solid #dc3545;border-radius:6px;';
        
        let html = '<strong>❌ Ảnh vượt quá 2MB:</strong><ul style="margin:5px 0 0 20px;padding:0;">';
        errorFiles.forEach(file => {
            html += `<li>${file.name} <strong>(${file.size} MB)</strong></li>`;
        });
        html += '</ul>';
        
        errorDiv.innerHTML = html;
        input.parentNode.insertBefore(errorDiv, input.nextSibling);
    }
    
    function removeErrorMessage(input) {
        const existingError = input.parentNode.querySelector('.file-error-message');
        if (existingError) {
            existingError.remove();
        }
        const existingSuccess = input.parentNode.querySelector('.file-success-message');
        if (existingSuccess) {
            existingSuccess.remove();
        }
    }
    
    function showSuccessMessage(input, files) {
        removeErrorMessage(input);
        
        const successDiv = document.createElement('div');
        successDiv.className = 'file-success-message';
        successDiv.style.cssText = 'color:#28a745;font-size:13px;margin-top:8px;padding:10px;background:#f0f8e8;border:1px solid #28a745;border-radius:6px;';
        
        const totalSize = Array.from(files).reduce((sum, file) => sum + file.size, 0);
        const totalSizeMB = (totalSize / (1024 * 1024)).toFixed(2);
        
        successDiv.innerHTML = `✓ Đã chọn ${files.length} ảnh (${totalSizeMB} MB)`;
        
        input.parentNode.insertBefore(successDiv, input.nextSibling);
    }
});
