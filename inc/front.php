<?php
function scupFront() 
{
	$getIcon = get_option('scupSettings_icon');
	$arrowIcon = (strpos($getIcon, 'fas') !== false) ? $getIcon : 'fas fa-angle-up';

	$getSpeed = get_option('scupSettings_speed');
	$scrollSpeed = (!empty(trim($getSpeed))) ? $getSpeed : 500;

	$getWidth = get_option('scupSettings_width');
	$width = (!empty(trim($getWidth))) ? $getWidth : 40;

	$getHeight = get_option('scupSettings_height');
	$height = (!empty(trim($getHeight))) ? $getHeight : 30;

	$getBackground = get_option('scupSettings_background', '#000000');
	$getColor = get_option('scupSettings_icon_color', '#ffffff');

	$getRightDistance = get_option('scupSettings_distance_right');
	$RightDistance = (!empty(trim($getRightDistance))) ? $getRightDistance : 50;

	$getBottomDistance = get_option('scupSettings_distance_bottom');
	$BottomDistance = (!empty(trim($getBottomDistance))) ? $getBottomDistance : 50;
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
			width:<?php echo esc_html( $width ); ?>px;
			height:<?php echo esc_html( $height ); ?>px;
			position:fixed;
			bottom:<?php echo esc_html( $BottomDistance ); ?>px;
			right:<?php echo esc_html( $RightDistance ); ?>px;
			display:none; 
			cursor: pointer;
			z-index: 999999!important;
			background:<?php echo esc_html( $getBackground ); ?>;
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
			color: <?php echo esc_html( $getColor ); ?>;
			margin: auto;
			position: absolute;
			left: 0;
			right: 0;
			top: 50%;
			margin-top: -13px;
		}
	</style>
<?php }
add_action('wp_head', 'scupFront');