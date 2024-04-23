<?php
/*
Plugin Name: TRDS Website Visitor Counter
Description: This plugin counts daily and monthly visits and provides a shortcode to display the counts on any part of the site. It also allows customization of the visitor count display options.
Version: 1.1
Author: Arnel Go
*/

// Function to count daily visits
function custom_visitor_count_daily()
{
    if (!isset($_COOKIE['custom_visitor_daily'])) {
        $count = get_option('custom_visitor_daily_count', 0);
        $count++;
        update_option('custom_visitor_daily_count', $count);
        setcookie('custom_visitor_daily', true, strtotime('tomorrow'));
    }
}

// Function to count monthly visits
function custom_visitor_count_monthly()
{
    if (!isset($_COOKIE['custom_visitor_monthly'])) {
        $count = get_option('custom_visitor_monthly_count', 0);
        $count++;
        update_option('custom_visitor_monthly_count', $count);
        setcookie('custom_visitor_monthly', true, strtotime('next month'));
    }
}

// Function to display visitor counts using shortcode
function custom_visitor_count_shortcode()
{
    $daily_count = get_option('custom_visitor_daily_count', 0);
    $monthly_count = get_option('custom_visitor_monthly_count', 0);
    $input_text = get_option('custom_visitor_input', 'Our Visitor');
    $input_color = get_option('custom_visitor_input_color', '#000000');
    $input_alignment = get_option('custom_visitor_input_alignment', 'left');
    $views_text_today = get_option('custom_visitor_views_text_today', 'Views Today');
    $views_text_month = get_option('custom_visitor_views_text_month', 'Views This Month');
    $views_color = get_option('custom_visitor_views_color', '#815b0a');
    $views_alignment = get_option('custom_visitor_views_alignment', 'left');

    $output = '<div class="elementor-shortcode">';
    $output .= '<div id="mvcwid" style="text-align: ' . esc_attr($input_alignment) . '; color: ' . esc_attr($input_color) . ';">';
    $output .= '<h3 class="wps_visitor_title">' . esc_html($input_text) . '</h3>';
    $output .= '<div id="wpsvctable">';
    $output .= '<div id="wpsvcviews" style="text-align: ' . esc_attr($views_alignment) . '; color: ' . esc_attr($views_color) . ';">' . esc_html($views_text_today) . ' : ' . esc_html($daily_count) . '</div>';
    $output .= '<div id="wpsvcviews" style="text-align: ' . esc_attr($views_alignment) . '; color: ' . esc_attr($views_color) . ';">' . esc_html($views_text_month) . ' : ' . esc_html($monthly_count) . '</div>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}
add_shortcode('trds_custom_visitor_count', 'custom_visitor_count_shortcode');

// Hook to count daily and monthly visits
add_action('init', 'custom_visitor_count_daily');
add_action('init', 'custom_visitor_count_monthly');

// Include backend configuration file
require_once plugin_dir_path(__FILE__) . 'trds-visitor-counter-settings.php';
