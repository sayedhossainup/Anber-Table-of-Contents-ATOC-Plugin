<?php

/* Table of Content */

// First, keep the TOC generation function as you wrote it.
function generate_table_of_contents($content) {
    if (is_single()) {
        $toc_title = get_option('atoc_tabile_title');      
        preg_match_all('/<h([1-6])[^>]*>(.*?)<\/h\1>/', $content, $matches);
        if ($matches && isset($matches[0]) && count($matches[0]) > 1) {
            $toc = '<div class="toc_wrapper accordion"><div class="tab"><input type="checkbox" name="accordion-1" id="cb1" checked><label for="cb1" class="tab__label">' . $toc_title . '</label><ul class="tab__content">';
            foreach ($matches[2] as $index => $heading) {
                $id = sanitize_title($heading);
                $toc .= '<li><a class="d-flex gap-3 align-items-center" href="#' . $id . '">' . $heading . '</a></li>';
                $content = str_replace($matches[0][$index], '<h' . $matches[1][$index] . ' id="' . $id . '">' . $heading . '</h' . $matches[1][$index] . '>', $content);
            }
            $toc .= '</ul></div></div>';
            // Store the table of contents in a global variable for use in the hook
            global $custom_table_of_contents;
            $custom_table_of_contents = $toc;
            return $content;
        }
    }
    return $content;
}

add_filter('the_content', 'generate_table_of_contents');



function insert_toc_before_heading($content) {
    if (is_singular() && in_the_loop() && is_main_query()) {
        global $custom_table_of_contents;
        $toc = $custom_table_of_contents; // Assume get_toc() generates the TOC HTML
        $content = preg_replace('/(<h[1-6].*?>)/i', $toc . '$1', $content, 1);
    }
    return $content;
}

function insert_toc_after_heading($content) {
    if (is_singular() && in_the_loop() && is_main_query()) {
        global $custom_table_of_contents;
        $toc = $custom_table_of_contents;
        $content = preg_replace('/(<h[1-6].*?>.*?<\/h[1-6]>)/i', '$1' . $toc, $content, 1);
    }
    return $content;
}

function insert_toc_after_paragraph($content) {
    if (is_singular() && in_the_loop() && is_main_query()) {
        global $custom_table_of_contents;
        $toc = $custom_table_of_contents;
        $paragraphs = explode('</p>', $content);
        $insert_after = 2; // Insert after the second paragraph
        if (count($paragraphs) > $insert_after) {
            $paragraphs[$insert_after] .= $toc;
        }
        $content = implode('</p>', $paragraphs);
    }
    return $content;
}

function insert_toc_top($content) {
    if (is_singular() && in_the_loop() && is_main_query()) {
        global $custom_table_of_contents;
        $toc = $custom_table_of_contents;
        $content = $toc . $content;
    }
    return $content;
}

function insert_toc_bottom($content) {
    if (is_singular() && in_the_loop() && is_main_query()) {
        global $custom_table_of_contents;
        $toc = $custom_table_of_contents;
        $content .= $toc;
    }
    return $content;
}

$placement = get_option('placementoftabl_multiselect');
if (is_array($placement)) {
    foreach ($placement as $position) {
        switch ($position) {
            case "before_heading":
                add_filter('the_content', 'insert_toc_before_heading', 20);
                break;
            case "after_heading":
                add_filter('the_content', 'insert_toc_after_heading', 20);
                break;
            case "after_paragraph":
                add_filter('the_content', 'insert_toc_after_paragraph', 20);
                break;
            case "top":
                add_filter('the_content', 'insert_toc_top', 20);
                break;
            case "bottm":
                add_filter('the_content', 'insert_toc_bottom', 20);
                break;
            default:
                add_filter('the_content', 'insert_toc_after_heading', 20);
        }
    }
} else {
    // Handle case where it's a single value instead of array
    switch ($placement) {
        // Same switch cases as above
    }
}


//add_filter('the_content', 'insert_toc_bottom', 20);
//add_filter('the_content', 'insert_toc_after_title', 20);
// Generate TOC when processing the content
add_filter('the_content', 'generate_table_of_contents', 10);

add_filter('the_content', 'generate_table_of_contents');


//shortcode
function atoc_shortcode() {
    // Retrieve the table of contents stored in the global variable
    global $custom_table_of_contents;

    // Return the table of contents
    return $custom_table_of_contents;
}

add_shortcode('atoc', 'atoc_shortcode');
