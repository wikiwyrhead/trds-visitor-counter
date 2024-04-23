<?php
/*
Plugin Name: TRDS Website Visitor Counter
Description: This plugin counts daily and monthly visits and provides a shortcode to display the counts on any part of the site. It also allows customization of the visitor count display options.
Version: 1.2
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

// Function to display total post count for a specific post type using shortcode
function custom_post_count_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'post_type' => 'post',
    ), $atts);

    $post_count = wp_count_posts($atts['post_type'])->publish;

    $text = get_option('custom_post_count_text', 'Total Posts:');
    $color = get_option('custom_post_count_color', '#000000');

    $output = '<div class="elementor-shortcode">';
    $output .= '<div id="post-count-widget">';
    $output .= '<h3 style="color: ' . esc_attr($color) . ';">' . esc_html($text) . ' ' . $post_count . '</h3>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}
add_shortcode('trds_post_count', 'custom_post_count_shortcode');

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
    register_setting('custom_visitor_settings_group', 'custom_post_count_text');
    register_setting('custom_visitor_settings_group', 'custom_post_count_color');
    register_setting('custom_visitor_settings_group', 'custom_post_type');

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

    add_settings_section(
        'custom_post_settings_section',
        'Post Count Display Options',
        'custom_post_settings_section_callback',
        'custom-visitor-settings'
    );

    add_settings_field(
        'custom_post_count_text',
        'Post Count Text',
        'custom_post_count_text_callback',
        'custom-visitor-settings',
        'custom_post_settings_section'
    );

    add_settings_field(
        'custom_post_count_color',
        'Post Count Text Color',
        'custom_post_count_color_callback',
        'custom-visitor-settings',
        'custom_post_settings_section'
    );

    add_settings_field(
        'custom_post_type',
        'Post Type',
        'custom_post_type_callback',
        'custom-visitor-settings',
        'custom_post_settings_section'
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

// Section callback function for post settings
function custom_post_settings_section_callback()
{
    echo '<p>To display the total number of posts under a specific post type, use the following shortcode format: <code>[trds_post_count post_type="your_post_type"]</code>. Save the changes and preview the page to see the post count.</p>';
}

// Post count text callback function
function custom_post_count_text_callback()
{
    $text = get_option('custom_post_count_text', 'Total Posts:');
    echo "<input type='text' name='custom_post_count_text' value='" . esc_attr($text) . "' />";
}

// Post count text color callback function
function custom_post_count_color_callback()
{
    $color = get_option('custom_post_count_color', '#000000');
    echo "<input type='color' name='custom_post_count_color' value='" . esc_attr($color) . "' />";
}

// Post type callback function
function custom_post_type_callback()
{
    $selected_post_type = get_option('custom_post_type', 'post');
    $post_types = get_post_types(array('public' => true), 'names');
    echo '<select name="custom_post_type">';
    foreach ($post_types as $post_type) {
        $selected = ($selected_post_type == $post_type) ? 'selected' : '';
        echo '<option value="' . esc_attr($post_type) . '" ' . esc_attr($selected) . '>' . esc_html($post_type) . '</option>';
    }
    echo '</select>';
}
