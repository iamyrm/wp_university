<?php
// loading css and scripts
function load_scripts()
{
    wp_enqueue_style('main_css', get_stylesheet_uri());

    wp_enqueue_style('site_css', get_theme_file_uri('/assets/build/style-index.css'));

    wp_enqueue_style('site_extra_css', get_theme_file_uri('/assets/build/index.css'));

    wp_enqueue_style('font_awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

    wp_enqueue_style('google_fonts', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');

    wp_enqueue_script('main_js', get_theme_file_uri('/assets/build/index.js'), array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'load_scripts');

function university_features()
{
    // Adding The dynamic title to each of the pages 
    add_theme_support('title-tag');

    // Refistering the Menus 
    // register_nav_menu('headerMenuLocation','Header Menu');
    // register_nav_menu('footerMenuLocation1','Footer Menu 1');
    // register_nav_menu('footerMenuLocation2','Footer Menu 2');
}
add_action('after_setup_theme', 'university_features');

function university_adjust_query($query)
{
    if (!is_admin() && is_post_type_archive() && $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            'key' => 'event_date',
            'compare' => '>=',
            'value' => $today,
            'type' => 'numeric'
        ));
    }
}
add_action('pre_get_posts', 'university_adjust_query');
