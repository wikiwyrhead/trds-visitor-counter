<?php

/**
 * TRDS Website Visitor Counter Settings Page
 *
 * This page allows users to customize the display options for the TRDS Website Visitor Counter plugin.
 * Users can configure settings such as title text, colors, alignment, and labels for visitor counts.
 */


// Add settings page
function custom_visitor_settings_page()
{
    add_options_page(
        'TRDS Website Counter',
        'TRDS Web Counter',
        'manage_options',
        'custom-visitor-settings',
        'custom_visitor_settings_callback'
    );
}
add_action('admin_menu', 'custom_visitor_settings_page');

// Settings page callback function
function custom_visitor_settings_callback()
{
?>
    <div class="wrap">
        <h2>TRDS Web Counter Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('custom_visitor_settings_group'); ?>
            <?php do_settings_sections('custom-visitor-settings'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

// Register and define settings
function custom_visitor_register_settings()
{
    register_setting('custom_visitor_settings_group', 'custom_visitor_input');
    register_setting('custom_visitor_settings_group', 'custom_visitor_input_color');
    register_setting('custom_visitor_settings_group', 'custom_visitor_input_alignment');
    register_setting('custom_visitor_settings_group', 'custom_visitor_views_text_today');
    register_setting('custom_visitor_settings_group', 'custom_visitor_views_text_month');
    register_setting('custom_visitor_settings_group', 'custom_visitor_views_color');
    register_setting('custom_visitor_settings_group', 'custom_visitor_views_alignment');

    add_settings_section(
        'custom_visitor_settings_section',
        'Visitor Count Display Options',
        'custom_visitor_settings_section_callback',
        'custom-visitor-settings'
    );

    add_settings_field(
        'custom_visitor_input',
        'Web Counter Title',
        'custom_visitor_input_callback',
        'custom-visitor-settings',
        'custom_visitor_settings_section'
    );

    add_settings_field(
        'custom_visitor_input_color',
        'Web Counter Title Color',
        'custom_visitor_input_color_callback',
        'custom-visitor-settings',
        'custom_visitor_settings_section'
    );

    add_settings_field(
        'custom_visitor_input_alignment',
        'Web Counter Title Alignment',
        'custom_visitor_input_alignment_callback',
        'custom-visitor-settings',
        'custom_visitor_settings_section'
    );

    add_settings_field(
        'custom_visitor_views_text_today',
        'Views Today (Label)',
        'custom_visitor_views_text_today_callback',
        'custom-visitor-settings',
        'custom_visitor_settings_section'
    );

    add_settings_field(
        'custom_visitor_views_text_month',
        'Views this month (Label)',
        'custom_visitor_views_text_month_callback',
        'custom-visitor-settings',
        'custom_visitor_settings_section'
    );

    add_settings_field(
        'custom_visitor_views_color',
        'Label Color',
        'custom_visitor_views_color_callback',
        'custom-visitor-settings',
        'custom_visitor_settings_section'
    );

    add_settings_field(
        'custom_visitor_views_alignment',
        'Label Alignment',
        'custom_visitor_views_alignment_callback',
        'custom-visitor-settings',
        'custom_visitor_settings_section'
    );
}
add_action('admin_init', 'custom_visitor_register_settings');

// Section callback function
function custom_visitor_settings_section_callback()
{
    echo '<p>To display visitor counts on any part of the site, Insert this shortcode : <code>[trds_custom_visitor_count]</code> into any post, page, or widget content. Save the changes and preview the page to see the visitor counts.</p>';
}

// Input callback function
function custom_visitor_input_callback()
{
    $input = get_option('custom_visitor_input');
    echo "<input type='text' name='custom_visitor_input' value='" . esc_attr($input) . "' />";
}

// Input color callback function
function custom_visitor_input_color_callback()
{
    $input_color = get_option('custom_visitor_input_color', '#000000');
    echo "<input type='color' name='custom_visitor_input_color' value='" . esc_attr($input_color) . "' />";
}

// Input alignment callback function
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

// Views text today callback function
function custom_visitor_views_text_today_callback()
{
    $views_text_today = get_option('custom_visitor_views_text_today', 'Views Today');
    echo "<input type='text' name='custom_visitor_views_text_today' value='" . esc_attr($views_text_today) . "' />";
}

// Views text month callback function
function custom_visitor_views_text_month_callback()
{
    $views_text_month = get_option('custom_visitor_views_text_month', 'Views This Month');
    echo "<input type='text' name='custom_visitor_views_text_month' value='" . esc_attr($views_text_month) . "' />";
}

// Views color callback function
function custom_visitor_views_color_callback()
{
    $views_color = get_option('custom_visitor_views_color', '#815b0a');
    echo "<input type='color' name='custom_visitor_views_color' value='" . esc_attr($views_color) . "' />";
}

// Views alignment callback function
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
?>