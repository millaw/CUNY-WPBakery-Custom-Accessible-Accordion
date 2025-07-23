<?php
if (!defined('ABSPATH')) exit;

add_action('vc_before_init', 'cuny_wbca_register_accordion');

function cuny_wbca_register_accordion() {
    // Parent element (Accordion Container)
    vc_map(array(
        'name' => __('Accessible Accordion', 'textdomain'),
        'base' => 'accessible_accordion',
        'as_parent' => array('only' => 'accessible_accordion_section'), // Allow all elements as children
        'content_element' => true,
        'show_settings_on_create' => true,
        'category' => __('Custom Elements', 'textdomain'),
        'icon' => '',
        'js_view' => 'VcColumnView',
        'params' => array(
            array(
                'type' => 'checkbox',
                'heading' => __('Allow Collapse All', 'textdomain'),
                'param_name' => 'collapse_all',
                'value' => array(__('Yes', 'textdomain') => 'true'),
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Active Section (0 = none)', 'textdomain'),
                'param_name' => 'active_section',
                'value' => '1',
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Accordion Style', 'textdomain'),
                'param_name' => 'accordion_style',
                'value' => array(
                    'White' => 'white',
                    'Chino' => 'chino',
                    'Blue' => 'blue'
                )
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Extra class name', 'textdomain'),
                'param_name' => 'el_class'
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Extra ID', 'textdomain'),
                'param_name' => 'el_id'
            )
        )
    ));

    // Accordion Section as a container for built-in elements
    vc_map(array(
        'name' => __('Accessible Accordion Section', 'textdomain'),
        'base' => 'accessible_accordion_section',
        'content_element' => true,
        'as_child' => array('only' => 'accessible_accordion'), // Only allowed inside Accordion
        'as_parent' => array('except' => ''), // Can contain any element
        'js_view' => 'VcColumnView', // Make children editable in backend
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => __('Title', 'textdomain'),
                'param_name' => 'title',
                'value' => __('Section Title', 'textdomain'),
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Section ID (auto-generated if left blank)', 'textdomain'),
                'param_name' => 'section_id',
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Heading Tag', 'textdomain'),
                'param_name' => 'heading_tag',
                'value' => array(
                    'DIV' => 'div',
                    'P' => 'p',
                    'H2' => 'h2',
                    'H3' => 'h3',
                    'H4' => 'h4',
                ),
                'description' => __('Wrap title in this HTML tag', 'textdomain')
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Extra class name', 'textdomain'),
                'param_name' => 'el_class'
            )
        )
    ));
}

// Allow nested shortcode structure
// Required to declare nested containers in WPBakery
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Accessible_Accordion extends WPBakeryShortCodesContainer {}
    class WPBakeryShortCode_Accessible_Accordion_Section extends WPBakeryShortCodesContainer {
        public function content($atts, $content = null) {
            $output = '';
            $atts = shortcode_atts(array(
                'title' => '',
                'section_id' => '',
                'heading_tag' => 'div',
                'el_class' => ''
            ), $atts);
            $section_id = $atts['section_id'] ? esc_attr($atts['section_id']) : uniqid('accordion-section-');
            $heading_tag = in_array($atts['heading_tag'], array('div','p','h2','h3','h4')) ? $atts['heading_tag'] : 'div';
            $el_class = esc_attr($atts['el_class']);
            $output .= '<div id="' . $section_id . '" class="accessible-accordion-section ' . $el_class . '">';
            $output .= '<' . $heading_tag . ' class="accessible-accordion-title">' . esc_html($atts['title']) . '</' . $heading_tag . '>';
            $output .= '<div class="accessible-accordion-content">';
            $output .= wpb_js_remove_wpautop($content, true);
            $output .= '</div></div>';
            return $output;
        }
    }
}
