/**
 * The tagline's line (Project Wizard › Elements › Tagline): measures for each
 * tagline with a line the distance from its start to the screen edge or to the
 * grid's outer edge (--pw-ll-lead, the CSS draws the line, elements.css) and
 * runs it in once it comes into view ("in"). Without motion wishes it stands
 * at once.
 */
(function () {
	var lines = [];
	var still = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	function measure() {
		lines.forEach(function (tagline) {
			var left = tagline.getBoundingClientRect().left;
			var edge = 0;
			if (tagline.getAttribute('data-leadline-reach') === 'grid') {
				var grid = tagline.closest('[data-layout="grid"]');
				edge = grid ? grid.getBoundingClientRect().left : 0;
			}
			tagline.style.setProperty('--pw-ll-lead', Math.max(0, Math.round(left - edge)) + 'px');
			tagline.setAttribute('data-leadline-ready', '');
		});
	}

	function start() {
		lines = Array.prototype.slice.call(document.querySelectorAll('[data-field="tagline"][data-leadline]'));
		if (!lines.length) return;
		measure();
		var waiting = false;
		window.addEventListener('resize', function () {
			if (waiting) return;
			waiting = true;
			window.requestAnimationFrame(function () { waiting = false; measure(); });
		});
		if (document.fonts && document.fonts.ready) document.fonts.ready.then(measure);

		// running in: once, when it comes into view
		var runIn = lines.filter(function (t) { return t.getAttribute('data-leadline-motion') === 'in'; });
		if (!runIn.length || still || !('IntersectionObserver' in window)) return;
		var seen = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) return;
				entry.target.setAttribute('data-leadline-play', 'run');
				seen.unobserve(entry.target);
			});
		}, { threshold: 0.35 });
		runIn.forEach(function (t) {
			t.setAttribute('data-leadline-play', 'wait');
			seen.observe(t);
		});
	}

	if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', start);
	else start();
})();
