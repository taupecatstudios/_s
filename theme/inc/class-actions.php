<?php
/**
 * Actions.
 *
 * @package %%PACKAGENAME%%
 */

namespace %%VARPREFIX%%\theme;

/**
 * Action hooks.
 */
class Actions extends %%CLASSNAME%% {

	/**
	 * CSS cache-busting timestamp.
	 *
	 * @var integer
	 */
	private $css_cachebust = 0;

	/**
	 * JS cache-busting timestamp.
	 *
	 * @var integer
	 */
	private $js_cachebust = 0;

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {

		$this->css_cachebust = filemtime( $this->template_directory . 'css/' . $this->project_name . '.min.css' );
		$this->js_cachebust  = filemtime( $this->template_directory . 'js/' . $this->project_name . '.min.js' );
	}

	/**
	 * Initialize action calls.
	 *
	 * @return void
	 */
	public function initialize() {

		$this->after_setup_theme();

		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'wp_head', array( $this, 'pingback_header' ) );
	}

	/**
	 * Setup.
	 *
	 * @return void
	 */
	public function after_setup_theme() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on _s, use a find and replace
		 * to change '_s' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( '%%TEXTDOMAIN%%', $this->template_directory . 'languages' );

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

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}

	/**
	 * Styles.
	 *
	 * @return void
	 */
	public function styles() {

		$dependencies    = array();
		$main_stylesheet = $this->project_name . '-style';

		wp_register_style(
			$main_stylesheet,
			$this->template_directory_uri . 'css/' . $this->project_name . '.min.css',
			$dependencies,
			$this->css_cachebust
		);

		wp_enqueue_style( $main_stylesheet );
	}

	/**
	 * Scripts.
	 *
	 * @return void
	 */
	public function scripts() {

		$dependencies    = array();
		$main_javascript = $this->project_name . '-script';

		wp_register_style(
			$main_javascript,
			$this->template_directory_uri . 'js/' . $this->project_name . '.min.js',
			$dependencies,
			$this->js_cachebust,
			true
		);

		wp_enqueue_style( $main_javascript );
	}

	/**
	 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
	 */
	public function pingback_header() {

		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}
}
