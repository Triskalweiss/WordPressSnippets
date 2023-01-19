<?php

namespace JansenMorin\DemoCustomTable;

require_once plugin_dir_path( __FILE__ ) . 'class-demo-item-handler.php';
require_once plugin_dir_path( __FILE__ ) . 'class-demo-item.php';

class ItemListShortcode {
    public $shortcode_name;
    public $add_nonce_action;
    public $add_nonce_key;
    public $delete_nonce_action;
    public $delete_nonce_key;
    
    public function __construct() {
        $this->shortcode_name = "demo-table-item-list";
        $this->add_nonce_key = 'demo-add-list-item-nonce';
        $this->add_nonce_action = 'demo-add-list-item';
        $this->delete_nonce_key = 'demo-delete-list-item-nonce';
        $this->delete_nonce_action = 'demo-delete-list-item';
    }

    public function init() {
        add_shortcode( $this->shortcode_name, [ $this, 'display' ] );
    }

    public function display() {
        $demo_item_handler = new DemoItemHandler();

        if ( isset( $_REQUEST['delete-item'] ) ) {
            $item_delete_nonce_key = $this->delete_nonce_key . '-' . $_REQUEST['delete-item'];
            $item_delete_nonce_action = $this->delete_nonce_action . '-' . $_REQUEST['delete-item'];

            if (
                isset( $_REQUEST[ $item_delete_nonce_key ] ) &&
                1 == wp_verify_nonce( $_REQUEST[ $item_delete_nonce_key ], $item_delete_nonce_action )
            ) {
                $delete_item_id = sanitize_text_field( $_REQUEST['delete-item'] );
                $demo_item_handler->delete( $delete_item_id );
            }
        }

        if ( isset( $_REQUEST['item-name'] ) && 1 == wp_verify_nonce( $_REQUEST[ $this->add_nonce_key ], $this->add_nonce_action ) ) {
            $item_name = sanitize_text_field( $_REQUEST['item-name'] );

            $new_item = new DemoItem(
                array(
                    'name' => $item_name,
                    'date_created' => wp_date( "Y-m-d H:i:s" )
                )
            );

            $demo_item_handler->add( $new_item );
        }
        
        $items = $demo_item_handler->get();
        
        ob_start();
        ?>
            <h3>Item List</h3>
            <?php if ( ! empty( $items ) ) : ?>
                <?php foreach ( $items as $item ) : ?>
                    <?php
                        $item_delete_nonce_key = $this->delete_nonce_key . '-' . $item['id'];
                        $item_delete_nonce_action = $this->delete_nonce_action . '-' . $item['id'];    
                    ?>
                    <p><?php esc_html_e( $item[ 'name' ] ); ?></p>
                    <form action="" method="post" name="<?php esc_attr_e( "delete-" . $item['id'] ); ?>">
                        <input type="hidden" name="delete-item" value="<?php esc_attr_e( $item['id'] ); ?>">
                        <?php wp_nonce_field( $item_delete_nonce_action,  $item_delete_nonce_key ); ?>
                        <input type="submit" value="Delete">
                    </form>
                <?php endforeach; ?>
                <?php else : ?>
                    <p>No Items</p>
            <?php endif; ?>
            
            <h4>Create New Item</h4>
            <form action="" method="post">
                <input type="text" name="item-name">
                <?php wp_nonce_field( $this->add_nonce_action,  $this->add_nonce_key ); ?>
                <input type="submit" value="Create New Item">
            </form>
        <?php
        return ob_get_clean();
    }

}