<?php
/**
 * Plugin Name: Donation Meta
 * Plugin URI: http://www.swarmstrategies.com/WPDonationMeta
 * Text Domain: WPDonationMeta
 * Description: A WordPress plugin to catch additional donor info fields before sending donors along to PayPal
 * Author: Matt Parrott
 * Author URI: http://www.swarmstrategies.com/matt
 * Donate URI: http://www.swarmstrategies.com/
 * Version: 0.1.1
 * Last change: 06.19.2012
 * Licence: GPL2
*/

/**
License:
==============================================================================
Copyright 2011 Matt Parrott  (email : matt@swarmstrategies.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

Requirements:
==============================================================================
This plugin requires WordPress >= 3.2 and tested with PHP Interpreter >= 5.3.1
*/

define('WPDonationMeta', '0.1.1');
define('WPDonationMeta_PLUGIN_URL', plugin_dir_url( __FILE__ ));

class WPDonationMeta {

	public function __construct() {

		add_filter('the_content', array(&$this, 'donation_button'));

		/* Colorbox */
		wp_enqueue_script('jquery');
		wp_register_style('colorbox_css', constant('WPDonationMeta_PLUGIN_URL') . '/css/colorbox.css');
		wp_enqueue_style('colorbox_css');
		wp_register_script('colorbox', constant('WPDonationMeta_PLUGIN_URL') . '/js/jquery.colorbox-min.js', array('jquery'));
		wp_enqueue_script('colorbox');
	}

	public function donation_button($content = '') {
		$donation_button  = "<a id='WPDonationMeta-donation-link' href='".constant('WPDonationMeta_PLUGIN_URL')."DonatePopUp.php'>";
		$donation_button .= "<img src='".constant('WPDonationMeta_PLUGIN_URL')."images/donation_button.png'";
		$donation_button .= "alt='Donate now with PayPal...' title='Donate now with PayPal...' />";
		$donation_button .= "</a>";
		return preg_replace("/\[donation_button\]/", $donation_button, $content);
	}
}

$wp_donation_meta = new WPDonationMeta();
