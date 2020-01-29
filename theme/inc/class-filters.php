<?php
/**
 * Filters.
 *
 * @package %%PACKAGENAME%%
 */

namespace %%VARPREFIX%%\theme;

/**
 * Filters.
 */
class Filters extends %%CLASSNAME%% {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {

	}

	/**
	 * Initialize.
	 *
	 * @return void
	 */
	public function intialize() {

		add_filter( 'body_class', array( $this, 'body_classes' ) );
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * 
	 * @return array
	 */
	public function body_classes( $classes ) {

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		// Adds a class of no-sidebar when there is no sidebar present.
		if ( ! is_active_sidebar( 'sidebar-1' ) ) {
			$classes[] = 'no-sidebar';
		}

		return $classes;
	}
}
