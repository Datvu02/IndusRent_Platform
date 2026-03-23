/**
 * Admin Image Upload Preview
 * Hiển thị preview ảnh sau khi chọn
 */

document.addEventListener('DOMContentLoaded', function() {
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]:not([multiple])');
    
    imageInputs.forEach(input => {
        // Tạo preview container
        const previewContainer = document.createElement('div');
        previewContainer.className = 'image-preview-container';
        previewContainer.style.cssText = 'margin-top:10px;display:none;';
        
        const previewImg = document.createElement('img');
        previewImg.style.cssText = 'max-width:300px;max-height:200px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);';
        
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.textContent = '✕ Xóa';
        removeBtn.style.cssText = 'display:block;margin-top:8px;padding:6px 12px;background:#dc3545;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:12px;';
        
        previewContainer.appendChild(previewImg);
        previewContainer.appendChild(removeBtn);
        
        // Insert after input's parent or small tag
        const insertAfter = input.nextElementSibling?.tagName === 'SMALL' 
            ? input.nextElementSibling 
            : input;
        insertAfter.parentNode.insertBefore(previewContainer, insertAfter.nextSibling);
        
        // Handle file selection
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewContainer.style.display = 'block';
                };
                
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        });
        
        // Handle remove button
        removeBtn.addEventListener('click', function() {
            input.value = '';
            previewContainer.style.display = 'none';
            
            // Remove success message if exists
            const successMsg = input.parentNode.querySelector('.file-success-message');
            if (successMsg) successMsg.remove();
        });
    });
    
    // Preview for multiple files
    const multipleImageInputs = document.querySelectorAll('input[type="file"][accept*="image"][multiple]');
    
    multipleImageInputs.forEach(input => {
        const previewContainer = document.createElement('div');
        previewContainer.className = 'multiple-image-preview-container';
        previewContainer.style.cssText = 'margin-top:10px;display:none;';
        
        const previewGrid = document.createElement('div');
        previewGrid.style.cssText = 'display:grid;grid-template-columns:repeat(auto-fill,minmax(100px,1fr));gap:10px;margin-top:10px;';
        
        const clearAllBtn = document.createElement('button');
        clearAllBtn.type = 'button';
        clearAllBtn.textContent = '✕ Xóa tất cả';
        clearAllBtn.style.cssText = 'margin-top:8px;padding:6px 12px;background:#dc3545;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:12px;';
        
        previewContainer.appendChild(previewGrid);
        previewContainer.appendChild(clearAllBtn);
        
        const insertAfter = input.nextElementSibling?.tagName === 'SMALL' 
            ? input.nextElementSibling 
            : input;
        insertAfter.parentNode.insertBefore(previewContainer, insertAfter.nextSibling);
        
        input.addEventListener('change', function(e) {
            const files = e.target.files;
            previewGrid.innerHTML = '';
            
            if (files && files.length > 0) {
                Array.from(files).forEach((file, index) => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            const imgWrapper = document.createElement('div');
                            imgWrapper.style.cssText = 'position:relative;';
                            
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.cssText = 'width:100%;height:100px;object-fit:cover;border-radius:8px;';
                            
                            const fileName = document.createElement('div');
                            fileName.textContent = file.name.length > 15 
                                ? file.name.substring(0, 12) + '...' 
                                : file.name;
                            fileName.style.cssText = 'font-size:10px;color:#666;margin-top:4px;text-align:center;';
                            
                            imgWrapper.appendChild(img);
                            imgWrapper.appendChild(fileName);
                            previewGrid.appendChild(imgWrapper);
                        };
                        
                        reader.readAsDataURL(file);
                    }
                });
                
                previewContainer.style.display = 'block';
            } else {
                previewContainer.style.display = 'none';
            }
        });
        
        clearAllBtn.addEventListener('click', function() {
            input.value = '';
            previewGrid.innerHTML = '';
            previewContainer.style.display = 'none';
            
            const successMsg = input.parentNode.querySelector('.file-success-message');
            if (successMsg) successMsg.remove();
        });
    });
});
