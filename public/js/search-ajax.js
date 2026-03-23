/**
 * Search without full page reload: intercept form submit and load results via AJAX.
 */

document.addEventListener('DOMContentLoaded', function() {
    var mainWrap = document.getElementById('main-content-wrap');
    if (!mainWrap) return;

    function loadSearchResults(url) {
        var req = new XMLHttpRequest();
        req.open('GET', url, true);
        req.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        req.setRequestHeader('Accept', 'text/html');
        req.onreadystatechange = function() {
            if (req.readyState !== 4) return;
            if (req.status >= 200 && req.status < 300) {
                mainWrap.innerHTML = req.responseText;
                history.pushState({ search: true }, '', url);
                if (typeof window.reinitCascadingLocation === 'function') {
                    window.reinitCascadingLocation();
                }
            }
        };
        req.send();
    }

    document.body.addEventListener('submit', function(e) {
        var form = e.target;
        if (!form || form.method !== 'get') return;
        var action = (form.getAttribute('action') || '').toString();
        if (action.indexOf('/tim-kiem') === -1) return;

        e.preventDefault();

        var data = new FormData(form);
        var params = new URLSearchParams();
        data.forEach(function(value, key) {
            if (value != null && String(value).trim() !== '') {
                params.set(key, value);
            }
        });
        var base = action.indexOf('?') >= 0 ? action.split('?')[0] : action;
        if (base.indexOf('http') !== 0) {
            base = window.location.origin + (base.indexOf('/') === 0 ? '' : '/') + base;
        }
        var url = base + (params.toString() ? '?' + params.toString() : '');
        loadSearchResults(url);
    }, true);

    document.body.addEventListener('click', function(e) {
        var a = e.target.closest('a');
        if (!a || !a.href) return;
        var href = a.getAttribute('href') || '';
        if (href.indexOf('/tim-kiem') === -1) return;
        if (a.target === '_blank' || e.ctrlKey || e.metaKey) return;

        e.preventDefault();
        loadSearchResults(a.href);
    }, true);

    window.addEventListener('popstate', function(e) {
        if (e.state && e.state.search && location.pathname.indexOf('/tim-kiem') !== -1) {
            loadSearchResults(location.href);
        }
    });
});
