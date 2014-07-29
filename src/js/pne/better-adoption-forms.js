/* =============================================================

	Better Adoption Forms v1.0
	Store and load data for better adoption forms, by Chris Ferdinandi.
	http://gomakethings.com

	Free to use under the MIT License.
	http://gomakethings.com/mit/

 * ============================================================= */

(function() {

	'use strict';

	// Let user save form data for reuse on future applications
	if ( 'querySelector' in document && 'addEventListener' in window && 'localStorage' in window && Array.prototype.forEach ) {

		// Variables
		var forms = document.forms;
		var formSave = document.querySelectorAll('.form-save-data');
		var formRemove = document.querySelectorAll('.form-delete-data');

		// Save form data
		[].forEach.call(formSave, function (save) {
			save.addEventListener('click', function(e) {

				e.preventDefault();

				// Variables
				var form = save.form;
				var formSaverID = form.parentNode.id === null || form.parentNode.id === '' ? 'formsaver-' + document.URL : 'formsaver-' + form.parentNode.id;
				var formSaverData = {};
				var formFields = form.elements;
				var formStatus = form.querySelectorAll('.form-status');

				// Add field data to array
				[].forEach.call(formFields, function (field) {
					if ( !buoy.hasClass(field, 'form-no-save') && field.name != 'terms[]' && field.name != 'applied-before' ) {
						if ( field.type == 'radio' || field.type == 'checkbox' ) {
							if ( field.checked === true ) {
								formSaverData[field.name + field.value] = 'on';
							}
						} else if ( field.type != 'hidden' && field.type != 'submit' ) {
							if ( field.value !== null && field.value !== '' ) {
								formSaverData[field.name] = field.value;
							}
						}
					}
				});

				// Display save success message
				[].forEach.call(formStatus, function (status) {
					if ( save.getAttribute('data-message') === null ) {
						status.innerHTML = '<div class="alert alert-green">Saved!</div>';
					} else {
						status.innerHTML = '<div class="alert alert-green">' + save.getAttribute('data-message') + '</div>';
					}
				});

				// Save form data in localStorage
				localStorage.setItem( formSaverID, JSON.stringify(formSaverData) );

				// If no form ID is provided, generate friendly console message encouraging one to be added
				if ( form.id === null || form.id === '' ) {
					console.log('FORM SAVER WARNING: This form has no ID attribute. This can create conflicts if more than one form is included on a page, or if the URL changes or includes a query string or hash value.');
				}

			}, false);
		});

		// Delete form data
		[].forEach.call(formRemove, function (remove) {
			remove.addEventListener('click', function(e) {

				e.preventDefault();

				// Variables
				var form = remove.form;
				var formSaverID = form.parentNode.id === null || form.parentNode.id === '' ? 'formsaver-' + document.URL : 'formsaver-' + form.parentNode.id;
				var formStatus = form.querySelectorAll('.form-status');
				var formMessage = remove.getAttribute('data-message') === null ? '<div class="alert alert-green">Deleted!</div>' : '<div class="alert alert-green">' + remove.getAttribute('data-message') + '</div>';

				// Remove form data
				localStorage.removeItem(formSaverID);

				// Display delete success message
				if ( remove.getAttribute('data-clear') == 'true' ) {
					sessionStorage.setItem(formSaverID + '-formSaverMessage', formMessage);
					location.reload(false);
				} else {
					[].forEach.call(formStatus, function (status) {
						status.innerHTML = formMessage;
					});
				}

			}, false);
		});

		// Get form data on page load
		[].forEach.call(forms, function (form) {

			// Variables
			var formSaverID = form.parentNode.id === null || form.parentNode.id === '' ? 'formsaver-' + document.URL : 'formsaver-' + form.parentNode.id;
			var formSaverData = JSON.parse( localStorage.getItem(formSaverID) );
			var formFields = form.elements;
			var formStatus = form.querySelectorAll('.form-status');

			// Populate form with data from localStorage
			[].forEach.call(formFields, function (field) {
				if ( formSaverData !== null ) {
					if ( field.type == 'radio' || field.type == 'checkbox' ) {
						if ( formSaverData[field.name + field.value] == 'on' ) {
							field.checked = true;
						}
					} else if ( field.type != 'hidden' && field.type != 'submit' ) {
						if ( formSaverData[field.name] !== null && formSaverData[field.name] !== undefined ) {
							field.value = formSaverData[field.name];
						}
					}
				}
			});

			// If page was reloaded and delete success message exists, display it
			[].forEach.call(formStatus, function (status) {
				status.innerHTML = sessionStorage.getItem(formSaverID + '-formSaverMessage');
				sessionStorage.removeItem(formSaverID + '-formSaverMessage');
			});

		});

	}

	// Pass name of pet user is interested in to the adoption form
	if ( 'querySelector' in document && 'addEventListener' in window && 'localStorage' in window && Array.prototype.forEach ) {

		// Pass the name of the dog the user is interested in adopting
		// from the "Our Dogs" page to the Adoption Form
		var adoptToggle = document.querySelectorAll('.adopt-toggle');
		[].forEach.call(adoptToggle, function (toggle) {
			toggle.addEventListener('click', function(e) {
				var name = toggle.getAttribute('data-name');
				sessionStorage.setItem('petToAdopt', name);
			}, false);
		});

		// Get pet name from session storage
		var adoptionFormGetPet = function (petNameField) {
			var petName = sessionStorage.getItem('petToAdopt');
			petNameField.value = petName;
			sessionStorage.removeItem('petToAdopt');
		};

		var adoptionForm = document.querySelector('#input-dog-name');
		if ( adoptionForm ) {
			adoptionFormGetPet(adoptionForm);
		}

	}

})();