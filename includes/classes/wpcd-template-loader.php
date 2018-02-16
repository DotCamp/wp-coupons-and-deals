<?php
/**
 * Shortcode Template Loader.
 *
 * @since 1.2
 */

if ( ! class_exists( 'WPCD_Template_Loader' ) ) {

	/**
	 * Template loader.
	 *
	 * @since 1.2
	 */
	class WPCD_Template_Loader {
		/**
		 * Prefix for filter names.
		 *
		 * @since 1.2
		 * @type string
		 */
		protected $filter_prefix = 'wpcd';


		/**
		 * Reference to the root directory path of this plugin.
		 *
		 * @since 1.2
		 * @type string
		 */
		protected $plugin_directory;

		/**
		 * Directory name where templates are found in this plugin.
		 *
		 * @since 1.2
		 * @type string
		 */
		protected $plugin_template_directory;

		/**
		 * WPCD_Template_Loader constructor.
		 *
		 * @since 1.2
		 */
		public function __construct() {

			$this->plugin_directory          = WPCD_Plugin::instance()->plugin_dir_path;
			$this->plugin_template_directory = 'includes/templates/';

		}

		/**
		 * Retrieve a template part.
		 *
		 * @since 1.2
		 *
		 * @param string $slug
		 * @param string $name Optional. Default null.
		 * @param bool   $load Optional. Default true.
		 *
		 * @return string
		 */
		public function get_template_part( $slug, $name = null, $load = true ) {
			// Execute code for this part
			do_action( 'get_template_part_' . $slug, $slug, $name );

			// Get files names of templates, for given slug and name.
			$templates = $this->get_template_file_names( $slug, $name );

			// Return the part that is found
			return $this->locate_template( $templates, $load, false );
		}

		/**
		 * Given a slug and optional name, create the file names of templates.
		 *
		 * @since 1.2
		 *
		 * @param string $slug
		 * @param string $name
		 *
		 * @return array
		 */
		protected function get_template_file_names( $slug, $name ) {
			$templates = array();
			if ( isset( $name ) ) {
				$templates[] = $slug . '-' . $name . '.php';
			}
			$templates[] = $slug . '.php';

			/**
			 * Allow template choices to be filtered.
			 *
			 * @since 1.2
			 *
			 * @param array  $templates Names of template files that should be looked for, for given slug and name.
			 * @param string $slug Template slug.
			 * @param string $name Template name.
			 */
			return apply_filters( $this->filter_prefix . '_get_template_part', $templates, $slug, $name );
		}

		/**
		 * Retrieve the name of the highest priority template file that exists.
		 *
		 * @since 1.2
		 *
		 * @param string|array $template_names Template file(s) to search for, in order.
		 * @param bool         $load If true the template file will be loaded if it is found.
		 * @param bool         $require_once Whether to require_once or require. Default true.
		 *   Has no effect if $load is false.
		 *
		 * @return string The template filename if one is located.
		 */
		public function locate_template( $template_names, $load = false, $require_once = true ) {
			// No file found yet
			$located = false;

			// Remove empty entries
			$template_names = array_filter( (array) $template_names );
			$template_paths = $this->get_template_paths();

			// Try to find a template file
			foreach ( $template_names as $template_name ) {
				// Trim off any slashes from the template name
				$template_name = ltrim( $template_name, '/' );

				// Try locating this template file by looping through the template paths
				foreach ( $template_paths as $template_path ) {
					if ( file_exists( $template_path . $template_name ) ) {
						$located = $template_path . $template_name;
						break 2;
					}
				}
			}

			if ( $load && $located ) {
				load_template( $located, $require_once );
			}

			return $located;
		}

		/**
		 * Return a list of paths to check for template locations.
		 *
		 * @since 1.2
		 * @return mixed|void
		 */
		protected function get_template_paths() {

			$file_paths = array(
				100 => $this->get_templates_dir(),
				101 => $this->get_templates_dir() . 'shortcode',
				102 => $this->get_templates_dir() . 'widget',
				103 => $this->get_templates_dir() . 'archive',
				104 => $this->get_templates_dir() . 'extras'
			);

			/**
			 * Allow ordered list of template paths to be amended.
			 *
			 * @since 1.2
			 *
			 * @param array $var Default is directory in child theme at index 1, parent theme at 10, and plugin at 100.
			 */
			$file_paths = apply_filters( $this->filter_prefix . '_template_paths', $file_paths );

			// sort the file paths based on priority
			ksort( $file_paths, SORT_NUMERIC );

			return array_map( 'trailingslashit', $file_paths );
		}

		/**
		 * Return the path to the templates directory in this plugin.
		 *
		 * @since 1.2
		 *
		 * @return string
		 */
		protected function get_templates_dir() {
			return $this->plugin_directory . $this->plugin_template_directory;
		}

	}

}
