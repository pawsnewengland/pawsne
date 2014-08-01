/**
 * pawsnewengland v5.0.1
 * WordPress theme for PAWS New England, by Chris Ferdinandi.
 * http://github.com/pawsnewengland/pawsne
 */

/*
 * classList.js: Cross-browser full element.classList implementation.
 * 2014-01-31
 *
 * By Eli Grey, http://eligrey.com
 * Public Domain.
 * NO WARRANTY EXPRESSED OR IMPLIED. USE AT YOUR OWN RISK.
 */

/*global self, document, DOMException */

/*! @source http://purl.eligrey.com/github/classList.js/blob/master/classList.js*/

if ("document" in self && !("classList" in document.createElement("_"))) {

	(function (view) {

		"use strict";

		if (!('Element' in view)) return;

		var
			classListProp = "classList",
			protoProp = "prototype",
			elemCtrProto = view.Element[protoProp],
			objCtr = Object,
			strTrim = String[protoProp].trim || function () {
				return this.replace(/^\s+|\s+$/g, "");
			},
			arrIndexOf = Array[protoProp].indexOf || function (item) {
				var
					i = 0,
					len = this.length;
				for (; i < len; i++) {
					if (i in this && this[i] === item) {
						return i;
					}
				}
				return -1;
			},
			// Vendors: please allow content code to instantiate DOMExceptions
			DOMEx = function (type, message) {
				this.name = type;
				this.code = DOMException[type];
				this.message = message;
			},
			checkTokenAndGetIndex = function (classList, token) {
				if (token === "") {
					throw new DOMEx(
						"SYNTAX_ERR",
						"An invalid or illegal string was specified"
					);
				}
				if (/\s/.test(token)) {
					throw new DOMEx(
						"INVALID_CHARACTER_ERR",
						"String contains an invalid character"
					);
				}
				return arrIndexOf.call(classList, token);
			},
			ClassList = function (elem) {
				var
					trimmedClasses = strTrim.call(elem.getAttribute("class") || ""),
					classes = trimmedClasses ? trimmedClasses.split(/\s+/) : [],
					i = 0,
					len = classes.length;
				for (; i < len; i++) {
					this.push(classes[i]);
				}
				this._updateClassName = function () {
					elem.setAttribute("class", this.toString());
				};
			},
			classListProto = ClassList[protoProp] = [],
			classListGetter = function () {
				return new ClassList(this);
			};
		// Most DOMException implementations don't allow calling DOMException's toString()
		// on non-DOMExceptions. Error's toString() is sufficient here.
		DOMEx[protoProp] = Error[protoProp];
		classListProto.item = function (i) {
			return this[i] || null;
		};
		classListProto.contains = function (token) {
			token += "";
			return checkTokenAndGetIndex(this, token) !== -1;
		};
		classListProto.add = function () {
			var
				tokens = arguments,
				i = 0,
				l = tokens.length,
				token,
				updated = false;
			do {
				token = tokens[i] + "";
				if (checkTokenAndGetIndex(this, token) === -1) {
					this.push(token);
					updated = true;
				}
			}
			while (++i < l);

			if (updated) {
				this._updateClassName();
			}
		};
		classListProto.remove = function () {
			var
				tokens = arguments,
				i = 0,
				l = tokens.length,
				token,
				updated = false;
			do {
				token = tokens[i] + "";
				var index = checkTokenAndGetIndex(this, token);
				if (index !== -1) {
					this.splice(index, 1);
					updated = true;
				}
			}
			while (++i < l);

			if (updated) {
				this._updateClassName();
			}
		};
		classListProto.toggle = function (token, force) {
			token += "";

			var
				result = this.contains(token),
				method = result ? force !== true && "remove" : force !== false && "add";

			if (method) {
				this[method](token);
			}

			return !result;
		};
		classListProto.toString = function () {
			return this.join(" ");
		};

		if (objCtr.defineProperty) {
			var classListPropDesc = {
				get: classListGetter,
				enumerable: true,
				configurable: true
			};
			try {
				objCtr.defineProperty(elemCtrProto, classListProp, classListPropDesc);
			} catch (ex) { // IE 8 doesn't support enumerable:true
				if (ex.number === -0x7FF5EC54) {
					classListPropDesc.enumerable = false;
					objCtr.defineProperty(elemCtrProto, classListProp, classListPropDesc);
				}
			}
		} else if (objCtr[protoProp].__defineGetter__) {
			elemCtrProto.__defineGetter__(classListProp, classListGetter);
		}

	}(self));

}
(function (root, factory) {
	if ( typeof define === 'function' && define.amd ) {
		define('astro', factory(root));
	} else if ( typeof exports === 'object' ) {
		module.exports = factory(root);
	} else {
		root.astro = factory(root);
	}
})(this, function (root) {

	'use strict';

	//
	// Variables
	//

	var exports = {}; // Object for public APIs
	var supports = !!document.querySelector && !!root.addEventListener; // Feature test
	var eventListeners = []; //Listeners array
	var settings, toggles;

	// Default settings
	var defaults = {
		toggleActiveClass: 'active',
		navActiveClass: 'active',
		initClass: 'js-astro',
		callbackBefore: function () {},
		callbackAfter: function () {}
	};


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
	 * Show and hide navigation menu
	 * @public
	 * @param  {Element} toggle Element that triggered the toggle
	 * @param  {String} navID The ID of the navigation element to toggle
	 * @param  {Object} settings
	 * @param  {Event} event
	 */
	exports.toggleNav = function ( toggle, navID, options, event ) {

		// Selectors and variables
		var settings = extend( settings || defaults, options || {} );  // Merge user options with defaults
		var nav = document.querySelector(navID);


		// If a link, prevent default click event
		if ( toggle && toggle.tagName.toLowerCase() === 'a' && event ) {
			event.preventDefault();
		}

		settings.callbackBefore( toggle, navID ); // Run callbacks before toggling nav
		toggle.classList.toggle( settings.toggleActiveClass ); // Toggle the '.active' class on the toggle element
		nav.classList.toggle( settings.navActiveClass ); // Toggle the '.active' class on the menu
		settings.callbackAfter( toggle, navID ); // Run callbacks after toggling nav

	};

	/**
	 * Destroy the current initialization.
	 * @public
	 */
	exports.destroy = function () {
		if ( !settings ) return;
		document.documentElement.classList.remove( settings.initClass );
		if ( toggles ) {
			forEach( toggles, function ( toggle, index ) {
				toggle.removeEventListener( 'click', eventListeners[index], false );
			});
			eventListeners = [];
		}
		settings = null;
		toggles = null;
	};

	/**
	 * Initialize Astro
	 * @public
	 * @param {Object} options User settings
	 */
	exports.init = function ( options ) {

		// feature test
		if ( !supports ) return;

		// Destroy any existing initializations
		exports.destroy();

		// Selectors and variables
		settings = extend( defaults, options || {} ); // Merge user options with defaults
		toggles = document.querySelectorAll('[data-nav-toggle]'); // Get all nav toggles

		document.documentElement.classList.add( settings.initClass ); // Add class to HTML element to activate conditional CSS

		// When a nav toggle is clicked, show or hide the nav
		forEach(toggles, function (toggle, index) {
			eventListeners[index] = exports.toggleNav.bind( null, toggle, toggle.getAttribute('data-nav-toggle'), settings );
			toggle.addEventListener('click', eventListeners[index], false);
		});

	};


	//
	// Public APIs
	//

	return exports;

});
(function (root, factory) {
	if ( typeof define === 'function' && define.amd ) {
		define('drop', factory(root));
	} else if ( typeof exports === 'object' ) {
		module.exports = factory(root);
	} else {
		root.drop = factory(root);
	}
})(this, function (root) {

	'use strict';

	//
	// Variables
	//

	var exports = {}; // Object for public APIs
	var supports = !!document.querySelector && !!root.addEventListener; // Feature test
	var eventListeners = { //Listener arrays
		toggle: [],
		menu: []
	};
	var settings, toggles, menus;

	// Default settings
	var defaults = {
		toggleSelector: '.dropdown',
		contentSelector: '.dropdown-menu',
		toggleActiveClass: 'active',
		contentActiveClass: 'active',
		initClass: 'js-drop',
		callbackBefore: function () {},
		callbackAfter: function () {}
	};


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
	 * Get siblings of an element
	 * @private
	 * @param  {Element} elem
	 * @return {NodeList}
	 */
	var getSiblings = function (elem) {
		var siblings = [];
		var sibling = elem.parentNode.firstChild;
		var skipMe = elem;
		for ( ; sibling; sibling = sibling.nextSibling ) {
			if ( sibling.nodeType == 1 && sibling != elem ) {
				siblings.push( sibling );
			}
		}
		return siblings;
	};

	/**
	 * Toggle a dropdown menu
	 * @public
	 * @param  {Element} toggle Element that triggered the expand or collapse
	 * @param  {Object} settings
	 * @param  {Event} event
	 */
	exports.toggleDrop = function ( toggle, options, event ) {

		// Selectors and variables
		var settings = extend( settings || defaults, options || {} );  // Merge user options with defaults
		var toggleMenu = toggle.nextElementSibling;
		var toggleParent = toggle.parentNode;
		var toggleSiblings = getSiblings(toggleParent);

		// Prevent defaults
		if ( event ) {
			event.stopPropagation();
			event.preventDefault();
		}

		settings.callbackBefore( toggle ); // Run callbacks before drop toggle

		// Add/remove '.active' class from dropdown item
		toggle.classList.toggle( settings.toggleActiveClass );
		toggleMenu.classList.toggle( settings.contentActiveClass );
		toggleParent.classList.toggle( settings.toggleActiveClass );

		// For each toggle, remove the active class
		forEach(toggleSiblings, function (sibling) {
			var siblingContent = sibling.children;
			sibling.classList.remove( settings.toggleActiveClass );
			forEach(siblingContent, function (content) {
				content.classList.remove( settings.contentActiveClass );
			});
		});

		settings.callbackAfter( toggle ); // Run callbacks after drop toggle

	};

	/**
	 * Close all dropdown menus
	 * @private
	 * @param  {Object} settings
	 */
	var closeDrops = function ( settings ) {

		// Selectors and variables
		var dropToggle = document.querySelectorAll(settings.toggleSelector + ' > a.' + settings.toggleActiveClass);
		var dropWrapper = document.querySelectorAll(settings.toggleSelector + '.' + settings.toggleActiveClass);
		var dropContent = document.querySelectorAll(settings.contentSelector + '.' + settings.contentActiveClass);

		if ( dropToggle.length > 0 || dropWrapper.length > 0 || dropContent > 0 ) {

			settings.callbackBefore(); // Run callbacks before drop close

			// For each dropdown toggle, remove '.active' class
			forEach(dropToggle, function (toggle) {
				toggle.classList.remove( settings.toggleActiveClass );
			});

			// For each dropdown toggle wrapper, remove '.active' class
			forEach(dropWrapper, function (wrapper) {
				wrapper.classList.remove( settings.toggleActiveClass );
			});

			// For each dropdown content area, remove '.active' class
			forEach(dropContent, function (content) {
				content.classList.remove( settings.contentActiveClass );
			});

			settings.callbackAfter(); // Run callbacks after drop close

		}

	};

	/**
	 * Don't close dropdown menus when clicking on content within them
	 * @private
	 * @param  {Event} event
	 */
	var handleDropdownClick = function ( event ) {
		event.stopPropagation();
	};

	/**
	 * Destroy the current initialization.
	 * @public
	 */
	exports.destroy = function () {
		if ( !settings ) return;
		document.documentElement.classList.remove( settings.initClass );
		document.removeEventListener('click', closeDrops, false);
		if ( toggles ) {
			forEach( toggles, function ( toggle, index ) {
				toggle.removeEventListener( 'click', eventListeners.toggle[index], false );
			});
			eventListeners.toggle = [];
		}
		if ( menus ) {
			forEach( menus, function ( menu, index ) {
				menu.removeEventListener( 'click', eventListeners.menu[index], false );
			});
			eventListeners.menu = [];
		}
		settings = null;
		toggles = null;
		menus = null;
	};

	/**
	 * Initialize Drop
	 * @public
	 * @param {Object} options User settings
	 */
	exports.init = function ( options ) {

		// feature test
		if ( !supports ) return;

		// Destroy any existing initializations
		exports.destroy();

		// Selectors and variables
		settings = extend( defaults, options || {} ); // Merge user options with defaults
		toggles = document.querySelectorAll(settings.toggleSelector + ' > a');
		menus = document.querySelectorAll(settings.contentSelector);

		// Add class to HTML element to activate conditional CSS
		document.documentElement.classList.add( settings.initClass );

		// When body is clicked, close all dropdowns
		document.addEventListener('click', closeDrops.bind( null, settings ), false);

		// When a toggle is clicked, show/hide dropdown menu
		forEach(toggles, function (toggle, index) {
			eventListeners.toggle[index] = exports.toggleDrop.bind( null, toggle, settings );
			toggle.addEventListener('click', eventListeners.toggle[index], false);
		});

		// When dropdown menu content is clicked, don't close the menu
		forEach(menus, function (menu, index) {
			eventListeners.menu[index] = handleDropdownClick;
			menu.addEventListener('click', eventListeners.menu[index], false);
		});

	};


	//
	// Public APIs
	//

	return exports;

});
/*! fluidvids.js v2.4.1 | (c) 2014 @toddmotto | https://github.com/toddmotto/fluidvids */
(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    define(factory);
  } else if (typeof exports === 'object') {
    module.exports = factory;
  } else {
    root.fluidvids = factory();
  }
})(this, function () {

  'use strict';

  var fluidvids = {
    selector: ['iframe'],
    players: ['www.youtube.com', 'player.vimeo.com']
  };

  var css = [
    '.fluidvids {',
      'width: 100%; max-width: 100%; position: relative;',
    '}',
    '.fluidvids-item {',
      'position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;',
    '}'
  ].join('');

  var head = document.head || document.getElementsByTagName('head')[0];

  var matches = function (src) {
    return new RegExp('^(https?:)?\/\/(?:' + fluidvids.players.join('|') + ').*$', 'i').test(src);
  };

  var getRatio = function (height, width) {
    return ((parseInt(height, 10) / parseInt(width, 10)) * 100) + '%';
  };

  var fluid = function (elem) {
    if (!matches(elem.src) || !!elem.getAttribute('data-fluidvids')) return;
    var wrap = document.createElement('div');
    elem.parentNode.insertBefore(wrap, elem);
    elem.className += (elem.className ? ' ' : '') + 'fluidvids-item';
    elem.setAttribute('data-fluidvids', 'loaded');
    wrap.className += 'fluidvids';
    wrap.style.paddingTop = getRatio(elem.height, elem.width);
    wrap.appendChild(elem);
  };

  var addStyles = function () {
    var div = document.createElement('div');
    div.innerHTML = '<p>x</p><style>' + css + '</style>';
    head.appendChild(div.childNodes[1]);
  };

  fluidvids.render = function () {
    var nodes = document.querySelectorAll(fluidvids.selector.join());
    var i = nodes.length;
    while (i--) {
      fluid(nodes[i]);
    }
  };

  fluidvids.init = function (obj) {
    for (var key in obj) {
      fluidvids[key] = obj[key];
    }
    fluidvids.render();
    addStyles();
  };

  return fluidvids;

});
/* =============================================================

	Better Adoption Forms v2.0
	Store and load data for better adoption forms, by Chris Ferdinandi.
	http://gomakethings.com

	Free to use under the MIT License.
	http://gomakethings.com/mit/

 * ============================================================= */

(function (root, factory) {
	if ( typeof define === 'function' && define.amd ) {
		define('formSaver', factory(root));
	} else if ( typeof exports === 'object' ) {
		module.exports = factory(root);
	} else {
		root.formSaver = factory(root);
	}
})(this, function (root) {

	'use strict';

	//
	// Variables
	//

	var exports = {}; // Object for public APIs
	var supports = !!document.querySelector && !!root.addEventListener && !!root.localStorage; // Feature test
	var eventListeners = { //Listener arrays
		save: [],
		del: []
	};
	var settings, forms, saveBtns, deleteBtns, petNameField;

	// Default settings
	var defaults = {
		deleteClear: true,
		saveMessage: 'Saved!',
		deleteMessage: 'Deleted!',
		saveClass: '',
		deleteClass: '',
		initClass: 'js-form-saver',
		callbackBeforeSave: function () {},
		callbackAfterSave: function () {},
		callbackBeforeDelete: function () {},
		callbackAfterDelete: function () {},
		callbackBeforeLoad: function () {},
		callbackAfterLoad: function () {}
	};


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
	 * Remove whitespace from a string
	 * @private
	 * @param {String} string
	 * @returns {String}
	 */
	var trim = function ( string ) {
		return string.replace(/^\s+|\s+$/g, '');
	};

	/**
	 * Convert data-options attribute into an object of key/value pairs
	 * @private
	 * @param {String} options Link-specific options as a data attribute string
	 * @returns {Object}
	 */
	var getDataOptions = function ( options ) {
		return !options || !(typeof JSON === 'object' && typeof JSON.parse === 'function') ? {} : JSON.parse( options );
	};

	/**
	 * Save form data to localStorage
	 * @public
	 * @param  {Element} btn Button that triggers form save
	 * @param  {Element} form The form to save
	 * @param  {Object} options
	 * @param  {Event} event
	 */
	exports.saveForm = function ( btn, formID, options, event ) {

		// Defaults and settings
		var settings = extend( settings || defaults, options || {} );  // Merge user options with defaults
		var overrides = getDataOptions( btn ? btn.getAttribute('data-options') : null );
		settings = extend( settings, overrides ); // Merge overrides with settings

		// Selectors and variables
		var form = document.querySelector(formID);
		var formSaverID = 'formSaver-' + form.className;
		var formSaverData = {};
		var formFields = form.elements;
		var formStatus = form.querySelectorAll('[data-form-status]');

		/**
		 * Convert field data into an array
		 * @private
		 * @param  {Element} field Form field to convert
		 */
		var prepareField = function (field) {
			if ( !field.hasAttribute('data-form-no-save') ) {
				if ( field.type.toLowerCase() === 'radio' || field.type.toLowerCase() === 'checkbox' ) {
					if ( field.checked === true ) {
						formSaverData[field.name + field.value] = 'on';
					}
				} else if ( field.type.toLowerCase() !== 'hidden' && field.type.toLowerCase() !== 'submit' ) {
					if ( field.value && field.value !== '' ) {
						formSaverData[field.name] = field.value;
					}
				}
			}
		};

		/**
		 * Display status message
		 * @private
		 * @param  {Element} status The element that displays the status message
		 * @param  {String} saveMessage The message to display on save
		 * @param  {String} saveClass The class to apply to the save message wrappers
		 */
		var displayStatus = function ( status, saveMessage, saveClass ) {
			status.innerHTML = saveClass === '' ? '<div>' + saveMessage + '</div>' : '<div class="' + saveClass + '">' + saveMessage + '</div>';
		};

		// If a link or button, prevent default click event
		if ( btn && (btn.tagName.toLowerCase() === 'a' || btn.tagName.toLowerCase() === 'button' ) && event ) {
			event.preventDefault();
		}

		settings.callbackBeforeSave( btn, form ); // Run callbacks before save

		// Add field data to array
		forEach(formFields, function (field) {
			prepareField(field);
		});

		// Display save success message
		forEach(formStatus, function (status) {
			displayStatus( status, settings.saveMessage, settings.saveClass );
		});

		// Save form data in localStorage
		localStorage.setItem( formSaverID, JSON.stringify(formSaverData) );

		settings.callbackAfterSave( btn, form ); // Run callbacks after save

	};

	/**
	 * Remove form data from localStorage
	 * @public
	 * @param  {Element} btn Button that triggers form delete
	 * @param  {Element} form The form to remove from localStorage
	 * @param  {Object} options
	 * @param  {Event} event
	 */
	exports.deleteForm = function ( btn, formID, options, event ) {

		// Defaults and settings
		var settings = extend( settings || defaults, options || {} );  // Merge user options with defaults
		var overrides = getDataOptions( btn ? btn.getAttribute('data-options') : null );
		settings = extend( settings, overrides ); // Merge overrides with settings

		// Selectors and variables
		var form = document.querySelector(formID);
		var formSaverID = 'formSaver-' + form.className;
		var formStatus = form.querySelectorAll('[data-form-status]');
		var formMessage = settings.deleteClass === '' ? '<div>' + settings.deleteMessage + '</div>' : '<div class="' + settings.deleteClass + '">' + settings.deleteMessage + '</div>';

		/**
		 * Display succes message
		 * @private
		 */
		var displayStatus = function () {
			if ( settings.deleteClear === true || settings.deleteClear === 'true' ) {
				sessionStorage.setItem(formSaverID + '-formSaverMessage', formMessage);
				location.reload(false);
			} else {
				forEach(formStatus, function (status) {
					status.innerHTML = formMessage;
				});
			}
		};

		// If a link or button, prevent default click event
		if ( btn && (btn.tagName.toLowerCase() === 'a' || btn.tagName.toLowerCase() === 'button' ) && event ) {
			event.preventDefault();
		}

		settings.callbackBeforeDelete( btn, form ); // Run callbacks before delete
		localStorage.removeItem(formSaverID); // Remove form data
		displayStatus(); // Display delete success message
		settings.callbackAfterDelete( btn, form ); // Run callbacks after delete

	};

	/**
	 * Load form data from localStorage
	 * @public
	 * @param  {Element} form The form to get data for
	 * @param  {Object} options
	 */
	exports.loadForm = function ( form, options ) {

		// Selectors and variables
		var settings = extend( settings || defaults, options || {} );  // Merge user options with defaults
		var formSaverID = 'formSaver-' + form.className;
		var formSaverData = JSON.parse( localStorage.getItem(formSaverID) );
		var formFields = form.elements;
		var formStatus = form.querySelectorAll('[data-form-status]');

		/**
		 * Populate a field with localStorage data
		 * @private
		 * @param  {Element} field The field to get data form
		 */
		var populateField = function ( field ) {
			if ( formSaverData ) {
				if ( field.type.toLowerCase() === 'radio' || field.type.toLowerCase() === 'checkbox' ) {
					if ( formSaverData[field.name + field.value] === 'on' ) {
						field.checked = true;
					}
				} else if ( field.type.toLowerCase() !== 'hidden' && field.type.toLowerCase() !== 'submit' ) {
					if ( formSaverData[field.name] ) {
						field.value = formSaverData[field.name];
					}
				}
			}
		};

		/**
		 * Display success message
		 * @param  {Element} status The element that displays the status message
		 */
		var displayStatus = function ( status ) {
			status.innerHTML = sessionStorage.getItem(formSaverID + '-formSaverMessage');
			sessionStorage.removeItem(formSaverID + '-formSaverMessage');
		};

		settings.callbackBeforeLoad( form ); // Run callbacks before load

		// Populate form with data from localStorage
		forEach(formFields, function (field) {
			populateField(field);
		});

		// If page was reloaded and delete success message exists, display it
		forEach(formStatus, function (status) {
			displayStatus(status);
		});

		settings.callbackAfterLoad( form ); // Run callbacks after load

	};

	/**
	 * Save the name and id of the pet user is interested in adopting
	 */
	exports.savePetName = function () {

		// feature test
		if ( !supports ) return;

		// Pass the name of the dog the user is interested in adopting
		// from the "Our Dogs" page to the Adoption Form
		var adoptToggle = document.querySelectorAll('.adopt-toggle');
		forEach( adoptToggle, function ( toggle ) {
			toggle.addEventListener('click', function(e) {
				var name = toggle.getAttribute('data-name');
				sessionStorage.setItem('petToAdopt', name);
			}, false);
		});

	};

	/**
	 * Get the name and id of the pet user is interested in adopting from localStorage
	 * @param  {Element} petNameField The field for the pet's name
	 */
	var adoptionFormGetPet = function (petNameField) {
		var petName = sessionStorage.getItem('petToAdopt');
		petNameField.value = petName;
		sessionStorage.removeItem('petToAdopt');
	};

	/**
	 * Destroy the current initialization.
	 * @public
	 */
	exports.destroy = function () {
		if ( !settings ) return;
		document.documentElement.classList.remove( settings.initClass );
		if ( saveBtns ) {
			forEach( saveBtns, function ( btn, index ) {
				btn.removeEventListener( 'click', eventListeners.save[index], false );
			});
			eventListeners.save = [];
		}
		if ( deleteBtns ) {
			forEach( deleteBtns, function ( btn, index ) {
				btn.removeEventListener( 'click', eventListeners.del[index], false );
			});
			eventListeners.del = [];
		}
		settings = null;
		forms = null;
		saveBtns = null;
		deleteBtns = null;
		petNameField = null;
	};

	/**
	 * Initialize Form Saver
	 * @public
	 * @param {Object} options User settings
	 */
	exports.init = function ( options ) {

		// feature test
		if ( !supports ) return;

		// Destroy any existing initializations
		exports.destroy();

		// Selectors and variables
		settings = extend( defaults, options || {} ); // Merge user options with defaults
		forms = document.forms;
		saveBtns = document.querySelectorAll('[data-form-save]');
		deleteBtns = document.querySelectorAll('[data-form-delete]');
		petNameField = document.querySelector('#input-dog-name');

		// Add class to HTML element to activate conditional CSS
		document.documentElement.className += (document.documentElement.className ? ' ' : '') + settings.initClass;

		// When a save button is clicked, save form data
		forEach(saveBtns, function (btn, index) {
			eventListeners.save[index] = exports.saveForm.bind( null, btn, btn.getAttribute('data-form-save'), settings );
			btn.addEventListener('click', eventListeners.save[index], false);
		});

		// When a delete button is clicked, delete form data
		forEach(deleteBtns, function (btn, index) {
			eventListeners.del[index] = exports.deleteForm.bind( null, btn, btn.getAttribute('data-form-delete'), settings );
			btn.addEventListener('click', eventListeners.del[index], false);
		});

		// Get saved form data on page load
		forEach(forms, function (form) {
			exports.loadForm( form, settings );
		});

		if ( petNameField ) {
			adoptionFormGetPet(petNameField);
		}

	};


	//
	// Public APIs
	//

	return exports;

});
(function (root, factory) {
	if ( typeof define === 'function' && define.amd ) {
		define('houdini', factory(root));
	} else if ( typeof exports === 'object' ) {
		module.exports = factory(root);
	} else {
		root.houdini = factory(root);
	}
})(this, function (root) {

	'use strict';

	//
	// Variables
	//

	var exports = {}; // Object for public APIs
	var supports = !!document.querySelector && !!root.addEventListener; // Feature test
	var eventListeners = []; //Listeners array
	var settings, toggles;

	// Default settings
	var defaults = {
		toggleActiveClass: 'active',
		contentActiveClass: 'active',
		initClass: 'js-houdini',
		callbackBefore: function () {},
		callbackAfter: function () {}
	};


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
	 * Stop YouTube, Vimeo, and HTML5 videos from playing when leaving the slide
	 * @private
	 * @param  {Element} content The content container the video is in
	 * @param  {String} activeClass The class asigned to expanded content areas
	 */
	var stopVideos = function ( content, activeClass ) {
		if ( !content.classList.contains( activeClass ) ) {
			var iframe = content.querySelector( 'iframe');
			var video = content.querySelector( 'video' );
			if ( iframe ) {
				var iframeSrc = iframe.src;
				iframe.src = iframeSrc;
			}
			if ( video ) {
				video.pause();
			}
		}
	};

	/**
	 * Close all content areas in an expand/collapse group
	 * @private
	 * @param  {Element} toggle The element that toggled the expand or collapse
	 * @param  {Object} settings
	 */
	var closeCollapseGroup = function ( toggle, settings ) {
		if ( !toggle.classList.contains( settings.toggleActiveClass ) && toggle.hasAttribute('data-group') ) {

			// Get all toggles in the group
			var groupName = toggle.getAttribute('data-group');
			var group = document.querySelectorAll('[data-group="' + groupName + '"]');

			// Deactivate each toggle and it's content area
			forEach(group, function (item) {
				var content = document.querySelector( item.getAttribute('data-collapse') );
				item.classList.remove( settings.toggleActiveClass );
				content.classList.remove( settings.contentActiveClass );
			});

		}
	};

	/**
	 * Toggle the collapse/expand widget
	 * @public
	 * @param  {Element} toggle The element that toggled the expand or collapse
	 * @param  {String} contentID The ID of the content area to expand or collapse
	 * @param  {Object} options
	 * @param  {Event} event
	 */
	exports.toggleContent = function (toggle, contentID, options, event) {

		var settings = extend( settings || defaults, options || {} );  // Merge user options with defaults
		var content = document.querySelector(contentID); // Get content area

		// If toggle is a link, prevent default click event
		if ( toggle && toggle.tagName.toLowerCase() === 'a' && event ) {
			event.preventDefault();
		}

		settings.callbackBefore( toggle, contentID ); // Run callbacks before toggling content

		// Toggle collapse element
		closeCollapseGroup(toggle, settings); // Close collapse group items
		toggle.classList.toggle( settings.toggleActiveClass );// Change text on collapse toggle
		content.classList.toggle( settings.contentActiveClass ); // Collapse or expand content area
		stopVideos( content, settings.contentActiveClass ); // If content area is closed, stop playing any videos

		settings.callbackAfter( toggle, contentID ); // Run callbacks after toggling content

	};

	/**
	 * Destroy the current initialization.
	 * @public
	 */
	exports.destroy = function () {
		if ( !settings ) return;
		document.documentElement.classList.remove( settings.initClass );
		if ( toggles ) {
			forEach( toggles, function ( toggle, index ) {
				toggle.removeEventListener( 'click', eventListeners[index], false );
			});
			eventListeners = [];
		}
		settings = null;
		toggles = null;
	};

	/**
	 * Initialize Houdini
	 * @public
	 * @param {Object} options User settings
	 */
	exports.init = function ( options ) {

		// feature test
		if ( !supports ) return;

		// Destroy any existing initializations
		exports.destroy();

		// Selectors and variables
		settings = extend( defaults, options || {} ); // Merge user options with defaults
		toggles = document.querySelectorAll('[data-collapse]'); // Get all collapse toggles

		// Add class to HTML element to activate conditional CSS
		document.documentElement.classList.add( settings.initClass );

		// Whenever a toggle is clicked, run the expand/collapse function
		forEach(toggles, function (toggle, index) {
			eventListeners[index] = exports.toggleContent.bind( null, toggle, toggle.getAttribute('data-collapse'), settings );
			toggle.addEventListener('click', eventListeners[index], false);
		});

	};


	//
	// Public APIs
	//

	return exports;

});
/*!
loadCSS: load a CSS file asynchronously.
[c]2014 @scottjehl, Filament Group, Inc.
Licensed MIT
*/
function loadCSS( href, before, media ){
	"use strict";
	// Arguments explained:
	// `href` is the URL for your CSS file.
	// `before` optionally defines the element we'll use as a reference for injecting our <link>
	// By default, `before` uses the first <script> element in the page.
	// However, since the order in which stylesheets are referenced matters, you might need a more specific location in your document.
	// If so, pass a different reference element to the `before` argument and it'll insert before that instead
	// note: `insertBefore` is used instead of `appendChild`, for safety re: http://www.paulirish.com/2011/surefire-dom-element-insertion/
	var ss = window.document.createElement( "link" );
	var ref = before || window.document.getElementsByTagName( "script" )[ 0 ];
	ss.rel = "stylesheet";
	ss.href = href;
	// temporarily, set media to something non-matching to ensure it'll fetch without blocking render
	ss.media = "only x";
	// inject link
	ref.parentNode.insertBefore( ss, ref );
	// set media back to `all` so that the styleshet applies once it loads
	setTimeout( function(){
		ss.media = media || "all";
	} );
	return ss;
 }

(function (root, factory) {
	if ( typeof define === 'function' && define.amd ) {
		define('modals', factory(root));
	} else if ( typeof exports === 'object' ) {
		module.exports = factory(root);
	} else {
		root.modals = factory(root);
	}
})(this, function (root) {

	'use strict';

	//
	// Variables
	//

	var exports = {}; // Object for public APIs
	var supports = !!document.querySelector && !!root.addEventListener; // Feature test
	var eventListeners = {  //Listener arrays
		toggles: [],
		modals: [],
		buttons: []
	};
	var settings, toggles, modals, buttons;

	// Default settings
	var defaults = {
		modalActiveClass: 'active',
		modalBGClass: 'modal-bg',
		offset: 50,
		callbackBeforeOpen: function () {},
		callbackAfterOpen: function () {},
		callbackBeforeClose: function () {},
		callbackAfterClose: function () {}
	};


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
	 * Stop YouTube, Vimeo, and HTML5 videos from playing when leaving the slide
	 * @private
	 * @param  {Element} content The content container the video is in
	 * @param  {String} activeClass The class asigned to expanded content areas
	 */
	var stopVideos = function ( content, activeClass ) {
		if ( !content.classList.contains( activeClass ) ) {
			var iframe = content.querySelector( 'iframe');
			var video = content.querySelector( 'video' );
			if ( iframe ) {
				var iframeSrc = iframe.src;
				iframe.src = iframeSrc;
			}
			if ( video ) {
				video.pause();
			}
		}
	};

	/**
	 * Open the target modal window
	 * @public
	 * @param  {Element} toggle The element that toggled the open modal event
	 * @param  {String} modalID ID of the modal to open
	 * @param  {Object} options
	 * @param  {Event} event
	 */
	exports.openModal = function (toggle, modalID, options, event) {

		// Define the modal
		var settings = extend( settings || defaults, options || {} );  // Merge user options with defaults
		var modal = document.querySelector(modalID);

		// Define the modal background
		var modalBg = document.createElement('div');
		modalBg.setAttribute('data-modal-bg', null);
		modalBg.classList.add( settings.modalBGClass );

		// Prevent `closeModals()` and the default link behavior
		if ( event ) {
			event.stopPropagation();
			if ( toggle && toggle.tagName.toLowerCase() === 'a' ) {
				event.preventDefault();
			}
		}

		settings.callbackBeforeOpen( toggle, modalID ); // Run callbacks before opening a modal

		// Activate the modal
		modal.classList.add( settings.modalActiveClass );
		modal.style.top = window.pageYOffset + parseInt(settings.offset, 10) + 'px';
		document.body.appendChild(modalBg);

		settings.callbackAfterOpen( toggle, modalID ); // Run callbacks after opening a modal

	};

	/**
	 * Close all modal windows
	 * @public
	 * @param  {Object} options
	 * @param  {Event} event
	 */
	exports.closeModals = function (options, event) {

		// Selectors and variables
		var settings = extend( defaults, options || {} ); // Merge user options with defaults
		var openModals = document.querySelectorAll('[data-modal-window].' + settings.modalActiveClass);
		var modalsBg = document.querySelectorAll('[data-modal-bg]'); // Get modal background element

		if ( openModals.length > 0 || modalsBg.length > 0 ) {

			settings.callbackBeforeClose(); // Run callbacks before closing a modal

			// Close all modals
			forEach(openModals, function (modal) {
				if ( modal.classList.contains( settings.modalActiveClass ) ) {
					stopVideos(modal); // If active, stop video from playing
					modal.classList.remove( settings.modalActiveClass );
				}
			});

			// Remove all modal backgrounds
			forEach(modalsBg, function (bg) {
				document.body.removeChild(bg);
			});

			settings.callbackAfterClose(); // Run callbacks after closing a modal

		}

	};

	/**
	 * Close modals when the esc key is pressed
	 * @private
	 * @param  {Object} options [description]
	 * @param  {Event} event   [description]
	 */
	var handleEscKey = function (settings, event) {
		if (event.keyCode === 27) {
			exports.closeModals(settings, event);
		}
	};

	/**
	 * Don't close modals when clicking inside one
	 * @private
	 * @param  {Event} event
	 */
	var handleModalClick = function ( event ) {
		event.stopPropagation();
	};

	/**
	 * Destroy the current initialization.
	 * @public
	 */
	exports.destroy = function () {
		if ( !settings ) return;
		if ( toggles ) {
			forEach( toggles, function ( toggle, index ) {
				toggle.removeEventListener( 'click', eventListeners.toggles[index], false );
			});
			forEach( modals, function ( modal, index ) {
				modal.removeEventListener( 'click', eventListeners.modals[index], false );
				modal.removeEventListener( 'touchstart', eventListeners.modals[index], false );
			});
			forEach( buttons, function ( btn, index ) {
				btn.removeEventListener( 'click', eventListeners.buttons[index], false );
			});
			document.removeEventListener('click', exports.closeModals, false);
			document.removeEventListener('touchstart', exports.closeModals, false);
			document.removeEventListener('keydown', handleEscKey, false);
			eventListeners.toggles = [];
			eventListeners.modals = [];
			eventListeners.buttons = [];
		}
		settings = null;
		toggles = null;
		modals = null;
		buttons = null;
	};

	/**
	 * Initialize Modals
	 * @public
	 * @param {Object} options User settings
	 */
	exports.init = function ( options ) {

		// feature test
		if ( !supports ) return;

		// Destroy any existing initializations
		exports.destroy();

		// Selectors and variables
		settings = extend( defaults, options || {} ); // Merge user options with defaults
		toggles = document.querySelectorAll('[data-modal]');
		modals = document.querySelectorAll('[data-modal-window]');
		buttons = document.querySelectorAll('[data-modal-close]');

		// When modal toggle is clicked, open modal
		forEach(toggles, function (toggle, index) {
			eventListeners.toggles[index] = exports.openModal.bind(null, toggle, toggle.getAttribute('data-modal'), settings);
			toggle.addEventListener('click', eventListeners.toggles[index], false);
		});

		// When modal close is clicked, close modal
		forEach(buttons, function (btn, index) {
			eventListeners.buttons[index] = exports.closeModals.bind(null, settings);
			btn.addEventListener('click', eventListeners.buttons[index], false);
		});

		// When page outside of modal is clicked, close modal
		document.addEventListener('click', exports.closeModals.bind(null, settings), false); // When body is clicked
		document.addEventListener('touchstart', exports.closeModals.bind(null, settings), false); // When body is tapped
		document.addEventListener('keydown', handleEscKey.bind(null, settings), false); // When esc key is pressed

		// When modal itself is clicked, don't close it
		forEach(modals, function (modal, index) {
			eventListeners.modals[index] = handleModalClick;
			modal.addEventListener('click', eventListeners.modals[index], false);
			modal.addEventListener('touchstart', eventListeners.modals[index], false);
		});

	};


	//
	// Public APIs
	//

	return exports;

});
/* =============================================================

	Petfinder Sort v3.0
	Filter PetFinder results by a variety of categories, by Chris Ferdinandi.
	http://gomakethings.com

	Free to use under the MIT License.
	http://gomakethings.com/mit/

 * ============================================================= */

(function (root, factory) {
	if ( typeof define === 'function' && define.amd ) {
		define('petfinderSort', factory(root));
	} else if ( typeof exports === 'object' ) {
		module.exports = factory(root);
	} else {
		root.petfinderSort = factory(root);
	}
})(this, function (root) {

	'use strict';

	//
	// Variables
	//

	var exports = {}; // Object for public APIs
	var supports = !!document.querySelector && !!root.addEventListener && !!root.localStorage; // Feature test

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
	 * Setup save filter settings
	 * @param  {Element} filter Checkbox element
	 */
	var petfinderSortSave = function (filter) {
		if ( window.sessionStorage ) {
			var name = filter.getAttribute('data-target');
			if ( filter.checked === false ) {
				sessionStorage.setItem(name, 'unchecked');
			} else {
				sessionStorage.removeItem(name);
			}
		}
	};

	/**
	 * Setup show/hide filter
	 */
	var petfinderSort = function (pets, petFilterBreeds, petFilterOthers) {
		forEach(pets, function (pet) {
			pet.classList.add('hide');
		});
		forEach(petFilterBreeds, function (filter) {
			var sortTargetValue = filter.getAttribute('data-target');
			var sortTargets = document.querySelectorAll(sortTargetValue);
			if ( filter.checked === true ) {
				forEach(sortTargets, function (target) {
					target.classList.remove('hide');
				});
			}
		});
		forEach(petFilterOthers, function (filter) {
			var sortTargetValue = filter.getAttribute('data-target');
			var sortTargets = document.querySelectorAll(sortTargetValue);
			if ( filter.checked === false ) {
				forEach(sortTargets, function (target) {
					target.classList.add('hide');
				});
			}
		});
	};

	/**
	 * Get sort settings from localStorage
	 * @param  {Element} filter Checkbox to get data for
	 */
	var petfinderSortGet = function (filter) {
		if ( window.sessionStorage ) {
			var name = filter.getAttribute('data-target');
			var status = sessionStorage.getItem(name);
			if ( status === 'unchecked' ) {
				filter.checked = false;
			}
		}
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
	 * Initialize Plugin
	 * @public
	 * @param {Object} options User settings
	 */
	exports.init = function ( options ) {

		// feature test
		if ( !supports ) return;

		// Variables
		var pets = document.querySelectorAll('.pf');
		var petFilterBreeds = document.querySelectorAll('.pf-breeds');
		var petFilterOthers = document.querySelectorAll('.pf-sort');
		var petFilterToggleAll = document.querySelectorAll('.pf-toggle-all');

		// Toggle check/uncheck all
		forEach(petFilterToggleAll, function (filter) {
			filter.addEventListener('change', function(e) {
				var sortTargetValue = filter.getAttribute('data-target');
				var sortTargets = document.querySelectorAll(sortTargetValue);
				if ( filter.checked === true ) {
					forEach(sortTargets, function (target) {
						target.checked = true;
						petfinderSortSave(target);
					});
				} else {
					forEach(sortTargets, function (target) {
						target.checked = false;
						petfinderSortSave(target);
					});
				}
				petfinderSortSave(filter);
				petfinderSort(pets, petFilterBreeds, petFilterOthers);
			}, false);
		});


		// Run sort when filter is changed
		forEach(petFilterBreeds, function (filter) {
			filter.addEventListener('change', function(e) {
				petfinderSort(pets, petFilterBreeds, petFilterOthers);
				petfinderSortSave(filter);
			}, false);
		});

		forEach(petFilterOthers, function (filter) {
			filter.addEventListener('change', function(e) {
				petfinderSort(pets, petFilterBreeds, petFilterOthers);
				petfinderSortSave(filter);
			}, false);
		});


		// Load filter settings on page load
		forEach(petFilterBreeds, function (filter) {
			petfinderSortGet(filter);
		});
		forEach(petFilterOthers, function (filter) {
			petfinderSortGet(filter);
		});
		forEach(petFilterToggleAll, function (filter) {
			petfinderSortGet(filter);
		});
		petfinderSort(pets, petFilterBreeds, petFilterOthers);

	};


	//
	// Public APIs
	//

	return exports;

});
(function (root, factory) {
	if ( typeof define === 'function' && define.amd ) {
		define('rightHeight', factory(root));
	} else if ( typeof exports === 'object' ) {
		module.exports = factory(root);
	} else {
		root.rightHeight = factory(root);
	}
})(this, function (root) {

	'use strict';

	//
	// Variables
	//

	var exports = {}; // Object for public APIs
	var supports = !!document.querySelector && !!root.addEventListener; // Feature test
	var settings;

	// Default settings
	var defaults = {
		callbackBefore: function () {},
		callbackAfter: function () {}
	};


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
	 * Calculate distance to top of page
	 * @private
	 * @param  {Element} content The content area to get the distance for
	 * @return {Number} Distance to the top of the document
	 */
	var getDistanceToTop = function ( content ) {
		var distance = 0;
		if (content.offsetParent) {
			do {
				distance += content.offsetTop;
				content = content.offsetParent;
			} while (content);
		}
		return distance;
	};

	/**
	 * Check if a group of content areas are stacked
	 * @private
	 * @param  {NodeList} contents A collection of content areas to compare
	 * @return {Boolean} Returns true if elements are stacked
	 */
	var checkIfStacked = function ( contents ) {

		// Selectors and variables
		var contentFirst = contents.item(0);
		var contentSecond = contents.item(1);

		// Determine if content containers are stacked
		if ( contentFirst && contentSecond ) {
			if ( getDistanceToTop(contentFirst) - getDistanceToTop(contentSecond) === 0 ) {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}

	};

	/**
	 * Reset the content height to 'auto'
	 * @private
	 * @param  {Element} content The content area to set to height: auto
	 */
	var resetHeight = function ( content ) {
		content.style.height = 'auto';
		content.style.minHeight = '0';
	};

	/**
	 * Get the natural height of each content area, and
	 * record the tallest height to set for all other elements.
	 * @private
	 * @param  {Element} content A content area
	 * @param  {Number} height The current tallest height
	 * @return {Number} The updated tallest height
	 */
	var getHeight = function ( content, height ) {
		if ( content.offsetHeight > height ) {
			height = content.offsetHeight;
		}
		return height;
	};

	/**
	 * Set the height of each content area
	 * @private
	 * @param {Element} content The content area to set a height for
	 * @param {Number} height The height of the tallest content area
	 */
	var setHeight = function ( content, height ) {
		content.style.height = height + 'px';
	};

	/**
	 * Get all content areas within a group
	 * @public
	 * @param  {Element} container The wrapper that contains a set of content areas
	 * @param  {Object} options
	 */
	exports.adjustContainerHeight = function ( container, options ) {

		// Selectors and variables
		var settings = extend( settings || defaults, options || {} );  // Merge user options with defaults
		var contents = container.querySelectorAll('[data-right-height-content]');
		var isStacked = checkIfStacked(contents);
		var height = '0';

		settings.callbackBefore( container ); // Run callbacks before adjusting content

		// Reset each content area to its natural height
		forEach(contents, function (content) {
			resetHeight( content );
		});

		// If content areas are not stacked, give them equal heights
		if ( !isStacked ) {
			forEach(contents, function (content) {
				height = getHeight( content, height );
			});
			forEach(contents, function (content) {
				setHeight( content, height );
			});
		}

		settings.callbackAfter( container ); // Run callbacks after adjust content

	};

	/**
	 * For each group of content, adjust the content area heights
	 * @private
	 * @param  {NodeList} containers A collection of content wrappers
	 * @param  {Object} settings
	 */
	var runRightHeight = function ( containers, settings ) {
		forEach(containers, function (container) {
			exports.adjustContainerHeight( container, settings );
		});
	};

	/**
	 * On window resize, only run 'runRightHeight' at a rate of 15fps for better performance
	 * @private
	 * @param  {Function} eventTimeout Timeout function
	 * @param  {NodeList} containers A collection of content wrappers
	 * @param  {Object} settings
	 */
	var eventThrottler = function ( eventTimeout, containers, settings ) {
		if ( !eventTimeout ) {
			eventTimeout = setTimeout(function() {
				eventTimeout = null;
				runRightHeight( containers, settings );
			}, 66);
		}
	};

	/**
	 * Initialize Right Height
	 * @public
	 * @param {Object} options User settings
	 */
	exports.init = function ( options ) {

		// feature test
		if ( !supports ) return;

		// Selectors and variables
		settings = extend( defaults, options || {} ); // Merge user options with defaults
		var containers = document.querySelectorAll('[data-right-height]'); // Groups of content
		var eventTimeout; // Timer for resize event throttler

		// Events and listeners
		window.addEventListener('load', function() {
			runRightHeight( containers, options ); // Run Right Height when DOM content fully loaded
		});
		window.addEventListener( 'resize', eventThrottler.bind( null, eventTimeout, containers, options ), false); // Run Right Height on window resize

	};


	//
	// Public APIs
	//

	return exports;

});
/* =============================================================

		Slider v3.3
		A simple, responsive, touch-enabled image slider, forked from Swipe.

		Script by Brad Birdsall.
		http://swipejs.com/

		Forked by Chris Ferdinandi.
		http://gomakethings.com

		Code contributed by Ron Ilan.
		https://github.com/bradbirdsall/Swipe/pull/277

		Licensed under the MIT license.
		http://gomakethings.com/mit/

 * ============================================================= */

 if ( 'querySelector' in document && 'addEventListener' in window && 'localStorage' in window && Array.prototype.forEach ) {

	var Swipe = function (container, options) {

		"use strict";

		// utilities
		var noop = function() {}; // simple no operation function
		var offloadFn = function(fn) { setTimeout(fn || noop, 0) }; // offload a functions execution

		// check browser capabilities
		var browser = {
			addEventListener: !!window.addEventListener,
			touch: ('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch,
			transitions: (function(temp) {
				var props = ['transitionProperty', 'WebkitTransition', 'MozTransition', 'OTransition', 'msTransition'];
				for ( var i in props ) if (temp.style[ props[i] ] !== undefined) return true;
				return false;
			})(document.createElement('swipe'))
		};

		// quit if no root element
		if (!container) return;
		var element = container.children[0];
		var slides, slidePos, width, length;
		options = options || {};
		var index = parseInt(options.startSlide - 1, 10) || 0;
		var speed = options.speed || 300;
		options.continuous = options.continuous !== undefined ? options.continuous : true;

		var setup = function () {

			// cache slides
			slides = element.children;
			length = slides.length;

			// set continuous to false if only one slide
			if (slides.length < 2) options.continuous = false;

			// create an array to store current positions of each slide
			slidePos = new Array(slides.length);

			// determine width of each slide
			width = container.getBoundingClientRect().width || container.offsetWidth;

			element.style.width = (slides.length * width) + 'px';

			// stack elements
			var pos = slides.length;
			while(pos--) {

				var slide = slides[pos];

				slide.style.width = width + 'px';
				slide.setAttribute('data-index', pos);

				if (browser.transitions) {
					slide.style.left = (pos * -width) + 'px';
					move(pos, index > pos ? -width : (index < pos ? width : 0), 0);
				}

			}

			// reposition elements before and after index
			if (options.continuous && browser.transitions) {
				move(circle(index-1), -width, 0);
				move(circle(index+1), width, 0);
			}

			if (!browser.transitions) element.style.left = (index * -width) + 'px';

			visibleThree(index, slides);

			container.style.visibility = 'visible';

		};

		var prev = function () {

			if (options.continuous) slide(index-1);
			else if (index) slide(index-1);

		};

		var next = function () {

			if (options.continuous) slide(index+1);
			else if (index < slides.length - 1) slide(index+1);

		};

		var circle = function (index) {

			// a simple positive modulo using slides.length
			return (slides.length + (index % slides.length)) % slides.length;

		};

		var slide = function (to, slideSpeed) {

			// do nothing if already on requested slide
			if (index == to) return;

			if (browser.transitions) {

				var direction = Math.abs(index-to) / (index-to); // 1: backward, -1: forward

				// get the actual position of the slide
				if (options.continuous) {
					var natural_direction = direction;
					direction = -slidePos[circle(to)] / width;

					// if going forward but to < index, use to = slides.length + to
					// if going backward but to > index, use to = -slides.length + to
					if (direction !== natural_direction) to =  -direction * slides.length + to;

				}

				var diff = Math.abs(index-to) - 1;

				// move all the slides between index and to in the right direction
				while (diff--) move( circle((to > index ? to : index) - diff - 1), width * direction, 0);

				to = circle(to);

				move(index, width * direction, slideSpeed || speed);
				move(to, 0, slideSpeed || speed);

				if (options.continuous) move(circle(to - direction), -(width * direction), 0); // we need to get the next in place

			} else {

				to = circle(to);
				animate(index * -width, to * -width, slideSpeed || speed);
				//no fallback for a circular continuous if the browser does not accept transitions
			}

			index = to;
			offloadFn(options.callback && options.callback(index, slides[index]));
		};

		var move = function (index, dist, speed) {

			translate(index, dist, speed);
			slidePos[index] = dist;

		};

		var translate = function (index, dist, speed) {

			var slide = slides[index];
			var style = slide && slide.style;

			if (!style) return;

			style.webkitTransitionDuration =
			style.MozTransitionDuration =
			style.msTransitionDuration =
			style.OTransitionDuration =
			style.transitionDuration = speed + 'ms';

			style.webkitTransform = 'translate(' + dist + 'px,0)' + 'translateZ(0)';
			style.msTransform =
			style.MozTransform =
			style.OTransform = 'translateX(' + dist + 'px)';

		};

		var animate = function (from, to, speed) {

			// if not an animation, just reposition
			if (!speed) {

				element.style.left = to + 'px';
				return;

			}

			var start = +new Date;

			var timer = setInterval(function() {

				var timeElap = +new Date - start;

				if (timeElap > speed) {

					element.style.left = to + 'px';

					if (delay) begin();

					options.transitionEnd && options.transitionEnd.call(event, index, slides[index]);

					clearInterval(timer);
					return;

				}

				element.style.left = (( (to - from) * (Math.floor((timeElap / speed) * 100) / 100) ) + from) + 'px';

			}, 4);

		};

		// hide all slides other than current one
		function visibleThree(index, slides) {

			var pos = slides.length;

			// first make this one visible
			slides[index].style.visibility = 'visible';

			// then check all others for hiding
			while(pos--) {

				if(pos === circle(index) || pos === circle(index-1) || pos === circle(index+1)){
					slides[pos].style.visibility = 'visible';
				} else {
					slides[pos].style.visibility = 'hidden';
				}

			}

		}

		// setup auto slideshow
		var delay = options.auto || 0;
		var interval;

		var begin = function () {

			interval = setTimeout(next, delay);

		};

		var stop = function () {

			delay = 0;
			clearTimeout(interval);

		};


		// setup initial vars
		var start = {};
		var delta = {};
		var isScrolling;

		// setup event capturing
		var events = {

			handleEvent: function(event) {

				switch (event.type) {
					case 'touchstart': this.start(event); break;
					case 'touchmove': this.move(event); break;
					case 'touchend': offloadFn(this.end(event)); break;
					case 'webkitTransitionEnd':
					case 'msTransitionEnd':
					case 'oTransitionEnd':
					case 'otransitionend':
					case 'transitionend': offloadFn(this.transitionEnd(event)); break;
					case 'resize': offloadFn(setup.call()); break;
				}

				if (options.stopPropagation) event.stopPropagation();

			},
			start: function(event) {

				var touches = event.touches[0];

				// measure start values
				start = {

					// get initial touch coords
					x: touches.pageX,
					y: touches.pageY,

					// store time to determine touch duration
					time: +new Date

				};

				// used for testing first move event
				isScrolling = undefined;

				// reset delta and end measurements
				delta = {};

				// attach touchmove and touchend listeners
				element.addEventListener('touchmove', this, false);
				element.addEventListener('touchend', this, false);

			},
			move: function(event) {

				// ensure swiping with one touch and not pinching
				if ( event.touches.length > 1 || event.scale && event.scale !== 1) return;

				if (options.disableScroll) event.preventDefault();

				var touches = event.touches[0];

				// measure change in x and y
				delta = {
					x: touches.pageX - start.x,
					y: touches.pageY - start.y
				};

				// determine if scrolling test has run - one time test
				if ( typeof isScrolling == 'undefined') {
					isScrolling = !!( isScrolling || Math.abs(delta.x) < Math.abs(delta.y) );
				}

				// if user is not trying to scroll vertically
				if (!isScrolling) {

					// prevent native scrolling
					event.preventDefault();

					// stop slideshow
					stop();

					// increase resistance if first or last slide
					if (options.continuous) { // we don't add resistance at the end

						translate(circle(index-1), delta.x + slidePos[circle(index-1)], 0);
						translate(index, delta.x + slidePos[index], 0);
						translate(circle(index+1), delta.x + slidePos[circle(index+1)], 0);

					} else {

						delta.x =
							delta.x /
								( (!index && delta.x > 0               // if first slide and sliding left
								|| index == slides.length - 1        // or if last slide and sliding right
								&& delta.x < 0                       // and if sliding at all
								) ?
								( Math.abs(delta.x) / width + 1 )      // determine resistance level
								: 1 );                                 // no resistance if false

						// translate 1:1
						translate(index-1, delta.x + slidePos[index-1], 0);
						translate(index, delta.x + slidePos[index], 0);
						translate(index+1, delta.x + slidePos[index+1], 0);
					}

				}

			},
			end: function(event) {

				// measure duration
				var duration = +new Date - start.time;

				// determine if slide attempt triggers next/prev slide
				var isValidSlide =
							Number(duration) < 250               // if slide duration is less than 250ms
							&& Math.abs(delta.x) > 20            // and if slide amt is greater than 20px
							|| Math.abs(delta.x) > width/2;      // or if slide amt is greater than half the width

				// determine if slide attempt is past start and end
				var isPastBounds =
							!index && delta.x > 0                            // if first slide and slide amt is greater than 0
							|| index == slides.length - 1 && delta.x < 0;    // or if last slide and slide amt is less than 0

				if (options.continuous) isPastBounds = false;

				// determine direction of swipe (true:right, false:left)
				var direction = delta.x < 0;

				// if not scrolling vertically
				if (!isScrolling) {

					if (isValidSlide && !isPastBounds) {

						if (direction) {

							if (options.continuous) { // we need to get the next in this direction in place

								move(circle(index-1), -width, 0);
								move(circle(index+2), width, 0);

							} else {
								move(index-1, -width, 0);
							}

							move(index, slidePos[index]-width, speed);
							move(circle(index+1), slidePos[circle(index+1)]-width, speed);
							index = circle(index+1);

						} else {
							if (options.continuous) { // we need to get the next in this direction in place

								move(circle(index+1), width, 0);
								move(circle(index-2), -width, 0);

							} else {
								move(index+1, width, 0);
							}

							move(index, slidePos[index]+width, speed);
							move(circle(index-1), slidePos[circle(index-1)]+width, speed);
							index = circle(index-1);

						}

						options.callback && options.callback(index, slides[index]);

					} else {

						if (options.continuous) {

							move(circle(index-1), -width, speed);
							move(index, 0, speed);
							move(circle(index+1), width, speed);

						} else {

							move(index-1, -width, speed);
							move(index, 0, speed);
							move(index+1, width, speed);
						}

					}

				}

				// kill touchmove and touchend event listeners until touchstart called again
				element.removeEventListener('touchmove', events, false);
				element.removeEventListener('touchend', events, false);

			},
			transitionEnd: function(event) {

				visibleThree(index, slides);

				if (parseInt(event.target.getAttribute('data-index'), 10) == index) {

					if (delay) begin();

					options.transitionEnd && options.transitionEnd.call(event, index, slides[index]);

				}

			}

		};

		// trigger setup
		setup();

		// start auto slideshow if applicable
		if (delay) begin();


		// add event listeners
		if (browser.addEventListener) {

			// set touchstart event on element
			if (browser.touch) element.addEventListener('touchstart', events, false);

			if (browser.transitions) {
				element.addEventListener('webkitTransitionEnd', events, false);
				element.addEventListener('msTransitionEnd', events, false);
				element.addEventListener('oTransitionEnd', events, false);
				element.addEventListener('otransitionend', events, false);
				element.addEventListener('transitionend', events, false);
			}

			// set resize event on window
			window.addEventListener('resize', events, false);

		} else {

			window.onresize = function () { setup() }; // to play nice with old IE

		}

		// expose the Swipe API
		return {
			setup: function() {

				setup();

			},
			slide: function(to, speed) {

				// cancel slideshow
				stop();

				slide(to, speed);

			},
			prev: function() {

				// cancel slideshow
				stop();

				prev();

			},
			next: function() {

				// cancel slideshow
				stop();

				next();

			},
			getPos: function() {

				// return current index position
				return index + 1;

			},
			getNumSlides: function() {

				// return total number of slides
				return length;
			},
			kill: function() {

				// cancel slideshow
				stop();

				// reset element
				element.style.width = 'auto';
				element.style.left = 0;

				// reset slides
				var pos = slides.length;
				while(pos--) {

					var slide = slides[pos];
					slide.style.width = '100%';
					slide.style.left = 0;

					if (browser.transitions) translate(pos, 0, 0);

				}

				// removed event listeners
				if (browser.addEventListener) {

					// remove current event listeners
					element.removeEventListener('touchstart', events, false);
					element.removeEventListener('webkitTransitionEnd', events, false);
					element.removeEventListener('msTransitionEnd', events, false);
					element.removeEventListener('oTransitionEnd', events, false);
					element.removeEventListener('otransitionend', events, false);
					element.removeEventListener('transitionend', events, false);
					window.removeEventListener('resize', events, false);

				}
				else {

					window.onresize = null;

				}

			}
		};

	};

}
(function (root, factory) {
	if ( typeof define === 'function' && define.amd ) {
		define('smoothScroll', factory(root));
	} else if ( typeof exports === 'object' ) {
		module.smoothScroll = factory(root);
	} else {
		root.smoothScroll = factory(root);
	}
})(this, function (root) {

	'use strict';

	//
	// Variables
	//

	var exports = {}; // Object for public APIs
	var supports = !!document.querySelector && !!root.addEventListener; // Feature test
	var settings;

	// Default settings
	var defaults = {
		speed: 500,
		easing: 'easeInOutCubic',
		offset: 0,
		updateURL: true,
		callbackBefore: function () {},
		callbackAfter: function () {}
	};


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
	 * Calculate the easing pattern
	 * @private
	 * @param {String} type Easing pattern
	 * @param {Number} time Time animation should take to complete
	 * @returns {Number}
	 */
	var easingPattern = function ( type, time ) {
		var pattern;
		if ( type === 'easeInQuad' ) pattern = time * time; // accelerating from zero velocity
		if ( type === 'easeOutQuad' ) pattern = time * (2 - time); // decelerating to zero velocity
		if ( type === 'easeInOutQuad' ) pattern = time < 0.5 ? 2 * time * time : -1 + (4 - 2 * time) * time; // acceleration until halfway, then deceleration
		if ( type === 'easeInCubic' ) pattern = time * time * time; // accelerating from zero velocity
		if ( type === 'easeOutCubic' ) pattern = (--time) * time * time + 1; // decelerating to zero velocity
		if ( type === 'easeInOutCubic' ) pattern = time < 0.5 ? 4 * time * time * time : (time - 1) * (2 * time - 2) * (2 * time - 2) + 1; // acceleration until halfway, then deceleration
		if ( type === 'easeInQuart' ) pattern = time * time * time * time; // accelerating from zero velocity
		if ( type === 'easeOutQuart' ) pattern = 1 - (--time) * time * time * time; // decelerating to zero velocity
		if ( type === 'easeInOutQuart' ) pattern = time < 0.5 ? 8 * time * time * time * time : 1 - 8 * (--time) * time * time * time; // acceleration until halfway, then deceleration
		if ( type === 'easeInQuint' ) pattern = time * time * time * time * time; // accelerating from zero velocity
		if ( type === 'easeOutQuint' ) pattern = 1 + (--time) * time * time * time * time; // decelerating to zero velocity
		if ( type === 'easeInOutQuint' ) pattern = time < 0.5 ? 16 * time * time * time * time * time : 1 + 16 * (--time) * time * time * time * time; // acceleration until halfway, then deceleration
		return pattern || time; // no easing, no acceleration
	};

	/**
	 * Calculate how far to scroll
	 * @private
	 * @param {Element} anchor The anchor element to scroll to
	 * @param {Number} headerHeight Height of a fixed header, if any
	 * @param {Number} offset Number of pixels by which to offset scroll
	 * @returns {Number}
	 */
	var getEndLocation = function ( anchor, headerHeight, offset ) {
		var location = 0;
		if (anchor.offsetParent) {
			do {
				location += anchor.offsetTop;
				anchor = anchor.offsetParent;
			} while (anchor);
		}
		location = location - headerHeight - offset;
		return location >= 0 ? location : 0;
	};

	/**
	 * Determine the document's height
	 * @private
	 * @returns {Number}
	 */
	var getDocumentHeight = function () {
		return Math.max(
			document.body.scrollHeight, document.documentElement.scrollHeight,
			document.body.offsetHeight, document.documentElement.offsetHeight,
			document.body.clientHeight, document.documentElement.clientHeight
		);
	};

	/**
	 * Convert data-options attribute into an object of key/value pairs
	 * @private
	 * @param {String} options Link-specific options as a data attribute string
	 * @returns {Object}
	 */
	var getDataOptions = function ( options ) {
		return !options || !(typeof JSON === 'object' && typeof JSON.parse === 'function') ? {} : JSON.parse( options );
	};

	/**
	 * Update the URL
	 * @private
	 * @param {Element} anchor The element to scroll to
	 * @param {Boolean} url Whether or not to update the URL history
	 */
	var updateUrl = function ( anchor, url ) {
		if ( history.pushState && (url || url === 'true') ) {
			history.pushState( {
				pos: anchor.id
			}, '', window.location.pathname + anchor );
		}
	};

	/**
	 * Start/stop the scrolling animation
	 * @public
	 * @param {Element} toggle The element that toggled the scroll event
	 * @param {Element} anchor The element to scroll to
	 * @param {Object} settings
	 * @param {Event} event
	 */
	exports.animateScroll = function ( toggle, anchor, options, event ) {

		// Options and overrides
		var settings = extend( settings || defaults, options || {} );  // Merge user options with defaults
		var overrides = getDataOptions( toggle ? toggle.getAttribute('data-options') : null );
		settings = extend( settings, overrides );

		// Selectors and variables
		var fixedHeader = document.querySelector('[data-scroll-header]'); // Get the fixed header
		var headerHeight = fixedHeader === null ? 0 : (fixedHeader.offsetHeight + fixedHeader.offsetTop); // Get the height of a fixed header if one exists
		var startLocation = root.pageYOffset; // Current location on the page
		var endLocation = getEndLocation( document.querySelector(anchor), headerHeight, parseInt(settings.offset, 10) ); // Scroll to location
		var animationInterval; // interval timer
		var distance = endLocation - startLocation; // distance to travel
		var documentHeight = getDocumentHeight();
		var timeLapsed = 0;
		var percentage, position;

		// Prevent default click event
		if ( toggle && toggle.tagName.toLowerCase() === 'a' && event ) {
			event.preventDefault();
		}

		// Update URL
		updateUrl(anchor, settings.updateURL);

		/**
		 * Stop the scroll animation when it reaches its target (or the bottom/top of page)
		 * @private
		 * @param {Number} position Current position on the page
		 * @param {Number} endLocation Scroll to location
		 * @param {Number} animationInterval How much to scroll on this loop
		 */
		var stopAnimateScroll = function (position, endLocation, animationInterval) {
			var currentLocation = root.pageYOffset;
			if ( position == endLocation || currentLocation == endLocation || ( (root.innerHeight + currentLocation) >= documentHeight ) ) {
				clearInterval(animationInterval);
				settings.callbackAfter( toggle, anchor ); // Run callbacks after animation complete
			}
		};

		/**
		 * Loop scrolling animation
		 * @private
		 */
		var loopAnimateScroll = function () {
			timeLapsed += 16;
			percentage = ( timeLapsed / parseInt(settings.speed, 10) );
			percentage = ( percentage > 1 ) ? 1 : percentage;
			position = startLocation + ( distance * easingPattern(settings.easing, percentage) );
			root.scrollTo( 0, Math.floor(position) );
			stopAnimateScroll(position, endLocation, animationInterval);
		};

		/**
		 * Set interval timer
		 * @private
		 */
		var startAnimateScroll = function () {
			settings.callbackBefore( toggle, anchor ); // Run callbacks before animating scroll
			animationInterval = setInterval(loopAnimateScroll, 16);
		};

		/**
		 * Reset position to fix weird iOS bug
		 * @link https://github.com/cferdinandi/smooth-scroll/issues/45
		 */
		if ( root.pageYOffset === 0 ) {
			root.scrollTo( 0, 0 );
		}

		// Start scrolling animation
		startAnimateScroll();

	};

	/**
	 * Initialize Smooth Scroll
	 * @public
	 * @param {Object} options User settings
	 */
	exports.init = function ( options ) {

		// feature test
		if ( !supports ) return;

		// Selectors and variables
		settings = extend( defaults, options || {} ); // Merge user options with defaults
		var toggles = document.querySelectorAll('[data-scroll]'); // Get smooth scroll toggles

		// When a toggle is clicked, run the click handler
		forEach(toggles, function (toggle) {
			toggle.addEventListener('click', exports.animateScroll.bind( null, toggle, toggle.hash, settings ), false);
		});

	};


	//
	// Public APIs
	//

	return exports;

});

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