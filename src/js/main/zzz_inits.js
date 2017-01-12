astro.init();
drop.init({
	selector: '.menu-item-has-children'
});
formSaver.init();
stickyFooter.init();

ready(function () {
	var rh = document.querySelector( '[data-right-height]' );
	if ( !rh ) return;
	imagesLoaded(rh, function () {
		rightHeight.init();
	});
});

ready(function () {

	// Only run on adoption form
	if ( !document.querySelector( '#adoption-form' ) ) return;

	// Get pet selects
	var pet = document.querySelector( '[name="reserveanimalname1_3"]' );
	var alternate = document.querySelector( '[name="alternateDog_143"]' );

	// Replace select with text area
	var replaceWithInput = function ( elem ) {
		var required = elem.hasAttribute( 'required' ) ? 'required' : '';
		var input = '<input type="text" name="' + elem.name + '" ' + required + '>';
		elem.parentNode.innerHTML = input;
	};

	// If no pets listed, replace with text input
	if ( pet && pet.length < 2 ) {
		replaceWithInput( pet );
	}

	// If not alternates listed, replace with text input
	if ( alternate && alternate.length < 1 ) {
		replaceWithInput( alternate );
	}

});

fluidvids.init({
	selector: ['iframe', 'object'],
	players: ['www.youtube.com', 'player.vimeo.com', 'www.slideshare.net', 'www.google.com/maps', 'maps.google.com']
});