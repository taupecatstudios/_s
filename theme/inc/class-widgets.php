<?php
/**
 * Widget areas.
 *
 * @package %%PACKAGENAME%%
 */

namespace %%VARPREFIX%%\theme;

class Widgets extends %%CLASSNAME%% {

	/**
	 * Default widget area arguments.
	 *
	 * @var array
	 */
	private $this->default_args;

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {

		$this->default_args = array(
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		);
	}

	/**
	 * Initialize.
	 *
	 * @return void
	 */
	public function initialize() {

		add_action( 'widgets_init', array( $this, 'register_widget_areas' ) );
	}

	/**
	 * Register widget areas.
	 *
	 * @return void
	 */
	public function register_widget_areas() {

		$this->sidebar();
	}

	/**
	 * Default "Sidebar" widget area.
	 *
	 * @return void
	 */
	private function sidebar() {

		$args = array_merge(
			$this->default_args,
			array(
				'name'          => esc_html__( 'Sidebar', '_s' ),
				'id'            => 'sidebar-1',
				'description'   => esc_html__( 'Add widgets here.', '_s' ),
			)
		);

		register_sidebar( $args );
	}
}
