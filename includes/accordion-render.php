<?php
add_shortcode('accessible_accordion', 'render_accessible_accordion');
function render_accessible_accordion($atts, $content = null) {
    $atts = shortcode_atts(array(
        'collapse_all' => '',
        'active_section' => '1',
        'accordion_style' => 'white',
        'el_class' => '',
        'el_id' => ''
    ), $atts);

    $id_attr = $atts['el_id'] ? 'id="' . esc_attr($atts['el_id']) . '"' : '';
    $class_attr = 'cuny-wbca-accordion ' . esc_attr($atts['accordion_style']) . ' ' . esc_attr($atts['el_class']);
    $output = "<div $id_attr class=\"$class_attr\" data-collapse-all=\"{$atts['collapse_all']}\" data-active-section=\"{$atts['active_section']}\">";
    $output .= do_shortcode($content);
    $output .= "</div>";
    return $output;
}

add_shortcode('accessible_accordion_section', 'render_accessible_accordion_section');
function render_accessible_accordion_section($atts, $content = null) {
    $atts = shortcode_atts(array(
        'title' => 'Section',
        'section_id' => '',
        'heading_tag' => 'div',
        'add_icon' => '',
        'el_class' => ''
    ), $atts);

    if (empty($atts['section_id'])) {
        $atts['section_id'] = uniqid('accordion_');
    }

    $heading_tag = in_array($atts['heading_tag'], ['div', 'p', 'h2', 'h3', 'h4']) ? $atts['heading_tag'] : 'div';

    $output = '<div class="cuny-wbca-item ' . esc_attr($atts['el_class']) . '">';
    $output .= '<' . $heading_tag . ' class="cuny-wbca-header cuny-wbca-icon">';
    $output .= '<button class="cuny-wbca-toggle" aria-expanded="false" aria-controls="panel-' . esc_attr($atts['section_id']) . '">';
    $output .= '<div>';
    $output .= esc_html($atts['title']);
    $output .= '</div>';
    $output .= '</button>';
    $output .= '</' . $heading_tag . '>';

    $output .= '<div id="panel-' . esc_attr($atts['section_id']) . '" class="cuny-wbca-panel" role="region" aria-hidden="true">';
    $output .= do_shortcode($content);
    $output .= '</div></div>';

    return $output;
}
