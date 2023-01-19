<?php

namespace JansenMorin\DemoCustomTable;

class DatabaseHandler {
    public $database_version;
    public $database_version_option_key;

    public function __construct () {
        $this->database_version = '1.0.0';
        $this->database_version_option_key = 'demo-custom-table-db-version';
    }

    public function install () {
        $current_database_version = get_option( $this->database_version_option_key, '0.0.0' );

        if ( version_compare( $current_database_version, $this->database_version ) < 0 ) {
            $this->create_table();
        }
    }

    public function create_table () {
        global $wpdb;
        
        $table_name = $wpdb->prefix . "demo_items";
        $charset_collate = $wpdb->get_charset_collate();

        $sql_query = "CREATE TABLE {$table_name} (
            id int NOT NULL AUTO_INCREMENT,
            date_created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            name tinytext NOT NULL,
            PRIMARY KEY  (id)
            ) $charset_collate;";
    

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        dbDelta( $sql_query );
        
        update_option( $this->database_version_option_key, $this->database_version );
    }
}