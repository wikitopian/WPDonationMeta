<?php

if (!defined( 'WP_UNINSTALL_PLUGIN'))
    exit ();

// Remove table
global $wpdb;
$table = $wpdb->prefix . 'wpdm';
$query = 'drop table ' . $table . ';';
$result = $wpdb->query($query);

?>
