<?php
/*
Settings file for Combined Counter Plugin
*/

// Register and define settings
function combined_counter_plugin_register_settings()
{
    register_setting('combined_counter_plugin_settings_group', 'custom_visitor_input');
    register_setting('combined_counter_plugin_settings_group', 'custom_visitor_input_color');
    register_setting('combined_counter_plugin_settings_group', 'custom_visitor_input_alignment');
    register_setting('combined_counter_plugin_settings_group', 'custom_visitor_views_text_today');
    register_setting('combined_counter_plugin_settings_group', 'custom_visitor_views_text_month');
    register_setting('combined_counter_plugin_settings_group', 'custom_visitor_views_color');
    register_setting('combined_counter_plugin_settings_group', 'custom_visitor_views_alignment');
    register_setting('combined_counter_plugin_settings_group', 'custom_post_counter_title');
    register_setting('combined_counter_plugin_settings_group', 'custom_post_counter_color');
    register_setting('combined_counter_plugin_settings_group', 'custom_post_counter_alignment');

    // Website Visitor Counter settings section
    add_settings_section(
        'custom_visitor_settings_section',
        'Website Visitor Counter Display Options',
        'custom_visitor_settings_section_callback',
        'combined-counter-plugin-settings'
    );

    add_settings_field(
        'custom_visitor_input',
        'Web Counter Title',
        'custom_visitor_input_callback',
        'combined-counter-plugin-settings',
        'custom_visitor_settings_section'
    );

    add_settings_field(
        'custom_visitor_input_color',
        'Web Counter Title Color',
        'custom_visitor_input_color_callback',
        'combined-counter-plugin-settings',
        'custom_visitor_settings_section'
    );

    add_settings_field(
        'custom_visitor_input_alignment',
        'Web Counter Title Alignment',
        'custom_visitor_input_alignment_callback',
        'combined-counter-plugin-settings',
        'custom_visitor_settings_section'
    );

    add_settings_field(
        'custom_visitor_views_text_today',
        'Views Today (Label)',
        'custom_visitor_views_text_today_callback',
        'combined-counter-plugin-settings',
        'custom_visitor_settings_section'
    );

    add_settings_field(
        'custom_visitor_views_text_month',
        'Views this month (Label)',
        'custom_visitor_views_text_month_callback',
        'combined-counter-plugin-settings',
        'custom_visitor_settings_section'
    );

    add_settings_field(
        'custom_visitor_views_color',
        'Label Color',
        'custom_visitor_views_color_callback',
        'combined-counter-plugin-settings',
        'custom_visitor_settings_section'
    );

    add_settings_field(
        'custom_visitor_views_alignment',
        'Label Alignment',
        'custom_visitor_views_alignment_callback',
        'combined-counter-plugin-settings',
        'custom_visitor_settings_section'
    );

    // Total Post Counter settings section
    add_settings_section(
        'custom_post_counter_settings_section',
        'Post Counter Display Options',
        'custom_post_counter_settings_section_callback',
        'combined-counter-plugin-settings'
    );

    add_settings_field(
        'custom_post_counter_title',
        'Counter Title',
        'custom_post_counter_title_callback',
        'combined-counter-plugin-settings',
        'custom_post_counter_settings_section'
    );

    add_settings_field(
        'custom_post_counter_color',
        'Counter Color',
        'custom_post_counter_color_callback',
        'combined-counter-plugin-settings',
        'custom_post_counter_settings_section'
    );

    add_settings_field(
        'custom_post_counter_alignment',
        'Counter Alignment',
        'custom_post_counter_alignment_callback',
        'combined-counter-plugin-settings',
        'custom_post_counter_settings_section'
    );
}
add_action('admin_init', 'combined_counter_plugin_register_settings');

// Website Visitor Counter section callback function
function custom_visitor_settings_section_callback()
{
    echo '<p>To display visitor counts on any part of the site, Insert this shortcode : <code>[website_visitor_counter]</code> into any post, page, or widget content. Save the changes and preview the page to see the visitor counts.</p>';
}

// Website Visitor Counter settings callbacks...

// Web Counter Title callback function
function custom_visitor_input_callback()
{
    $input = get_option('custom_visitor_input');
    echo "<input type='text' name='custom_visitor_input' value='" . esc_attr($input) . "' />";
}

// Web Counter Title Color callback function
function custom_visitor_input_color_callback()
{
    $input_color = get_option('custom_visitor_input_color', '#000000');
    echo "<input type='color' name='custom_visitor_input_color' value='" . esc_attr($input_color) . "' />";
}

// Web Counter Title Alignment callback function
function custom_visitor_input_alignment_callback()
{
    $input_alignment = get_option('custom_visitor_input_alignment', 'left');
    $options = array('left', 'center', 'right');
    echo '<select name="custom_visitor_input_alignment">';
    foreach ($options as $option) {
        $selected = ($input_alignment == $option) ? 'selected' : '';
        echo '<option value="' . esc_attr($option) . '" ' . esc_attr($selected) . '>' . esc_html($option) . '</option>';
    }
    echo '</select>';
}

// Label for Views Today callback function
function custom_visitor_views_text_today_callback()
{
    $views_text_today = get_option('custom_visitor_views_text_today', 'Views Today');
    echo "<input type='text' name='custom_visitor_views_text_today' value='" . esc_attr($views_text_today) . "' />";
}

// Label for Views This Month callback function
function custom_visitor_views_text_month_callback()
{
    $views_text_month = get_option('custom_visitor_views_text_month', 'Views This Month');
    echo "<input type='text' name='custom_visitor_views_text_month' value='" . esc_attr($views_text_month) . "' />";
}

// Label Color callback function
function custom_visitor_views_color_callback()
{
    $views_color = get_option('custom_visitor_views_color', '#815b0a');
    echo "<input type='color' name='custom_visitor_views_color' value='" . esc_attr($views_color) . "' />";
}

// Label Alignment callback function
function custom_visitor_views_alignment_callback()
{
    $views_alignment = get_option('custom_visitor_views_alignment', 'left');
    $options = array('left', 'center', 'right');
    echo '<select name="custom_visitor_views_alignment">';
    foreach ($options as $option) {
        $selected = ($views_alignment == $option) ? 'selected' : '';
        echo '<option value="' . esc_attr($option) . '" ' . esc_attr($selected) . '>' . esc_html($option) . '</option>';
    }
    echo '</select>';
}

// Total Post Counter section callback function
function custom_post_counter_settings_section_callback()
{
    echo '<p>To display total post count on any part of the site, Insert this shortcode : <code>[total_post_counter]</code> into any post, page, or widget content. Save the changes and preview the page to see the post count.</p>';
}

// Total Post Counter settings callbacks...

// Counter Title callback function
function custom_post_counter_title_callback()
{
    $counter_title = get_option('custom_post_counter_title');
    echo "<input type='text' name='custom_post_counter_title' value='" . esc_attr($counter_title) . "' />";
}

// Counter Color callback function
function custom_post_counter_color_callback()
{
    $counter_color = get_option('custom_post_counter_color', '#000000');
    echo "<input type='color' name='custom_post_counter_color' value='" . esc_attr($counter_color) . "' />";
}

// Counter Alignment callback function
function custom_post_counter_alignment_callback()
{
    $counter_alignment = get_option('custom_post_counter_alignment', 'left');
    $options = array('left', 'center', 'right');
    echo '<select name="custom_post_counter_alignment">';
    foreach ($options as $option) {
        $selected = ($counter_alignment == $option) ? 'selected' : '';
        echo '<option value="' . esc_attr($option) . '" ' . esc_attr($selected) . '>' . esc_html($option) . '</option>';
    }
    echo '</select>';
}
