<?php
/**
 * The file register assets for the plugin
 *
 * @package wpcd_coupon
 */

/**
 * Handle plugin assets
 */
class WPCD_Block_Assets {

     public function __construct() {
          add_action( 'wp_enqueue_scripts', array( $this, 'register_frontend_assets' ) );
          add_action( 'enqueue_block_assets', array( $this, 'register_blocks_assets' ) );
     }

     /**
      * Register block assets for frontend.
      * I.e. dynamic responsiveness
      */
     public function register_frontend_assets() {
          wp_register_script(
               'wpcd-frontend-script',
               WPCD_Plugin::instance()->plugin_dir_uri . 'build/front.js',
               array(),
               WPCD_Plugin::PLUGIN_VERSION,
               true
          );
     }

     /**
      * Register blocks assets
      */
     public function register_blocks_assets() {
          wp_register_script(
               'wpcd-block-script',
               WPCD_Plugin::instance()->plugin_dir_uri . 'build/index.js',
               array(
                    'lodash',
                    'react',
                    'wp-block-editor',
                    'wp-blocks',
                    'wp-components',
                    'wp-data',
                    'wp-element',
                    'wp-i18n',
                    'wp-primitives',
               ),
               WPCD_Plugin::PLUGIN_VERSION,
               false
          );
          wp_register_style(
               'wpcd-editor-style',
               WPCD_Plugin::instance()->plugin_dir_uri . 'build/index.css',
               array(),
               WPCD_Plugin::PLUGIN_VERSION,
               false
          );
          wp_register_style(
               'wpcd-frontend-style',
               WPCD_Plugin::instance()->plugin_dir_uri . 'build/style-index.css',
               array(),
               WPCD_Plugin::PLUGIN_VERSION,
               false
          );
     }

     private static function pass_data_to_js( string $handle ) {
          // $data = [
          //     'plugin_url' => WPCD_Plugin::instance()->plugin_dir_uri
          // ];
          // global $tp_fs;
          // if (isset($tp_fs)) {
          //     $data['IS_PRO'] = $tp_fs->is__premium_only()
          //         && $tp_fs->can_use_premium_code();
          // } else {
          //     $data['IS_PRO'] = false;
          // }
          // wp_localize_script($handle, 'wpcd_CFG', $data);
     }
}

new WPCD_Block_Assets();
