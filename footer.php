	    </section>

        <div class="bg-color space-top">
	        <footer class="container text-center space-top">
		        <p><span class="text-small">Many thanks to <a href="http://www.4dogman.com/">John Gagnon's Pet Resort</a>, <a href="http://www.jennfrankavitz.com/">Jenn Frankavitz Photography</a>, <a href="http://www.goodnessgracioustreats.com/">Goodness Gracious</a>, <a href="http://www.smartpakequine.com/">SmartPak</a>, <a href="http://www.timberwolforganics.com/">Timberwolf Organics</a>, and our numerous <a href="http://www.pawsnewengland.com/paws-partners/">partners, volunteers and donors</a> for their support!</span></p>
		
		        <p class="space-bottom-small"><span class="text-small">Copyright © 2010 - <?php echo date('Y');?> <?php bloginfo('name'); ?>. All rights reserved.</span></p>

		        <p><a href="http://gomakethings.com"><span class="text-small">Web design by Chris Ferdinandi</a>.</span></p>	
	        </footer>
        <div>


	    <?php wp_footer(); ?>

        <!-- PetFinder API Redirect -->
        <?php if (is_page('our-dogs')) : ?>
            <script>
                $(document).ready(function() {
                    setTimeout("window.location='<?php echo get_option('home'); ?>/our-dogs-list/'", 500);
                });
            </script>
        <?php endif; ?>

        <!-- Google Analytics -->
        <script>
            var _gaq=[['_setAccount','UA-16807859-1'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>

    </body>
</html>