<?php
/**
 * @package    Cherry_Framework
 * @subpackage Class
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Footer Sidebar-N static.
 */
class cherry_footer_sidebar_static_4 extends cherry_register_static {

	/**
	 * Callback-method for registered static.
	 * @since 4.0.0
	 */
	public function callback() {
		cherry_get_sidebar( "sidebar-footer-4" );
	}
}

/**
 * Registration for Footer Sidebar-4 static.
 */
new cherry_footer_sidebar_static_4(
	array(
		'name'    => __( 'Call To Action', 'child-theme-domain' ),
		'id'      => 'footer_sidebar_4',
		'options' => array(
			'position' => 1,
			'area'     => 'footer-top',
		)
	)
);