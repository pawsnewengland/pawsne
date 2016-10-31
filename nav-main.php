<?php

/**
 * nav-main.php
 * Template for site navigation.
 * @link http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */

?>
<?php
	// Get number of items in cart
	$cart_count = class_exists( 'WooCommerce' ) ? WC()->cart->get_cart_contents_count() : 0;
?>

<nav class="nav-wrap-navbar nav-collapse <?php if ( !keel_has_hero() && $cart_count === 0 ) { echo 'margin-bottom'; } ?>  no-js-drop">
	<div class="container container-large">
		<a class="logo-navbar" href="<?php echo site_url(); ?>/">
			<?php
				$logo = get_theme_mod( 'keel_logo' );
				if ( empty( $logo ) ) :
			?>
				<?php bloginfo( 'name' ); ?>
			<?php else : ?>
				<?php if ( substr( $logo, -4 ) === '.svg' ) : ?>
					<?php echo file_get_contents( $logo ); ?>
					<span class="icon-fallback-text"><?php bloginfo( 'name' ); ?></span>
				<?php else : ?>
					<img src="<?php echo $logo; ?>" alt="<?php bloginfo( 'name' ); ?>">
				<?php endif; ?>
			<?php endif; ?>
		</a>
		<?php if ( has_nav_menu( 'primary' ) || wp_get_nav_menu_object( 'Primary' ) ) : ?>
			<a class="nav-toggle-navbar" data-nav-toggle="#nav-menu" href="#">Menu</a>
			<div class="nav-menu-navbar" id="nav-menu">
				<?php
					wp_nav_menu(
						array(
							'menu'           => 'Primary',
							'theme_location' => 'primary',
							'container'      => false,
							'menu_class'     => 'nav-navbar',
						)
					);
				?>
			</div>
		<?php endif; ?>
	</div>
</nav>
<?php if ( $cart_count !== 0 ) : ?>
	<nav class="bg-muted padding-top-small padding-bottom-small <?php if ( !keel_has_hero() ) { echo 'margin-bottom'; } ?>">
		<div class="container container-large">
			<a class="float-right" href="<?php echo wc_get_cart_url(); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 17 17"><path d="M6.375 15.406c0 .88-.714 1.594-1.594 1.594s-1.593-.714-1.593-1.594c0-.88.714-1.594 1.594-1.594s1.595.714 1.595 1.594zM17 15.406c0 .88-.714 1.594-1.594 1.594s-1.594-.714-1.594-1.594c0-.88.714-1.594 1.594-1.594S17 14.526 17 15.406zM17 8.5V2.125H4.25c0-.587-.476-1.063-1.063-1.063H0v1.063h2.124l.798 6.84c-.486.39-.798.99-.798 1.66 0 1.174.95 2.125 2.125 2.125H17v-1.063H4.25c-.588 0-1.064-.476-1.064-1.063v-.01l13.812-2.115z"/></svg>
				<?php _e( 'Your Cart', 'keel' ) ?> (<?php echo esc_html( $cart_count ); ?>)
			</a>
		</div>
	</nav>
<?php endif; ?>
