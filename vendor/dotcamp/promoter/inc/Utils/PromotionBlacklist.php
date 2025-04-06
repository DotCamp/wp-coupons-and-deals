<?php
/**
 * Promotion blacklist.
 *
 * @package DotCamp\Promoter
 */

namespace DotCamp\Promoter\Utils;

/**
 * Promotion blacklist data holder.
 */
class PromotionBlacklist {
	/**
	 * Blacklist items.
	 *
	 * @var Array<PromotionBlacklistItem>
	 */
	private $blacklist_items;

	/**
	 * Class constructor.
	 *
	 * @param Array<PromotionBlacklistItem> $blacklist_items Blacklist items.
	 */
	public function __construct( $blacklist_items = array() ) {
		$this->blacklist_items = $blacklist_items;
	}

	/**
	 * Get blacklist items.
	 *
	 * @return Array<PromotionBlacklistItem> Blacklist items.
	 */
	public function get_blacklist_items() {
		return $this->blacklist_items;
	}

	/**
	 * Add blacklist item data.
	 *
	 * @param string $block_id            Block id.
	 * @param string $promotion_plugin_id Promotion plugin id.
	 */
	public function add_blacklist_item_data( $block_id, $promotion_plugin_id ) {
		$this->add_blacklist_item( new PromotionBlacklistItem( $block_id, $promotion_plugin_id ) );
	}

	/**
	 * Add blacklist item.
	 *
	 * @param PromotionBlacklistItem $item Blacklist item.
	 */
	public function add_blacklist_item( $item ) {
		// Only add unique items to the blacklist.
		foreach ( $this->blacklist_items as $blacklist_item ) {
			if ( $blacklist_item->block_id === $item->block_id && $blacklist_item->promotion_plugin_id === $item->promotion_plugin_id ) {
				return;
			}
		}

		$this->blacklist_items[] = $item;
	}
}
