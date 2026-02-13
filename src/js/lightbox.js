(function () {
	'use strict';

	var overlay, img, caption, isOpen = false;

	function init() {
		overlay = document.createElement('div');
		overlay.className = 'pw-lightbox';
		overlay.setAttribute('role', 'dialog');
		overlay.setAttribute('aria-modal', 'true');
		overlay.setAttribute('aria-label', 'Image zoom');
		overlay.innerHTML =
			'<button class="pw-lightbox-close" aria-label="Close">' +
				'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>' +
			'</button>' +
			'<div class="pw-lightbox-content">' +
				'<img />' +
				'<p class="pw-lightbox-caption"></p>' +
			'</div>';
		document.body.appendChild(overlay);

		img = overlay.querySelector('img');
		caption = overlay.querySelector('.pw-lightbox-caption');

		// Close on overlay background or close button
		overlay.addEventListener('click', function (e) {
			if (e.target === overlay || e.target.closest('.pw-lightbox-close')) {
				close();
			}
		});

		// Close on Escape
		document.addEventListener('keydown', function (e) {
			if (isOpen && e.key === 'Escape') close();
		});

		// Open on click on zoom figure
		document.addEventListener('click', function (e) {
			if (isOpen) return;

			var figure = e.target.closest('figure[data-zoom]');
			if (!figure) return;

			// Don't open if click originated inside lightbox overlay
			if (e.target.closest('.pw-lightbox')) return;

			e.preventDefault();
			e.stopPropagation();

			var sourceImg = figure.querySelector('img');
			if (!sourceImg) return;

			var fullSrc = sourceImg.getAttribute('data-full') || sourceImg.src;
			var altText = sourceImg.alt || '';
			var captionEl = figure.querySelector('[data-field="caption"]');
			var captionText = captionEl ? captionEl.textContent : '';

			open(fullSrc, altText, captionText);
		}, true);
	}

	function open(src, alt, captionText) {
		img.src = src;
		img.alt = alt;

		if (captionText) {
			caption.textContent = captionText;
			caption.style.display = '';
		} else {
			caption.style.display = 'none';
		}

		isOpen = true;
		overlay.classList.add('is-active');
		document.documentElement.style.overflow = 'hidden';
	}

	function close() {
		isOpen = false;
		overlay.classList.remove('is-active');
		document.documentElement.style.overflow = '';
		img.src = '';
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
