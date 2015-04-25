<?php

global $maudience_client_slug = 'MAUDIENCE-CLIENT-NAME';

// include 'demo.php';
/*
#
#   REGISTER JS AND CSS
#
*/
    // function lowermedia_scripts() {
        // wp_enqueue_script(
        //     'custom-js',
        //     get_stylesheet_directory_uri() . '/custom.js',
        //     array( 'jquery' )
        // );
        // if (is_front_page()) {
        //     wp_enqueue_script(
        //         'jssor',
        //         get_stylesheet_directory_uri() . '/js/jssor.js',
        //         array( 'jquery' )
        //     );
        //     wp_enqueue_script(
        //         'jssorslider',
        //         get_stylesheet_directory_uri() . '/js/jssor.slider.js',
        //         array( 'jquery' )
        //     );
        // }
        // wp_enqueue_script('jquery-ui-accordion');
    // }
    // add_action( 'wp_enqueue_scripts', 'lowermedia_scripts' );
    // function lowermedia_enqueue_parent_style() {
    //     wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    // }
    // add_action( 'wp_enqueue_scripts', 'lowermedia_enqueue_parent_style' );

/**
 * Enqueue scripts and styles
 */

    function lowermedia_scripts() {
        wp_enqueue_style( $maudience_client_slug.'-css', get_stylesheet_directory_uri()."lib/css/style.css" );
    }
    add_action( 'wp_enqueue_scripts', 'lowermedia_scripts', 15 );

/*
#
#   ADD CUSTOM CONTENT TYPES 
#
*/
    /**
     * Custom Post Types, on the fly creation
     *
     **/
    // function lm_custom_post_type_creator($post_type_name, $description, $public, $menu_position, $supports, $has_archive, $irreg_plural, $slug) {
    //   if ($irreg_plural) {$plural = 's';} else {$plural = '';}
    //   $labels = array(
    //     'name'               => _x( $post_type_name, 'post type general name' ),
    //     'singular_name'      => _x( strtolower($post_type_name), 'post type singular name' ),
    //     'add_new'            => _x( 'Add New', 'book' ),
    //     'add_new_item'       => __( 'Add New '.$post_type_name),
    //     'edit_item'          => __( 'Edit '.$post_type_name ),
    //     'new_item'           => __( 'New '.$post_type_name ),
    //     'all_items'          => __( 'All '.$post_type_name.$plural ),
    //     'view_item'          => __( 'View '.$post_type_name ),
    //     'search_items'       => __( 'Search'.$post_type_name.$plural ),
    //     'not_found'          => __( 'No '.$post_type_name.$plural.' found' ),
    //     'not_found_in_trash' => __( 'No '.$post_type_name.$plural.' found in the Trash' ), 
    //     'parent_item_colon'  => '',
    //     'menu_name'          => $post_type_name
    //   );
    //   $args = array(
    //     'labels'        => $labels,
    //     'description'   => $description,
    //     'public'        => $public,
    //     'menu_position' => $menu_position,
    //     'supports'      => $supports,
    //     'rewrite' => array('slug' => $slug),
    //     'has_archive'   => $has_archive,
    //   );
    //   register_post_type( $post_type_name, $args ); 
    // }
    // add_action( 'init', lm_custom_post_type_creator('Vehicles', 'Holds our fleet vehicles', true, 4, array( 'title', 'editor', 'thumbnail' ), true, false, 'fleet'));
    // add_action( 'init', lm_custom_post_type_creator('Staff', 'Holds our staff specific data', true, 5, array( 'title', 'editor', 'thumbnail' ), true, false));
    // add_action( 'init', lm_custom_post_type_creator('Car Care Tips', 'Holds our car care tips.', true, 6, array( 'title', 'editor', 'thumbnail', 'excerpt' ), true, false));
    // add_action( 'init', lm_custom_post_type_creator('Car Care Videos', 'Holds our car care videos.', true, 7, array( 'title', 'editor', 'thumbnail' ), true, false));

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */

    function lm_add_meta_box() {
        add_meta_box(
            'lm_vehicles_capacity',
            __( 'Capacity', 'lm_textdomain' ),
            'lm_meta_box_callback1',
            'vehicles',//$screen
            'side',
            'high'
        );
        add_meta_box(
            'lm_vehicles_upselltext',
            __( 'Upsell Text', 'lm_textdomain' ),
            'lm_meta_box_callback2',
            'vehicles',//$screen
            'side',
            'high'
        );
    }
    add_action( 'add_meta_boxes', 'lm_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */

    function lm_meta_box_callback1( $post ) {
        // Add an nonce field so we can check for it later.
        wp_nonce_field( 'lm_meta_box', 'lm_meta_box_nonce' );
        /*
         * Use get_post_meta() to retrieve an existing value
         * from the database and use the value for the form.
         */
        $value = get_post_meta( $post->ID, '_lm_meta_value_key1', true );
        echo '<label for="lm_new_field1">';
        _e( 'Description for this field', 'lm_textdomain' );
        echo '</label> ';
        echo '<input type="text" id="lm_new_field1" name="lm_new_field1" value="' . esc_attr( $value ) . '" size="25" />';
    }

    function lm_meta_box_callback2( $post ) {
        // Add an nonce field so we can check for it later.
        wp_nonce_field( 'lm_meta_box', 'lm_meta_box_nonce' );
        /*
         * Use get_post_meta() to retrieve an existing value
         * from the database and use the value for the form.
         */
        $value = get_post_meta( $post->ID, '_lm_meta_value_key2', true );
        echo '<label for="lm_new_field2">';
        _e( 'Description for this field', 'lm_textdomain' );
        echo '</label> ';
        echo '<input type="text" id="lm_new_field2" name="lm_new_field2" value="' . esc_attr( $value ) . '" size="25" />';
    }
/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function lm_save_meta_box_data( $post_id ) {
    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */
    // Check if our nonce is set.
    if ( ! isset( $_POST['lm_meta_box_nonce'] ) ) {
        return;
    }
    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['lm_meta_box_nonce'], 'lm_meta_box' ) ) {
        return;
    }
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    } else {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }
    /* OK, it's safe for us to save the data now. */
    // Make sure that it is set.
    if ( ! isset( $_POST['lm_new_field1'] ) || ! isset( $_POST['lm_new_field2'] ) ) {
        return;
    }
    // Sanitize user input.
    $my_data1 = sanitize_text_field( $_POST['lm_new_field1'] );
    $my_data2 = sanitize_text_field( $_POST['lm_new_field2'] );
    // Update the meta field in the database.
    update_post_meta( $post_id, '_lm_meta_value_key1', $my_data1 );
    update_post_meta( $post_id, '_lm_meta_value_key2', $my_data2 );
}
add_action( 'save_post', 'lm_save_meta_box_data' );
/*
#
#   Make Archives.php Include Custom Post Types
#   http://css-tricks.com/snippets/wordpress/make-archives-php-include-custom-post-types/
#
*/
/*
    --    ADD CUSTOM POST TYPES HERE   --
*/
    // function namespace_add_custom_types( $query ) {
    //   if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
    //         $query->set( 'post_type', array( 'post', 'post-type-name' ));
    //         return $query;
    //     }
    // }
    // add_filter( 'pre_get_posts', 'namespace_add_custom_types' );
/*
#
#   Define what post types to search
#   The hook needed to search ALL content
#
*/
/*
    --    ADD CUSTOM POST TYPES HERE   --
*/
    // function searchAll( $query ) {
    //     if ( $query->is_search ) {
    //         $query->set( 'post_type', array( 'post', 'page', 'feed', 'products', 'people'));
    //     }
    //     return $query;
    // }
    // add_filter( 'the_search_query', 'searchAll' );
/*
#
#   PHONENUMBER
#   
#
*/
    function format_phonenumber( $arg ) {
        $data = '+'.$arg;
        if(  preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $data,  $matches ) )
        {
            $result = '('.$matches[1] . ')&nbsp;' .$matches[2] . '-' . $matches[3];
            return $result;
        }
    }
    // Add [phonenumber] shortcode
    function phonenumber_shortcode( $atts ){
        //retrieve phone number from database
        $lm_array = get_option('lowermedia_phone_number');
        //check if user is on mobile if so make the number a link
        if (wp_is_mobile())
        {
            return '<a href="tel:+'.$lm_array["id_number"].'">'.format_phonenumber($lm_array["id_number"]).'</a>';
        } else {
            return format_phonenumber($lm_array["id_number"]);
        }
    }
    add_shortcode( 'phonenumber', 'phonenumber_shortcode' );
    class lowermedia_phonenumber_settings
    {
        /**
         * Holds the values to be used in the fields callbacks
         */
        private $options;
        /**
         * Start up
         */
        public function __construct()
        {
            add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
            add_action( 'admin_init', array( $this, 'page_init' ) );
        }
        /**
         * Add options page
         */
        public function add_plugin_page()
        {
            // This page will be under "Settings"
            add_options_page(
                'Settings Admin', 
                'Phone Number', 
                'manage_options', 
                'lowermedia-setting-admin', 
                array( $this, 'create_admin_page' )
            );
        }
        /**
         * Options page callback
         */
        public function create_admin_page()
        {
            // Set class property
            $this->options = get_option( 'lowermedia_phone_number' );
            ?>
            <div class="wrap">
                <?php screen_icon(); ?>
                <h2>Phone Number</h2>           
                <form method="post" action="options.php">
                <?php
                    // This prints out all hidden setting fields
                    settings_fields( 'lowermedia_phone_options' );   
                    do_settings_sections( 'lowermedia-setting-admin' );
                    submit_button(); 
                ?>
                </form>
            </div>
            <?php
        }
        /**
         * Register and add settings
         */
        public function page_init()
        {        
            register_setting(
                'lowermedia_phone_options', // Option group
                'lowermedia_phone_number', // Option name
                array( $this, 'sanitize' ) // Sanitize
            );
            add_settings_section(
                'setting_section_id', // ID
                'Enter your site specific Phone Number Below:', // Title
                array( $this, 'print_section_info' ), // Callback
                'lowermedia-setting-admin' // Page
            );  
            add_settings_field(
                'id_number', // ID
                'ID Number', // Title 
                array( $this, 'id_number_callback' ), // Callback
                'lowermedia-setting-admin', // Page
                'setting_section_id' // Section           
            );      
       
        }
        /**
         * Sanitize each setting field as needed
         *
         * @param array $input Contains all settings fields as array keys
         */
        public function sanitize( $input )
        {
            $new_input = array();
            if( isset( $input['id_number'] ) )
                $new_input['id_number'] = absint( $input['id_number'] );
            return $new_input;
        }
        /** 
         * Print the Section text
         */
        public function print_section_info()
        {
            print 'This creates a shortcode that outputs the site specific phone number as a link on mobile but only as text on desktop<br/><br/>Usage Info:<br/> - Use [phonenumber] to activate<br/> - Make sure you add your country code to the begining (1 for North America), ie: 12223334444';
        }
        /** 
         * Get the settings option array and print one of its values
         */
        public function id_number_callback()
        {
            printf(
                '<input type="text" id="id_number" name="lowermedia_phone_number[id_number]" value="%s" />',
                isset( $this->options['id_number'] ) ? esc_attr( $this->options['id_number']) : ''
            );
        }
    }
    if( is_admin() ) { $lowermedia_phonenumber_settings = new lowermedia_phonenumber_settings(); }
/*
#
#   REGISTER SIDEBARS/WIDGET AREAS
#   
#
*/
    function lowermedia_widgets_init() {
        // register_sidebar( array(
        //     'name' => 'Pre Content Widget Area',
        //     'id' => 'pre-content-widget',
        //     'before_widget' => '<div id="pre-content-widget" class="pre-content-widget">',
        //     'after_widget' => '</div>',
        //     'before_title' => '<h2 class="rounded">',
        //     'after_title' => '</h2>',
        // ) );
    }
    add_action( 'widgets_init', 'lowermedia_widgets_init' );
/*
#
#   REGISTER MENUS
#   
#
*/
    function lowermedia_menus_init() {
      register_nav_menus(
        array(
          'social-media-navigation' => __( 'Social Media Navigation' )
        )
      );
    }
    add_action( 'init', 'lowermedia_menus_init' );
/*
#   Create widget info for above function: lm_add_dashboard_widgets
*/
    function lm_theme_info() {
      echo "
          <ul>
          <li><strong>Developed By:</strong> LowerMedia.Net</li>
          <li><strong>Website:</strong> <a href='http://lowermedia.net'>www.lowermedia.net</a></li>
          <li><strong>Contact:</strong> <a href='mailto:pete.lower@gmail.com'>pete.lower@gmail.com</a></li>
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
if (!is_admin()) add_action("wp_enqueue_scripts", "lowermedia_jquery_enqueue", 11);
function lowermedia_jquery_enqueue() {
    wp_deregister_script('jquery');
    // wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js", false, null, true);
    wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js", false, null, true);
    wp_enqueue_script('jquery');
}
//added lazy load styles to style.css so deregister
// add_action( 'wp_print_styles', 'lowermedia_deregister_styles', 100 );
// function lowermedia_deregister_styles() {
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
    function lowermedia_return_custom_posts($post_type, $how_many) {
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