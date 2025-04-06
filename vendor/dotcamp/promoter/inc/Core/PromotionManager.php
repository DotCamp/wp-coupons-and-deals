<?php
/**
 * Promotion manager.
 *
 * @package DotCamp\Promoter
 */

namespace DotCamp\Promoter\Core;

use DotCamp\Promoter\Promotion;

/**
 * Promotion manager.
 */
class PromotionManager {

	/**
	 * Available promotions.
	 *
	 * @var Array<Promotion>
	 * @private
	 */
	private $available_promotions = array();


	/**
	 * Class constructor.
	 *
	 * @param Array<Promotion> $startup_promotions Promotions to start with.
	 */
	public function __construct( $startup_promotions = array() ) {
		$this->add_promotions( $startup_promotions );
	}

	/**
	 * Add promotions.
	 *
	 * @param Array<Promotion> | Promotion $promotions Single promotion or array of promotions to add.
	 */
	public function add_promotions( $promotions ) {
		if ( ! is_array( $promotions ) ) {
			$promotions = array( $promotions );
		}

		// Filter operations.
		$filtered_promotions = $this->filter_by_active( $promotions );
		$filtered_promotions = $this->filter_to_be_unique( $filtered_promotions );

		$this->available_promotions = array_merge( $filtered_promotions, $this->available_promotions );
	}

	/**
	 * Get available promotions.
	 *
	 * @return Array<Promotion> Available promotions.
	 */
	public function get_available_promotions() {
		return $this->available_promotions;
	}

	/**
	 * Filter promotions by active status.
	 *
	 * Promotions will be filtered based on install and active status of their target plugins. If the target plugin is not installed or active, the promotion will be included in the result.
	 *
	 * @param Array<Promotion> $target_promotions Promotions to filter.
	 *
	 * @return array Filtered promotions.
	 */
	private function filter_by_active( $target_promotions ) {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$filtered_values = array();
		array_map(
			function ( $promotion ) use ( &$filtered_values ) {
				$promotion_target_id = $promotion->promotion_target_id;
				$active_status       = is_plugin_active( $promotion_target_id );

				if ( ! $active_status ) {
					$filtered_values[] = $promotion;

				}
			},
			$target_promotions
		);

		return $filtered_values;
	}

	/**
	 * Filter promotions to be unique.
	 *
	 * If a promotion target is already present for a target block type, it will be filtered out.
	 *
	 * @param Array<Promotion> $target_promotions Promotions to filter.
	 *
	 * @return array Filtered promotions.
	 */
	private function filter_to_be_unique( $target_promotions ) {
		$current_promotions = $this->get_available_promotions();
		$unique_promotions  = array();

		array_walk(
			$target_promotions,
			function ( $current ) use ( $current_promotions, &$unique_promotions ) {
				$current_target_id = $current->promotion_target_id;
				$blocks_to_use     = $current->blocks_to_use;

				// Merge current promotions with unique promotions.
				$merged_promotions = array_merge( $current_promotions, $unique_promotions );

				array_walk(
					$merged_promotions,
					function ( $available_promotion ) use ( $current_target_id, &$blocks_to_use ) {
						if ( $current_target_id === $available_promotion->promotion_target_id ) {
							$blocks_to_use = array_diff( $blocks_to_use, $available_promotion->blocks_to_use );
						}
					}
				);

				// Empty blocks_to_use means that the promotion is a duplicate in functionality and there is other promotions that already covers the same blocks and target plugins.
				if ( ! empty( $blocks_to_use ) ) {
					$current->blocks_to_use = $blocks_to_use;
					$unique_promotions[]    = $current;
				}
			}
		);

		return $unique_promotions;
	}
}
