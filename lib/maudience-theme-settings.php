<?php
// register setting
function ma_theme_init() {

	// example checkbox setting
	register_setting( 'ma-settings-group', 'ma_show_setting' );//Checkbox Setting

	/* POST TYPE CHECKBOXES */
	register_setting( 'ma-settings-group', 'ma_services_cpt_option' );//Services Checkbox Setting
	register_setting( 'ma-settings-group', 'ma_testimonials_cpt_option' );//Testimonials Checkbox Setting
	register_setting( 'ma-settings-group', 'ma_staff_cpt_option' );//Staff Checkbox Setting
	register_setting( 'ma-settings-group', 'ma_vehicles_cpt_option' );//Vehicles Checkbox Setting

	/* CONTACT INFO CHECKBOXES */
	register_setting( 'ma-settings-group', 'ma_phonenumber_setting' );//Phone Number Setting
	register_setting( 'ma-settings-group', 'ma_phonenumberalt_setting' );//Phone Number Setting
	register_setting( 'ma-settings-group', 'ma_email_setting' );//Phone Number Setting

	/* ADD SETTINGS SECTIONS */
	add_settings_section( 'ma_setting_section', 'Custom Theme Settings:', 'ma_setting_section_callback', 'wpsettings' );

	/* ADD THE SETTINGS FIELDS THAT CORRESPOND WITH THE ABOVE SETTINGS FIELDS*/
	add_settings_field( 'ma_setting_checkbox', 'CheckBox', 'ma_setting_checkbox_callback', 'wpsettings', $section = 'ma_setting_section');
	add_settings_field( 'ma_setting_services', 'Services Post Type:', 'ma_setting_services_checkbox_callback', 'wpsettings', $section = 'ma_setting_section');
	add_settings_field( 'ma_setting_testimonials', 'Testimonials Post Type:', 'ma_setting_testimonials_checkbox_callback', 'wpsettings', $section = 'ma_setting_section');
	add_settings_field( 'ma_setting_staff', 'Staff Post Type:', 'ma_setting_staff_checkbox_callback', 'wpsettings', $section = 'ma_setting_section');
	add_settings_field( 'ma_setting_vehicles', 'Vehicles Post Type:', 'ma_setting_vehicles_checkbox_callback', 'wpsettings', $section = 'ma_setting_section');
	add_settings_field( 'ma_setting_phonenumber', 'Phone Number:', 'ma_setting_phonenumber_callback', 'wpsettings', $section = 'ma_setting_section');
	add_settings_field( 'ma_setting_phonenumberalt', 'Alternate Phone Number:', 'ma_setting_phonenumberalt_callback', 'wpsettings', $section = 'ma_setting_section');
	add_settings_field( 'ma_setting_email', 'Contact Email:', 'ma_setting_email_callback', 'wpsettings', $section = 'ma_setting_section');

}
add_action('admin_init', 'ma_theme_init');

function ma_setting_section_callback() {
}

function ma_setting_checkbox_callback() {

	$option = get_option( 'ma_show_setting' );
	$html = '<input type="checkbox" id="ma_show_setting" name="ma_show_setting" value="1"' . checked( 1, $option, false ) . '/>';
	$html .= '<label for="ma_show_setting">Check to check the box.</label>';
	echo $html;

}

function ma_setting_services_checkbox_callback() {

	$option = get_option( 'ma_services_cpt_option' );
	$html = '<input type="checkbox" id="ma_services_cpt_option" name="ma_services_cpt_option" value="1"' . checked( 1, $option, false ) . '/>';
	$html .= '<label for="ma_services_cpt_option">Check to enable services.</label>';
	echo $html;

}

function ma_setting_testimonials_checkbox_callback() {

	$option = get_option( 'ma_testimonials_cpt_option' );
	$html = '<input type="checkbox" id="ma_testimonials_cpt_option" name="ma_testimonials_cpt_option" value="1"' . checked( 1, $option, false ) . '/>';
	$html .= '<label for="ma_testimonials_cpt_option">Check to enable testimonials.</label>';
	echo $html;

}

function ma_setting_staff_checkbox_callback() {

	$option = get_option( 'ma_staff_cpt_option' );
	$html = '<input type="checkbox" id="ma_staff_cpt_option" name="ma_staff_cpt_option" value="1"' . checked( 1, $option, false ) . '/>';
	$html .= '<label for="ma_staff_cpt_option">Check to enable staff.</label>';
	echo $html;

}

function ma_setting_vehicles_checkbox_callback() {

	$option = get_option( 'ma_vehicles_cpt_option' );
	$html = '<input type="checkbox" id="ma_vehicles_cpt_option" name="ma_vehicles_cpt_option" value="1"' . checked( 1, $option, false ) . '/>';
	$html .= '<label for="ma_vehicles_cpt_option">Check to enable vehicles.</label>';
	echo $html;

}

function ma_setting_phonenumber_callback() {

	$option = get_option( 'ma_phonenumber_setting' );
	printf( '<input type="text" id="ma_phonenumber_setting" name="ma_phonenumber_setting" value="%s" />', isset( $option ) ? esc_attr( $option) : '' );

}

function ma_setting_phonenumberalt_callback() {

	$option = get_option( 'ma_phonenumberalt_setting' );
	printf( '<input type="text" id="ma_phonenumberalt_setting" name="ma_phonenumberalt_setting" value="%s" />', isset( $option ) ? esc_attr( $option) : '' );

}

function ma_setting_email_callback() {

	$option = get_option( 'ma_email_setting' );
	printf( '<input type="text" id="ma_email_setting" name="ma_email_setting" value="%s" />', isset( $option ) ? esc_attr( $option) : '' );

}

// Create Theme Options Page
function ma_add_theme_page() {
	add_theme_page(
		__('Theme Options', 'wpsettings'),//Page Title
		__('Theme Options', 'wpsettings'),//Menu Title
		'edit_theme_options',//Capability
		'ma-settings',//Slug
		'ma_theme_options_page'//Callback function
		);
}
add_action('admin_menu', 'ma_add_theme_page', $priority = 10, $accepted_args = 1 );

function ma_theme_options_page() {
	?>
	<div class="wrap">
		<h2>Theme Options - <?php echo wp_get_theme(); ?></h2>
		<form method="post" action="options.php">
			<?php
				settings_fields( 'ma-settings-group' );
				do_settings_sections( 'wpsettings' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}