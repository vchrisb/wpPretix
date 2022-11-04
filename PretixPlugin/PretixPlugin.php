<?php
/*
Plugin Name: Pretix Shortcode
Description: Plugin to add a shortcode for Pretix
Version: 0.1.0
Author: Christopher Banck
Author URI: https://banck.net
*/
/* Start Adding Functions Below this Line */


$Pretix_options_defaults = array(
    'organization' => 'https://pretix.eu/demo',
    'widget_script' => '/widget/v1.de.js',
    'widget_style' => '/widget/v1.css',
  );

/**
 * This function is used to check the_content to see if it contains any pretix shortcode and adds widget code
 *
 * @param $content
 *
 * @return string
 */

function Pretix_shortcode_check($content)
{
    if (has_shortcode($content, 'pretix-button')) {
        global $Pretix_options_defaults;
        $options = wp_parse_args(get_option('Pretix_options'), $Pretix_options_defaults);
        wp_enqueue_style('pretix_style', $options['organization'] . $options['widget_style']);
        wp_enqueue_script('pretix_script', $options['organization'] . $options['widget_script']);
    }

    return $content; // Make sure you still return your content or else nothing will display.
}
add_filter('the_content', 'Pretix_shortcode_check');


/**
 * This function is used to generate the widget code
 */

function pretix_button($atts = [], $content = null, $tag = '')
{
    global $Pretix_options_defaults;
    $options = wp_parse_args(get_option('Pretix_options'), $Pretix_options_defaults);
    $POST_ID = get_the_ID();

    if (isset($atts['event'])) {
        $event = $atts['event'];
    } elseif (get_post_meta($POST_ID, 'pretix_event', true)) {
        $event = get_post_meta($POST_ID, 'pretix_event', true);
    } else {
        return '';
    }
    $eventurl = $options['organization'] . '/' . $event;
    $button_options = 'event="' . $eventurl . '"';


    if (isset($atts['subevent'])) {
        $button_options .= ' subevent="' . $atts['subevent'] . '"';
    } elseif (get_post_meta($POST_ID, 'pretix_subevent', true)) {
        $button_options .= ' subevent="' . get_post_meta($POST_ID, 'pretix_subevent', true) . '"';
    }

    if (isset($atts['voucher'])) {
        $button_options .= ' voucher="' . $atts['voucher'] . '"';
    } elseif (get_post_meta($POST_ID, 'pretix_voucher', true)) {
        $button_options .= ' voucher="' . get_post_meta($POST_ID, 'pretix_voucher', true) . '"';
    }

    if (isset($atts['items'])) {
        $button_options .= ' items="' . $atts['items'] . '"';
    } elseif (get_post_meta($POST_ID, 'pretix_items', true)) {
        $button_options .= ' items="' . get_post_meta($POST_ID, 'pretix_items', true) . '"';
    }

    if (isset($atts['iframe']) && $atts['iframe'] === 'disable') {
        $button_options .= ' disable-iframe';
    } elseif (get_post_meta($POST_ID, 'pretix_iframe', true) === 'disable') {
        $button_options .= ' disable-iframe';
    }

    if (isset($atts['text'])) {
        $text = $atts['text'];
    } else {
        $text = "Tickets";
    }
    return '<pretix-button ' . $button_options . '>' . $text . '</pretix-button>';
}

function Pretix_register_shortcodes()
{
    add_shortcode('pretix-button', 'pretix_button');
}

add_action('init', 'Pretix_register_shortcodes');

class PretixAdmin
{
    private $Pretix_options;

    public function __construct()
    {
        add_action('admin_menu', array( $this, 'Pretix_add_plugin_page' ));
        add_action('admin_init', array( $this, 'Pretix_page_init' ));
    }

    public function Pretix_add_plugin_page()
    {
        add_options_page(
            'Pretix', // page_title
            'Pretix', // menu_title
            'manage_options', // capability
            'pretix', // menu_slug
            array( $this, 'Pretix_create_admin_page' ) // function
        );
    }

    public function Pretix_create_admin_page()
    {
        global $Pretix_options_defaults;
        $this->Pretix_options = get_option('Pretix_options', $Pretix_options_defaults); ?>

		<div class="wrap">
			<h2>Pretix Shortcode Settings</h2>
			<p>Configure options</p>

			<form method="post" action="options.php">
				<?php
                    settings_fields('Pretix_option_group');
        do_settings_sections('Pretix-admin');
        submit_button();
        ?>
			</form>
		</div>
	<?php }

    public function Pretix_page_init()
    {
        register_setting(
            'Pretix_option_group', // option_group
            'Pretix_options', // option_name
            array( $this, 'Pretix_sanitize' ) // sanitize_callback
        );

        add_settings_section(
            'Pretix_setting_section', // id
            'Settings', // title
            array( $this, 'Pretix_section_info' ), // callback
            'Pretix-admin' // page
        );

        add_settings_field(
            'organization', // id
            'Organization URL', // title
            array( $this, 'organization_callback' ), // callback
            'Pretix-admin', // page
            'Pretix_setting_section' // section
        );

        add_settings_field(
            'widget_script', // id
            'Widget script', // title
            array( $this, 'widget_script_callback' ), // callback
            'Pretix-admin', // page
            'Pretix_setting_section' // section
        );

        add_settings_field(
            'widget_style', // id
            'Widget style', // title
            array( $this, 'widget_style_callback' ), // callback
            'Pretix-admin', // page
            'Pretix_setting_section' // section
        );
    }

    public function Pretix_sanitize($input)
    {
        $sanitary_values = array();
        if (isset($input['organization'])) {
            $sanitary_values['organization'] = sanitize_text_field($input['organization']);
        }

        if (isset($input['widget_script'])) {
            $sanitary_values['widget_script'] = sanitize_text_field($input['widget_script']);
        }

        if (isset($input['widget_style'])) {
            $sanitary_values['widget_style'] = sanitize_text_field($input['widget_style']);
        }
        return $sanitary_values;
    }

    public function Pretix_section_info()
    {
    }

    public function organization_callback()
    {
        printf(
            '<input class="regular-text" type="text" name="Pretix_options[organization]" id="organization" value="%s">',
            isset($this->Pretix_options['organization']) ? esc_attr($this->Pretix_options['organization']) : ''
        );
    }

    public function widget_script_callback()
    {
        printf(
            '<input class="regular-text" type="text" name="Pretix_options[widget_script]" id="widget_script" value="%s">',
            isset($this->Pretix_options['widget_script']) ? esc_attr($this->Pretix_options['widget_script']) : ''
        );
    }

    public function widget_style_callback()
    {
        printf(
            '<input class="regular-text" type="text" name="Pretix_options[widget_style]" id="widget_style" value="%s">',
            isset($this->Pretix_options['widget_style']) ? esc_attr($this->Pretix_options['widget_style']) : ''
        );
    }
}
if (is_admin()) {
    $pretix = new PretixAdmin();
}

?>