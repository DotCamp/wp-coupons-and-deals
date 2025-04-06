<?php
/**
 * Promotion blacklist handler.
 *
 * @package DotCamp\Promoter
 */

namespace DotCamp\Promoter\Core;

use DotCamp\Promoter\Utils\PromotionBlacklist;
use function get_option;
use function update_option;

/**
 * Promotion blacklist handler.
 *
 * This class is responsible for handling blacklisting operations for promotions.
 */
class PromotionBlacklistManager {
	/**
	 * Blacklist version.
	 *
	 * @var string
	 */
	const BLACKLIST_VERSION = '1';

	/**
	 * Option id to write blacklist.
	 *
	 * @var string
	 * @private
	 */
	private $option_id;

	/**
	 * Class constructor.
	 *
	 * @param string $option_id Option id to write blacklist.
	 */
	public function __construct( $option_id ) {
		$this->option_id = $option_id;
	}

	/**
	 * Format a raw data.
	 *
	 * @param PromotionBlacklist $blacklist_obj Blacklist object.
	 *
	 * @return array Formatted data.
	 */
	private function raw_data_format( $blacklist_obj ) {
		$blacklist_items = $blacklist_obj->get_blacklist_items();
		$blacklist_data  = array(
			'__v' => self::BLACKLIST_VERSION,
			'bl'  => array(),
		);

		foreach ( $blacklist_items as $blacklist_item ) {
			$blacklist_data['bl'][] = array(
				$blacklist_item->block_id,
				$blacklist_item->promotion_plugin_id,
			);
		}

		return $blacklist_data;
	}

	/**
	 * Generate blacklist object.
	 *
	 * @param array $list_tuples List of tuples, [block_id, promotion_id].
	 *
	 * @return PromotionBlacklist Blacklist object.
	 */
	private function generate_blacklist_obj( $list_tuples ) {
		$generated_blacklist = new PromotionBlacklist();

		foreach ( $list_tuples as $tuple ) {
			$generated_blacklist->add_blacklist_item_data( $tuple[0], $tuple[1] );
		}

		return $generated_blacklist;
	}

	/**
	 * Get option from db.
	 *
	 * @return array Option data.
	 */
	private function get_option_from_db() {
		$empty_blacklist_data = $this->raw_data_format( new PromotionBlacklist() );
		$current_blacklist    = get_option(
			$this->option_id,
			$empty_blacklist_data
		);

		if ( self::BLACKLIST_VERSION !== $current_blacklist['__v'] ) {
			$current_blacklist = $empty_blacklist_data;
		}

		return $current_blacklist;
	}

	/**
	 * Set option to db.
	 *
	 * @param PromotionBlacklist $blacklist_obj Blacklist object.
	 * @return bool Operation status.
	 */
	private function set_option_to_db( $blacklist_obj ) {
		$raw_data = $this->raw_data_format( $blacklist_obj );
		return update_option( $this->option_id, $raw_data );
	}

	/**
	 * Get promotion blacklist.
	 *
	 * @return PromotionBlacklist Promotion blacklist.
	 */
	public function get_blacklist() {
		$current_blacklist = $this->get_option_from_db();

		return $this->generate_blacklist_obj( $current_blacklist['bl'] );
	}

	/**
	 * Add to blacklist.
	 *
	 * @param string $block_id Block id.
	 * @param string $promotion_plugin_id Promotion plugin id.
	 *
	 * @return bool Operation status.
	 */
	public function add_to_blacklist( $block_id, $promotion_plugin_id ) {
		$current_blacklist = $this->get_blacklist();

		$current_blacklist->add_blacklist_item_data( $block_id, $promotion_plugin_id );

		return $this->set_option_to_db( $current_blacklist );
	}
}
