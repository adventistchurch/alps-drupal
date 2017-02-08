(function($) {
	$.fn.textfill = function(options) {
		var fontSize = options.maxFontPixels;
		var widthSelector = options.widthSelector;
		var heightSelector = options.heightSelector;
		var ourText, maxHeight, maxWidth;
		ourText = $('span:visible:first', this);
		if (heightSelector) {
			maxHeight = $(heightSelector).outerHeight();
		} else {
			maxHeight = $(this).outerHeight();
		}
		if (widthSelector) {
			maxWidth = $(widthSelector).outerWidth();
		} else {
			maxWidth = $(this).outerWidth();
		}
		var textHeight;
		var textWidth;
		do {
			ourText.css('font-size', fontSize);
			textHeight = ourText.height();
			textWidth = ourText.width();
			fontSize = fontSize - 1;
		} while ((textHeight > maxHeight || textWidth > maxWidth) && fontSize > 3);
		return this;
	}
	$(function() {
		function init() {
			resizeLogoText();
		}

		function resizeLogoText() {
			$('.logo__link--square .logo__text').textfill({ maxFontPixels: 16, widthSelector: '.logo__link--square' });
			$('.logo__link--horiz .logo__text').textfill({ maxFontPixels: 12, widthSelector: '.logo__link--horiz' });
		}

		function resize() {
			resizeLogoText();
		}

		var _delayed_timeout = null;
		function resizeDelayed() {
			if (_delayed_timeout) {
				clearTimeout(_delayed_timeout);
			}
			_delayed_timeout = setTimeout(resize, 250);
		}

		$(window).on('resize', resizeDelayed);

		init();
	})
})(jQuery);