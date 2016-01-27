/*!
 * pawsnewengland v6.4.0: WordPress theme for PAWS New England
 * (c) 2016 Chris Ferdinandi
 * MIT License
 * https://github.com/pawsnewengland/pawsne
 * Open Source Credits: https://github.com/ftlabs/fastclick, https://github.com/toddmotto/fluidvids, http://photoswipe.com, http://masonry.desandro.com, http://imagesloaded.desandro.com
 */

/**
 * Autofill the name of the selected pet into the adoption form
 */
;(function (window, document, undefined) {

	'use strict';

	// Feature test
	var supports = 'querySelector' in document && 'addEventListener' in window && 'localStorage' in window;
	if ( !supports ) return;

	// Save pet name
	var savePetName = function () {

		// Variables
		var pet = document.querySelector( '[data-adopt]' );

		// Sanity check
		if ( !pet ) return;

		// On click save data to localStorage
		pet.addEventListener('click', function () {
			sessionStorage.setItem( 'desiredPetName', this.getAttribute( 'data-adopt' ) );
		}, false);

	};

	// Get pet name
	var getPetName = function () {

		// Variables
		var field = document.querySelector( 'select[name="reserveanimalname1_3"]' );
		var pet = sessionStorage.getItem( 'desiredPetName' );

		console.log(field);
		console.log(pet);

		// Sanity check
		if ( !field || !pet ) return;

		// Populate field with pet name
		field.value = pet;

	};

	// Init functions onload
	savePetName();
	getPetName();

})(window, document);