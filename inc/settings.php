<?php

/* Load admin assets */
function scupLoadAdminScript()
{
    if ( 'settings_page_scup-setting'  === get_current_screen()->base )
    {   
        wp_enqueue_script( array( 'jquery' ) );
        wp_enqueue_script( 'scupadmin', plugin_dir_url( __DIR__ ) . 'assets/scupadmin.js', array('jquery'), '1.0.0', true );
        wp_enqueue_style( 'fontawesome', '//use.fontawesome.com/releases/v5.5.0/css/all.css', '5.5.0' );
        wp_enqueue_style( 'scupadmin', plugin_dir_url( __DIR__ ) . 'assets/admin.css', '1.0.0' );
    }
}
add_action( 'admin_enqueue_scripts', 'scupLoadAdminScript' );


/* Add settings page */
function scupSettings()
{
	add_options_page(
        'Scroll UP Options', 
        'Scroll UP', 
        'manage_options', 
        'scup-setting', 
        'scupSettingsRender'
    );
}
add_action('admin_menu', 'scupSettings');


function scupSettingsSections()
{
    add_settings_section( 'scupSettings_section_top', __( 'General Settings', 'sc-scrollup' ), array(), 'scup-setting' );
    add_settings_section( 'scupSettings_section_bottom', __( 'Distance', 'sc-scrollup' ), array(), 'scup-setting' );
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
            'description' => __('Set width (px) of the scrollup.', 'sc-scrollup' ),
        ),
        
        array(
            'label'   => __( 'Height', 'sc-scrollup' ),
            'id'      => 'scupSettings_height',
            'type'    => 'number',
            'section' => 'scupSettings_section_top',
            'description' => __('Set height (px) of the scrollup.', 'sc-scrollup' ),
        ),

        array(
            'label'   => __( 'Background', 'sc-scrollup' ),
            'id'      => 'scupSettings_background',
            'type'    => 'Color',
            'section' => 'scupSettings_section_top',
            'description' => __('Set background color of the scrollup.', 'sc-scrollup' ),
        ),

        array(
            'label'   => __( 'Speed', 'sc-scrollup' ),
            'id'      => 'scupSettings_speed',
            'type'    => 'number',
            'section' => 'scupSettings_section_top',
            'description' => __('Scrollup speed in ms.', 'sc-scrollup' ),
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
            'scup-setting',
            $field['section'], 
            $field 
        );

        switch ( $field['type'] )
        {
            case 'toggle':
            case 'checkbox':
            case 'radio':
                register_setting( 
                    'scup-setting', 
                    $field['id'], 
                    array('sanitize_callback' => 'sanitize_text_field')
                );
                break;
            
            default:
                register_setting( 
                    'scup-setting', 
                    $field['id'],
                    array('sanitize_callback' => 'sanitize_text_field')
                );
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
                esc_attr($field['id']),
                esc_attr(isset($field['placeholder']) ? $field['placeholder'] : ''),
                esc_textarea($value)
            );
            break;

        case 'select':
            $options = $field['options'];

            echo '<select id="'.esc_attr($field['id']).'" name="'.esc_attr($field['id']).'">';
            foreach( $options as $option )
            {
                $selected = ($value === $option) ? 'selected' : '';
                printf('<option value="%s" %s>%s</option>', esc_attr($option), esc_attr($selected), esc_attr($option) );
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
                </div>', esc_attr($field['id']), esc_attr($field['id']), esc_attr($checked), esc_attr($field['id']));
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

                printf('<input type="checkbox" name="%s[]" value="%s" %s> %s <br>', esc_attr($field['id']), esc_attr($option), esc_attr($checked), esc_html($option) );
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

                printf('<input type="radio" name="%s[]" value="%s" %s> %s <br>', esc_attr($field['id']), esc_attr($option), esc_attr($checked), esc_html($option) );

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
                esc_attr($field['id']),
                esc_attr($field['type']),
                esc_attr(isset($field['placeholder']) ? $field['placeholder'] : ''),
                esc_attr($value)
            );
    }

    if ( isset( $field['description'] ) )
    {
        if ( $desc = $field['description'] )
            printf( '<p class="description">%s</p>', esc_html($desc) );
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
            
            settings_fields( 'scup-setting' ); //option group , should match with register_setting('otfw-options') 
            do_settings_sections( 'scup-setting' ); // setting page slug 'otfw-options'
            submit_button();
            ?>
        </form>
    </div>
    <div class="scup-recommendations">
        <h2>Hello!</h2>
        <div class="dev-credit"><strong><a href="https://x.com/MashiurR_">Follow Me</a></strong> on X!</br>I'm available to hire, Contact: <a href="mailto:mashiur.dev@gmail.com">mashiur.dev@gmail.com</a></div>
    </div>
</div>

<?php
}