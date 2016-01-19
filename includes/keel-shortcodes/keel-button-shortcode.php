<?php

	/**
	 * Add a shortcode for button links
	 */

	function keel_button_shortcode( $atts ) {

		// Check that feature is activated
		$dev_options = keel_developer_options();
		if ( !$dev_options['button_shortcode'] ) return '';

		// Get user options
		$btn = shortcode_atts(array(
			'link'  => '',
			'label' => '',
			'size' => '',
		), $atts);

		// Bail if no link or label is set
		if ( empty( $btn['link'] ) || empty( $btn['label'] ) ) return;

		return '<a class="btn btn-' . $btn['size'] . '" href="' . $btn['link'] . '">' . $btn['label'] . '</a>';

	}
	add_shortcode( 'button', 'keel_button_shortcode' );



	/**
	 * Polyfills old slideshow shortcode to use the new [gallery] functionality
	 */
	function keel_button_polyfill( $atts ) {
		$atts = shortcode_atts(array(
			'link' => 'http://www.pawsnewengland.com/donate/',
			'label' => 'Donate'
		), $atts);
		return keel_button_shortcode( $atts );
	}
	add_shortcode( 'btn', 'keel_button_polyfill' );