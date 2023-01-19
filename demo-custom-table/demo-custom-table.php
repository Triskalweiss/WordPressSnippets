<?php
/*
 * Plugin Name:       Demo Custom Table
 * Description:       Custom table demonstration.
 * Author:            Jansen Morin
 * Text Domain:       demo-custom-field
*/

namespace JansenMorin\DemoCustomTable;

require_once plugin_dir_path( __FILE__ ) . 'classes/class-database-handler.php';
require_once plugin_dir_path( __FILE__ ) . 'classes/class-item-list-shortcode.php';

$database_handler = new DatabaseHandler();
register_activation_hook( __FILE__, [ $database_handler, 'install' ] );

$item_list_shortcode = new ItemListShortcode();
$item_list_shortcode->init();