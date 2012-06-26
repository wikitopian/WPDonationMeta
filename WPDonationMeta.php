<?php

/**
 * Plugin Name: Donation Meta
 * Plugin URI: http://www.swarmstrategies.com/WPDonationMeta
 * Text Domain: WPDonationMeta
 * Description: A WordPress plugin to catch additional donor info fields before sending donors along to PayPal.
 * Author: Matt Parrott / ah
 * Author URI: http://www.swarmstrategies.com/matt
 * Donate URI: http://www.swarmstrategies.com/
 * Version: 0.1.2
 * Last change: 06.23.2012
 * Licence: GPL2
 */

/**
 * License:
 * **************************************************************************
 * Copyright 2011 Matt Parrott  (email : matt@swarmstrategies.com)
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 * 
 * Requirements:
 * ***************************************************************************
 * This plugin requires WordPress >= 3.2, tested with PHP Interpreter >= 5.3.1
 */

if (!class_exists('WPDonationMeta')):

define('WPDonationMeta', '0.1.1');
define('WPDonationMeta_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define('WPDonationMeta_EmailSubject', 'WPDonationMeta Successful on ' . get_option('blogname'));

class WPDonationMeta {

    // Instantiate the class
	function __construct() {

        global $pagenow;
        
        if ($pagenow == 'plugins.php') {
            register_activation_hook( __FILE__, array($this, 'wpdm_activation_hook' ));
        } else {
            if (isset($_POST['wpdm_submit'])) {
                wpdm_submit();
            } else {
                add_action('wp_enqueue_scripts', 'wpdm_jquery');
                add_action('wp_enqueue_scripts', 'wpdm_colorbox');
                add_action('wp_enqueue_scripts', 'wpdm_colorbox_css');
                add_filter('the_content', array(&$this, 'wpdm_generate'));
            }
        }

		/* Colorbox
		// wp_enqueue_script('jquery');
		// wp_register_style('colorbox_css', constant('WPDonationMeta_PLUGIN_URL') . '/css/colorbox.css');
		// wp_enqueue_style('colorbox_css');
		// wp_register_script('colorbox', constant('WPDonationMeta_PLUGIN_URL') . '/js/jquery.colorbox-min.js', array('jquery'));
		// wp_enqueue_script('colorbox');
        //
        // Changed to uninstall hook
        // register_deactivation_hook( __FILE__, array($this, 'wpdm_deactivation_hook' ));
        ** This section can be deleted **
         */

        function wpdm_jquery() {
            // Respects SSL, Style.css is relative to the current file
            wp_register_script( 'jquery', plugins_url(constant('WPDonationMeta_PLUGIN_URL') . '/js/jquery.css'));
            wp_enqueue_script( 'jquery' );
        }


        function wpdm_colorbox() {
            // Respects SSL, Style.css is relative to the current file
            wp_register_script( 'colorbox', plugins_url(constant('WPDonationMeta_PLUGIN_URL') . '/js/jquery.colorbox-min.css', array('jquery')));
            wp_enqueue_script( 'colorbox' );
        }


        function wpdm_colorbox_css() {
            // Respects SSL, Style.css is relative to the current file
            wp_register_style( 'colorbox_css', plugins_url(constant('WPDonationMeta_PLUGIN_URL') . '/css/colorbox.css', __FILE__) );
            wp_enqueue_style( 'colorbox_css' );
        }


	}

    // Create database table upon plug-in activation if it does not exist
    function wpdm_activation_hook() {

        global $wpdb;
        $table = $wpdb->prefix . 'wpdm';

        $query = 'CREATE TABLE IF NOT EXISTS ' . $table . '('
              . 'id int(11) unsigned NOT NULL AUTO_INCREMENT,'
              . 'name_full tinytext COLLATE utf8_unicode_ci NOT NULL,'
              . 'address text COLLATE utf8_unicode_ci NOT NULL,'
              . 'city tinytext COLLATE utf8_unicode_ci NOT NULL,'
              . 'state tinytext COLLATE utf8_unicode_ci NOT NULL,'
              . 'zip tinyint(5) unsigned NOT NULL,'
              . 'phone varchar(10) COLLATE utf8_unicode_ci NOT NULL,'
              . 'occupation tinytext COLLATE utf8_unicode_ci NOT NULL,'
              . 'contribution int(4) unsigned NOT NULL,'
              . 'memo text COLLATE utf8_unicode_ci NOT NULL,'
              . 'result tinyint(1) unsigned NOT NULL,'
              . 'stamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,'
              . 'ip varchar(15) COLLATE utf8_unicode_ci NOT NULL,'
              . 'PRIMARY KEY (id)'
              . ') ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1' 
            . ';';
        $query = $wpdb->escape($query);
        $result = $wpdb->query($query);

              /*
              . 'sign tinyint(1) unsigned NOT NULL,'
              . 'knocker tinyint(1) unsigned NOT NULL,'
              . 'caller tinyint(1) unsigned NOT NULL,'
              . 'eventhost tinyint(1) unsigned NOT NULL,'
              . 'other text COLLATE utf8_unicode_ci NOT NULL,'
              ** Extra fields have been removed, this section can be deleted
               */
    }

    // Process form submission
    function wpmd_submit() {

        global $wpdb;
        $table = $wpdb->prefix . 'wpdm';
        
        $wpdm_data = array(
            'name_full' => $_POST['wpdm_name_full'],
            'address' => $_POST['wpdm_address'],
            'city' => $_POST['wpdm_city'],
            'state' => $_POST['wpdm_state'],
            'zip' => $_POST['wpdm_zip'],
            'occupation' => $_POST['wpdm_occupation'],
            'telephone' => $_POST['wpdm_telephone'],
            'contribution' => $_POST['amount'],
            'memo' => $_POST['memo']
        );

        if ($_GET['wpdm_paypal_success'] == true) {
            array_push($wpdm_data, array('result' => 1));
            $recip = get_option('admin_email'); 
            $subj = WPDonationMeta_EmailSubject;
            $body = '';
            foreach ($wpdm_data as $k => $v) {
                $body .= $k . ': ' . $v . "\n";
            }
            mail ($recip, $subj, $body);
            include(WPDonationMeta_PLUGIN_URL . 'success.php');
        } else {
            include(WPDonationMeta_PLUGIN_URL . 'failure.php');
        }

        array_push($wpdm_data, array('ip' => $_SERVER['REMOTE_ADDR']));
        $wpdb->insert($table, $data);
        $id_insert = $wpdb->insert_id;

    }

    // Generate donation button
	function wpdm_generate($content = '') {
        // This should be a js link that opens up colorbox probably?
		$donation_button  = "<a id='WPDonationMeta-donation-link' href='".constant('WPDonationMeta_PLUGIN_URL')."DonatePopUp.php'>";
		$donation_button .= "<img src='".constant('WPDonationMeta_PLUGIN_URL')."images/donation_button.png'";
		$donation_button .= "alt='Donate now with PayPal...' title='Donate now with PayPal...' />";
		$donation_button .= "</a>";
		return preg_replace("/\[wpdm_generate\]/", $donation_button, $content);
	}


}

$wpdm = new WPDonationMeta();

endif;
