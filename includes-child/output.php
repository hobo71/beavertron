<?php
/**
 * BeaverTron Inline CSS
 *
 * This file adds the required CSS to the front end of BeaverTron theme.
 *
 * @package beavertron
 * @author  @_neilgee
 * @license GPL-2.0+
 * @link    http://wpbeaches.com
 */

add_action( 'wp_enqueue_scripts', 'bt_css', 1001 );
/**
 * Checks the settings for the images and background colors for each image
 * If any of these value are set the appropriate CSS is output
 * Enqueued with a 1001 priority as the main style sheet is at 1000
 *
 * @since 1.0
 */
function bt_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';
	
	/* Our Customiser settings, stored as variables */
	$hero_bg_image                     = get_theme_mod( 'hero_bg');
	$bt_link_color                     = get_theme_mod( 'bt_link_color', bt_link_color_default() );
	$bt_link_hover_color               = get_theme_mod( 'bt_link_hover_color', bt_link_hover_color_default() );
	$bt_menu_color                     = get_theme_mod( 'bt_menu_color', bt_menu_color_default() );
	$bt_menu_hover_color               = get_theme_mod( 'bt_menu_hover_color', bt_menu_hover_color_default() );
	$bt_button_color                   = get_theme_mod( 'bt_button_color', bt_button_color_default() );
	$bt_button_hover_color             = get_theme_mod( 'bt_button_hover_color', bt_button_hover_color_default() );
	$bt_footer_link_color              = get_theme_mod( 'bt_footer_link_color', bt_footer_link_color_default() );
	$bt_footer_link_hover_color        = get_theme_mod( 'bt_footer_link_hover_color', bt_footer_link_hover_color_default() );
	$bt_footerwidgets_background_color = get_theme_mod( 'bt_footerwidgets_background_color', bt_footerwidgets_background_color_default() );
	// WooCommerce
	if ( class_exists( 'WooCommerce' ) ) {
	$bt_woo_button_color             = get_theme_mod( 'bt_woo_button_color', bt_woo_button_color_default() );
	$bt_woo_button_hover_color       = get_theme_mod( 'bt_woo_button_hover_color', bt_woo_button_hover_color_default() );
	$bt_woo_button_alt_color         = get_theme_mod( 'bt_woo_button_alt_color', bt_woo_button_alt_color_default() );
	$bt_woo_button_alt_hover_color   = get_theme_mod( 'bt_woo_button_alt_hover_color', bt_woo_button_alt_hover_color_default() );
	$bt_woo_button_dis_color         = get_theme_mod( 'bt_woo_button_dis_color', bt_woo_button_dis_color_default() );
	$bt_woo_button_dis_hover_color   = get_theme_mod( 'bt_woo_button_dis_hover_color', bt_woo_button_dis_hover_color_default() );

	$bt_woo_price_color		 = get_theme_mod( 'bt_woo_price_color', bt_woo_price_color_default() );
	$bt_woo_sale_price_color	 = get_theme_mod( 'bt_woo_sale_price_color', bt_woo_sale_price_color_default() );

	$bt_woo_error_color	         = get_theme_mod( 'bt_woo_error_color', bt_woo_error_color_default() );
	$bt_woo_info_color	         = get_theme_mod( 'bt_woo_info_color', bt_woo_info_color_default() );
	$bt_woo_message_color	         = get_theme_mod( 'bt_woo_message_color', bt_woo_message_color_default() );
	}


	//* Calculate Color Contrast
	function bt_color_contrast( $color ) {

		$hexcolor = str_replace( '#', '', $color );

		$red   = hexdec( substr( $hexcolor, 0, 2 ) );
		$green = hexdec( substr( $hexcolor, 2, 2 ) );
		$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

		$luminosity = ( ( $red * 0.2126 ) + ( $green * 0.7152 ) + ( $blue * 0.0722 ) );

		return ( $luminosity > 128 ) ? '#333333' : '#ffffff';
	}

	//* Calculate Color Brightness
	function bt_color_brightness( $color, $change ) {

		$hexcolor = str_replace( '#', '', $color );

		$red   = hexdec( substr( $hexcolor, 0, 2 ) );
		$green = hexdec( substr( $hexcolor, 2, 2 ) );
		$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

		$red   = max( 0, min( 255, $red + $change ) );
		$green = max( 0, min( 255, $green + $change ) );
		$blue  = max( 0, min( 255, $blue + $change ) );

		return '#'.dechex( $red ).dechex( $green ).dechex( $blue );
	}

	/* Start off with •nuffink*/
	$css = '';


	$css .= ( !empty($hero_bg_image) ) ? sprintf('
		.herocontainer {
		background: url(%s) no-repeat center;
		background-size: cover;
		}
	', $hero_bg_image ) : '';

	$css .= ( bt_link_color_default() !== $bt_link_color ) ? sprintf( '
		a {
			color: %s;
		}
		', $bt_link_color ) : '';

	$css .= ( bt_link_hover_color_default() !== $bt_link_hover_color  ) ? sprintf( '
	 	a:hover,
	 	a:focus,
		.entry-title a:hover,
		.entry-title a:focus,
		.archive-pagination li a:hover,
		.archive-pagination li a:focus,
		.archive-pagination .active a {
			color: %s;
		}
	', $bt_link_hover_color ) : '';

	$css .= ( bt_menu_color_default() !== $bt_menu_color  ) ? sprintf( '
		.genesis-nav-menu a,
		.nav-primary .genesis-nav-menu .sub-menu a,
		.menu-toggle,
		.sub-menu-toggle {
			color: %s;
		}

		@media only screen and (min-width: 767px) {
			.genesis-responsive-menu .genesis-nav-menu a {
			    color: %s;
			}
		}
	', $bt_menu_color, $bt_menu_color ) : '';

	$css .= ( bt_menu_hover_color_default() !== $bt_menu_hover_color ) ? sprintf( '
		.genesis-nav-menu a:hover,
		.genesis-nav-menu a:focus,
		.genesis-nav-menu .current-menu-item > a,
		.genesis-nav-menu .sub-menu .current-menu-item > a:hover,
		.genesis-nav-menu .sub-menu .current-menu-item > a:focus,
		.nav-primary .genesis-nav-menu .sub-menu a:hover,
		.nav-primary .genesis-nav-menu .sub-menu a:focus,
		.nav-primary .genesis-nav-menu .sub-menu .current-menu-item > a,
		.menu-toggle:focus,
		.menu-toggle:hover,
		.sub-menu-toggle:focus,
		.sub-menu-toggle:hover {
			color: %s;
		}

		@media only screen and (min-width: 767px) {
			.genesis-responsive-menu .genesis-nav-menu a:focus,
			.genesis-responsive-menu .genesis-nav-menu a:hover,
			.genesis-responsive-menu .genesis-nav-menu .current-menu-item > a,
			.genesis-responsive-menu .genesis-nav-menu .sub-menu .current-menu-item > a:focus,
			.genesis-responsive-menu .genesis-nav-menu .sub-menu .current-menu-item > a:hover {
			    color: %s;
			}
		}
	', $bt_menu_hover_color, $bt_menu_hover_color ) : '';

	$css .= ( bt_button_color_default() !== $bt_button_color ) ? sprintf( '
		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.button,
		.widget .button,
		.enews-widget input[type="submit"],
  		.archive-pagination li a,
		a.more-link {
			background-color: %s;
			color: %s;
		}
		', $bt_button_color, bt_color_contrast( $bt_button_color ) ) : '';


	$css .= ( bt_button_hover_color_default() !== $bt_button_hover_color ) ? sprintf( '
		button:hover,
		button:focus,
		.button:hover,
		.button:focus,
		input[type="button"]:hover,
		input[type="button"]:focus,
		input[type="reset"]:hover,
		input[type="reset"]:focus,
		input[type="reset"]:hover,
		input[type="reset"]:focus,
		input:hover[type="reset"],
		input:hover[type="submit"],
		input:focus[type="button"],
		input:focus[type="reset"],
		input:focus[type="submit"],
		.widget .button:hover,
		.widget .button:focus,
		.enews-widget input[type="submit"]:hover,
		.enews-widget input[type="submit"]:focus,
		.archive-pagination li a:hover,
		.archive-pagination li a:focus,
		.archive-pagination .active a,
		a.more-link:hover  {
			background-color: %s;
			color: %s;
		}
		', $bt_button_hover_color, bt_color_contrast( $bt_button_hover_color ) ) : '';



	$css .= ( bt_footer_link_color_default() !== $bt_footer_link_color ) ? sprintf( '
		.footer-widgets a {
			color: %s;
		}
		', $bt_footer_link_color ) : '';

	$css .= ( bt_footer_link_hover_color_default() !== $bt_footer_link_hover_color  ) ? sprintf( '
		.footer-widgets a:hover,
		.footer-widgets a:focus {
			color: %s;
		}
		', $bt_footer_link_hover_color ) : '';

	$css .= ( bt_footerwidgets_background_color_default() !== $bt_footerwidgets_background_color ) ? sprintf( '
		.footer-widgets {
			background-color: %s;
		}
		', $bt_footerwidgets_background_color ) : '';

	// WooCommerce
	if ( class_exists( 'WooCommerce' ) ) {

		$css .= ( bt_woo_button_color_default() !== $bt_woo_button_color ) ? sprintf( '

		.woocommerce a.button,
		.woocommerce #respond input#submit,
		.woocommerce button.button,
		.woocommerce input.button {
				background-color: %s;
				color: %s;
		}
		', $bt_woo_button_color, bt_color_contrast( $bt_woo_button_color ) ) : '';

		$css .= ( bt_woo_button_hover_color_default() !== $bt_woo_button_hover_color ) ? sprintf( '

		.woocommerce #respond input#submit:hover,
		.woocommerce a.button:hover,
		.woocommerce button.button:hover,
		.woocommerce input.button:hover  {
			background-color: %s;
			color: %s;
		}
		', $bt_woo_button_hover_color, bt_color_contrast( $bt_woo_button_hover_color ) ) : '';

		$css .= ( bt_woo_button_alt_color_default() !== $bt_woo_button_alt_color ) ? sprintf( '


		.woocommerce #respond input#submit.alt.disabled,
		.woocommerce #respond input#submit.alt.disabled:hover,
		.woocommerce #respond input#submit.alt:disabled,
		.woocommerce #respond input#submit.alt:disabled:hover,
		.woocommerce #respond input#submit.alt:disabled[disabled],
		.woocommerce #respond input#submit.alt:disabled[disabled]:hover,
		.woocommerce a.button.alt.disabled,
		.woocommerce a.button.alt.disabled:hover,
		.woocommerce a.button.alt:disabled,
		.woocommerce a.button.alt:disabled:hover,
		.woocommerce a.button.alt:disabled[disabled],
		.woocommerce a.button.alt:disabled[disabled]:hover,
		.woocommerce button.button.alt.disabled,
		.woocommerce button.button.alt.disabled:hover,
		.woocommerce button.button.alt:disabled,
		.woocommerce button.button.alt:disabled:hover,
		.woocommerce button.button.alt:disabled[disabled],
		.woocommerce button.button.alt:disabled[disabled]:hover,
		.woocommerce input.button.alt.disabled,
		.woocommerce input.button.alt.disabled:hover,
		.woocommerce input.button.alt:disabled,
		.woocommerce input.button.alt:disabled:hover,
		.woocommerce input.button.alt:disabled[disabled],
		.woocommerce input.button.alt:disabled[disabled]:hover,
		.woocommerce #respond input#submit.alt,
		.woocommerce a.button.alt,
		.woocommerce button.button.alt,
		.woocommerce input.button.alt,
		.woocommerce span.onsale {
				background-color: %s;
				color: %s;
		}
		', $bt_woo_button_alt_color, bt_color_contrast( $bt_woo_button_alt_color ) ) : '';

		$css .= ( bt_woo_button_alt_hover_color_default() !== $bt_woo_button_alt_hover_color ) ? sprintf( '

		.woocommerce #respond input#submit.alt:hover,
		.woocommerce a.button.alt:hover,
		.woocommerce button.button.alt:hover,
		.woocommerce input.button.alt:hover {
			background-color: %s;
			color: %s;
		}
		', $bt_woo_button_alt_hover_color, bt_color_contrast( $bt_woo_button_alt_hover_color ) ) : '';

		$css .= ( bt_woo_button_dis_color_default() !== $bt_woo_button_dis_color ) ? sprintf( '

		.woocommerce #respond input#submit.disabled,
		.woocommerce #respond input#submit:disabled,
		.woocommerce #respond input#submit:disabled[disabled],
		.woocommerce a.button.disabled, .woocommerce a.button:disabled,
		.woocommerce a.button:disabled[disabled],
		.woocommerce button.button.disabled,
		.woocommerce button.button:disabled,
		.woocommerce button.button:disabled[disabled],
		.woocommerce input.button.disabled,
		.woocommerce input.button:disabled,
		.woocommerce input.button:disabled[disabled] {
				background-color: %s;
		}
		', $bt_woo_button_dis_color, bt_color_contrast( $bt_woo_button_dis_color ) ) : '';

		$css .= ( bt_woo_button_dis_hover_color_default() !== $bt_woo_button_dis_hover_color ) ? sprintf( '

		.woocommerce #respond input#submit.disabled:hover,
		.woocommerce #respond input#submit:disabled:hover,
		.woocommerce #respond input#submit:disabled[disabled]:hover,
		.woocommerce a.button.disabled:hover,
		.woocommerce a.button:disabled:hover,
		.woocommerce a.button:disabled[disabled]:hover,
		.woocommerce button.button.disabled:hover,
		.woocommerce button.button:disabled:hover,
		.woocommerce button.button:disabled[disabled]:hover,
		.woocommerce input.button.disabled:hover,
		.woocommerce input.button:disabled:hover,
		.woocommerce input.button:disabled[disabled]:hover {
			background-color: %s;
		}
		', $bt_woo_button_dis_hover_color, bt_color_contrast( $bt_woo_button_dis_hover_color ) ) : '';



		$css .= ( bt_woo_price_color_default() !== $bt_woo_price_color ) ? sprintf( '

		.woocommerce div.product p.price,
		.woocommerce div.product span.price,
		.woocommerce ul.products li.product .price {
			color: %s;
		}
		', $bt_woo_price_color, bt_color_contrast( $bt_woo_price_color ) ) : '';

		$css .= ( bt_woo_sale_price_color_default() !== $bt_woo_sale_price_color ) ? sprintf( '

		.woocommerce span.onsale {
			background-color: %s;
		}
		', $bt_woo_sale_price_color, bt_color_contrast( $bt_woo_sale_price_color ) ) : '';



		$css .= ( bt_woo_info_color_default() !== $bt_woo_info_color  ) ? sprintf( '
		.woocommerce-info {
			border-top-color: %s;
		}
		', $bt_woo_info_color ) : '';


		$css .= ( bt_woo_info_color_default() !== $bt_woo_info_color  ) ? sprintf( '
		.woocommerce-info:before {
		    color:%s;
		}
		', $bt_woo_info_color ) : '';

		$css .= ( bt_woo_error_color_default() !== $bt_woo_error_color  ) ? sprintf( '
		.woocommerce-error {
			border-top-color: %s;
		}
		', $bt_woo_error_color ) : '';


		$css .= ( bt_woo_error_color_default() !== $bt_woo_error_color  ) ? sprintf( '
		.woocommerce-error:before,
		.woocommerce form .form-row.woocommerce-invalid label,
		.woocommerce form .form-row .required,
		.woocommerce a.remove {
		    color:%s !important;
		}
		', $bt_woo_error_color ) : '';

		$css .= ( bt_woo_error_color_default() !== $bt_woo_error_color  ) ? sprintf( '
		.woocommerce form .form-row.woocommerce-invalid .select2-container,
		.woocommerce form .form-row.woocommerce-invalid input.input-text,
		.woocommerce form .form-row.woocommerce-invalid select {
		    border-color: %s;
		}
		', $bt_woo_error_color ) : '';

		$css .= ( bt_woo_error_color_default() !== $bt_woo_error_color  ) ? sprintf( '
		.woocommerce a.remove:hover {
		    background: %s;
		}
		', $bt_woo_error_color ) : '';

		$css .= ( bt_woo_message_color_default() !== $bt_woo_message_color  ) ? sprintf( '
		.woocommerce-message {
			border-top-color: %s;
		}
		', $bt_woo_message_color ) : '';


		$css .= ( bt_woo_message_color_default() !== $bt_woo_message_color  ) ? sprintf( '
		.woocommerce-message:before {
		    color:%s;
		}
		', $bt_woo_message_color ) : '';

	}

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}


}
