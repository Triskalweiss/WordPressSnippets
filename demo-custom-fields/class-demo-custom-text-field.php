<?php
namespace JansenMorin\DemoCustomFields;

class DemoCustomTextField {
    public string $display_title;
    public string $meta_key;
    public string $nonce_action;
    public string $nonce_key;
    public string $input_key;

    public function __construct () {
        $this->display_title = 'Demo Custom Field';
        $this->meta_key = 'demo-post-meta';
        $this->nonce_action = 'update-' . $this->meta_key;
        $this->nonce_key = 'update-' . $this->meta_key . '-nonce';
        $this->input_key = $this->meta_key. '-input';
    }

    public function init () {
        add_action( 'add_meta_boxes', [ $this, 'add_meta_box' ] );
        add_action( 'save_post', [ $this, 'save_meta_box' ] );
    }

    public function add_meta_box () {
        add_meta_box( $this->meta_key, $this->display_title, [ $this, 'display_meta_box' ], 'post', 'advanced', 'default', null );
    }
    
    public function display_meta_box ( $post ) {
        $demo_post_meta = get_post_meta( $post->ID, $this->meta_key, true );

        ob_start();
        ?>
    
        <input id="<?php esc_attr_e( $this->input_key, 'demo-custom-fields' ) ?>" type="text" name="<?php esc_attr_e( $this->input_key, 'demo-custom-fields' ) ?>" value="<?php esc_html_e( $demo_post_meta, 'demo-custom-fields' ) ?>">
        <?php wp_nonce_field( $this->nonce_action,  $this->nonce_key ); ?>
    
        <?php
        echo ob_get_clean();
    }

    public function save_meta_box ( $post_id ) {
        if ( ! isset( $_REQUEST[ $this->nonce_key ] ) || ! wp_verify_nonce( $_REQUEST[ $this->nonce_key ], $this->nonce_action ) ) {
            return;
        }
    
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
            return;
        }
    
        if ( isset( $_REQUEST[ $this->input_key ] )) {
            $demo_post_meta_input = sanitize_text_field( $_REQUEST[ $this->input_key ] );
            update_post_meta( $post_id, $this->meta_key, $demo_post_meta_input );
        }
    }
}