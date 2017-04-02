<?php
/**
 * home_21 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package home_21
 */

if (!function_exists('home_21_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function home_21_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on home_21, use a find and replace
         * to change 'home_21' to the name of your theme in all the template files.
         */
        load_theme_textdomain('home_21', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'menu-1' => esc_html__('Primary', 'home_21'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('home_21_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');
    }
endif;
add_action('after_setup_theme', 'home_21_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function home_21_content_width()
{
    $GLOBALS['content_width'] = apply_filters('home_21_content_width', 640);
}

add_action('after_setup_theme', 'home_21_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function home_21_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Sidebar', 'home_21'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Add widgets here.', 'home_21'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}

add_action('widgets_init', 'home_21_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function home_21_scripts()
{
    wp_enqueue_style('home_21-style', get_stylesheet_uri());

    wp_enqueue_style('home_21_custom-style', get_template_directory_uri() . '/css/main.css');

    wp_enqueue_script('home_21-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true);

    wp_enqueue_script('home_21-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'home_21_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

// My functions

add_action('customize_register', 'home_link_icon_customize');

// Add Header customization section
function home_link_icon_customize($wp_customize)
{
    $wp_customize->add_section('header_customization_section', array(
        'title' => 'Header customization',
    ));

    $wp_customize->add_setting('home_link_icon_setting');

    $wp_customize->add_setting('header_background_image_setting');

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'home_link_icon_control', array(
        'label' => 'Home link icon',
        'section' => 'header_customization_section',
        'settings' => 'home_link_icon_setting',
    )));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'header_background_image_control', array(
        'label' => 'Header background image',
        'section' => 'header_customization_section',
        'settings' => 'header_background_image_setting',
    )));
}

function home_link_icon_customize_css()
{
    ?>

    <style type="text/css">

        <?php if (get_theme_mod('home_link_icon_setting')): ?>

        .home-page-link a {
            background-image: url("<?php echo get_theme_mod('home_link_icon_setting'); ?>");
            background-position: center;
            background-repeat: no-repeat;
            color: transparent;
        }

        <?php endif; ?>

        <?php if (get_theme_mod('header_background_image_setting')): ?>

        .site-header {
            background: url("<?php echo get_theme_mod('header_background_image_setting'); ?>") center/cover no-repeat;
        }

        <?php endif; ?>

    </style>

    <?php
}

add_action('wp_head', 'home_link_icon_customize_css');

function create_video_custom_post()
{
    register_post_type('video_posts', array(
            'labels' => array(
                'name' => 'Videos',
                'singular_name' => 'Video',
            ),
            'public' => true,
            'has_archive' => true,
        )
    );
}

add_action('init', 'create_video_custom_post');