(function (root, factory) {
	if ( typeof define === 'function' && define.amd ) {
		define('petfinderToggleImage', factory(root));
	} else if ( typeof exports === 'object' ) {
		module.exports = factory(root);
	} else {
		root.petfinderToggleImage = factory(root);
	}
})(this, function (root) {

	'use strict';

	//
	// Variables
	//

	var exports = {}; // Object for public APIs
	var supports = !!document.querySelector && !!root.addEventListener; // Feature test

	// // Default settings
	// var defaults = {
	// 	someVar: 123,
	// 	callbackBefore: function () {},
	// 	callbackAfter: function () {}
	// };


	//
	// Methods
	//

	/**
	 * A simple forEach() implementation for Arrays, Objects and NodeLists
	 * @private
	 * @param {Array|Object|NodeList} collection Collection of items to iterate
	 * @param {Function} callback Callback function for each iteration
	 * @param {Array|Object|NodeList} scope Object/NodeList/Array that forEach is iterating over (aka `this`)
	 */
	var forEach = function (collection, callback, scope) {
		if (Object.prototype.toString.call(collection) === '[object Object]') {
			for (var prop in collection) {
				if (Object.prototype.hasOwnProperty.call(collection, prop)) {
					callback.call(scope, collection[prop], prop, collection);
				}
			}
		} else {
			for (var i = 0, len = collection.length; i < len; i++) {
				callback.call(scope, collection[i], i, collection);
			}
		}
	};

	/**
	 * Merge defaults with user options
	 * @private
	 * @param {Object} defaults Default settings
	 * @param {Object} options User options
	 * @returns {Object} Merged values of defaults and options
	 */
	var extend = function ( defaults, options ) {
		var extended = {};
		forEach(defaults, function (value, prop) {
			extended[prop] = defaults[prop];
		});
		forEach(options, function (value, prop) {
			extended[prop] = options[prop];
		});
		return extended;
	};

	/**
	 * Destroy the current initialization.
	 * @public
	 * @todo
	 */
	exports.destroy = function () {
		// @todo Undo init...
	};

	/**
	 * Load an image into the main image container
	 * @param  {Node} toggle Element that triggered the event
	 * @param  {Node} container Element to place image into
	 * @param  {Event} event Click event
	 */
	var showImage = function ( toggle, container, event ) {
		var img = toggle.firstChild.src;
		if (event) {
			event.preventDefault();
		}
		container.innerHTML = '<img src="' + img + '">';
	};

	/**
	 * Initialize Plugin
	 * @public
	 * @param {Object} options User settings
	 */
	exports.init = function ( options ) {

		// feature test
		if ( !supports ) return;

		// variables
		var imgToggles = document.querySelectorAll('[data-pet-img-toggle]');
		var container = document.querySelector('[data-pet-img-main]');

		if ( imgToggles.length === 0 ) return;
		forEach(imgToggles, function (toggle) {
			toggle.addEventListener('click', showImage.bind( null, toggle, container ), false);
		});
		showImage(imgToggles[0], container, null);

	};


	//
	// Public APIs
	//

	return exports;

});