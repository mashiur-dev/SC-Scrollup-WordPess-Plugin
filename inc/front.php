<?php
function scupFront() 
{
	// Icon size
	$iconSize = absint(get_option('scupSettings_icon_size', 16));
	if (0 === $iconSize) {
		$iconSize = 16; // Fallback to default if stored value was 0 or invalid
	}

	// Scroll Speed
	$scrollSpeed = absint(get_option('scupSettings_speed', 400));
	if (0 === $scrollSpeed) {
		$scrollSpeed = 400; // Fallback to default if stored value was 0 or invalid
	}

	// Width
	$width = absint(get_option('scupSettings_width', 40));
	if (0 === $width) {
		$width = 40; // Fallback to default if stored value was 0 or invalid
	}

	// Height
	$height = absint(get_option('scupSettings_height', 30));
	if (0 === $height) {
		$height = 30; // Fallback to default if stored value was 0 or invalid
	}

	// Right Distance
	$rightDistance = absint(get_option('scupSettings_distance_right', 50));
	if (0 === $rightDistance) {
		$rightDistance = 50; // Fallback to default if stored value was 0 or invalid
	}

	// Bottom Distance
	$bottomDistance = absint(get_option('scupSettings_distance_bottom', 50));
	if (0 === $bottomDistance) {
		$bottomDistance = 50; // Fallback to default if stored value was 0 or invalid
	}

	// Background Color
	$background = sanitize_hex_color(get_option('scupSettings_background', '#000000'));

	// Icon Color
	$color = sanitize_hex_color(get_option('scupSettings_icon_color', '#ffffff'));


	// This securely passes PHP variables to a JavaScript object named 'scup_vars'
	wp_localize_script('scup-script', 'scup_vars', array(
		'scrollSpeed' => $scrollSpeed
	));

	// Pass Variables to CSS (Using wp_add_inline_style)
	$inline_css = sprintf(
		'#scUPscroller {
            width: %1$dpx;
            height: %2$dpx;
            bottom: %3$dpx;
            right: %4$dpx;
            background: %5$s;
        }
        #scUPscroller i {
            color: %6$s;
			font-size: %7$dpx;
        }',
		$width,
		$height,
		$bottomDistance,
		$rightDistance,
		$background,
		$color,
		$iconSize
	);

	wp_add_inline_style('scup-styles', $inline_css);

	add_action('wp_footer', 'scupPrintHtml');
}
add_action('wp_enqueue_scripts', 'scupFront');



function scupPrintHtml()
{
	$arrowIcon = (strpos(get_option('scupSettings_icon'), 'fas') !== false) ? get_option('scupSettings_icon') : 'fas fa-angle-up';
	$iconClass = esc_attr($arrowIcon);

	$buttonLabel = esc_attr(__('Scroll to top', 'sc-scrollup'));

	printf(
		'<button id="scUPscroller" aria-label="%1$s" title="%1$s"><i class="%2$s"></i></button>',
		esc_attr($buttonLabel),
		esc_attr($iconClass)
	);
}