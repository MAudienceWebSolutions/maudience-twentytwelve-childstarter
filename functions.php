<?php

global $maudience_client_slug = 'MAUDIENCE-CLIENT-NAME';
require_once('lib/custom-post-types.php');
require_once('lib/maudience-phonenumber.php');

/*
#
#   REGISTER JS AND CSS
#
*/
    // function maudience_scripts() {
    //     wp_enqueue_script(
    //         'custom-js',
    //         get_stylesheet_directory_uri() . '/custom.js',
    //         array( 'jquery' )
    //     );
    //     if (is_front_page()) {
    //         wp_enqueue_script(
    //             'jssor',
    //             get_stylesheet_directory_uri() . '/js/jssor.js',
    //             array( 'jquery' )
    //         );
    //         wp_enqueue_script(
    //             'jssorslider',
    //             get_stylesheet_directory_uri() . '/js/jssor.slider.js',
    //             array( 'jquery' )
    //         );
    //     }
    //     wp_enqueue_script('jquery-ui-accordion');
    // }
    // add_action( 'wp_enqueue_scripts', 'maudience_scripts' );
    // function maudience_enqueue_parent_style() {
    //     wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    // }
    // add_action( 'wp_enqueue_scripts', 'maudience_enqueue_parent_style' );

/**
 * Enqueue scripts and styles
 */

    function maudience_scripts() {
        wp_enqueue_style( $maudience_client_slug.'-css', get_stylesheet_directory_uri()."lib/css/style.css" );
    }
    add_action( 'wp_enqueue_scripts', 'maudience_scripts', 15 );

/*
#
#   REGISTER SIDEBARS/WIDGET AREAS
#   
#
*/
    function maudience_widgets_init() {
        // register_sidebar( array(
        //     'name' => 'Pre Content Widget Area',
        //     'id' => 'pre-content-widget',
        //     'before_widget' => '<div id="pre-content-widget" class="pre-content-widget">',
        //     'after_widget' => '</div>',
        //     'before_title' => '<h2 class="rounded">',
        //     'after_title' => '</h2>',
        // ) );
    }
    add_action( 'widgets_init', 'maudience_widgets_init' );
/*
#
#   REGISTER MENUS
#   
#
*/
    function maudience_menus_init() {
      register_nav_menus(
        array(
          'social-media-navigation' => __( 'Social Media Navigation' )
        )
      );
    }
    add_action( 'init', 'maudience_menus_init' );
/*
#   Create widget info for above function: lm_add_dashboard_widgets
*/
    function lm_theme_info() {
      echo "
          <ul>
          <li><strong>Developed By:</strong> MAudience</li>
          <li><strong>Website:</strong> <a href='http://maudience.com'>http://www.maudience.net</a></li>
          <li><strong>Contact:</strong> <a href='mailto:pete@maudience.com'>pete@maudience.com</a></li>
          </ul>"
      ;
    }
/*
#
#   ENABLE SHORTCODE IN WIDGETS
#
*/
    add_filter('widget_text', 'do_shortcode');
/*
# SPEED OPTIMIZATIONS
# 
*/
    // Remove jquery migrate as is not needed
    if(!is_admin()) add_filter( 'wp_default_scripts', 'dequeue_jquery_migrate' );
    function dequeue_jquery_migrate( &$scripts){
        $scripts->remove( 'jquery');
        $scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
    }
    //load jquery from google
    if (!is_admin()) add_action("wp_enqueue_scripts", "maudience_jquery_enqueue", 11);
    function maudience_jquery_enqueue() {
        wp_deregister_script('jquery');
        // wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js", false, null, true);
        wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js", false, null, true);
        wp_enqueue_script('jquery');
    }

    //added lazy load styles to style.css so deregister
    // add_action( 'wp_print_styles', 'maudience_deregister_styles', 100 );
    // function maudience_deregister_styles() {
    //   wp_deregister_style( 'image-lazy-load-frontend' );
    // }
/*
#
#   SPEED OPTIMIZATIONS
#   -Load all fonts from google
#
#
*/
    function load_fonts() {
        wp_dequeue_style( 'twentytwelve-fonts' );
        wp_deregister_style( 'twentytwelve-fonts' );
        wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Signika:400,700|Open+Sans:400italic,700italic,400,700&amp;subset=latin,latin-ext');
        wp_enqueue_style( 'googleFonts');
    }
    add_action('wp_print_styles', 'load_fonts');
/*
#
#   RETURN CUSTOM POST TYPES
#
#   return all if $how_many equals 'all'
#
*/
    function maudience_return_custom_posts($post_type, $how_many) {
        ?><ul class='custom-post-type-list'><?php
        if( $how_many !='all' ){ $posts_per_page = $how_many; }
        $args=array(
          'post_type' => $post_type,
          'post_status' => 'publish',
          'posts_per_page' => $posts_per_page,
          'caller_get_posts'=> 1
        );
        $my_query = null;
        $my_query = new WP_Query($args);
        if( $my_query->have_posts() ) :
          while ($my_query->have_posts()) : $my_query->the_post(); ?>
            <li class='custom-post-type-list-item'>
                <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="entry-page-image">
                            <?php the_post_thumbnail(); ?>
                        </div><!-- .entry-page-image -->
                    <?php endif; ?>
                    <div class="post-image-wrap">

                        <div class="custom-post-title">
                            <?php the_title(); ?>
                        </div><!-- .custom-post-title -->

                        <?php if ( get_post_meta( get_the_ID(), '_lm_meta_value_key2', true ) ) : ?>
                            <div class="custom-post-capacity">
                                <?php echo esc_html(get_post_meta( get_the_ID(), '_lm_meta_value_key2', true )); ?>                           
                            </div><!-- .custom-post-capacity -->
                        <?php endif; ?>

                        <?php if ( get_post_meta( get_the_ID(), '_lm_meta_value_key1', true ) ) : ?>
                            <div class="custom-post-upselltext">
                                <?php echo esc_html(get_post_meta( get_the_ID(), '_lm_meta_value_key1', true ))." Person"; ?>                            
                            </div><!-- .custom-post-upselltext -->
                        <?php endif; ?>

                        
                    </div>
                </a>
                <div class="cpt-button-wrap">
                    <a class="ctl-button ctl-viewdetails-button" href="<?php the_permalink() ?>" />View Details <span>>></span></a>
                    <a class="ctl-button ctl-inquire-button" href="/contact/" />Inquire</a>
                </div>
            </li>
            <?php
          endwhile;
        endif;
        wp_reset_query();  // Restore global post data stomped by the_post().
        ?></ul><?php
    }
    add_filter("gform_submit_button", "form_submit_button", 10, 2);
    
    function form_submit_button($button, $form){
        $button_title = $form['button']['text'];
        return "<button class='button' id='gform_submit_button_{$form["id"]}'>".$button_title."</button>";
    }
/*
#
#   END
#
*/