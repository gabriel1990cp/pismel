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
 * Header Logo static.
 */
class cherry_header_logo_static extends cherry_register_static {

	/**
	 * Callback-method for registered static.
	 *
	 * @since 4.0.1
	 */
	
	public function callback() {
		global $wp_version;

		$title = '';
		$mobDisplay = '';
		$xsVisibilityVar = 'col-xs-6';
 		$xsValueVar = '0';
 		$xsFullValue = '12';
 		$hiddenLogo = '';

		if (cherry_get_option( "logo-on-off" )) {
			$mobDisplay = cherry_get_option( "logo-on-off" );
		}

		if( !is_front_page() && !is_singular( 'post' ) && !is_home() ) {
			if (version_compare($wp_version, '4.4', '>=')) {
				// Get site title
				$title = wp_get_document_title();
				// Remove site name
				$title = str_replace(' &#8211; '.get_bloginfo('name'), '', $title);
			} else {
				$title = get_the_title();
			}
		} else if (is_singular( 'post' ) || is_home() && !is_front_page()) {
 			$title = get_the_title( get_option( 'page_for_posts' ) );
 		}

 		if ($mobDisplay == 'false' && !is_front_page()) {
 			$xsVisibilityVar = 'hidden-xs';
 			$xsValueVar = '6';
 			$xsFullValue = '6';
 			$hiddenLogo = 'hidden-logo';
 		} 

 		echo '<div class="row '.$hiddenLogo.'">';

			printf( '<div class="'.$xsVisibilityVar.' col-sm-2 col-md-2 col-lg-2 site-logo-wrap"><div class="site-branding">%1$s %2$s</div></div>',
				cherry_get_site_logo( 'header' ),
				cherry_get_site_description()
			);

			echo '<div class="col-xs-6 col-sm-2 col-md-2 col-lg-2 col-xs-push-'.$xsValueVar.' col-sm-push-8 col-md-push-8 col-lg-push-8 site-hamburger">
					<a href="#" id="hamburger-btn"><div class="hamburger"><div class="lines"></div></div></a>
				  </div>';

			echo '<div class="col-xs-'.$xsFullValue.' col-sm-8 col-md-8 col-lg-8 col-xs-pull-'.$xsValueVar.' col-sm-pull-2 col-md-pull-2 col-lg-pull-2 site-title-inner">
					<h1 class="page-title">'.$title.'</h1>
				  </div>';

		echo '</div>';

		/*echo '<div class="row">';

			printf( '<div class="col-xs-0 col-sm-6 col-md-2 col-lg-2 site-logo-wrap"><div class="site-branding">%1$s %2$s</div></div>',
				cherry_get_site_logo( 'header' ),
				cherry_get_site_description()
			);

			echo '<div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 col-xs-push-0 col-sm-push-0 col-md-push-8 col-lg-push-8 site-hamburger">
					<a href="#" id="hamburger-btn"><div class="hamburger"><div class="lines"></div></div></a>
				  </div>';

			echo '<div class="col-xs-6 col-sm-12 col-md-8 col-lg-8 col-xs-pull-0 col-sm-pull-0 col-md-pull-2 col-lg-pull-2 site-title-inner">
					<h1 class="page-title">'.$title.'</h1>
				  </div>';

		echo '</div>';*/
	}
}

/**
 * Registration for Header Logo static.
 */
new cherry_header_logo_static(
	array(
		'id'      => 'header_logo',
		'name'    => __( 'Logo', 'child-theme-domain' ),
		'options' => array(
			'col-xs'   => 'col-xs-12',
			'col-sm'   => 'col-sm-12',
			'col-md'   => 'col-md-6',
			'col-lg'   => 'col-lg-6',
			'position' => 1,
			'area'     => 'header-top',
		)
	)
);