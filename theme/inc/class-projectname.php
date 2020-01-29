<?php
/**
 * Master %%THEMENAME%% class loader.
 *
 * @package %%PACKAGENAME%%
 */

namespace %%VARPREFIX%%\theme;

/**
 * Master %%THEMENAME%% class to activate all the specialized classes.
 */
class %%CLASSNAME%% {

	/**
	 * Project name.
	 *
	 * @var string
	 */
	protected $project_name = '%%PROJECT%%';

	/**
	 * Template directory.
	 *
	 * @var string
	 */
	protected $template_directory;

	/**
	 * Template directory URI.
	 *
	 * @var string
	 */
	protected $template_directory_uri;

	/**
	 * Template "includes" directory.
	 *
	 * @var string
	 */
	protected $template_directory_inc;

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {

		$this->template_directory     = trailingslashit( get_template_directory() );
		$this->template_directory_uri = trailingslashit( get_template_directory_uri() );
		$this->template_directory_inc = trailingslashit( $this->template_directory . 'inc' );
	}

	/**
	 * Initialize the theme with all the required actions, filters, etc.
	 *
	 * @return void
	 */
	public function initialize() {

		add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );
	}

	/**
	 * Set up the theme.
	 *
	 * @return void
	 */
	public function after_setup_theme() {

		// Actions.
		$this->actions();

		// Filters.
		$this->filters();

		// Menus.
		$this->menus();

		// Widgets.
		$this->widgets();

		// Template functions.
		$this->template_functions();

		// Template tags.
		$this->template_tags();

		// Customizer.
		$this->customizer();

		// Jetpack.
		$this->jetpack();

		// WooCommerce.
		$this->woocommerce();
	}

	/**
	 * Actions.
	 *
	 * @return void
	 */
	private function actions() {

		require_once $this->template_directory_inc . 'class-actions.php';

		( new Actions() )->initialize();
	}

	/**
	 * Filters.
	 *
	 * @return void
	 */
	private function filters() {

		require_once $this->template_directory_inc . 'class-filters.php';

		( new Filters() )->initialize();
	}

	/**
	 * Menus.
	 *
	 * @return void
	 */
	private function menus() {

		require_once $this->template_directory_inc . 'class-menus.php';

		( new Menus() )->initialize();
	}

	/**
	 * Widgets.
	 *
	 * @return void
	 */
	private function widgets() {

		require_once $this->template_directory_inc . 'class-widgets.php';

		( new Widgets() )->initialize();
	}

	/**
	 * Template functions.
	 *
	 * @return void
	 */
	private function template_functions() {

		require_once $this->template_directory_inc . 'template-functions.php';
	}

	/**
	 * Template tags.
	 *
	 * @return void
	 */
	private function template_tags() {

		require_once $this->template_directory_inc . 'template-tags.php';
	}

	/**
	 * Customizer.
	 *
	 * @return void
	 */
	private function customizer() {

		require_once $this->template_directory_inc . 'class-customizer.php';

		( new Customizer() )->initialize();
	}

	/**
	 * Jetpack.
	 *
	 * @return void
	 */
	private function jetpack() {

		/**
		 * Load Jetpack compatibility file.
		 */
		if ( defined( 'JETPACK__VERSION' ) ) {

			require $this->template_directory_inc . 'class-jetpack.php';

			( new Jetpack() )->initialize();
		}
	}

	/**
	 * WooCommerce.
	 *
	 * @return void
	 */
	private function woocommerce() {

		/**
		 * Load WooCommerce compatibility file.
		 */
		if ( class_exists( 'WooCommerce' ) ) {

			require $this->template_directory_inc . 'class-woocommerce.php';

			( new WooCommerce() )->initialize();
		}
	}
}
