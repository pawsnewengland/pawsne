<?php

/* ======================================================================
	searchform.php
	Template for search form.
	`.screen-reader` class hides label when used with Kraken boilerplate.
 * ====================================================================== */

?>

<form method="get" class="no-space-bottom" id="searchform" action="<?php echo esc_url( home_url('/') ); ?>" >
	<label class="screen-reader" for="s">Search this site:</label>
	<input type="text" class="input-search" placeholder="Search this site..." value="<?php get_search_query(); ?>" name="s" id="s">
	<button type="submit" class="btn-search" id="searchsubmit"><i class="icon icon-search"></i><span class="icon-fallback-text">Search</span></button>
</form>