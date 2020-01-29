<?php
/**
 * Menus.
 *
 * @package %%PACKAGENAME%%
 */

namespace %%VARPREFIX%%\theme;

/**
 * Menus.
 */
class Menus extends %%CLASSNAME%% {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {

	}

	/**
	 * Initialize menu locations.
	 *
	 * @return void
	 */
	public function intialize() {

		$this->register_nav_menus();
	}

	/**
	 * Primary navigation.
	 *
	 * @return void
	 */
	private register_nav_menus() {

		register_nav_menus(
			array(
				'primary-nav' => esc_html__( 'Primary Navigation', '%%TEXTDOMAIN%%' ),
			)
		);
	}
}
