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

function anber_dynamic_styles() {
    $background_color = get_option('table_background_color', '#ddd');
    $padding_top = get_option('table_padding_top_value', '10') . get_option('table_padding_top_unit', 'px');
    $padding_right = get_option('table_padding_right_value', '10') . get_option('table_padding_right_unit', 'px');
    $padding_bottom = get_option('table_padding_bottom_value', '10') . get_option('table_padding_bottom_unit', 'px');
    $padding_left = get_option('table_padding_left_value', '10') . get_option('table_padding_left_unit', 'px');
    $padding = $padding_top . ' ' . $padding_right . ' ' . $padding_bottom . ' ' . $padding_left;

    $border_radius_top = get_option('table_border_radius_top_value', '10') . get_option('table_border_radius_top_unit', 'px');
    $border_radius_right = get_option('table_border_radius_right_value', '10') . get_option('table_border_radius_right_unit', 'px');
    $border_radius_bottom = get_option('table_border_radius_bottom_value', '10') . get_option('table_border_radius_bottom_unit', 'px');
    $border_radius_left = get_option('table_border_radius_left_value', '10') . get_option('table_border_radius_left_unit', 'px');
    $border_radius = $border_radius_top . ' ' . $border_radius_right . ' ' . $border_radius_bottom . ' ' . $border_radius_left;

    $title_color = get_option('toc_title_color', '#000');
    $font_size_value = get_option('toc_font_size_value', '16');
    $font_size_unit = get_option('toc_font_size_unit', 'px');
    $toc_font_weight = get_option('toc_font_font_weight');
    $font_size = $font_size_value . $font_size_unit;

    $item_title_color = get_option('toc_item_color', '#000');
    $item_font_size_value = get_option('toc_item_font_size_value', '16');
    $item_font_size_unit = get_option('toc_item_font_size_unit', 'px');
    $item_font_size = $item_font_size_value . $item_font_size_unit;

    $ul_padding_top = get_option('toc_list_padding_top_value', '0') . get_option('toc_list_padding_unit', 'px');
    $ul_padding_right = get_option('toc_list_padding_right_value', '0') . get_option('toc_list_padding_unit', 'px');
    $ul_padding_bottom = get_option('toc_list_padding_bottom_value', '0') . get_option('toc_list_padding_unit', 'px');
    $ul_padding_left = get_option('toc_list_padding_left_value', '20') . get_option('toc_list_padding_unit', 'px');
    $ul_padding = $ul_padding_top . ' ' . $ul_padding_right . ' ' . $ul_padding_bottom . ' ' . $ul_padding_left;

    $li_pad_top_value = get_option('list_item_padding_top_value', '10') . get_option('list_item_padding_unit_value', 'px');
    $li_pad_right_value = get_option('list_item_padding_right_value', '10') . get_option('list_item_padding_unit_value', 'px');
    $li_pad_bottom_value = get_option('list_item_padding_bottom_value', '10') . get_option('list_item_padding_unit_value', 'px');
    $li_pad_left_value = get_option('list_item_padding_left_value', '10') . get_option('list_item_padding_unit_value', 'px');

    $li_padding = $li_pad_top_value . ' ' . $li_pad_right_value . ' ' . $li_pad_bottom_value . ' ' . $li_pad_left_value;

    $lidevider = get_option('list_item_devider');
    $lidevider_style = get_option('list_item_devider_style');
    $lidevider_color = get_option('list_item_devider_color');

    if ($lidevider === '1') {
        echo '<style>
         ul.tab__content li { border-bottom: 1px ' . esc_attr($lidevider_style) . ' ' . esc_attr($lidevider_color) . ';}        
        </style>';
    }
    $tbsitcky = get_option('table_sticky');
    $tabil_position = get_option('table_sticky_position');
    if ($tbsitcky === '1') {
        echo '<style>
         .toc_wrapper { position: sticky; top: ' . esc_attr($tabil_position) . 'px;}        
        </style>';
    }
    $list_icon_url = get_option('toc_list_icon_setting_field', '');
    $icon_gap = get_option('toc_list_icon_gap', '10');
    $icon_gap_unit = get_option('toc_list_icon_gap_unit', 'px');
    if (!empty($list_icon_url)) {
        echo '<style>
         ul.tab__content li {list-style: none !important;}
         ul.tab__content li::before{
            content:""; display: inline-block;
            height:' . esc_attr($item_font_size) . ';
            width: ' . esc_attr($item_font_size) . ';
            background-size: contain;
            background-image: url("' . $list_icon_url . '");
            margin-right:' . $icon_gap . $icon_gap_unit . ' ;
        }
        </style>';
    }

    echo '<style>
        .accordion {
            background: ' . esc_attr($background_color) . ';
            padding: ' . esc_attr($padding) . ';
            border-radius: ' . esc_attr($border_radius) . ';
        }
        .tab__label, .tab__close {
            color: ' . esc_attr($title_color) . ';
            font-size: ' . esc_attr($font_size) . ';
            font-weight:' . esc_attr($toc_font_weight) . ';                
        }
        ul.tab__content li{
        color: ' . esc_attr($title_color) . ';
             padding: ' . esc_attr($li_padding) . ';
            }
        ul.tab__content li a{
        color: ' . esc_attr($item_title_color) . ';
            font-size: ' . esc_attr($item_font_size) . ';
           
                
        }
       ul.tab__content{padding:' . esc_attr($ul_padding) . ';}
           
    </style>';
}

add_action('wp_head', 'anber_dynamic_styles');

