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
Copyright 2011 Matt Parrott  (email : parrott.matt@gmail.com)

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

	}
}

$wp_donation_meta = new WPDonationMeta();
