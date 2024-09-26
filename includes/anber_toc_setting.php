<?php
/**
 *
 * @link              https://github.com/frahim
 * @since             1.0.0
 * @package           Anber_table_of_contents

 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Add the top level menu page.
 */
function ato_options_page() {
    add_menu_page(
            'Anber Table of Contents',
            'ATOC Options',
            'manage_options',
            'atoc',
            'atoc_options_page_html'
    );
}

/**
 * Register our atoc_options_page to the admin_menu action hook.
 */
add_action('admin_menu', 'ato_options_page');

/**
 * Top level menu callback function
 */
function atoc_options_page_html() {
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    // add error/update messages
    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if (isset($_GET['settings-updated'])) {
        // add settings saved message with the class of "updated"
        add_settings_error('atoc_messages', 'atoc_message', __('Settings Saved', 'atoc'), 'updated');
    }

    // show error/update messages
    settings_errors('atoc_messages');
    ?>

    <section id="wrapper">
        <h2 class="pagetitle mb-30"><?php echo esc_html(get_admin_page_title()); ?></h2>
        <!-- Tab links -->
        <div class="tabs">
            <button class="tablinks active" data-country="general-settings"><p data-title="General">General</p></button>
            <button class="tablinks" data-country="style-tab"><p data-title="Style">Style</p></button>      
            <button class="tablinks" data-country="shortcode-tab"><p data-title="Shortcode">Shortcode</p></button>   
        </div>

        <!-- Tab content -->
        <div class="wrapper_tabcontent">
            <div id="general-settings" class="tabcontent active">
                <form method="post" action="options.php">
                    <?php
                    settings_fields('atoc');
                    do_settings_sections('atoc');
                    submit_button('Save Settings');
                    ?>
                </form>
            </div>

            <div id="style-tab" class="tabcontent">
                <form method="post" action="options.php">
                    <?php
                    settings_fields('atoc_style');
                    do_settings_sections('atoc_style');
                    submit_button('Save Settings');
                    ?>
                </form>
            </div>

            <div id="shortcode-tab" class="tabcontent">
                <form method="post" action="">
                    <?php
                    settings_fields('atoc_shortcode');
                    do_settings_sections('atoc_shortcode');
                    //submit_button('Save Settings');
                    ?>
                </form>
            </div>
        </div>
    </section>


    <?php
}

/**
 * custom option and settings
 */
function atoc_settings_init() {
    // General Tab
    register_setting('atoc', 'atoc_tabile_title');
    // Register the multiselect setting as an array
    register_setting('atoc', 'placementoftabl_multiselect', array(
        'type' => 'array', // Store multiple selections as an array
        'sanitize_callback' => 'sanitize_multiselect_input',
        'default' => array(),
    ));

    // Style Tab
    register_setting('atoc_style', 'table_background_color');
    register_setting('atoc_style', 'table_width_valu');
    register_setting('atoc_style', 'table_width_unit');

    // Register padding values
    register_setting('atoc_style', 'table_padding_top_value');
    register_setting('atoc_style', 'table_padding_right_value');
    register_setting('atoc_style', 'table_padding_bottom_value');
    register_setting('atoc_style', 'table_padding_left_value');

    // Register padding units
    register_setting('atoc_style', 'table_padding_unit');

    // Register border_radius values
    register_setting('atoc_style', 'table_border_radius_top_value');
    register_setting('atoc_style', 'table_border_radius_right_value');
    register_setting('atoc_style', 'table_border_radius_bottom_value');
    register_setting('atoc_style', 'table_border_radius_left_value');
    register_setting('atoc_style', 'table_border_radius_unit');

    register_setting('atoc_style', 'toc_title_color');
    register_setting('atoc_style', 'toc_font_size_value');
    register_setting('atoc_style', 'toc_font_size_unit');
    register_setting('atoc_style', 'toc_font_font_weight');
    register_setting('atoc_style', 'table_sticky');
    register_setting('atoc_style', 'table_sticky_position');

    register_setting('atoc_style', 'toc_item_color');
    register_setting('atoc_style', 'toc_item_font_size_value');
    register_setting('atoc_style', 'toc_item_font_size_unit');
    register_setting('atoc_style', 'toc_list_icon_setting_field');
    register_setting('atoc_style', 'toc_list_icon_gap');
    register_setting('atoc_style', 'toc_list_icon_gap_unit');
    // Register padding values
    register_setting('atoc_style', 'toc_list_padding_top_value');
    register_setting('atoc_style', 'toc_list_padding_right_value');
    register_setting('atoc_style', 'toc_list_padding_bottom_value');
    register_setting('atoc_style', 'toc_list_padding_left_value');
    register_setting('atoc_style', 'toc_list_padding_unit');

    // Register Item padding
    register_setting('atoc_style', 'list_item_padding_top_value');
    register_setting('atoc_style', 'list_item_padding_right_value');
    register_setting('atoc_style', 'list_item_padding_bottom_value');
    register_setting('atoc_style', 'list_item_padding_left_value');
    register_setting('atoc_style', 'list_item_padding_unit_value');
    register_setting('atoc_style', 'list_item_padding_unit_value');

    register_setting('atoc_style', 'list_item_devider');
    register_setting('atoc_style', 'list_item_devider_style');
    register_setting('atoc_style', 'list_item_devider_color');

    // Shortcode Tab
    register_setting('atoc_shortcode', 'atoc_shortcode');

    // Register a new section in the "atoc" page.
    add_settings_section(
            'atoc_section_developers',
            __('Anber Table of Contents', 'atoc'), 'atoc_section_developers_callback',
            'atoc'
    );
    add_settings_section(
            'atoc_section_style',
            __('Anber Table of Contents Style', 'atoc'), 'atoc_section_style_callback',
            'atoc_style'
    );
    add_settings_section(
            'atoc_section_shortcode',
            __('Anber Table of Contents Shortcode', 'atoc'), 'atoc_section_shortcode_callback',
            'atoc_shortcode'
    );

    // Register a new field in the "General TAb" section, inside the "atoc" page.
    add_settings_field(
            'atoc_tabile_title',
            'Title of the Table',
            'atoc_tabile_title_callback',
            'atoc',
            'atoc_section_developers'
    );

    // Register a new field for multiselect in the "General Tab" section.
    add_settings_field(
            'placementoftabl_multiselect',
            'Placement of Table (Multiselect)',
            'placementoftabl_multiselect_callback',
            'atoc',
            'atoc_section_developers'
    );

    // Register a new field in the "Style Tab" section, inside the "atoc" page.

    add_settings_field(
            'table_width',
            'Table Width',
            'table_width_setting_callback',
            'atoc_style',
            'atoc_section_style'
    );
    add_settings_field(
            'table_padding',
            'Table Padding Settings',
            'table_padding_setting_callback',
            'atoc_style',
            'atoc_section_style'
    );
    add_settings_field(
            'table_border_radius',
            'Table border radius Settings',
            'table_border_radius_callback',
            'atoc_style',
            'atoc_section_style'
    );
    add_settings_field(
            'table_background_color',
            'Table Background Color',
            'table_background_color_setting_callback',
            'atoc_style',
            'atoc_section_style'
    );
    add_settings_field(
            'toc_font_size',
            'Table header Font Size',
            'toc_font_size_setting_callback',
            'atoc_style',
            'atoc_section_style'
    );
    add_settings_field(
            'toc_title_color',
            'Table header Color',
            'toc_title_color_setting_callback',
            'atoc_style',
            'atoc_section_style'
    );
    add_settings_field(
            'table_sticky',
            'Make Table Sticky',
            'table_sticky_callback',
            'atoc_style',
            'atoc_section_style'
    );
    add_settings_field(
            'toc_list_paddingunit',
            'UL/List Wrapper Padding',
            'toc_list_padding_callback',
            'atoc_style',
            'atoc_section_style'
    );
    add_settings_field(
            'toc_item_font_size',
            'List Item Font Size',
            'toc_item_font_size_callback',
            'atoc_style',
            'atoc_section_style'
    );
    add_settings_field(
            'toc_item_color',
            'List Item Color',
            'toc_item_color_callback',
            'atoc_style',
            'atoc_section_style'
    );
    add_settings_field(
            'toc_list_icon_setting_field',
            'Upload List Style Icon',
            'toc_list_icon_select_render',
            'atoc_style',
            'atoc_section_style'
    );
    add_settings_field(
            'toc_list_icon_gap_setting',
            'List Icon Gap',
            'toc_list_icon_gap_setting_render',
            'atoc_style',
            'atoc_section_style'
    );
    add_settings_field(
            'toc_list_item_padding',
            'List Item padding',
            'toc_list_item_padding_render',
            'atoc_style',
            'atoc_section_style'
    );
    add_settings_field(
            'toc_list_devider_sec',
            'List Item Devider',
            'toc_list_devider_sec_render',
            'atoc_style',
            'atoc_section_style'
    );
    add_settings_field(
            'list_item_devider_color',
            'List Item Devider Color',
            'list_item_devider_color_render',
            'atoc_style',
            'atoc_section_style'
    );
}

/**
 * Register our atoc_settings_init to the admin_init action hook.
 */
add_action('admin_init', 'atoc_settings_init');

function atoc_section_style_callback($args) {
    ?>
    <p id="<?php echo esc_attr($args['id']); ?>"><?php esc_html_e('', 'atoc'); ?></p>
    <?php
}

function atoc_section_developers_callback($args) {
    ?>
    <p id="<?php echo esc_attr($args['id']); ?>"><?php esc_html_e('', 'atoc'); ?></p>
    <?php
}

function atoc_section_shortcode_callback($args) {
    ?>
    <p id="<?php echo esc_attr($args['id']); ?>"><?php esc_html_e('[atoc]', 'atoc'); ?> <br/>Past this shortcode where to display the table of contents.</p>
    <?php
}

/**
 *
 * @param array $args
 */
function atoc_tabile_title_callback() {
    $toc_title = get_option('atoc_tabile_title');
    //echo '<input type="text" id="atoc_tabile_title" name="atoc_tabile_title"' . esc_html_e($toc_title) . ' />';
    echo '<input id="atoc_tabile_title" name="atoc_tabile_title" value="' . esc_html($toc_title) . '" ></input>';
}

// Callback to render the checkboxes
function placementoftabl_multiselect_callback() {
    // Retrieve the stored values (as an array)
    $selected_values = get_option('placementoftabl_multiselect', array());

    // Define the options for the checkboxes
    $options = array(
        'before_heading' => 'Before first heading',
        'after_heading' => 'After first heading',
        'after_paragraph' => 'After first paragraph',
        'top' => 'Top',
        'bottm' => 'Bottom',
    );
    echo '<p class="description">Select where to display the table of contents.</p>';
    // Display the checkboxes
    foreach ($options as $value => $label) {

        $checked = in_array($value, (array) $selected_values) ? 'checked="checked"' : '';
        echo '<label><input type="checkbox" name="placementoftabl_multiselect[]" value="' . esc_attr($value) . '" ' . $checked . '>' . esc_html($label) . '</label><br>';
    }

    // Add a description for the checkboxes

    echo '<p>You can display the table of contents in multiple positions simultaneously, such as at the beginning of the document, following the title page, within the header or footer for easy access, and at the start of each major section, ensuring comprehensive navigation throughout the entire document.</p>';
}

// Sanitize the checkbox input to ensure it's saved properly as an array
function sanitize_multiselect_input($input) {
    // Ensure the input is an array and sanitize each value
    if (is_array($input)) {
        return array_map('sanitize_text_field', $input);
    }
    return array();
}

function atoc_field_pill_cb($args) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option('atoc_options');
    ?>
    <select
        id="<?php echo esc_attr($args['label_for']); ?>"
        data-custom="<?php echo esc_attr($args['atoc_custom_data']); ?>"
        name="atoc_options[<?php echo esc_attr($args['label_for']); ?>]">
        <option value="red" <?php echo isset($options[$args['label_for']]) ? ( selected($options[$args['label_for']], 'red', false) ) : ( '' ); ?>>
            <?php esc_html_e('red pill', 'atoc'); ?>
        </option>
        <option value="blue" <?php echo isset($options[$args['label_for']]) ? ( selected($options[$args['label_for']], 'blue', false) ) : ( '' ); ?>>
            <?php esc_html_e('blue pill', 'atoc'); ?>
        </option>
    </select>

    <?php
}

function toc_list_icon_select_render() {

    // Get the saved icon URL from the database
    $icon_url = get_option('toc_list_icon_setting_field', '');

    // Render the input field with the URL and the "Upload" button
    echo '<input type="text" id="toc_list_icon_setting_field" name="toc_list_icon_setting_field" value="' . esc_url($icon_url) . '" style="width: 300px;" />';
    echo '<input type="button" class="button" value="Upload Icon" id="upload_icon_button" />';

    // If an icon is already uploaded, display a preview
    if ($icon_url) {
        echo '<div><img src="' . esc_url($icon_url) . '" alt="Icon Preview" style="max-width: 100px; margin-top: 10px;"></div>';
    }

    // Include JavaScript for the media uploader
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('#upload_icon_button').click(function (e) {
                e.preventDefault();
                var image = wp.media({
                    title: 'Upload Icon',
                    // Enable image selection (you can specify types like images only)
                    multiple: false
                }).open()
                        .on('select', function () {
                            // Get the selected image URL
                            var uploaded_image = image.state().get('selection').first().toJSON();
                            $('#toc_list_icon_setting_field').val(uploaded_image.url); // Set the URL in the input field
                        });
            });
        });
    </script>
    <?php
}

function table_sticky_callback() {
    $option = get_option('table_sticky');
    $checked = isset($option) && $option === '1' ? 'checked' : '';
    $tabil_position = get_option('table_sticky_position');

    echo '<div class="dflex_item">';
    echo '<label class="switch" for="table_sticky">Active</label><input type="checkbox" id="table_sticky" name="table_sticky" value="1" ' . esc_attr($checked) . ' /><div class="slider round"></div>';
    echo '<label class="switch" for="table_sticky_position">Top</label><input type="number" id="table_sticky_position" name="table_sticky_position" value="' . esc_attr($tabil_position) . '" style="width: 100px;" /><label class="switch" for="list_item_devider">px</label>';
   
}

function toc_list_icon_gap_setting_render() {
    $list_icon_gap = get_option('toc_list_icon_gap', '10');
    $list_icon_gap_unit = get_option('toc_list_icon_gap_unit', 'px');
    $units = ['px', '%', 'em', 'rem'];

    echo '<div>';
    echo '<input type="number" id="toc_list_icon_gap" name="toc_list_icon_gap" value="' . esc_attr($list_icon_gap) . '" style="width: 100px;" />';
    echo '<select id="toc_list_icon_gap_unit" name="toc_list_icon_gap_unit">';
    foreach ($units as $unit) {
        $selected = ($unit === $list_icon_gap_unit) ? 'selected' : '';
        echo '<option value="' . esc_attr($unit) . '" ' . $selected . '>' . esc_html($unit) . '</option>';
    }
    echo '</select></div>';
}

function toc_list_item_padding_render() {
    // Get the saved values for padding
    $list_item_pad_top_value = get_option('list_item_padding_top_value', '10');
    $list_item_pad_right_value = get_option('list_item_padding_right_value', '10');
    $list_item_pad_bottom_value = get_option('list_item_padding_bottom_value', '10');
    $list_item_pad_left_value = get_option('list_item_padding_left_value', '10');

    // Get the saved units for padding
    $list_item_pad_unit = get_option('list_item_padding_unit_value', 'px');

    // Define the units
    $units = ['px', '%', 'em', 'rem'];

    // Display padding top input
    echo '<div>';
    echo '<input type="number" id="list_item_padding_top_value" name="list_item_padding_top_value" value="' . esc_attr($list_item_pad_top_value) . '" style="width: 80px;" />';
    echo '<input type="number" id="list_item_padding_right_value" name="list_item_padding_right_value" value="' . esc_attr($list_item_pad_right_value) . '" style="width: 80px;" />';
    echo '<input type="number" id="list_item_padding_bottom_value" name="list_item_padding_bottom_value" value="' . esc_attr($list_item_pad_bottom_value) . '" style="width: 80px;" />';
    echo '<input type="number" id="list_item_padding_left_value" name="list_item_padding_left_value" value="' . esc_attr($list_item_pad_left_value) . '" style="width: 80px;" />';
    echo '<select id="list_item_padding_unit_value" name="list_item_padding_unit_value">';
    foreach ($units as $unit) {
        $selected = ($unit === $list_item_pad_unit) ? 'selected' : '';
        echo '<option value="' . esc_attr($unit) . '" ' . $selected . '>' . esc_html($unit) . '</option>';
    }
    echo '</select></div>';
}

function list_item_devider_color_render() {
    $color = get_option('list_item_devider_color', '#000'); // Default color
    echo '<input type="text" id="list_item_devider_color" name="list_item_devider_color" value="' . esc_attr($color) . '" class="table_color" />';
}

function toc_list_padding_callback() {
    // Get the saved values for padding
    $item_pad_top_value = get_option('toc_list_padding_top_value', '10');
    $item_pad_right_value = get_option('toc_list_padding_right_value', '10');
    $item_pad_bottom_value = get_option('toc_list_padding_bottom_value', '10');
    $item_pad_left_value = get_option('toc_list_padding_left_value', '10');

    // Get the saved units for padding
    $item_pad_unit = get_option('toc_list_padding_unit', 'px');

    // Define the units
    $units = ['px', '%', 'em', 'rem'];

    // Display padding top input
    echo '<div>';
    echo '<input type="number" id="toc_list_padding_top_value" name="toc_list_padding_top_value" value="' . esc_attr($item_pad_top_value) . '" style="width: 80px;" />';
    echo '<input type="number" id="toc_list_padding_right_value" name="toc_list_padding_right_value" value="' . esc_attr($item_pad_right_value) . '" style="width: 80px;" />';
    echo '<input type="number" id="toc_list_padding_bottom_value" name="toc_list_padding_bottom_value" value="' . esc_attr($item_pad_bottom_value) . '" style="width: 80px;" />';
    echo '<input type="number" id="toc_list_padding_left_value" name="toc_list_padding_left_value" value="' . esc_attr($item_pad_left_value) . '" style="width: 80px;" />';
    echo '<select id="toc_list_padding_unit" name="toc_list_padding_unit">';
    foreach ($units as $unit) {
        $selected = ($unit === $item_pad_unit) ? 'selected' : '';
        echo '<option value="' . esc_attr($unit) . '" ' . $selected . '>' . esc_html($unit) . '</option>';
    }
    echo '</select></div>';
}

function table_background_color_setting_callback() {
    $color = get_option('table_background_color', '#ddd'); // Default color
    echo '<input type="text" id="table_background_color" name="table_background_color" value="' . esc_attr($color) . '" class="table_color" />';
}

function toc_title_color_setting_callback() {
    $color = get_option('toc_title_color', '#000'); // Default color
    echo '<input type="text" id="toc_title_color" name="toc_title_color" value="' . esc_attr($color) . '" class="table_color" />';
}

function toc_list_devider_sec_render() {
    $option = get_option('list_item_devider');
    $checked = isset($option) && $option === '1' ? 'checked' : '';
    $ds_style = get_option('list_item_devider_style');

    $devider_styles = ['dashed', 'double', 'dotted', 'solid'];
    echo '<div class="dflex_item">';
    echo '<label class="switch" for="list_item_devider">Active</label><input type="checkbox" id="list_item_devider" name="list_item_devider" value="1" ' . esc_attr($checked) . ' /><div class="slider round"></div>';
    echo '<label class="switch" for="list_item_devider">Select Style</label><select id="list_item_devider_style" name="list_item_devider_style">';
    foreach ($devider_styles as $devider_style) {
        $selected = ($devider_style === $ds_style) ? 'selected' : '';
        echo '<option value="' . esc_attr($devider_style) . '" ' . $selected . '>' . esc_html($devider_style) . '</option>';
    }
    echo '</select></div>';
}

function toc_item_font_size_callback() {
    $font_size_value = get_option('toc_item_font_size_value', '16'); // Default value
    $font_size_unit = get_option('toc_item_font_size_unit', 'px'); // Default unit
    // Define the units
    $units = ['px', '%', 'em', 'rem'];

    // Display the input for font size
    echo '<input type="number" id="toc_item_font_size_value" name="toc_item_font_size_value" value="' . esc_attr(rtrim($font_size_value, 'px%emrem')) . '" style="width: 50px;" />';

    // Display the select for units
    echo '<select id="toc_item_font_size_unit" name="toc_item_font_size_unit">';
    foreach ($units as $unit) {
        $selected = ($unit === $font_size_unit) ? 'selected' : '';
        echo '<option value="' . esc_attr($unit) . '" ' . $selected . '>' . esc_html($unit) . '</option>';
    }
    echo '</select>';
}

function toc_item_color_callback() {
    $color = get_option('toc_item_color', '#000'); // Default color
    echo '<input type="text" id="toc_item_color" name="toc_item_color" value="' . esc_attr($color) . '" class="table_color" />';
}

function toc_font_size_setting_callback() {
    $font_size_value = get_option('toc_font_size_value', '16'); // Default value
    $font_size_unit = get_option('toc_font_size_unit', 'px'); // Default unit
    $toc_font_width = get_option('toc_font_font_weight', 'px');
    //
    // Define the units
    $units = ['px', '%', 'em', 'rem'];

    // Display the input for font size
    echo '<input type="number" id="toc_font_size_value" name="toc_font_size_value" value="' . esc_attr(rtrim($font_size_value, 'px%emrem')) . '" style="width: 80px;" />';

    // Display the select for units
    echo '<select id="toc_font_size_unit" name="toc_font_size_unit">';
    foreach ($units as $unit) {
        $selected = ($unit === $font_size_unit) ? 'selected' : '';
        echo '<option value="' . esc_attr($unit) . '" ' . $selected . '>' . esc_html($unit) . '</option>';
    }
    echo '</select>';
    echo '<label style="margin-left: 20px;">Font Weight:</label> <input type="number" id="toc_font_font_weight" name="toc_font_font_weight" value="' . esc_attr(rtrim($toc_font_width, '')) . '" style="width: 80px;" />';
}

function table_width_setting_callback() {
    $table_width_value = get_option('table_width_valu', 'auto'); // Default value
    $table_width_unit = get_option('table_width_unit', 'px'); // Default unit
    // Define the units
    $units = ['px', '%'];

    // Display the input for font size
    echo '<input type="text" id="table_width_valu" name="table_width_valu" value="' . esc_attr(rtrim($table_width_value, 'px%')) . '" style="width: 150px;" />';

    // Display the select for units
    echo '<select id="table_width_unit" name="table_width_unit">';
    foreach ($units as $unit) {
        $selected = ($unit === $table_width_unit) ? 'selected' : '';
        echo '<option value="' . esc_attr($unit) . '" ' . $selected . '>' . esc_html($unit) . '</option>';
    }
    echo '</select>';
}

function table_padding_setting_callback() {
    // Get the saved values for padding
    $padding_top_value = get_option('table_padding_top_value', '10');
    $padding_right_value = get_option('table_padding_right_value', '10');
    $padding_bottom_value = get_option('table_padding_bottom_value', '10');
    $padding_left_value = get_option('table_padding_left_value', '10');
    // Get the saved units for padding
    $padding_unit = get_option('table_padding_unit', 'px');
    // Define the units
    $units = ['px', '%', 'em', 'rem'];
    // Display padding top input
    echo '<div>';
    echo '<input type="number" id="table_padding_top_value" name="table_padding_top_value" value="' . esc_attr($padding_top_value) . '" style="width: 80px;" />';
    echo '<input type="number" id="table_padding_right_value" name="table_padding_right_value" value="' . esc_attr($padding_right_value) . '" style="width: 80px;" />';
    echo '<input type="number" id="table_padding_bottom_value" name="table_padding_bottom_value" value="' . esc_attr($padding_bottom_value) . '" style="width: 80px;" />';
    echo '<input type="number" id="table_padding_left_value" name="table_padding_left_value" value="' . esc_attr($padding_left_value) . '" style="width: 80px;" />';
    echo '<select id="table_padding_unit" name="table_padding_unit">';
    foreach ($units as $unit) {
        $selected = ($unit === $padding_unit) ? 'selected' : '';
        echo '<option value="' . esc_attr($unit) . '" ' . $selected . '>' . esc_html($unit) . '</option>';
    }
    echo '</select></div>';
}

function table_border_radius_callback() {
    // Get the saved values for padding
    $br_top_value = get_option('table_border_radius_top_value', '10');
    $br_right_value = get_option('table_border_radius_right_value', '10');
    $br_bottom_value = get_option('table_border_radius_bottom_value', '10');
    $br_left_value = get_option('table_border_radius_left_value', '10');

    // Get the saved units for padding
    $br_top_unit = get_option('table_border_radius_unit', 'px');

    // Define the units
    $units = ['px', '%', 'em', 'rem'];

    // Display padding top input
    echo '<div>';
    echo '<input type="number" id="table_border_radius_top_value" name="table_border_radius_top_value" value="' . esc_attr($br_top_value) . '" style="width: 50px;" />';
    echo '<input type="number" id="table_border_radius_right_value" name="table_border_radius_right_value" value="' . esc_attr($br_right_value) . '" style="width: 50px;" />';
    echo '<input type="number" id="table_border_radius_bottom_value" name="table_border_radius_bottom_value" value="' . esc_attr($br_bottom_value) . '" style="width: 50px;" />';
    echo '<input type="number" id="table_border_radius_left_value" name="table_border_radius_left_value" value="' . esc_attr($br_left_value) . '" style="width: 50px;" />';
    echo '<select id="table_border_radius_unit" name="table_border_radius_unit">';
    foreach ($units as $unit) {
        $selected = ($unit === $br_top_unit) ? 'selected' : '';
        echo '<option value="' . esc_attr($unit) . '" ' . $selected . '>' . esc_html($unit) . '</option>';
    }
    echo '</select></div>';
}
