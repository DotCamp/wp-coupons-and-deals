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
          self::pass_data_to_js('wpcd-block-script');
     }

     private static function pass_data_to_js( string $handle ) {
          $data = [];
          $data['default_image_url'] = WPCD_Plugin::instance()->plugin_assets . 'img/coupon-200x200.png';
          if (wcad_fs()->is_plan__premium_only( 'pro' ) or wcad_fs()->can_use_premium_code()) {
              $data['IS_PRO'] = 'true';
          } else {
              $data['IS_PRO'] = 'false';
          }
          wp_localize_script($handle, 'WPCD_CFG', $data);
     }
}

new WPCD_Block_Assets();
