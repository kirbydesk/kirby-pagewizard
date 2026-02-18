(function () {
	'use strict';

	var overlay, content, img, caption, closeBtn, isOpen = false;

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
		closeBtn = overlay.querySelector('.pw-lightbox-close');
		content = overlay.querySelector('.pw-lightbox-content');

		// Close button
		closeBtn.addEventListener('mousedown', function (e) {
			e.preventDefault();
			e.stopPropagation();
			close();
		});

		// Click on backdrop (the overlay background itself)
		overlay.addEventListener('mousedown', function (e) {
			if (e.target === overlay) {
				e.preventDefault();
				e.stopPropagation();
				close();
			}
		});

		// Click on content area but not on the image
		content.addEventListener('mousedown', function (e) {
			if (e.target !== img) {
				e.preventDefault();
				e.stopPropagation();
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

			e.preventDefault();

			var sourceImg = figure.querySelector('img');
			if (!sourceImg) return;

			var fullSrc = sourceImg.getAttribute('data-full') || sourceImg.src;
			var altText = sourceImg.alt || '';
			var captionEl = figure.querySelector('[data-field="caption"]');
			var captionText = captionEl ? captionEl.textContent : '';

			open(fullSrc, altText, captionText);
		});
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
		document.body.style.overflow = 'hidden';
	}

	function close() {
		if (!isOpen) return;
		isOpen = false;
		overlay.classList.remove('is-active');
		document.documentElement.style.overflow = '';
		document.body.style.overflow = '';
		img.src = '';
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
