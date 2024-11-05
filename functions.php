<?php

// Page Banner 
function pageBanner($args = NULL)
{
    if (!$args['title']) {
        $args['title'] = get_the_title();
    }

    if (!$args['subtitle']) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }

    if (!$args['photo']) {
        if (get_field('page_banner_background_image') and !is_archive() and !is_home()) {
            $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }
?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title">
                <?php echo $args['title']; ?>
            </h1>
            <div class="page-banner__intro">
                <p>
                    <?php echo $args['subtitle']; ?>
                </p>
            </div>
        </div>
    </div>
<?php
}

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
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortraite', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);

    // Refistering the Menus 
    // register_nav_menu('headerMenuLocation','Header Menu');
    // register_nav_menu('footerMenuLocation1','Footer Menu 1');
    // register_nav_menu('footerMenuLocation2','Footer Menu 2');
}
add_action('after_setup_theme', 'university_features');

function university_adjust_query($query)
{
    if (!is_admin() && is_post_type_archive('program') && is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', '-1');
    }

    if (!is_admin() && is_post_type_archive('event') && $query->is_main_query()) {
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
