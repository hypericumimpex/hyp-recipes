<?php
/**
 * Plugin Name: HYP Reteta Produs
 * Author:      Hypericum
 * Author URI: 	https://github.com/hypericumimpex
 * Plugin URI:  https://github.com/hypericumimpex/hyp-recipes
 * Version:     1.9.0
 * Text Domain: trg_el
 * Domain Path: /languages/
 * Description: Extensie pt. HYP Page Builder. Pluginul te ajută să creezi retete online cu microdate Schema, tabel cu date nutritionale si microdate Schema .
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Total_Recipe_Generator_El' ) ) {

	class Total_Recipe_Generator_El {

		private static $instance = null;

		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		function __construct() {

			// Include required files
			add_action( 'plugins_loaded', array( &$this, 'trg_includes' ) );

			// Load translation
			add_action( 'init', array( &$this, 'trg_init' ) );

			// Elementor Specific			
			add_action( 'elementor/widgets/widgets_registered', array( &$this, 'trg_widgets_registered' ) );
			add_action( 'admin_notices',  array( &$this, 'trg_install_el_notice' ) );
			add_action( 'elementor/editor/after_enqueue_scripts', array( &$this, 'trg_admin_scripts' ) );			
			
			// Custom CSS in head
			add_action( 'wp_head',  array( &$this, 'trg_add_global_css' ) );
			add_filter( 'wp_kses_allowed_html', array( &$this, 'trg_allow_iframes_in_post' ) );

			//add_action( 'trg_el_after_nutrition', array( &$this, 'trg_add_social_links' ) );
		}

		// Allow iframe tag in wp_kses_allowed_html
		function trg_allow_iframes_in_post( $allowedtags ) {
			if ( ! current_user_can( 'publish_posts' ) ) return $allowedtags;
			// Allow iframes and the following attributes
			$allowedtags['iframe'] = array(
				'align' => true,
				'width' => true,
				'height' => true,
				'frameborder' => true,
				'name' => true,
				'src' => true,
				'id' => true,
				'class' => true,
				'style' => true,
				'scrolling' => true,
				'marginwidth' => true,
				'marginheight' => true,
			);
			return $allowedtags;
		}

		public function trg_add_social_links( $social ) {
			if ( is_singular() && ( ! empty( $social['social_buttons'] ) ) ) {
				$social_sticky = isset( $social['social_sticky'] ) && 'on' == $social['social_sticky'] ? 'true' : '';
				if ( '' !== $social['social_heading'] ) {
					printf( '<h3 class="trg-social-heading%s">%s</h3>',
						$social_sticky ? ' hide-on-mobile' : '',
						'' !== $social['social_heading'] ? esc_attr( $social['social_heading'] ) : ''
					);
				}

				if ( is_array( $social['social_buttons'] ) && ! empty( $social['social_buttons'] ) ) {
					echo '<div class="trg-share-buttons">';
					echo trg_el_social_sharing( $social['social_buttons'], $social_sticky );
					echo '</div>';
				}
			}
		}
		
		// Enqueue admin scripts and styles
		function trg_admin_scripts() {
			wp_enqueue_style( 'trg-admin-css', plugin_dir_url( __FILE__ ) . 'assets/css/trg_admin.css' );
		}		

		// Show notice if Elementor not installed
		function trg_install_el_notice() {
			if ( ! defined( 'ELEMENTOR_PLUGIN_BASE' ) ) {
				echo sprintf( '<div class="error"><p>%s</p></div>', esc_attr__( 'Total Recipe Generator plugin requires Elementor Page Builder. Kindly install and activate Elementor plugin.', 'trg_el' ) );
			}
			else {
				return;
			}
		}

		// Include required files
		function trg_includes() {
			$plugin_dir = trailingslashit( plugin_dir_path( __FILE__ ) );
			require_once( $plugin_dir . 'includes/class.settings-api.php' );
			require_once( $plugin_dir . 'includes/settings.php' );			
			require_once( $plugin_dir . 'includes/BFI_Thumb.php' );
			require_once( $plugin_dir . 'includes/helper-functions.php' );
		}

		public function trg_widgets_registered( $widgets_manager ) {
            require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/widget-trg.php';
            $widgets_manager->register_widget_type( new \TotalRecipeGenerator\Widgets\Widget_Total_Recipe_Generator_El() );
        }		

		// Add Global CSS from plugin settings
		function trg_add_global_css() {
			$colors = get_option( 'trg_display' );
			$css = '';
			// Icon color
			if ( isset( $colors ) && ! empty( $colors ) ) {
				if ( '' != $colors['icon_color'] ) {
					$css .= '.recipe-heading > .fa:before{color:' . $colors['icon_color'] . ' ;}';
				}

				if ( '' != $colors['heading_color'] ) {
					$css .= '.recipe-heading{color:' . $colors['heading_color'] . ' !important;}';
				}

				if ( '' != $colors['label_color'] ) {
					$css .= '.info-board>li .ib-label,.cuisine-meta .cm-label{color:' . $colors['label_color'] . ';}';
				}

				if ( '' != $colors['highlights'] ) {
					$css .= '.info-board>li .ib-value{color:' . $colors['highlights'] . ';}';
				}

				if ( '' != $colors['tick_color'] ) {
					$css .= '.ing-list>li .fa:before{color:' . $colors['tick_color'] . ';}';
				}

				if ( '' != $colors['count_color'] ) {
					$css .= '.step-num{color:' . $colors['count_color'] . ';}';
				}

				// Tags links CSS
				if ( '' != $colors['tags_bg'] || '' != $colors['tags_color'] ) {
					$css .= '.cuisine-meta .cm-value:not(.link-enabled),.cuisine-meta .cm-value a{';
					$css .= ( '' != $colors['tags_bg'] ) ? 'background-color:' . $colors['tags_bg'] . ' !important;' : '';
					$css .= ( '' != $colors['tags_color'] ) ? 'color:' . $colors['tags_color'] . ' !important;' : '';
					$css .= 'box-shadow:none !important;}';
				}

				// Tags links hover CSS
				if ( '' != $colors['tags_bg_hover'] || '' != $colors['tags_color_hover'] ) {
					$css .= '.cuisine-meta .cm-value a:hover,.cuisine-meta .cm-value a:active{';
					$css .= ( '' != $colors['tags_bg_hover'] ) ? 'background-color:' . $colors['tags_bg_hover'] . ' !important;' : '';
					$css .= ( '' != $colors['tags_color_hover'] ) ? 'color:' . $colors['tags_color_hover'] . ' !important;' : '';
					$css .= '}';
				}
			}
			if ( $css ) {
				echo '<style id="trg_global_css" type="text/css"> ' . $css . '</style>';
			}
		}		
		
		// Init function
		function trg_init() {

			// Translation
			load_plugin_textdomain( 'trg_el', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
			
			if ( ! is_admin() ) {
				wp_enqueue_style( 'trg-plugin-css', plugin_dir_url( __FILE__ ) . 'assets/css/trg_frontend.css', array(), null );

				if ( is_rtl() ) {
					wp_register_style( 'trg-plugin-rtl', plugin_dir_url( __FILE__ ) . 'assets/css/rtl_trg_frontend.css', array(), null );
					wp_enqueue_style( 'trg-plugin-rtl' );
				}

				// JavaScript files
				wp_enqueue_script( 'trg-plugin-functions', plugin_dir_url( __FILE__ ) . 'assets/js/trg_frontend.js', array( 'jquery' ), '', true );

				// Localization
				$social = get_option( 'trg_social' );
				$trg_localization = array(
					'plugins_url' => plugins_url() . '/total-recipe-generator-el',
					'prnt_header' => isset( $social['prnt_header'] ) ? $social['prnt_header'] : '',
					'prnt_footer' => isset( $social['prnt_footer'] ) ?$social['prnt_footer'] : '',
				);
				wp_localize_script('trg-plugin-functions', 'trg_localize', $trg_localization );
			}
		}
	}

	// Create new instance of class
	$total_recipe_generator_el = new Total_Recipe_Generator_El();

} // If not class exists
?>
