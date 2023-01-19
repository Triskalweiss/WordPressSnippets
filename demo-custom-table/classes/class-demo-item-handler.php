<?php

namespace JansenMorin\DemoCustomTable;

class DemoItemHandler {
    public $table_name;

    public function __construct () {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'demo_items';
    }

    public function get () {
        global $wpdb;

        $sql_query = $wpdb->prepare( "SELECT * FROM `{$this->table_name}`" );
        $results = $wpdb->get_results( $sql_query, ARRAY_A );

        if ( ! empty( $results ) ) {
            return $results;
        }

        return null;
    }

    public function add ( $item ) {
        global $wpdb;

        if ( ! empty( $item ) ) {
            $wpdb->insert(
                $this->table_name,
                array(
                    'date_created' => $item->date_created,
                    'name' => $item->name
                ),
                array(
                    '%s',
                    '%s'
                )
            );
        }

        if ( false !== $wpdb->insert_id ) {
            return $wpdb->insert_id;
        }

        return false;
    }

    public function delete ( $item_id ) {
        global $wpdb;

        $result = $wpdb->delete(
            $this->table_name,
            array(
                'id' =>
                $item_id
            ),
            array(
                '%d'
            )
        );

        if ( false !== $result ) {
            return true;
        }

        return false;
    }
}