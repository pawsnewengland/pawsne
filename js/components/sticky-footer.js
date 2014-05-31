/* =============================================================

	Sticky Footer v1.0
	Responsive sticky footers, by Chris Ferdinandi
	http://gomakethings.com

	Free to use under the MIT License.
	http://gomakethings.com/mit/

 * ============================================================= */

window.stickyFooter = (function (window, document, undefined) {

	'use strict';

	// Default settings
	// Private {object} variable
	var _defaults = {
		callbackBefore: function () {},
		callbackAfter: function () {}
	};

	// Merge default settings with user options
	// Private method
	// Returns an {object}
	var _mergeObjects = function ( original, updates ) {
		for (var key in updates) {
			original[key] = updates[key];
		}
		return original;
	};

	// Get height of viewport
	// Private method
	// Returns integer
	var _getViewportHeight = function () {
		return Math.max( document.documentElement.clientHeight, window.innerHeight || 0 );
	};

	// Set wrap height to fill viewport (minus footer height)
	// Private method
	// Runs functions
	var _setWrapHeight = function ( wrap, footer, options ) {
		options.callbackBefore(); // Run callbacks before...
		wrap.style.minHeight = ( _getViewportHeight() - footer.offsetHeight ) + 'px';
		options.callbackAfter(); // Run callbacks after...
	};

	// On window resize, only run `_setWrapHeight` at a rate of 15fps for better performance
	// Private method
	// Runs functions
	var _eventThrottler = function ( eventTimeout, wrap, footer, options ) {
		if ( !eventTimeout ) {
			eventTimeout = setTimeout(function() {
				eventTimeout = null;
				_setWrapHeight( wrap, footer, options );
			}, 66);
		}
	};

	// Initialize Form Saver
	// Public function
	// Runs functions
	var init = function ( options ) {

		// Feature test before initializing
		if ( 'querySelector' in document && 'addEventListener' in window && Array.prototype.forEach ) {

			// Selectors and variables
			options = _mergeObjects( _defaults, options || {} ); // Merge user options with defaults
			var wrap = document.querySelector( '[data-sticky-wrap]' );
			var footer = document.querySelector( '[data-sticky-footer]' );
			var eventTimeout; // Timer for resize event throttler

			// Stick footer
			document.documentElement.style.height = '100%';
			document.body.style.height = '100%';
			_setWrapHeight( wrap, footer, options );
			window.addEventListener( 'resize', _eventThrottler.bind( null, eventTimeout, wrap, footer, options ), false); // Run Sticky Footer on window resize

		}

	};

	// Return public methods
	return {
		init: init
	};

})(window, document);