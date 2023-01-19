<?php
/*
 * Plugin Name:       Demo Custom Fields
 * Description:       Custom field demonstration.
 * Author:            Jansen Morin
 * Text Domain:       demo-custom-fields
*/

namespace JansenMorin\DemoCustomFields;

require_once( plugin_dir_path( __FILE__ ) . 'class-demo-custom-text-field.php' );

$demo_custom_select_field = new DemoCustomTextField();
$demo_custom_select_field->init();