<?php
function scupFront() 
{
	$getIcon = get_option('styc_scrollup_icon', 'fas fa-angle-up');
	$arrowIcon = (strpos($getIcon, 'fas') !== false) ? $getIcon : 'fas fa-angle-up';

	$scrollSpeed = get_option('scupSettings_speed', 500);
?>
	
	<script>
		/*===== SC ScrolUP js ========*/
		jQuery(document).ready(function(){
			jQuery('body').append('<div id="scUPscroller"><i class="<?php echo esc_html( $arrowIcon ); ?>"></i></div>');

			var scroller = jQuery('#scUPscroller'),
				scrollSpeed = <?php echo esc_html( $scrollSpeed ); ?>;

			jQuery(window).scroll(function(){

				if ( jQuery(this).scrollTop() > 100 ) 
				{
					scroller.fadeIn();
				}
				else
				{
					scroller.fadeOut();
				}

			});
			
			scroller.click(function()
			{
				jQuery("html, body").animate( { scrollTop: 0 }, scrollSpeed );
				return false;
			});
		
		});
		
	</script>
	<!-- SC ScrolUP Style -->
	<style>
		/*===== SC Scrollup style ========*/
		#scUPscroller
		{
			width:<?php if( get_option('styc_scrollup_weight') ){ echo get_option('styc_scrollup_weight');}else {echo '40';}  ?>px;
			height:<?php if( get_option('styc_scrollup_height') ){ echo get_option('styc_scrollup_height');}else {echo '20';}  ?>px;
			position:fixed;
			bottom:50px;
			right:<?php if( get_option('styc_scrollup_right_distance') ){ echo get_option('styc_scrollup_right_distance'); }else{echo '50px';} ?>;
			display:none;
			cursor: pointer;
			z-index: 999999!important;
			background:<?php if( get_option('styc_scrollup_background') ){ echo get_option('styc_scrollup_background');}else { echo '#000000'; } ?>;
			opacity:0.6;
			border-radius: 2px;
		}
		
		#scUPscroller:hover
		{
			opacity:0.9;
		}
		
		#scUPscroller i
		{
			text-align: center;
			font-size: 24px;
			display: block;
			color: #fff;
			margin: auto;
			position: absolute;
			left: 0;
			right: 0;
			top: 50%;
			margin-top: -13px;
		}
		<?php echo get_option('styc_scrollup_stylecode'); ?>
		
		/*===== SC Scrollup style ========*/
	</style>
<?php }
add_action('wp_head', 'scupFront');