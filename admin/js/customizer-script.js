( function( $ ) {
	
	jQuery(document).ready(function($) { 

		//Chosen JS
	    jQuery(".hs-chosen-select").chosen({
	        width: "100%"
	    });

		let customizeBody = jQuery('body');

		function responsiveSwitcher() {

			// Responsive switchers
			customizeBody.on('click', '.responsive-switchers button', function (event) {

				// Set up variables				var ,
				var $device = jQuery(this).data('device'),
					$body = jQuery('.wp-full-overlay'),
					$footer_devices = jQuery('.wp-full-overlay-footer .devices');
				var $devices = jQuery('.responsive-switchers');
				// Button class

				if ($device == 'desktop') {
					jQuery(this).parents(".responsive-switchers").toggleClass("responsive-switchers-open");

					jQuery(this).parents('li').siblings('.has-switchers').find('.responsive-switchers').toggleClass('responsive-switchers-open');
				}

				$devices.find('button').removeClass('active');
				$devices.find('button.preview-' + $device).addClass('active');

				var controls = jQuery('.responsive-control-wrap');
				controls.each(function () {
					if ($device != 'normal') {
						if (jQuery(this).hasClass($device)) {
							jQuery(this).addClass('active');
						} else {
							jQuery(this).removeClass('active');
						}
					}
				});

				// Wrapper class
				$body.removeClass('preview-desktop preview-tablet preview-mobile').addClass('preview-' + $device);

				// Panel footer buttons
				$footer_devices.find('button').removeClass('active').attr('aria-pressed', false);
				$footer_devices.find('button.preview-' + $device).addClass('active').attr('aria-pressed', true);

			});

			jQuery('#customize-footer-actions .devices button').on('click', function (event) {
				event.preventDefault();
				let device = jQuery(this).data('device');
				let queries = jQuery('.devices-wrapper');
				let body = jQuery('.wp-full-overlay');
				let responsiveSwitchers = jQuery('.responsive-switchers');

				// Button class
				if (device == 'desktop') {
					if (queries.hasClass('responsive-switchers-open')) {
						queries.removeClass('responsive-switchers-open');
					} else {
						queries.addClass('responsive-switchers-open')
					}
				} else {
					if (!queries.hasClass('responsive-switchers-open')) {
						queries.addClass('responsive-switchers-open');
					}
				}

				queries.find('button').removeClass('active');
				queries.find('button.preview-' + device).addClass('active');

				responsiveSwitchers.find('button').removeClass('active');
				responsiveSwitchers.find('button.preview-' + device).addClass('active');

				var controls = jQuery('.responsive-control-wrap');
				controls.each(function () {
					if (device != 'normal') {
						if (jQuery(this).hasClass(device)) {
							jQuery(this).addClass('active');
						} else {
							jQuery(this).removeClass('active');
						}
					}
				});

				body.removeClass('preview-desktop preview-tablet preview-mobile').addClass('preview-' + device);
			});
		}

		responsiveSwitcher();

		var footerWidgetAreaSectionLinks = jQuery('.customize-section-link');
		footerWidgetAreaSectionLinks.each(function (i, o) {
			jQuery(this).on('click', function (event) {
				event.preventDefault();
				var sectionID = jQuery(this).attr('data-attr');
				wp.customize.section('sidebar-widgets-' + sectionID).focus();
			})
		});

		// @since 1.0.2
		customizeBody.on('click', '.unit-dropdown-toggle-button', function (event) {
			event.preventDefault();
			let thisButton = jQuery(this);
			let isUnitChangeable = thisButton.data('changeable');
			if (isUnitChangeable !== 'no') {
				thisButton.next('.cream-blog-unit-dropdown').toggleClass('dropdown-open');
			}
		});

		// @since 1.0.2
		customizeBody.on('click', '.cream-blog-control-toggle-button', function (event) {
			event.preventDefault();
			let thisButton = jQuery(this);
			let associatedControlModal = thisButton.parent().parent().find('.cream-blog-control-modal');
			let allControlModal = jQuery('.cream-blog-control-modal');
			allControlModal.each(function () {
				let thisControlModal = jQuery(this);
				if (thisControlModal.hasClass('modal-open') && thisButton.data('control') !== thisControlModal.data('control')) {
					thisControlModal.removeClass('modal-open');
				}
			});
			thisButton.parent().parent().find('.cream-blog-control-modal').toggleClass('modal-open');
		});

		// @since 1.0.2
		customizeBody.on('click', '.cream-blog-unit-button', function (event) {
			event.preventDefault();
			let thisButton = jQuery(this);
			let thisButtonVal = thisButton.val();
			let unitButton = thisButton.parent().prev('.cream-blog-unit-button');
			// Change the unit toggle button's text.
			unitButton.find('span').html(thisButtonVal);
			// Update the unit input field's value.
			unitButton.find('.cream-blog-unit-input').val(thisButtonVal).trigger('change');
			// Remove 'dropdown-open' classname from unit dropdown element.
			thisButton.parent().removeClass('dropdown-open');
		});

		// @since 1.0.2
		customizeBody.on('click', '.cream-blog-typography-font-style-button, .cream-blog-typography-text-transform-button', function (event) {
			event.preventDefault();
			let thisButton = jQuery(this);
			// Remove classname 'active' from sibling buttons.
			thisButton.siblings().removeClass('active');
			// Add classname 'active' to current button;
			thisButton.addClass('active');
			// Update the input field's value.
			thisButton.parent().prev('input').val(thisButton.val()).trigger('change');
		});
	});

} ) ( jQuery );