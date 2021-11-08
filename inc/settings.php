<?php


function scupLoadAdminScript()
{
    if ( 'settings_page_styc-scrollup'  === get_current_screen()->base )
    {   
        wp_enqueue_script( array( 'jquery' ) );
        wp_enqueue_script( 'scupadmin', plugin_dir_url( __DIR__ ) . 'assets/scupadmin.js', array('jquery'), '1.0.0', true );
        wp_enqueue_style( 'fontawesome', '//use.fontawesome.com/releases/v5.5.0/css/all.css', '5.5.0' );
        wp_enqueue_style( 'scupadmin', plugin_dir_url( __DIR__ ) . 'assets/admin.css', '1.0.0' );
    }
}


add_action( 'admin_enqueue_scripts', 'scupLoadAdminScript' );

/* Add Settings page */
function scupSettings()
{
	add_options_page(
        'Scroll UP', 
        'Scrollup Options', 
        'manage_options', 
        'styc-scrollup', 
        'scupSettingsRender'
    );
}
add_action('admin_menu', 'scupSettings');


function scupSettingsSections()
{
    add_settings_section( 'scupSettings_section_top', __( 'General Settings', 'sc-scrollup' ), array(), 'styc-scrollup' );
    add_settings_section( 'scupSettings_section_bottom', __( 'Distance', 'sc-scrollup' ), array(), 'styc-scrollup' );
}
add_action( 'admin_init', 'scupSettingsSections' );


function scupSettingsFields()
{
    $fields = array(
        array(
            'label'   => __( 'Width', 'sc-scrollup' ),
            'id'      => 'scupSettings_width',
            'type'    => 'number',
            'section' => 'scupSettings_section_top',
            'description' => __('Set width of the scrollup.', 'sc-scrollup' ),
        ),
        
        array(
            'label'   => __( 'Height', 'sc-scrollup' ),
            'id'      => 'scupSettings_height',
            'type'    => 'number',
            'section' => 'scupSettings_section_top',
            'description' => __('Set height of the scrollup.', 'sc-scrollup' ),
        ),

        array(
            'label'   => __( 'Background', 'sc-scrollup' ),
            'id'      => 'scupSettings_background',
            'type'    => 'Color',
            'section' => 'scupSettings_section_top',
            'description' => __('Set background color of the scrollup.', 'sc-scrollup' ),
        ),

        array(
            'label'   => __( 'Font Color', 'sc-scrollup' ),
            'id'      => 'scupSettings_font_color',
            'type'    => 'Color',
            'section' => 'scupSettings_section_top',
            'description' => __('Set background color of the scrollup.', 'sc-scrollup' ),
        ),

        array(
            'label'   => __( 'Speed', 'sc-scrollup' ),
            'id'      => 'scupSettings_speed',
            'type'    => 'number',
            'section' => 'scupSettings_section_top',
            'description' => __('Scrollup speed.', 'sc-scrollup' ),
        ),

        array(
            'label'   => __( 'Right', 'sc-scrollup' ),
            'id'      => 'scupSettings_distance_right',
            'type'    => 'range',
            'section' => 'scupSettings_section_bottom',
            'description' => __('Distance from right.', 'sc-scrollup' ),
        ),

        array(
            'label'   => __( 'Bottom', 'sc-scrollup' ),
            'id'      => 'scupSettings_distance_bottom',
            'type'    => 'range',
            'section' => 'scupSettings_section_bottom',
            'description' => __('Distance from right.', 'sc-scrollup' ),
        ),

        array(
            'label'   => esc_html__( 'Icon', 'sc-scrollup' ),
            'id'      => 'scupSettings_icon',
            'type'    => 'icons',
            'section' => 'scupSettings_section_bottom',
            'description' => esc_html__('Select icon.', 'sc-scrollup' ),
        )
        
    );

    foreach ( $fields as $field )
    {
        add_settings_field(
            $field['id'], 
            $field['label'], 
            'scupSettingsFieldsGenerator', 
            'styc-scrollup',
            $field['section'], 
            $field 
        );

        switch ( $field['type'] )
        {
            case 'toggle':
            case 'checkbox':
            case 'radio':
                register_setting( 'styc-scrollup', $field['id']);
                break;
            
            default:
                register_setting( 'styc-scrollup', $field['id'], array( 'sanitize_callback' => 'esc_attr' ) );
        }
    }

}

add_action( 'admin_init', 'scupSettingsFields' );



function scupSettingsFieldsGenerator( $field )
{
    $value = get_option( $field['id'] );

    switch ( $field['type'] ) {
        case 'textarea':
            printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>',
                $field['id'],
                isset( $field['placeholder'] ) ? $field['placeholder'] : '',
                $value
            );
            break;

        case 'select':
            $options = $field['options'];

            echo '<select id="'.$field['id'].'" name="'.$field['id'].'">';
            foreach( $options as $option )
            {
                $selected = ($value === $option) ? 'selected' : '';
                printf('<option value="%s" %s>%s</option>', $option, $selected, $option );
            }
            echo "</select>";

            break;

        case 'toggle':
                if( is_array($value) && in_array('toggled', $value) )
                {
                    $checked = 'checked';
                }
                printf ('<div class="jsp_switch">
                    <input type="checkbox" name="%s[]" id="%s" value="toggled" %s>
                    <label for="%s"></label>
                </div>', $field['id'], $field['id'], $checked, $field['id']);
                break;

        case 'checkbox':
            $options = $field['options'];

            foreach( $options as $option )
            {	
                $checked = '';
                if( is_array($value) && in_array($option, $value) )
                {
                    $checked = 'checked';
                }

                printf('<input type="checkbox" name="%s[]" value="%s" %s> %s <br>', $field['id'], $option, $checked, $option );
            }
            break;
        
        case 'radio':
            $options = $field['options'];

            foreach( $options as $option )
            {	
                $checked = '';
                if( is_array($value) && in_array($option, $value) )
                {
                    $checked = 'checked';
                }

                printf('<input type="radio" name="%s[]" value="%s" %s> %s <br>', $field['id'], $option, $checked, $option );
            }
            break;

        case 'icons':
            printf('<div id="%s" class="jomps-icons">
                <ul class="jomps-icons-selector">
                    <li><i class="fas fa-angle-double-up"></i></li>
                    <li><i class="fas fa-angle-up"></i></li>
                    <li><i class="fas fa-arrow-alt-circle-up"></i></li>
                    <li><i class="fas fa-arrow-circle-up"></i></li>
                    <li><i class="fas fa-arrow-up"></i></li>
                    <li><i class="fas fa-arrows-alt-v"></i></li>
                    <li><i class="fas fa-caret-square-up"></i></li>
                    <li><i class="fas fa-caret-up"></i></li>
                    <li><i class="fas fa-chevron-circle-up"></i></li>
                    <li><i class="fas fa-chevron-up"></i></li>
                    <li><i class="fas fa-cloud-upload-alt"></i></li>
                    <li><i class="fas fa-level-up-alt"></i></li>
                    <li><i class="fas fa-long-arrow-alt-up"></i></li>
                    <li><i class="fas fa-sort-up"></i></li>
                </ul>
                <input type="hidden" name="%s" value="%s">
            </div>', esc_attr( $field['id'] ), esc_attr( $field['id'] ), esc_attr( $value ));
            break;

        default:
            printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
                $field['id'],
                $field['type'],
                isset( $field['placeholder'] ) ? $field['placeholder'] : '',
                $value
            );
    }

    if ( isset( $field['description'] ) )
    {
        if ( $desc = $field['description'] )
            printf( '<p class="description">%s</p>', $desc );
    }
}


function scupSettingsRender()
{

?>

<div class="wrap scup-settings">
    <div class="scup-fields">
        <h1><?php echo esc_html__( 'SC ScrollUP Options', 'sc-scrollup' ); ?></h1>
        <p><?php echo esc_html__( 'Configure SC scrollup as you need!', 'sc-scrollup' ); ?></p>
        <form method="POST" action="options.php">
            <?php 
            wp_nonce_field('update-options');
            
            settings_fields( 'styc-scrollup' ); //option group , should match with register_setting('otfw-options') 
            do_settings_sections( 'styc-scrollup' ); // setting page slug 'otfw-options'
            submit_button();
            ?>
        </form>
    </div>
    <div class="scup-recommendations">
        <h2>Recommended Plugins</h2>
        <p><strong><a href="https://twitter.com/MashiurR_">Follow Me</a></strong> on Twitter!</br>I'm available to hire, Email Me: <a href="mailto:mashiur.dev@gmail.com">mashiur.dev@gmail.com</a></p>
        <a href="//wordpress.org/plugins/ultimate-coupon-for-woocommerce" target="_blank">
            <img src="<?php echo esc_url( __DIR__ . '/assets/ucfw-banner.png' ); ?>" alt="">
        </a>
    </div>
</div>

<?php
}