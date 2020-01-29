<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package _s
 */

namespace %%VARPREFIX%%\theme;

class WooCommerce extends %%CLASSNAME%% {

	public function initialize() {

		$this->setup();

		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

		/**
		 * Disable the default WooCommerce stylesheet.
		 *
		 * Removing the default WooCommerce stylesheet and enqueing your own will
		 * protect you during WooCommerce core updates.
		 *
		 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
		 */
		add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

		add_filter( 'body_class', array( $this, 'active_body_class' ) );
		add_filter( 'loop_shop_per_page', array( $this, 'products_per_page' ) );
		add_filter( 'woocommerce_product_thumbnails_columns', array( $this, 'thumbnail_columns' ) );
		add_filter( 'loop_shop_columns', array( $this, 'loop_columns' ) );
		add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ) );

		add_action( 'woocommerce_before_shop_loop', array( $this, 'product_columns_wrapper' ), 40 );
		add_action( 'woocommerce_after_shop_loop', array( $this, 'product_columns_wrapper_close' ), 40 );

		/**
		 * Remove default WooCommerce wrapper.
		 */
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

		add_action( 'woocommerce_before_main_content', array( $this, 'wrapper_before' ) );
		add_action( 'woocommerce_after_main_content', array( $this, 'wrapper_after' ) );

		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'cart_link_fragment' ) );
	}

	/**
	 * WooCommerce setup function.
	 *
	 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
	 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
	 *
	 * @return void
	 */
	public function setup() {
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}

	/**
	 * WooCommerce specific scripts & stylesheets.
	 *
	 * @return void
	 */
	public function scripts() {
		wp_enqueue_style( '_s-woocommerce-style', get_template_directory_uri() . '/woocommerce.css' );

		$font_path   = WC()->plugin_url() . '/assets/fonts/';
		$inline_font = '@font-face {
				font-family: "star";
				src: url("' . $font_path . 'star.eot");
				src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
					url("' . $font_path . 'star.woff") format("woff"),
					url("' . $font_path . 'star.ttf") format("truetype"),
					url("' . $font_path . 'star.svg#star") format("svg");
				font-weight: normal;
				font-style: normal;
			}';

		wp_add_inline_style( '_s-woocommerce-style', $inline_font );
	}

	/**
	 * Add 'woocommerce-active' class to the body tag.
	 *
	 * @param  array $classes CSS classes applied to the body tag.
	 * @return array $classes modified to include 'woocommerce-active' class.
	 */
	public function active_body_class( $classes ) {
		$classes[] = 'woocommerce-active';

		return $classes;
	}

	/**
	 * Products per page.
	 *
	 * @return integer number of products.
	 */
	public function products_per_page() {
		return 12;
	}

	/**
	 * Product gallery thumnbail columns.
	 *
	 * @return integer number of columns.
	 */
	public function thumbnail_columns() {
		return 4;
	}

	/**
	 * Default loop columns on product archives.
	 *
	 * @return integer products per row.
	 */
	public function loop_columns() {
		return 3;
	}

	/**
	 * Related Products Args.
	 *
	 * @param array $args related products args.
	 * @return array $args related products args.
	 */
	public function related_products_args( $args ) {
		$defaults = array(
			'posts_per_page' => 3,
			'columns'        => 3,
		);

		$args = wp_parse_args( $defaults, $args );

		return $args;
	}

	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	public function product_columns_wrapper() {
		$columns = $this->loop_columns();
		echo '<div class="columns-' . absint( $columns ) . '">';
	}

	/**
	 * Product columns wrapper close.
	 *
	 * @return  void
	 */
	public function product_columns_wrapper_close() {
		echo '</div>';
	}

	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	public function wrapper_before() {
		?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
			<?php
	}

	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	public function wrapper_after() {
			?>
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php
	}

	/**
	 * Sample implementation of the WooCommerce Mini Cart.
	 *
	 * You can add the WooCommerce Mini Cart to header.php like so ...
	 *
		<?php
			if ( function_exists( '\\%%VARPREFIX%%\\theme\\WooCommerce::header_cart' ) ) {
				\%%VARPREFIX%%\theme\WooCommerce::header_cart();
			}
		?>
	 */

	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	public function cart_link_fragment( $fragments ) {
		ob_start();
		$this->cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}

	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	public function cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', '_s' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), '_s' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}

	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	public function header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php \%%VARPREFIX%%\theme\WooCommerce::cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}
