		
		<div class="clear"></div>
		
		<div id="push"></div>
		
	</div>
	
	<div id="footer">
		<div id="footer-inside">
		
			<div id="footer-1">

				<h1>Help us rebuild our sanctuary</h1>

				<p>Our dog sanctuary was destroyed by flooding in Tennessee this summer. You can help.</p>

<p><strong><a href="<?php echo get_option('home'); ?>/paws-sanctuary-flood/">Learn how...</a></strong></p>
			
			</div>

			<div id="footer-2">

				<h1>The PAWS Story</h1>
			
				<p>Learn how PAWS got started, how we work, and how you can help.</p>

				<p><strong><a href="<?php echo get_option('home'); ?>/about/">Learn more...</a></strong></p>
			
			</div>

			<div id="footer-3">
			
				<ul id="connect-footer">
           			<li><a href="http://eepurl.com/ifVL"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/email.png"> Newsletter</a></li>
           			<li><a href="http://www.facebook.com/group.php?gid=51621723873"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/facebook.png"> Facebook</a></li>
           			<li><a href="http://twitter.com/PAWSNewEngland"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/twitter.png"> Twitter</a></li>
       				</ul>
			
			</div>

			<div id="footer-4">

				<center><p><a href="<?php echo get_option('home'); ?>/">Home</a> | <a href="<?php echo get_option('home'); ?>/about/">Our Story</a> | <a href="<?php echo get_option('home'); ?>/adopt/">Adopt</a> | <a href="<?php echo get_option('home'); ?>/donate/">Donate</a> | <a href="<?php echo get_option('home'); ?>/help/">Get Involved</a> | <a href="<?php echo get_option('home'); ?>/news/">News</a> | <a href="<?php echo get_option('home'); ?>/resources/">Resouces</a> | <a href="<?php echo get_option('home'); ?>/contact/">Contact</a> | <a href="<?php echo get_option('home'); ?>/site-map/">Site Map</a></p></center>

				<center><p>Copyright © 2010 PAWS New England. All rights reserved. Web Design by Chris Ferdinandi</p></center>
			
			</div>

			
		</div>
	</div>

	<?php wp_footer(); ?>
	
<!-- MAILCHIMP SCRIPTS -->

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
<script type="text/javascript" src="http://downloads.mailchimp.com/js/jquery.validate.js"></script>
<script type="text/javascript" src="http://downloads.mailchimp.com/js/jquery.form.js"></script>
<script type="text/javascript">
// delete this script tag and use a "div.mce_inline_error{ XXX !important}" selector
// or fill this in and it will be inlined when errors are generated
var mc_custom_error_style = '';
</script>



<script type="text/javascript">
var fnames = new Array();var ftypes = new Array();fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[0]='EMAIL';ftypes[0]='email';var err_style = '';
try{
    err_style = mc_custom_error_style;
} catch(e){
    err_style = 'margin: 1em 0 0 0; padding: 1em 0.5em 0.5em 0.5em; background: ERROR_BGCOLOR none repeat scroll 0% 0%; font-weight: bold; float: left; z-index: 1; width: 80%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; color: ERROR_COLOR;';
}
var mce_jQuery = jQuery.noConflict();
mce_jQuery(document).ready( function($) {
  var options = { errorClass: 'mce_inline_error', errorElement: 'div', errorStyle: err_style, onkeyup: function(){}, onfocusout:function(){}, onblur:function(){}  };
  var mce_validator = mce_jQuery("#mc-embedded-subscribe-form").validate(options);
  options = { url: 'http://pawsnewengland.us1.list-manage.com/subscribe/post-json?u=0c705fc71db1e2d4d6f5f4ba3&id=2d6244b8d5&c=?', type: 'GET', dataType: 'json', contentType: "application/json; charset=utf-8",
                beforeSubmit: function(){
                    mce_jQuery('#mce_tmp_error_msg').remove();
                    mce_jQuery('.datefield','#mc_embed_signup').each(
                        function(){
                            var txt = 'filled';
                            var fields = new Array();
                            var i = 0;
                            mce_jQuery(':text', this).each(
                                function(){
                                    fields[i] = this;
                                    i++;
                                });
                            mce_jQuery(':hidden', this).each(
                                function(){
                                	if ( fields[0].value=='MM' && fields[1].value=='DD' && fields[2].value=='YYYY' ){
                                		this.value = '';
									} else if ( fields[0].value=='' && fields[1].value=='' && fields[2].value=='' ){
                                		this.value = '';
									} else {
	                                    this.value = fields[0].value+'/'+fields[1].value+'/'+fields[2].value;
	                                }
                                });
                        });
                    return mce_validator.form();
                }, 
                success: mce_success_cb
            };
  mce_jQuery('#mc-embedded-subscribe-form').ajaxForm(options);

});
function mce_success_cb(resp){
    mce_jQuery('#mce-success-response').hide();
    mce_jQuery('#mce-error-response').hide();
    if (resp.result=="success"){
        mce_jQuery('#mce-'+resp.result+'-response').show();
        mce_jQuery('#mce-'+resp.result+'-response').html(resp.msg);
        mce_jQuery('#mc-embedded-subscribe-form').each(function(){
            this.reset();
    	});
    } else {
        var index = -1;
        var msg;
        try {
            var parts = resp.msg.split(' - ',2);
            if (parts[1]==undefined){
                msg = resp.msg;
            } else {
                i = parseInt(parts[0]);
                if (i.toString() == parts[0]){
                    index = parts[0];
                    msg = parts[1];
                } else {
                    index = -1;
                    msg = resp.msg;
                }
            }
        } catch(e){
            index = -1;
            msg = resp.msg;
        }
        try{
            if (index== -1){
                mce_jQuery('#mce-'+resp.result+'-response').show();
                mce_jQuery('#mce-'+resp.result+'-response').html(msg);            
            } else {
                err_id = 'mce_tmp_error_msg';
                html = '<div id="'+err_id+'" style="'+err_style+'"> '+msg+'</div>';
                
                var input_id = '#mc_embed_signup';
                var f = mce_jQuery(input_id);
                if (ftypes[index]=='address'){
                    input_id = '#mce-'+fnames[index]+'-addr1';
                    f = mce_jQuery(input_id).parent().parent().get(0);
                } else if (ftypes[index]=='date'){
                    input_id = '#mce-'+fnames[index]+'-month';
                    f = mce_jQuery(input_id).parent().parent().get(0);
                } else {
                    input_id = '#mce-'+fnames[index];
                    f = mce_jQuery().parent(input_id).get(0);
                }
                if (f){
                    mce_jQuery(f).append(html);
                    mce_jQuery(input_id).focus();
                } else {
                    mce_jQuery('#mce-'+resp.result+'-response').show();
                    mce_jQuery('#mce-'+resp.result+'-response').html(msg);
                }
            }
        } catch(e){
            mce_jQuery('#mce-'+resp.result+'-response').show();
            mce_jQuery('#mce-'+resp.result+'-response').html(msg);
        }
    }
}
</script>

<!-- END OF MAILCHIMP SCRIPTS -->


</body>

</html>