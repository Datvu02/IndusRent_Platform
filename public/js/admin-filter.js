/**
 * Admin Filter Toggle
 */

function toggleFilter(filterId) {
    const filterBody = document.getElementById(filterId);
    const filterIcon = document.getElementById(filterId + '-icon');
    
    if (!filterBody || !filterIcon) return;
    
    if (filterBody.classList.contains('show')) {
        filterBody.classList.remove('show');
        filterIcon.classList.remove('active');
    } else {
        filterBody.classList.add('show');
        filterIcon.classList.add('active');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const filterBodies = document.querySelectorAll('.admin-filter-body.show');
    filterBodies.forEach(body => {
        const filterId = body.id;
        const icon = document.getElementById(filterId + '-icon');
        if (icon) {
            icon.classList.add('active');
        }
    });
});
