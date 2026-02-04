jQuery(document).ready(function () {

    // Open active mobile flyout menu on page load
    jQuery('header.mobile nav ul.l1 li.active').addClass('open').find('ul').show();

    // Toggle 'open' class on hover for desktop dropdown menu
    jQuery(document).on('mouseenter', 'div.navitem > .item', function () {
        jQuery(this).addClass('open');
    }).on('mouseleave', 'div.navitem > .item', function () {
        jQuery(this).removeClass('open');
    });

    // Utility: Close all open desktop flyouts
    function closeAllDesktopFlyouts() {
        // Close desktop flyouts
        jQuery('div.navitem > .item').removeClass('open').attr('aria-expanded', 'false');
    }

    // Keyboard and click control for desktop dropdown menu (.item) and mobile burger menu (.burger)
		jQuery(document)
        // Toggle menu on click (open/close)
        .on('click', 'div.navitem > .item, div.burger', function (e) {
            let $t = jQuery(this),
                $nav = $t.closest('header.mobile').find('nav');
            // Close all other open desktop flyouts before opening the current one
            jQuery('div.navitem > .item').not(this).removeClass('open').attr('aria-expanded', 'false');
            $t.toggleClass('open').attr('aria-expanded', $t.hasClass('open'));
            // For mobile: slide toggle the navigation menu
            if ($nav.length) $nav.stop().slideToggle(300);
            e.stopPropagation();
        })
        // Enable keyboard control: open/close menu with Enter, Space, or close with Escape
        .on('keydown', 'div.navitem > .item, div.burger', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                jQuery(this).trigger('click');
            }
            if (e.key === 'Escape' || e.key === 'Esc') {
                jQuery(this).removeClass('open').attr('aria-expanded', 'false');
                // For mobile: also hide nav if open
                let $nav = jQuery(this).closest('header.mobile').find('nav');
                if ($nav.length) $nav.stop().slideUp(300);
            }
        });

    // Close all open desktop flyouts when focus moves outside or when clicking outside the navigation
    jQuery(document).on('focusout', 'div.navitem > .item', function (e) {
        if (!$.contains(this, e.relatedTarget)) closeAllDesktopFlyouts();
    });
    jQuery(document).on('click', function () {
        closeAllDesktopFlyouts();
    });

    // Mobile flyout: open/close on click or keyboard (Enter/Space)
    jQuery(document)
        .on('click', 'header.mobile nav ul.l1 li div.flyout, header.mobile nav ul.l1 li div.item', function (e) {
            var $li = jQuery(this).closest('li');
            $li.siblings('.open').removeClass('open').find('ul').stop().slideUp(300);
            $li.toggleClass('open').find('ul').stop().slideToggle(300);
            // Update ARIA attributes for accessibility
            $li.attr('aria-expanded', $li.hasClass('open'));
            e.preventDefault();
            e.stopPropagation();
        })
        .on('keydown', 'header.mobile nav ul.l1 li div.item', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                jQuery(this).trigger('click');
            }
        });

    // Header fixed on scroll
    jQuery(window).on('scroll', function () {
        jQuery('body').toggleClass('sticky', $(this).scrollTop() > 1);
    });

    // Language and language level switcher (mobile)
    jQuery(document).on('change', 'select#language, select#languagelevel', function () {
        // If language is changed, redirect to selected language URL
				if (this.value.startsWith('/') || this.value.startsWith(window.location.origin) || this.value.startsWith('http')) {
						window.location = this.value;
				}
    });
});