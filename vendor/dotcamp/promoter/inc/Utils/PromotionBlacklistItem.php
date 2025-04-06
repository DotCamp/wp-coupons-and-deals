<?php
/**
 * Promotion blacklist item.
 *
 * @package DotCamp\Promoter
 */

namespace DotCamp\Promoter\Utils;

/**
 * Promotion blacklist item.
 *
 * Data holder for a single blacklist item.
 */
class PromotionBlacklistItem {
	/**
	 * Block id.
	 *
	 * @var string
	 */
	public $block_id;

	/**
	 * Promotion plugin id.
	 *
	 * @var string
	 */
	public $promotion_plugin_id;

	/**
	 * Class constructor.
	 *
	 * @param string $block_id            Block id.
	 * @param string $promotion_plugin_id Plugin id of targeted promotion.
	 */
	public function __construct( $block_id, $promotion_plugin_id ) {
		$this->block_id            = $block_id;
		$this->promotion_plugin_id = $promotion_plugin_id;
	}
}
