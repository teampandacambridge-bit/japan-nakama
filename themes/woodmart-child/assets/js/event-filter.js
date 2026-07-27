/**
 * Events archive filter (All / Free Events).
 *
 * Swaps the upcoming-events grid via admin-ajax. Config is injected by
 * wp_localize_script as `jnEventsFilter` (ajaxUrl, nonce, catId).
 */
(function () {
    'use strict';

    var cfg = window.jnEventsFilter;
    if (!cfg) {
        return;
    }

    var filter = document.querySelector('.events-filter');
    var grid = document.querySelector('.events-cards--upcoming');
    if (!filter || !grid) {
        return;
    }

    var pills = filter.querySelectorAll('.events-filter__pill');

    function setActive(activePill) {
        pills.forEach(function (pill) {
            var isActive = pill === activePill;
            pill.classList.toggle('is-active', isActive);
            pill.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        });
    }

    function applyFilter(filter) {
        grid.classList.add('is-loading');

        var body = new URLSearchParams();
        body.append('action', 'jn_filter_events');
        body.append('nonce', cfg.nonce);
        body.append('cat', cfg.catId);
        body.append('filter', filter);

        fetch(cfg.ajaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: body.toString()
        })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (data && data.success && data.data && typeof data.data.html === 'string') {
                    grid.innerHTML = data.data.html;
                }
            })
            .catch(function () {
                /* leave the current grid in place on error */
            })
            .finally(function () {
                grid.classList.remove('is-loading');
            });
    }

    pills.forEach(function (pill) {
        pill.addEventListener('click', function () {
            if (pill.classList.contains('is-active')) {
                return; // already showing this filter
            }
            setActive(pill);
            applyFilter(pill.getAttribute('data-filter') || 'all');
        });
    });
})();
