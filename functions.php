<?php
/**
 * Orchid Store functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Orchid_Store
 */

$current_theme = wp_get_theme( 'orchid-store-custom' );

define( 'ORCHID_STORE_VERSION', $current_theme->get( 'Version' ) );
define( 'ORCHID_STORE_CUSTOM_ROOT', $current_theme->get_theme_root() . DIRECTORY_SEPARATOR . $current_theme->get_template());

if ( ! function_exists( 'orchid_store_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function orchid_store_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Orchid Store, use a find and replace
		 * to change 'orchid-store' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'orchid-store', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'orchid-store-thumbnail-extra-large', 800, 600, true );
		add_image_size( 'orchid-store-thumbnail-large', 800, 450, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary Menu', 'orchid-store' ),
				'menu-2' => esc_html__( 'Secondary Menu', 'orchid-store' ),
				'menu-3' => esc_html__( 'Top Header Menu', 'orchid-store' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'orchid_store_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 70,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		/**
		 * Remove block widget support in WordPress version 5.8 & later.
		 *
		 * @link https://make.wordpress.org/core/2021/06/29/block-based-widgets-editor-in-wordpress-5-8/
		 */
		remove_theme_support( 'widgets-block-editor' );
	}
endif;
add_action( 'after_setup_theme', 'orchid_store_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function orchid_store_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'orchid_store_content_width', 640 );
}
add_action( 'after_setup_theme', 'orchid_store_content_width', 0 );


/**
 * Enqueue scripts and styles.
 */
function orchid_store_scripts() {

	wp_enqueue_style(
		'orchid-store-style',
		get_stylesheet_uri(),
		array(),
		ORCHID_STORE_VERSION,
		'all'
	);

	wp_enqueue_style(
		'orchid-store-fonts',
		orchid_store_lite_fonts_url(),
		array(),
		ORCHID_STORE_VERSION,
		'all'
	);

	wp_enqueue_style(
		'orchid-store-boxicons',
		get_template_directory_uri() . '/assets/fonts/boxicons/boxicons.css',
		array(),
		ORCHID_STORE_VERSION,
		'all'
	);

	wp_enqueue_style(
		'orchid-store-fontawesome',
		get_template_directory_uri() . '/assets/fonts/fontawesome/fontawesome.css',
		array(),
		ORCHID_STORE_VERSION,
		'all'
	);

	if ( is_rtl() ) {

		wp_enqueue_style(
			'orchid-store-main-style-rtl',
			get_template_directory_uri() . '/assets/dist/css/main-style-rtl.css',
			array(),
			ORCHID_STORE_VERSION,
			'all'
		);

		wp_add_inline_style(
			'orchid-store-main-style-rtl',
			orchid_store_dynamic_style()
		);
	} else {

		wp_enqueue_style(
			'orchid-store-main-style',
			get_template_directory_uri() . '/assets/dist/css/main-style.css',
			array(),
			ORCHID_STORE_VERSION,
			'all'
		);

		wp_add_inline_style(
			'orchid-store-main-style',
			orchid_store_dynamic_style()
		);
	}

	wp_register_script(
		'orchid-store-bundle',
		get_template_directory_uri() . '/assets/dist/js/bundle.min.js',
		array( 'jquery' ),
		ORCHID_STORE_VERSION,
		true
	);

	$script_obj = array(
		'ajax_url'              => esc_url( admin_url( 'admin-ajax.php' ) ),
		'homeUrl'               => esc_url( home_url() ),
		'isUserLoggedIn'        => is_user_logged_in(),
		'isCartMessagesEnabled' => orchid_store_get_option( 'enable_cart_messages' ),
	);

	$script_obj['scroll_top'] = orchid_store_get_option( 'display_scroll_top_button' );

	if ( class_exists( 'WooCommerce' ) ) {

		if ( get_theme_mod( 'orchid_store_field_product_added_to_cart_message', esc_html__( 'Product successfully added to cart!', 'orchid-store' ) ) ) {

			$script_obj['added_to_cart_message'] = get_theme_mod( 'orchid_store_field_product_added_to_cart_message', esc_html__( 'Product successfully added to cart!', 'orchid-store' ) );
		}

		if ( get_theme_mod( 'orchid_store_field_product_removed_from_cart_message', esc_html__( 'Product has been removed from your cart!', 'orchid-store' ) ) ) {

			$script_obj['removed_from_cart_message'] = get_theme_mod( 'orchid_store_field_product_removed_from_cart_message', esc_html__( 'Product has been removed from your cart!', 'orchid-store' ) );
		}

		if ( get_theme_mod( 'orchid_store_field_cart_update_message', esc_html__( 'Cart items has been updated successfully!', 'orchid-store' ) ) ) {

			$script_obj['cart_updated_message'] = get_theme_mod( 'orchid_store_field_cart_update_message', esc_html__( 'Cart items has been updated successfully!', 'orchid-store' ) );
		}

		if ( get_theme_mod( 'orchid_store_field_product_cols_in_mobile', 1 ) ) {
			$script_obj['product_cols_on_mobile'] = get_theme_mod( 'orchid_store_field_product_cols_in_mobile', 1 );
		}

		if ( get_theme_mod( 'orchid_store_field_display_plus_minus_btns', true ) ) {
			$script_obj['displayPlusMinusBtns'] = get_theme_mod( 'orchid_store_field_display_plus_minus_btns', true );
		}

		if ( get_theme_mod( 'orchid_store_field_cart_display', 'default' ) ) {
			$script_obj['cartDisplay'] = ( class_exists( 'Addonify_Floating_Cart' ) ) ? apply_filters( 'orchid_store_cart_display_filter', get_theme_mod( 'orchid_store_field_cart_display', 'default' ) ) : 'default';
		}

		if ( class_exists( 'Addonify_Wishlist' ) ) {
			$script_obj['addToWishlistText']     = get_option( 'addonify_wishlist_btn_label', 'Add to wishlist' );
			$script_obj['addedToWishlistText']   = get_option( 'addonify_wishlist_btn_label_when_added_to_wishlist', 'Added to wishlist' );
			$script_obj['alreadyInWishlistText'] = get_option( 'addonify_wishlist_btn_label_if_added_to_wishlist', 'Already in wishlist' );
		}
	}

	wp_localize_script( 'orchid-store-bundle', 'orchid_store_obj', $script_obj );

	wp_enqueue_script( 'orchid-store-bundle' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'orchid_store_scripts' );


/**
 * Enqueue scripts and styles for admin.
 */
function orchid_store_admin_enqueue() {

	wp_enqueue_script( 'media-upload' );

	wp_enqueue_media();

	wp_enqueue_style(
		'orchid-store-admin-style',
		get_template_directory_uri() . '/admin/css/admin-style.css',
		array(),
		ORCHID_STORE_VERSION,
		'all'
	);

	wp_enqueue_script(
		'orchid-store-admin-script',
		get_template_directory_uri() . '/admin/js/admin-script.js',
		array( 'jquery' ),
		ORCHID_STORE_VERSION,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'orchid_store_admin_enqueue' );
add_action( 'wp_ajax_wp_ajax_install_plugin', 'wp_ajax_install_plugin' );

/**
 * @param $template
 * @return string
 */
function wc_get_template_filter($template) : string
{
    if (!defined("ABSPATH")) {
        return $template;
    }

    $partForOverriding = substr($template, strpos($template, 'woocommerce/') + strlen('woocommerce/'));
    $customTemplatePath = ORCHID_STORE_CUSTOM_ROOT . '/woocommerce/' . $partForOverriding;
    if (!empty($partForOverriding) && file_exists($customTemplatePath)) {
        return $customTemplatePath;
    }
    return $template;
}

/**
 * @param $atts
 * @return string
 */
function get_counter_handler($atts) {
    $attributes = shortcode_atts(
        array(
            'entity' => '',
        ),
        $atts);

    return match ($attributes['entity']) {
        'good' => wp_count_posts( 'product' )->publish,
        'category' => count(get_terms( 'product_cat', ['hide_empty' => 1])),
        default => 0
    };
}

add_shortcode( 'counter', 'get_counter_handler' );

// customize shop filter

//region custom main banner
function main_banner_shortcode($atts) {
    $atts = shortcode_atts([
        'background' => '',
        'text' => 'Default Text',
        'sub_text' => '',
        'button_text' => 'Click Here',
        'button_link' => '#',
        'image_url' => '',
    ], $atts, 'main_banner');

    ob_start();
    get_template_part( 'template-parts/partials/banner', 'main' , $atts);
    return ob_get_clean();
}
add_shortcode('main_banner', 'main_banner_shortcode');
//endregion

function custom_filter_dropdown() {
    $categories = get_terms('product_cat');

	echo '<div class="filter-block">';
	
    if ($categories) {
        echo '<select name="category_filter" id="category_filter" class="select-filter">';
        echo '<option value=""></option>';

        foreach ($categories as $category) {
            echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
        }

        echo '</select>';
    }
	
	echo '</div>';
}

//add_action('woocommerce_before_shop_loop', 'custom_filter_dropdown');

function custom_filter_products() {
    if (isset($_GET['category_filter']) && !empty($_GET['category_filter'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $_GET['category_filter'],
            ),
        );
    }

    return $args;
}

// customize shop filter

/**
 * Activates plugin AFC plugin.
 *
 * @since 1.4.2
 */
function orchid_store_activate_plugin() {

	$return_data = array(
		'success' => false,
		'message' => '',
	);

	if ( isset( $_POST['_ajax_nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_ajax_nonce'] ) ), 'updates' ) ) {
		$return_data['message'] = esc_html__( 'Invalid security token.', 'orchid-store' );
		wp_send_json( $return_data );
	}

	$activation = activate_plugin( WP_PLUGIN_DIR . '/addonify-floating-cart/addonify-floating-cart.php' );

	if ( ! is_wp_error( $activation ) ) {

		$return_data['success'] = true;
		$return_data['message'] = esc_html__( 'The plugin is activated successfully.', 'orchid-store' );
	} else {

		$return_data['message'] = $activation->get_error_message();
	}

	wp_send_json( $return_data );
}
add_action( 'wp_ajax_orchid_store_activate_plugin', 'orchid_store_activate_plugin' );

//region FIELDS FOR CHECKOUT
function checkout_fields($fields) {
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_address_2']);

    $fields['billing']['billing_postcode']['placeholder'] = "XXXXX";
    $fields['billing']['billing_postcode']['required'] = false;
    $fields['billing']['billing_postcode']['label'] = __("Поштовий індекс") . ' <abbr class="required" title="">*</abbr>';

    $fields['billing']['billing_phone']['placeholder'] = "+380YYXXXXXX";
    $fields['billing']['billing_email']['placeholder'] = "username@domain.com";
    $fields['billing']['newPostAddress_field'] = [
        'type' => 'text',
        'required' => false,
        'class' => array('new-post-address form-row-wide'),
        'label' => __('Відділення нової пошти') . ' <abbr class="required" title="">*</abbr>',
        'placeholder' => __('Відділення'),
    ];
    $fields['billing']['billing_address_1']['placeholder'] = __("Місто, вулиця, будинок");
    $fields['billing']['billing_address_1']['label'] = __("Адреса");

    $fields['shipping'] = [];
    return $fields;
}
add_filter('woocommerce_checkout_fields', "checkout_fields");
//endregion

//region MINI CART UPDATE
function orchid_store_mini_cart_action($fragments) {
?>
<div class="mini-cart">
    <button class="trigger-mini-cart">
        <i class='bx bx-cart'></i><sub class="mini-cart-count"><?php echo wp_kses_post( WC()->cart->get_cart_contents_count() ); ?></sub>
    </button><!-- .trigger-mini-cart -->
    <?php
    if ( ! is_cart() && ! is_checkout() ) {
        ?>
        <div class="mini-cart-open">
            <div class="mini-cart-items">
                <?php

                $instance = array( 'title' => '' );

                the_widget( 'WC_Widget_Cart', $instance );
                ?>
            </div><!-- .mini-cart-tems -->
        </div><!-- .mini-cart-open -->
        <?php
        }
    }
    add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {
        ob_start();
        ?>
        <sub class="mini-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></sub>
        <?php
        $fragments['.mini-cart-count'] = ob_get_clean();
        return $fragments;
    });
//endregion

// Validate the custom field during the checkout process
add_action('woocommerce_checkout_process', 'validate_delivery_fields');

function validate_delivery_fields()
{
    $shipping_method = $_POST['shipping_method'][0] ?? null;

    if ($shipping_method === "flat_rate:2") {
        if (empty($_POST['newPostAddress_field'])) {
            wc_add_notice(__("Відділення нової пошти обов'язкове поле"), 'error');
        }
    } elseif ($shipping_method === "flat_rate:3") {
        if (empty($_POST['billing_postcode'])) {
            wc_add_notice(__("Поштовий індекс обов'язкове поле"), 'error');
        }
    }
}

add_action('wp_enqueue_scripts', 'enqueue_custom_script');

function enqueue_custom_script()
{
    wp_enqueue_script('custom-checkout-script', get_template_directory_uri() . '/assets/dist/js/custom-checkout-script.js', array('jquery'), '', true);

    // Pass variables to JavaScript
    wp_localize_script('custom-checkout-script', 'checkout_params', array(
        'delivery_method_selector' => 'input.shipping_method',
    ));
}

//region custom order of checkout fields
function custom_checkout_field_priority($fields) {
    $fields['billing']['billing_first_name']['priority'] = 10;
    $fields['billing']['billing_last_name']['priority'] = 20;
    $fields['billing']['billing_phone']['priority'] = 30;
    $fields['billing']['billing_email']['priority'] = 40;
    $fields['billing']['billing_address_1']['priority'] = 50;
    $fields['billing']['billing_postcode']['priority'] = 60;
    $fields['billing']['newPostAddress_field']['priority'] = 70;
    $fields['order']['order_comments']['priority'] = 900;
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'custom_checkout_field_priority');
//endregion

// Save custom field value to order meta
add_action('woocommerce_checkout_create_order', 'save_custom_checkout_fields');

function save_custom_checkout_fields($order)
{
    if (!empty($_POST['newPostAddress_field'])) {
        $order->update_meta_data('_newPostAddress_field', sanitize_text_field($_POST['newPostAddress_field']));
    }
}

// Display custom field in admin order edit screen
//add_action('woocommerce_admin_order_data_after_billing_address', 'display_custom_field_in_admin');

/**
 * Display field value on the order edit page
 */

add_action( 'woocommerce_admin_order_data_after_shipping_address', 'newPostAddress_checkout_field_display_admin_order_meta', 10, 1 );

function newPostAddress_checkout_field_display_admin_order_meta($order) {

    $newPostInfo = $order->get_meta('_newPostAddress_field');
    $billingPostCode = $order->get_billing_postcode();
    $billingAddress = $order->get_billing_address_1();
    if ($newPostInfo) {
        echo '<p><strong>' . __("Адреса") . ': ' . $billingAddress . ' (' .  __('відділення') . ': ' . esc_html($newPostInfo) . " " . ")" . '</p>';
    } else if($billingPostCode) {
        echo '<p><strong>' .__("Адреса") . ': ' . $billingAddress . ' (' . __('Поштовий індекс') . ': ' . esc_html($billingPostCode) . ")" . '</p>';
    }
}

// Add custom field to the delivery cell in WooCommerce order confirmation email
add_filter('woocommerce_get_order_item_totals', 'add_custom_field_to_delivery_cell', 10, 3);

function add_custom_field_to_delivery_cell($total_rows, $order, $tax_display)
{
    $newPostInfo = $order->get_meta('_newPostAddress_field');
    $billingPostCode = $order->get_billing_postcode();
    $billingAddress = $order->get_billing_address_1();
    if ($newPostInfo) {
        $total_rows['shipping']['value'] .= '<br><small>' . __("Адреса") . ': ' . $billingAddress . ' (' .  __('відділення') . ': ' . esc_html($newPostInfo) . " " . ")</small>";
    } else if($billingPostCode) {
        $total_rows['shipping']['value'] .= '<br><small>' . __("Адреса") . ': ' . $billingAddress . ' (' . __('Поштовий індекс') . ': ' . esc_html($billingPostCode) . ")</small>";
    }
    return $total_rows;
}

// END ADDING CUSTOM FIELD

// ADD CLASS FOR BODY
add_filter( 'body_class','bodyClassBasedOnUrl' );
function bodyClassBasedOnUrl( $classes ) {
    global $wp;
    if (
        str_contains(home_url( $wp->request ), 'privacy-policy')
        ||
        str_contains(home_url( $wp->request ), 'refund_returns')
    ) {
        $classes[] = 'background-clear';
    }
    return $classes;

}

// END ADDING CLASS FOR BODY

// ALLOW ONLY GOOD MENU ITEM FOR MANAGER
function customize_admin_menu() {
    global $menu;
    if (current_user_can('shop_manager')) {
        foreach ($menu as $index => $menu_item) {
            if (!in_array($menu_item[1], ['edit_products', 'upload_files', 'edit_others_shop_orders'])) {
                remove_menu_page($menu_item[2]);
            }
        }
    }
}

add_action('admin_menu', 'customize_admin_menu');
// END ALLOWING ONLY ONE MENU ITEM FOR MANAGER

// DISABLE PAYMENT FOR GOODS
add_filter( 'woocommerce_cart_needs_payment', '__return_false' );
// END DISABLING PAYMENT METHODS

//region SEND EMAIL TO CUSTOMERS
function send_new_product_email($post_id, $post, $update) {

    if ($post->post_type !== 'product' || $update) {
        return;
    }


    $product = wc_get_product($post_id);
    if (!$product) {
        return;
    }

    $product_name = $product->get_name();
    $product_url = get_permalink($post_id);
    $product_price = wc_price($product->get_price());

    ob_start();
    get_template_part( 'template-parts/mail/product', 'new' , [
        'name' => $product->get_name(),
        'url' => get_permalink($post_id),
        'price' => wc_price($product->get_price()),
    ]);
    $emailContent = ob_get_clean();
    $subject = 'New Product Available: ' . $product_name;
    $message = "
        <h2>Exciting News!</h2>
        <p>We've just added a new product to our store: <strong>$product_name</strong>.</p>
        <p>Price: $product_price</p>
        <p><a href='$product_url'>View Product</a></p>
    ";

    $customers = get_users(['role' => 'customer']);
    $emails = [];

    foreach ($customers as $customer) {
        $emails[] = $customer->user_email;
    }

    if (!empty($emails)) {
        $headers = ['Content-Type: text/html; charset=UTF-8'];
        wp_mail($emails, $subject, $message, $headers);
    }
}
//add_action('save_post_product', 'send_new_product_email', 10, 3);
//endregion

//region CUSTOMIZE ALL CATEGORIES BLOCK
add_filter('woocommerce_subcategory_count_html', '__return_empty_string');
$categories = get_categories(array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => false,
));
function enqueue_slick_slider_assets() {
    // Slick Slider CSS
    wp_enqueue_style( 'slick-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css' );
    wp_enqueue_style( 'slick-theme-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css' );

    // Slick Slider JS
    wp_enqueue_script( 'slick-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery'), '', true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_slick_slider_assets' );
//endregion

if ( defined( 'ELEMENTOR_VERSION' ) ) {
	add_action( 'elementor/editor/before_enqueue_scripts', 'orchid_store_admin_enqueue' );
}


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/customizer/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {

	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {

	require get_template_directory() . '/inc/woocommerce.php';

	require get_template_directory() . '/inc/woocommerce-hooks.php';
}

/**
 * Load breadcrumb trails.
 */
require get_template_directory() . '/third-party/breadcrumbs.php';

/**
 * Load TGM plugin activation.
 */
require get_template_directory() . '/third-party/class-tgm-plugin-activation.php';

/**
 * Load plugin recommendations.
 */
require get_template_directory() . '/inc/plugin-recommendation.php';

/**
 * Load custom hooks necessary for theme.
 */
require get_template_directory() . '/inc/custom-hooks.php';

/**
 * Load custom hooks necessary for theme.
 */
require get_template_directory() . '/inc/udp/init.php';


/**
 * Load function that enhance theme functionality.
 */
require get_template_directory() . '/inc/theme-functions.php';


/**
 * Load option choices.
 */
require get_template_directory() . '/inc/option-choices.php';


/**
 * Load widgets and widget areas.
 */
require get_template_directory() . '/widget/widgets-init.php';


/**
 * Load custom fields.
 */
require get_template_directory() . '/inc/custom-fields.php';

/**
 * Load theme dependecies
 */
require get_template_directory() . '/vendor/autoload.php';
