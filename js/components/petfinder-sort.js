/* =============================================================

	Petfinder Sort v2.0
	Filter PetFinder results by a variety of categories, by Chris Ferdinandi.
	http://gomakethings.com

	Free to use under the MIT License.
	http://gomakethings.com/mit/

 * ============================================================= */

(function() {

	'use strict';

	// Feature test
	if ( 'querySelector' in document && 'addEventListener' in window && 'localStorage' in window && Array.prototype.forEach ) {

		// Variables
		var pets = document.querySelectorAll('.pf');
		var petFilterBreeds = document.querySelectorAll('.pf-breeds');
		var petFilterOthers = document.querySelectorAll('.pf-sort');
		var petFilterToggleAll = document.querySelectorAll('.pf-toggle-all');

		// Setup save filter settings
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

		// Setup show/hide filter
		var petfinderSort = function () {
			[].forEach.call(pets, function (pet) {
				buoy.addClass(pet, 'hide');
			});
			[].forEach.call(petFilterBreeds, function (filter) {
				var sortTargetValue = filter.getAttribute('data-target');
				var sortTargets = document.querySelectorAll(sortTargetValue);
				if ( filter.checked === true ) {
					[].forEach.call(sortTargets, function (target) {
						buoy.removeClass(target, 'hide');
					});
				}
			});
			[].forEach.call(petFilterOthers, function (filter) {
				var sortTargetValue = filter.getAttribute('data-target');
				var sortTargets = document.querySelectorAll(sortTargetValue);
				if ( filter.checked === false ) {
					[].forEach.call(sortTargets, function (target) {
						buoy.addClass(target, 'hide');
					});
				}
			});
		};

		// Toggle all breeds
		[].forEach.call(petFilterToggleAll, function (filter) {
			filter.addEventListener('change', function(e) {
				var sortTargetValue = filter.getAttribute('data-target');
				var sortTargets = document.querySelectorAll(sortTargetValue);
				if ( filter.checked === true ) {
					[].forEach.call(sortTargets, function (target) {
						target.checked = true;
						petfinderSortSave(target);
					});
				} else {
					[].forEach.call(sortTargets, function (target) {
						target.checked = false;
						petfinderSortSave(target);
					});
				}
				petfinderSortSave(filter);
				petfinderSort();
			}, false);
		});

		// Run sort when filter is changed
		[].forEach.call(petFilterBreeds, function (filter) {
			filter.addEventListener('change', function(e) {
				petfinderSort();
				petfinderSortSave(filter);
			}, false);
		});
		[].forEach.call(petFilterOthers, function (filter) {
			filter.addEventListener('change', function(e) {
				petfinderSort();
				petfinderSortSave(filter);
			}, false);
		});

		// Load filter settings on page load
		var petfinderSortGet = function (filter) {
			if ( window.sessionStorage ) {
				var name = filter.getAttribute('data-target');
				var status = sessionStorage.getItem(name);
				if ( status === 'unchecked' ) {
					filter.checked = false;
				}
			}
		};
		[].forEach.call(petFilterBreeds, function (filter) {
			petfinderSortGet(filter);
		});
		[].forEach.call(petFilterOthers, function (filter) {
			petfinderSortGet(filter);
		});
		[].forEach.call(petFilterToggleAll, function (filter) {
			petfinderSortGet(filter);
		});
		petfinderSort();

	}

})();